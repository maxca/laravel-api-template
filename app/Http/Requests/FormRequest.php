<?php

namespace App\Http\Requests;

use Validator;
use Illuminate\Foundation\Http\FormRequest as Request;
use Illuminate\Contracts\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Hashids\Hashids;

abstract class FormRequest extends Request
{
    private $auth;

    public $onlyEntered = false;

    protected $decode = [];

    protected $urlParameters = [];

    public function __construct()
    {
        $this->auth = config('oauth');
    }

    public function all($keys = null)
    {
        $requestData = parent::all($keys);
        $requestData = $this->mergeUrlParametersWithRequestData($requestData);
        $requestData = $this->mergeHasId($requestData);
        return $requestData;
    }

    protected function mergeHasId($requestData)
    {
        foreach ($this->decode as $key => $value) {
            $requestData[$value] = last(hashIdDecode(request()->{$value}));
        }
        return $requestData;
    }

    public function validate()
    {
        if (false === $this->authorize()) {
            throw new UnauthorizedException();
        }
        $inputs = $this->all();

        $validator = Validator::make(
            $inputs,
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );


        if ($validator->fails()) {
            $validationError = $validator->errors();
            if ($this->onlyEntered == true) {
                $errorMessages   = $validationError->messages();
                $validationError = new MessageBag;
                foreach ($errorMessages as $field => $errors) {
                    if ($this->has($field)) {
                        foreach ($errors as $error) {
                            $validationError->add($field, $error);
                        }
                    }
                }
            }
            if ($validationError->count() > 0) {
                throw new ValidationException($validationError);
            }
        }
    }

    public function authorize()
    {
        return true;
    }

    abstract public function rules();

    public function ruleRequired()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }

    public function hasRoles(array $roles)
    {
        return (bool)array_intersect($roles, $this->auth['roles'] ? $this->auth['roles'] : []);
    }

    public function hasPermissions(array $permissions)
    {
        return (bool)array_intersect($permissions, $this->auth['permissions'] ? $this->auth['permissions'] : []);
    }

    /**
     * apply validation rules to the ID's in the URL, since Laravel
     * doesn't validate them by default!
     * Now you can use validation riles like this: `'id' => 'required|integer|exists:items,id'`
     * @param array $requestData
     * @return  array
     */
    private function mergeUrlParametersWithRequestData(array $requestData)
    {
        if (isset($this->urlParameters) && !empty($this->urlParameters)) {
            foreach ($this->urlParameters as $param) {
                $requestData[$param] = $this->route($param);
            }
        }

        return $requestData;
    }
}
