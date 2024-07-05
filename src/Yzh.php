<?php

namespace Mitoop\Yzh;

use Throwable;

/**
 * @method static Response getContract()
 * @method static Response sign(string $name, string $idCard)
 * @method static Response unsign(string $name, string $idCard)
 * @method static Response pay(BankCard $bankCard, string $amount, string $orderId, string $payRemark = '',string $notifyUrl = '',string $projectId = '')
 * @method static Response processCallback()
 *
 * @see Service
 */
class Yzh
{
    public static function __callStatic(string $method, array $args)
    {
        try {
            /** @var ResponseAdapter $response */
            $response = app(Service::class)->$method(...$args);

            if ($response->isSuccess()) {
                return new Response(true, response: $response->getResponse());
            }

            return new Response(
                false,
                error: $response->getError());
        } catch (Throwable $e) {
            return new Response(
                false,
                error: sprintf('%s:%s %s', $e->getFile(), $e->getLine(), $e->getMessage())
            );
        }
    }
}
