<?php

namespace Mitoop\Yzh;

use Exception;
use Throwable;
use Yzh\Config;

/**
 * @method Response getContract()
 * @method Response sign(string $name, string $idCard)
 * @method Response unsign(string $name, string $idCard)
 * @method Response payWithAlipay(string $alipay,string $amount,string $realName,string $idCard,string $phoneNo,string $orderId,string $payRemark = '',string $notifyUrl = '',string $projectId = '')
 * @method Response payWithBankCard(string $cardNo,string $amount,string $realName,string $idCard,string $phoneNo,string $orderId,string $payRemark = '',string $notifyUrl = '',string $projectId = '')
 * @method Response notify()
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
    protected static ?Config $cachedConfig = null;

    protected static array $methods = [];

    public function __construct(protected array $config)
    {
    }

    protected function getConfig(): Config
    {
        if (static::$cachedConfig !== null) {
            return self::$cachedConfig;
        }

        $config = $this->config;
        $config['app_private_key'] = file_get_contents($config['app_private_key']);
        $config['yzh_public_key'] = file_get_contents($config['yzh_public_key']);

        return static::$cachedConfig = Config::newFromArray($config);
    }

    public static function register($method, $class = null): void
    {
        if (is_array($method)) {
            foreach ($method as $key => $value) {
                static::register($key, $value);
            }
        } else {
            static::$methods[$method] = $class;
        }
    }

    public function __call(string $method, array $args)
    {
        try {
            if (isset(static::$methods[$method])) {
                $class = new static::$methods[$method]($this->getConfig());

                return call_user_func_array([$class, 'handle'], $args);
            }

            throw new Exception("Method $method not found.");
        } catch (Throwable $e) {
            return new Response(error: sprintf('%s:%s %s', $e->getFile(), $e->getLine(), $e->getMessage()));
        }
    }
}
