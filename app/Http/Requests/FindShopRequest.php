<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class FindShopRequest
 * @package App\Http\Requests
 * @author samark chaisanguan <samarkchsngn@gmail.com>
 */
class FindShopRequest extends FormRequest
{

    /**
     * @var array
     */
    protected $decode = [
        'id'
    ];

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:shops,id|filled',
        ];
    }
}
