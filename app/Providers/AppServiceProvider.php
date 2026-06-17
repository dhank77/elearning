<?php

namespace App\Providers;

use App\Prism\Providers\SumopodProvider;
use Illuminate\Support\ServiceProvider;
use Prism\Prism\PrismManager;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->booted(function (): void {
            $this->app->make(PrismManager::class)->extend('sumopod', function ($app, $config) {
                return new SumopodProvider(
                    apiKey: $config['api_key'] ?? '',
                    url: $config['url'] ?? 'https://ai.sumopod.com/v1',
                );
            });
        });
    }
}
