<?php

namespace App\Services\Generate;

/**
 * Trait GenerateFileConfig
 * @package Samark\ModuleGenerate\Services\Generate
 * @author samark chisanguan <samarkchsngn@gmail.com>
 */
trait GenerateFileConfig
{

    /**
     * @return array|\Illuminate\Config\Repository|mixed
     */
    public function getConfig()
    {
        if (!empty(config(CONFIG_NAME . '.template'))) {
            return config(CONFIG_NAME . '.template');
        }
        return ['template' => [
            'RequestApi'         => [
                'resource' => 'template/Request.stub',
                'target'   => 'app/Http/Requests/Api/',
                'needDir'  => true,
                'name'     => 'Request',
            ],
            'Request'            => [
                'resource' => 'template/Request.stub',
                'target'   => 'app/Http/Requests/Backend/',
                'needDir'  => true,
                'name'     => 'Request',
            ],
            'ControllerApi'      => [
                'resource'  => 'template/ApiController.stub',
                'target'    => 'app/Http/Controllers/Api/',
                'namespace' => 'App/',
                'needDir'   => true,
                'name'      => 'Controller',
            ],
            'Controller'         => [
                'resource'  => 'template/BackendController.stub',
                'target'    => 'app/Http/Controllers/Backend/',
                'namespace' => 'App/',
                'needDir'   => true,
                'name'      => 'Request',
            ],
            'Model'              => [
                'resource' => 'template/Model.stub',
                'target'   => 'app/Models/',
                'needDir'  => false,
            ],
            'RepositoryEloquent' => [
                'resource' => 'template/Repository.stub',
                'target'   => 'app/Repositories/',
                'needDir'  => true,
            ],
            'Repository'         => [
                'resource' => 'template/Interface.stub',
                'target'   => 'app/Interfaces/',
                'needDir'  => false,
            ],
            'Route'              => [
                'resource' => 'template/Route.stub',
                'target'   => 'Routes/',
                'needDir'  => true,
            ],
            'Transformer'        => [
                'resource' => 'template/Transformer.stub',
                'target'   => 'app/Transformers/',
                'needDir'  => false,
            ],
            'Factory'            => [
                'resource' => 'template/Factory.stub',
                'target'   => 'database/factories/',
                'needDir'  => false,
            ],
            'Test'               => [
                'resource' => 'template/Tests.stub',
                'target'   => 'Tests/',
                'needDir'  => true,
            ],
            'Seeder'             => [
                'resource' => 'template/Seeder.stub',
                'target'   => 'database/seeds/',
                'needDir'  => true,
            ],
            'Lang'               => [
                'resource' => 'template/Lang.stub',
                'target'   => 'resources/lang/',
                'needDir'  => true,
                'lang'     => true,
            ]
        ]];
    }

    /**
     * @return bool|\Illuminate\Config\Repository|mixed
     */
    public function getCustomPath()
    {
        if (!empty(config(CONFIG_NAME . '.custom_path'))) {
            return config(CONFIG_NAME . '.custom_path');
        }
        return true;
    }

    /**
     * @return array|\Illuminate\Config\Repository|mixed
     */
    public function getNeedDuplicate()
    {
        if (!empty(config(CONFIG_NAME . '.need_duplicate'))) {
            return config(CONFIG_NAME . '.need_duplicate');
        }
        return [
            'Request' => 'requestType',
            'Lang'    => 'configLang',
        ];
    }


}