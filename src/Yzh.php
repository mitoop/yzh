<?php

namespace Mitoop\Yzh;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Response getContract()
 * @method static Response sign(string $name, string $idCard)
 * @method static Response unsign(string $name, string $idCard)
 * @method static Response payWithAlipay(string $alipay,string $amount,string $realName,string $idCard,string $phoneNo,string $orderId,string $payRemark = '',string $notifyUrl = '',string $projectId = '')
 * @method static Response PayWithBankCard(string $cardNo,string $amount,string $realName,string $idCard,string $phoneNo,string $orderId,string $payRemark = '',string $notifyUrl = '',string $projectId = '')
 * @method static Response notify()
 *
 * @see API\Contract
 * @see API\Sign
 * @see API\Unsign
 * @see API\PayWithAlipay
 * @see API\PayWithBankCard
 * @see API\Notify
 */
class Yzh extends Facade
{
    protected static function getFacadeAccessor()
    {
        return YzhService::class;
    }
}
