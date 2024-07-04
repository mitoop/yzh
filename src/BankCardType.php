<?php

namespace Mitoop\Yzh;

use ArchTech\Enums\Comparable;
use ArchTech\Enums\InvokableCases;

enum BankCardType: int
{
    use Comparable, InvokableCases;

    case BANK = 1;
    case ALIPAY = 2;
}
