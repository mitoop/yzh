<?php

namespace Mitoop\Yzh;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function register(): void
    {
        $config = config('services.yzh', []);

        $this->app->singleton(Service::class, fn () => new Service($config));

        if (isset($config['pay_remark'])) {
            Service::payRemarkUsing((string) $config['pay_remark']);
        }

        if (isset($config['notify_url'])) {
            Service::notifyUrlUsing((string) $config['notify_url']);
        }

        if (isset($config['project_id'])) {
            Service::projectIdUsing((string) $config['project_id']);
        }
    }
}
