<?php

namespace Mitoop\Yzh;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Mitoop\Yzh\API\Contract;
use Mitoop\Yzh\API\Notify;
use Mitoop\Yzh\API\PayWithAlipay;
use Mitoop\Yzh\API\PayWithBankCard;
use Mitoop\Yzh\API\Sign;
use Mitoop\Yzh\API\Unsign;

class ServiceProvider extends LaravelServiceProvider
{
    public function register(): void
    {
        $config = config('services.yzh', []);

        Config::payRemarkUsing($config['pay_remark'] ?? '');
        Config::notifyUrlUsing($config['notify_url'] ?? '');
        Config::projectIdUsing($config['project_id'] ?? '');

        YzhService::register([
            'getContract' => Contract::class,
            'sign' => Sign::class,
            'unsign' => Unsign::class,
            'payWithAlipay' => PayWithAlipay::class,
            'PayWithBankCard' => PayWithBankCard::class,
            'notify' => Notify::class,
        ]);

        $this->app->singleton(YzhService::class, fn () => new YzhService($config));

        $this->app->alias(YzhService::class, 'yzh');
    }
}
