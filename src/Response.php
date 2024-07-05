<?php

namespace Mitoop\Yzh;

use Illuminate\Support\Collection;
use Yzh\Model\Apiusersign\ApiUserSignContractResponseData;
use Yzh\Model\Apiusersign\ApiUserSignReleaseResponseData;
use Yzh\Model\Apiusersign\ApiUserSignResponseData;
use Yzh\Model\BaseResponse;
use Yzh\Model\Notify\NotifyResponse;
use Yzh\Model\Payment\CreateAlipayOrderResponseData;
use Yzh\Model\Payment\CreateBankpayOrderResponseData;

class Response
{
    public function __construct(
        protected bool $status,
        protected BaseResponse|NotifyResponse|null $response = null,
        protected string $error = ''
    ) {
    }

    public function ok(): bool
    {
        return $this->status;
    }

    public function data(): Collection
    {
        if ($response = $this->response) {
            if ($response instanceof NotifyResponse) {
                return collect(json_decode($response->getData(), true))->dot();
            }

            $data = $response->getData();

            if ($data instanceof ApiUserSignContractResponseData) {
                return collect([
                    'title' => $data->getTitle(), // 协议名称
                    'url' => $data->getUrl(), // 预览跳转 URL
                ]);
            }

            if ($data instanceof ApiUserSignResponseData) {
                return collect([
                    'status' => $data->getStatus(), // 是否签约成功
                ]);
            }

            if ($data instanceof ApiUserSignReleaseResponseData) {
                return collect([
                    'status' => $data->getStatus(), // 是否解约成功
                ]);
            }

            if ($data instanceof CreateBankpayOrderResponseData || $data instanceof CreateAlipayOrderResponseData) {
                return collect([
                    'order_id' => $data->getOrderId(), // 平台企业订单号
                    'pay' => $data->getPay(), // 订单金额
                    'ref' => $data->getRef(), // 综合服务平台流水号
                ]);
            }
        }

        return collect();
    }

    public function error(): string
    {
        return $this->error;
    }
}
