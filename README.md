<h1 align="center">云账户</h1>
<p align="center">灵活就业服务</p>


## 配置
`config/services.php`
```php
    // ...
    'yzh' => [
        // 基础配置
        'app_broker_id' => env('YZH_BROKER_ID', 'app_broker_id'),
        'app_dealer_id' => env('YZH_DEALER_ID', 'app_dealer_id'),
        'app_key' => env('YZH_APP_KEY', 'app_key'),
        'app_des3_key' => env('YZH_DES_KEY', 'app_des3_key'),
        'app_private_key' => env('YZH_PRIVATE_KEY', storage_path('certs/private.pem')),
        'yzh_public_key' => env('YZH_YZH_PUBLIC_KEY', storage_path('certs/yzh_public.pem')),
        'sign_type' => 'rsa', // 固定
        'timeout' => 30,
        
        // 支付全局默认配置 [可以在支付时具体指定, 优先级高于此处配置]
        // 订单备注 [选填] 银行卡支持最大36个字符 支付宝支持最大40个字符 都不能包含特殊字符
        'pay_remark' => '', 
        // 回调地址 [选填] 长度不超过 200 个字符
        'notify_url' => '', 
        // 项目ID [选填] 该字段由云账户分配，指定项目时，会将订单关联指定项目
        'project_id' => '', 
    ],
```

## 配置
```php
use Yzh;

// 获取协议预览 URL
Yzh::getContract();
// 用户签约
Yzh::sign('name', 'id card');
// 用户解约 [云账户: 此接口只适用于对接联调时自助解约使用，若正式账号下用户需要解约，请联系云账户客户运营进行人工解约。]
Yzh::unsign('name', 'id card');
// 银行卡支付
Yzh::payWithBankCard($cardNo, $amount, $realName, $idCard, $phoneNo, $orderId);
// 支付宝支付
Yzh::payWithAlipay($alipay, $amount, $realName, $idCard, $phoneNo, $orderId);
// 支付回调
Yzh::notify();

// 所有方法都返回 `Mitoop\Yzh\Response` 实例
// Response 实例提供三个方法 `ok`, `data`, `error`
// `ok` 判断请求是否成功
// `data` 获取返回数据
// `error` 获取错误信息
$response = Yzh::notify();

if ($response->ok()){
   $data = $response->data();
   // or
   $status = $response->data('data.status')
} else {
  echo $response->error();
}

```
