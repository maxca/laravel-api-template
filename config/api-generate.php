<?php return [
    /*
     *  @author samark chaisanguan <samarkchsngn@gmail.com>
    |--------------------------------------------------------------------------
    | Setting open route
    |--------------------------------------------------------------------------
    */
    'backend' => [
        'limit' => '30',
        'image' => 'jpg|jpeg|png',
        'link'  => 'admin',
    ],

    /*
    |--------------------------------------------------------------------------
    | Setting open route
    |--------------------------------------------------------------------------
    */
    'route'   => [
        'enabled'   => true,
        'namespace' => [
            'api' => 'DSPLoanPlatform\\',
            'as'  => 'DSPLoanPlatform.',
            'web' => 'App\Http\\Controllers\\',
        ],
        'prefix'    => [
            'api' => 'dsploanplatform/',
            'web' => '',
        ],
        'path'      => [
            'api' => 'routes/api/',
            'web' => 'routes/web/',
        ],

        'middleware' => [
            'api' => 'api',
            'web' => 'web',
        ],


        /*
        |--------------------------------------------------------------------------
        | Setting route file
        |--------------------------------------------------------------------------
        */
        'filename'   => 'Route.php',

        /*
        |--------------------------------------------------------------------------
        | Setting enabled autoload route in path
        |--------------------------------------------------------------------------
        */
        'autoload'   => true,
        /*
        |--------------------------------------------------------------------------
        | Setting uppercase directory
        |--------------------------------------------------------------------------
        */
        'upper_case' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default template file generate
    |--------------------------------------------------------------------------
    */

    'template' => [
        'RequestApi' => [
            'resource' => 'template/RequestApi.stub',
            'target'   => 'app/Http/Requests/Api/',
            'needDir'  => true,
            'name'     => 'Request',
        ],

        'ControllerApi' => [
            'resource'  => 'template/ApiController.stub',
            'target'    => 'app/Http/Controllers/DSPLoanPlatform/',
            'namespace' => 'App/',
            'needDir'   => true,
            'name'      => 'Controller',
        ],
        'Repository'    => [
            'resource' => 'template/Repository.stub',
            'target'   => 'app/Repository/',
            'needDir'  => true,
            'name'     => 'Repository',
        ],

        'Models'     => [
            'resource' => 'template/Model.stub',
            'target'   => 'app/Models/',
            'needDir'  => false,
            'name'     => 'Model',
        ],
        'Procedures' => [
            'resource' => 'template/Procedures.stub',
            'target'   => 'app/Services/',
            'needDir'  => true,
            'name'     => 'Procedures',
        ],
        'RouteApi'   => [
            'resource' => 'template/RouteApi.stub',
            'target'   => 'Routes/api/',
            'needDir'  => true,
            'name'     => 'Route',
        ],
        'Test'       => [
            'resource' => 'template/Tests.stub',
            'target'   => 'Tests/',
            'needDir'  => true,
        ],
        'Lang'       => [
            'resource' => 'template/Lang.stub',
            'target'   => 'resources/lang/',
            'needDir'  => true,
            'lang'     => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | set using repository
    |--------------------------------------------------------------------------
    */

    'using_repository' => false,

    /*
    |--------------------------------------------------------------------------
    | Set list of need duplicate copy file
    |--------------------------------------------------------------------------
    | value only : requestType, configLang
    */

    'need_duplicate' => [
        'Request'    => 'requestType',
        'RequestApi' => 'requestType',
        'Lang'       => 'configLang',
    ],

    /*
    |--------------------------------------------------------------------------
    | Set list of replace label
    |--------------------------------------------------------------------------
    */

    'label'   => [
        'search'  => [
            '_en', '_th', '_id',
        ],
        'replace' => [
            '[en]', '[th]', ''
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Set list of use cnd cloudflare
    |--------------------------------------------------------------------------
    */
    'use_cdn' => [
        'production',
        'staging',
    ],

];