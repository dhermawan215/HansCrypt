<?php

namespace HansCrypt\Integrations\Laravel;

use HansCrypt\Contract\SecureEncryptionInterface;
use HansCrypt\SecureEncryption;
use Illuminate\Support\ServiceProvider;

class HansCryptServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../../config/hanscrypt.php', 'hanscrypt');

        $this->app->singleton(SecureEncryption::class, function ($app) {
            return new SecureEncryption((string) $app['config']->get('hanscrypt.key'));
        });

        $this->app->alias(SecureEncryption::class, SecureEncryptionInterface::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../../config/hanscrypt.php' => config_path('hanscrypt.php'),
            ], 'hanscrypt-config');
        }
    }
}
