## YunZhangHu


#### Config
`config/services.php`
```php
    // ...
    'yzh' => [
        // 基础配置
        'app_broker_id' => env('YZH_BROKER_ID', '88888888'),
        'app_dealer_id' => env('YZH_DEALER_ID', '88888888'),
        'app_key' => env('YZH_APP_KEY', 'YZH_APP_KEY'),
        'app_des3_key' => env('YZH_DES_KEY', 'YZH_DES_KEY'),
        'app_private_key' => env('YZH_PRIVATE_KEY', storage_path('certs/private.pem')),
        'yzh_public_key' => env('YZH_YZH_PUBLIC_KEY', storage_path('certs/yzh_public.pem')),
        'sign_type' => 'rsa',
        'timeout' => 30,
        
        // 支付全局配置 调用 pay 方法指定的配置优先级高于全局配置
        'pay_remark' => 'remark', // 订单备注 [选填] 银行卡支付时最大36个字符 支付宝支付时候最大40个字符 都不能包含特殊字符
        'notify_url' => 'notify url', // 回调地址 [选填] 长度不超过 200 个字符
        'project_id' => 'project id', // 项目ID [选填] 该字段由云账户分配，当接口指定项目时，会将订单关联指定项目
    // ...
```
