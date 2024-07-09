<?php

namespace Mitoop\Yzh;

class Response
{
    public function __construct(protected bool $status = false, protected array $data = [], protected string $error = '')
    {
    }

    public function ok(): bool
    {
        return $this->status;
    }

    public function data($key = null, $default = null): mixed
    {
        return data_get($this->data, $key, $default);
    }

    public function error(): string
    {
        return $this->error;
    }
}
