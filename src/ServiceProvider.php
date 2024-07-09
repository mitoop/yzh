<?php

namespace Mitoop\Yzh;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function register(): void
    {
        $config = config('services.yzh', []);

        Config::payRemarkUsing((string) ($config['pay_remark'] ?? ''));
        Config::notifyUrlUsing((string) ($config['notify_url'] ?? ''));
        Config::projectIdUsing((string) ($config['project_id'] ?? ''));

        $this->app->singleton(YzhService::class, fn () => new YzhService($config));

        $this->app->alias(YzhService::class, 'yzh');
    }
}
