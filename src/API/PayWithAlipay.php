<?php

namespace Mitoop\Yzh\API;

use Illuminate\Support\Str;
use Mitoop\Yzh\Config;
use Mitoop\Yzh\Response;
use Yzh\Model\Payment\CreateAlipayOrderRequest;
use Yzh\PaymentClient;

class PayWithAlipay extends BaseAPI
{
    public function handle(
        string $alipay,
        string $amount,
        string $realName,
        string $idCard,
        string $phoneNo,
        string $orderId,
        string $payRemark = '',
        string $notifyUrl = '',
        string $projectId = ''): Response
    {
        $client = new PaymentClient($this->config);

        $payRemark = ($payRemark !== '' ? $payRemark : Config::$payRemark);
        $notifyUrl = ($notifyUrl !== '' ? $notifyUrl : Config::$notifyUrl);
        $projectId = ($projectId !== '' ? $projectId : Config::$projectId);

        $request = new CreateAlipayOrderRequest([
            'order_id' => $orderId,
            'dealer_id' => $this->config->app_dealer_id,
            'broker_id' => $this->config->app_broker_id,
            'real_name' => $realName,
            'card_no' => $alipay,
            'id_card' => $idCard,
            'phone_no' => $phoneNo,
            'pay' => $amount,
            'pay_remark' => $payRemark,
            'check_name' => 'Check', // 固定值
            'notify_url' => $notifyUrl,
            'project_id' => $projectId,
        ]);

        $request->setRequestID((string) Str::orderedUuid());

        $response = $client->createAlipayOrder($request);

        if ($status = $response->isSuccess()) {
            $this->data = [
                'order_id' => $response->getData()->getOrderId(), // 平台企业订单号
                'pay' => $response->getData()->getPay(), // 订单金额
                'ref' => $response->getData()->getRef(), // 综合服务平台流水号
            ];
        }

        return new Response($status, $this->data, $this->getError($response));
    }
}
