<?php

namespace LoghouseIo\LoghouseLaravel;


use Illuminate\Support\ServiceProvider;

/**
 * Class LoghouseLaravelServiceProvider
 * @package LoghouseIo\LoghouseLaravel
 */
class LoghouseLaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->registerMiddleware();
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->registerService();
    }

    private function registerMiddleware(): void
    {
        $channelsConfig = app('config')['logging']['channels'];

        foreach ($channelsConfig as $channelConfig) {
            if (isset($channelConfig['via']) && strpos($channelConfig['via'], 'LoghouseLaravelFactory')) {
                app('router')->pushMiddlewareToGroup('web', LoghouseLaravelMiddleware::class);
                app('router')->pushMiddlewareToGroup('api', LoghouseLaravelMiddleware::class);
                return;
            }
        }
    }

    private function registerService(): void
    {
        $this->app->singleton('LoghouseLaravel', function () {

            $accessToken = env('LOGHOUSE_LARAVEL_ACCESS_TOKEN');
            $defaultBucketId = env('LOGHOUSE_LARAVEL_DEFAULT_BUCKET_ID');

            return new LoghouseLaravel($accessToken, $defaultBucketId);
        });
    }
}