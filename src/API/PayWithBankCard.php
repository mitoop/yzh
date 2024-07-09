<?php

namespace Mitoop\Yzh\API;

use Illuminate\Support\Str;
use Mitoop\Yzh\Config;
use Mitoop\Yzh\Response;
use Yzh\Model\Payment\CreateBankpayOrderRequest;
use Yzh\PaymentClient;

class PayWithBankCard extends BaseAPI
{
    public function handle(
        string $cardNo,
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

        $request = new CreateBankpayOrderRequest([
            'order_id' => $orderId,
            'dealer_id' => $this->config->app_dealer_id,
            'broker_id' => $this->config->app_broker_id,
            'real_name' => $realName,
            'card_no' => $cardNo,
            'id_card' => $idCard,
            'phone_no' => $phoneNo,
            'pay' => $amount,
            'pay_remark' => $payRemark,
            'notify_url' => $notifyUrl,
            'project_id' => $projectId,
        ]);

        $request->setRequestID((string) Str::orderedUuid());

        $response = $client->createBankpayOrder($request);

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
