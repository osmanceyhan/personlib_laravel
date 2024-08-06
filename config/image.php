<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    'cdn_dir' => env('CDN_BASE_DIR', '/images/'),

    'convert_ext' => env('IMAGE_CONVERT_EXTENSION'),

    'is_convert' => env('IMAGE_CONVERT', false),

    'storage_asset_url' => env('STORAGE_ASSET_URL', 'https://cdn.cappadociavisitor.com'),
    'cdn_base_dir' => env('CDN_BASE_DIR', '/images/'),
];
