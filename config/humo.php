<?php

// config for Uzbek/LaravelHumo
return [
    'base_urls' => [
        'payment' => env('HUMO_PAYMENT_URL', 'http://192.168.35.126:11210/'), /* 11210 */
        'json_info' => env('HUMO_JSON_INFO_URL', 'https://192.168.35.177/test/'), /*json info*/
//        'access_gateway' => env('HUMO_ACCESS_GATEWAY_URL', 'http://192.168.35.22:11220/'), /* 13010 */
//        'issuing' => env('HUMO_ISSUING_URL', 'https://192.168.35.150:8444/'), /* 8443 */
//        'card' => env('HUMO_CARD_URL', 'http://192.168.35.150:6680/'), /* 6677 */
    ],
    'username' => env('HUMO_USERNAME', 'aab'),
    'password' => env('HUMO_PASSWORD', '1234'),
    'token' => env('HUMO_TOKEN'),
    'max_amount_without_passport' => env('HUMO_MAX_AMOUNT_WITHOUT_PASSPORT', 11_999_999_99), // Passport information is required from 12 million UZS
    'proxy_url' => env('HUMO_PROXY_URL'),
    'proxy_proto' => env('HUMO_PROXY_PROTO'),
    'proxy_host' => env('HUMO_PROXY_HOST'),
    'proxy_port' => env('HUMO_PROXY_PORT'),
    'is_test_mode' => env('HUMO_TEST_MODE', false),
];
