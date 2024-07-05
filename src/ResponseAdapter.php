<?php

namespace Mitoop\Yzh;

use Yzh\Model\BaseResponse;
use Yzh\Model\Notify\NotifyResponse;

class ResponseAdapter
{
    public function __construct(protected BaseResponse|NotifyResponse $response)
    {
    }

    public function isSuccess(): bool
    {
        if ($this->response instanceof BaseResponse) {
            return $this->response->isSuccess();
        }

        if ($this->response instanceof NotifyResponse) {
            return $this->response->getSignRes() && $this->response->getDescryptRes();
        }
    }

    public function getError(): string
    {
        if ($this->response instanceof BaseResponse) {
            return sprintf('%s:%s %s',
                $this->response->getCode(),
                $this->response->getMessage(),
                $this->response->getRequestID()
            );
        }

        if ($this->response instanceof NotifyResponse) {
            return sprintf('验签失败 sign_res:%s descrypt_res%s',
                (int) $this->response->getSignRes(),
                (int) $this->response->getDescryptRes()
            );
        }

        return '';
    }

    public function getResponse(): BaseResponse|NotifyResponse
    {
        return $this->response;
    }
}
