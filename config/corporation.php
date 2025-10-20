<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Corporation Module Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can specify configuration for your corporation module
    |
    */

    'name' => 'Corporation',
    'route_prefix' => 'admin/corporation',
    'middleware' => ['web', 'auth'],
];
