<?php

return [
    // 基础配置
    'app_broker_id' => env('YZH_BROKER_ID', '88888888'),
    'app_dealer_id' => env('YZH_DEALER_ID', '88888888'),
    'app_key' => env('YZH_APP_KEY', 'YZH_APP_KEY'),
    'app_des3_key' => env('YZH_DES_KEY', 'YZH_DES_KEY'),
    'app_private_key' => env('YZH_PRIVATE_KEY', storage_path('certs/private.pem')),
    'yzh_public_key' => env('YZH_YZH_PUBLIC_KEY', storage_path('certs/yzh_public.pem')),
    'sign_type' => 'rsa',
    'timeout' => 30,
    // 支付配置 [选填]
    'pay_remark' => 'remark',
    'project_id' => 'project id',
];
