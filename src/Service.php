<?php

namespace Mitoop\Yzh;

use Illuminate\Support\Str;
use Yzh\ApiUserSignServiceClient;
use Yzh\Config;
use Yzh\Model\Apiusersign\ApiUserSignContractRequest;
use Yzh\Model\Apiusersign\ApiUserSignContractResponse;
use Yzh\Model\Apiusersign\ApiUserSignReleaseRequest;
use Yzh\Model\Apiusersign\ApiUserSignReleaseResponse;
use Yzh\Model\Apiusersign\ApiUserSignRequest;
use Yzh\Model\Apiusersign\ApiUserSignResponse;
use Yzh\Model\Payment\CreateAlipayOrderRequest;
use Yzh\Model\Payment\CreateAlipayOrderResponse;
use Yzh\Model\Payment\CreateBankpayOrderRequest;
use Yzh\Model\Payment\CreateBankpayOrderResponse;
use Yzh\PaymentClient;

class Service
{
    protected static string $payRemark = '';

    protected static string $projectId = '';

    protected Config $config;

    public function __construct(array $config)
    {
        $config['app_private_key'] = file_get_contents($config['app_private_key']);
        $config['yzh_public_key'] = file_get_contents($config['yzh_public_key']);

        $this->config = Config::newFromArray($config);
    }

    public function getContract(): ApiUserSignContractResponse
    {
        $client = new ApiUserSignServiceClient($this->config);

        $request = new ApiUserSignContractRequest([
            'dealer_id' => $this->config->app_dealer_id,
            'broker_id' => $this->config->app_broker_id,
        ]);

        $request->setRequestID((string) Str::orderedUuid());

        return $client->apiUserSignContract($request);
    }

    public function sign(string $name, string $idCard): ApiUserSignResponse
    {
        $client = new ApiUserSignServiceClient($this->config);

        $request = new ApiUserSignRequest([
            'dealer_id' => $this->config->app_dealer_id,
            'broker_id' => $this->config->app_broker_id,
            'real_name' => $name,
            'id_card' => strtoupper($idCard),
            'card_type' => 'idcard',
        ]);

        $request->setRequestID((string) Str::orderedUuid());

        return $client->apiUserSign($request);
    }

    public function unsign(string $name, string $idCard): ApiUserSignReleaseResponse
    {
        $client = new ApiUserSignServiceClient($this->config);

        $request = new ApiUserSignReleaseRequest([
            'dealer_id' => $this->config->app_dealer_id,
            'broker_id' => $this->config->app_broker_id,
            'real_name' => $name,
            'id_card' => strtoupper($idCard),
            'card_type' => 'idcard',
        ]);

        $request->setRequestID((string) Str::orderedUuid());

        return $client->apiUserSignRelease($request);
    }

    protected function payWithBankCard(BankCard $bankCard, string $amount, string $orderId, string $payRemark, string $notifyUrl, string $projectId): CreateBankpayOrderResponse
    {
        $client = new PaymentClient($this->config);

        $request = new CreateBankpayOrderRequest([
            'order_id' => $orderId,
            'dealer_id' => $this->config->app_dealer_id,
            'broker_id' => $this->config->app_broker_id,
            'real_name' => $bankCard->getRealName(),
            'card_no' => $bankCard->getCardNo(),
            'id_card' => $bankCard->getIdCard(),
            'phone_no' => $bankCard->getPhoneNo(),
            'pay' => $amount,
            'pay_remark' => $payRemark,
            'notify_url' => $notifyUrl,
            'project_id' => $projectId,
        ]);

        $request->setRequestID((string) Str::orderedUuid());

        return $client->createBankpayOrder($request);
    }

    protected function payWithAlipay(BankCard $bankCard, string $amount, string $orderId, string $payRemark, string $notifyUrl, string $projectId): CreateAlipayOrderResponse
    {
        $client = new PaymentClient($this->config);

        $request = new CreateAlipayOrderRequest([
            'order_id' => $orderId,
            'dealer_id' => $this->config->app_dealer_id,
            'broker_id' => $this->config->app_broker_id,
            'real_name' => $bankCard->getRealName(),
            'card_no' => $bankCard->getAlipayNo(),
            'id_card' => $bankCard->getIdCard(),
            'phone_no' => $bankCard->getPhoneNo(),
            'pay' => $amount,
            'pay_remark' => $payRemark,
            'check_name' => 'Check', // 固定值
            'notify_url' => $notifyUrl,
            'project_id' => $projectId,
        ]);

        $request->setRequestID((string) Str::orderedUuid());

        return $client->createAlipayOrder($request);
    }

    /**
     * @param  string  $amount  string 类型 单位为元 支持两位小数
     * @param  string  $orderId  最大64位
     * @param  string  $payRemark  订单备注
     * @param  string  $notifyUrl  回调地址 [选填] 长度不超过 200 个字符
     * @param  string  $projectId  项目ID [选填] 该字段由云账户分配，当接口指定项目时，会将订单关联指定项目
     */
    public function pay(
        BankCard $bankCard,
        string $amount,
        string $orderId,
        string $payRemark = '',
        string $notifyUrl = '',
        string $projectId = ''
    ): CreateBankpayOrderResponse|CreateAlipayOrderResponse {
        $payRemark = ($payRemark !== '') ? $payRemark : static::$payRemark;
        $projectId = ($projectId !== '') ? $projectId : static::$projectId;

        if ($bankCard->type->is(BankCardType::BANK)) {
            return $this->payWithBankCard($bankCard, $amount, $orderId, $payRemark, $notifyUrl, $projectId);
        }

        if ($bankCard->type->is(BankCardType::ALIPAY)) {
            return $this->payWithAlipay($bankCard, $amount, $orderId, $payRemark, $notifyUrl, $projectId);
        }
    }

    public static function payRemarkUsing(string $payRemark): void
    {
        static::$payRemark = $payRemark;
    }

    public static function projectIdUsing(string $projectId): void
    {
        static::$projectId = $projectId;
    }
}
