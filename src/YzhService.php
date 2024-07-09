<?php

namespace Mitoop\Yzh;

use Exception;
use Mitoop\Yzh\API\Contract;
use Mitoop\Yzh\API\Notify;
use Mitoop\Yzh\API\PayWithAlipay;
use Mitoop\Yzh\API\PayWithBankCard;
use Mitoop\Yzh\API\Sign;
use Mitoop\Yzh\API\Unsign;
use Throwable;
use Yzh\Config;

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
class YzhService
{
    private static ?Config $cachedConfig = null;

    protected array $methods = [
        'getContract' => Contract::class,
        'sign' => Sign::class,
        'unsign' => Unsign::class,
        'payWithAlipay' => PayWithAlipay::class,
        'PayWithBankCard' => PayWithBankCard::class,
        'notify' => Notify::class,
    ];

    public function __construct(protected array $config)
    {
    }

    protected function getConfig(): Config
    {
        if (static::$cachedConfig !== null) {
            return self::$cachedConfig;
        }

        $config['app_private_key'] = file_get_contents($this->config['app_private_key']);
        $config['yzh_public_key'] = file_get_contents($this->config['yzh_public_key']);

        return static::$cachedConfig = Config::newFromArray($config);
    }

    public function __call(string $method, array $args)
    {
        try {
            if (isset($this->methods[$method])) {
                $class = $this->methods[$method]($this->getConfig());

                return call_user_func_array([$class, 'handle'], $args);
            }

            throw new Exception("Method $method not found.");
        } catch (Throwable $e) {
            return new Response(error: sprintf('%s:%s %s', $e->getFile(), $e->getLine(), $e->getMessage()));
        }
    }
}
