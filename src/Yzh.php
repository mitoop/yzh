<?php

namespace Mitoop\Yzh;

use Throwable;
use Yzh\Model\Apiusersign\ApiUserSignContractResponse;
use Yzh\Model\Apiusersign\ApiUserSignReleaseResponse;
use Yzh\Model\Apiusersign\ApiUserSignResponse;
use Yzh\Model\Payment\CreateAlipayOrderResponse;

/**
 * @method static ApiUserSignContractResponse getContract()
 * @method static ApiUserSignResponse userSign(string $name, string $idCard)
 * @method static ApiUserSignReleaseResponse userUnsign(string $name, string $idCard)
 * @method static CreateAlipayOrderResponse pay(BankCard $bankCard, string $amount, string $orderId, string $payRemark = '',string $notifyUrl = '',string $projectId = '')
 *
 * @see Service
 */
class Yzh
{
    public static function __callStatic(string $method, array $args)
    {
        try {
            return app(Service::class)->$method(...$args);
        } catch (Throwable $e) {
            throw new YzhException($e->getMessage(), previous: $e);
        }
    }
}
