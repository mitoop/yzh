<?php

namespace Mitoop\Yzh;

use Illuminate\Support\Facades\Facade;

class Yzh extends Facade
{
    protected static function getFacadeAccessor()
    {
        return YzhService::class;
    }
}
