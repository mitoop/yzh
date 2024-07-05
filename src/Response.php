<?php

namespace Mitoop\Yzh;

use Yzh\Model\BaseResponse;

class Response
{
    public function __construct(
        protected bool $status,
        protected ?BaseResponse $response = null,
        protected string $error = ''
    ) {
    }

    public function ok(): bool
    {
        return $this->status;
    }

    public function data(): mixed
    {
        return $this->response?->getData();
    }

    public function error(): string
    {
        return $this->error;
    }
}
