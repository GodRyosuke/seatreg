<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ログイン方法
    |--------------------------------------------------------------------------
    |
    | SSO でログインするときは .env の SSO_LOGIN_URI をセットしてください。なければ
    | ローカル認証（login）します。
    |
    */

    'ssologin' => env('SSO_LOGIN_URI', 'login'),
    'qrcode_prefix' => env('QRCODE_PREFIX', 'http://localhost:20080/reg/'),
    'default_admin' => env('DEFAULT_ADMIN', ''),
];

