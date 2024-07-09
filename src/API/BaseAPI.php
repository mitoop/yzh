<?php

namespace Mitoop\Yzh\API;

use Yzh\Config;
use Yzh\Model\BaseResponse;

abstract class BaseAPI
{
    protected array $data = [];

    public function __construct(protected Config $config)
    {
    }

    protected function getError($response): string
    {
        if ($response->isSuccess()) {
            return '';
        }

        /** @var BaseResponse $response */
        return sprintf('%s:%s %s', $response->getCode(), $response->getMessage(), $response->getRequestID());
    }
}
