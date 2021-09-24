<?php

namespace LoghouseIo\LoghouseLaravel;


use Illuminate\Support\ServiceProvider;
use LoghouseIo\LoghouseLaravel\Models\LoghouseLaravelConfigImpl;
use LoghouseIo\LoghouseLaravel\Models\LoghouseLaravelEntriesStorageRequestConfigImpl;
use LoghouseIo\LoghouseLaravel\Models\LoghouseLaravelEntriesStorageImpl;
use LoghouseIo\LoghouseLaravel\Utils\LoghouseLaravelUtils;
use LoghouseIo\LoghouseLaravel\Factories\LoghouseLaravelEntryFactory;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoghouseLaravelServiceProvider
 * @package LoghouseIo\LoghouseLaravel
 */
class LoghouseLaravelServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerService();
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerMiddleware();
    }

    private function registerMiddleware()
    {
        if ($this->checkChannelAdded()) {
            $this->registerGroupMiddleware('api');
            $this->registerGroupMiddleware('web');
        }
    }

    private function checkChannelAdded()
    {
        $appConfig = app('config');

        if (isset($appConfig['logging']) && isset($appConfig['logging']['channels'])) {
            foreach ($appConfig['logging']['channels'] as $channelConfig) {
                if (isset($channelConfig['via']) && strpos($channelConfig['via'], 'LoghouseLaravelFactory') !== false) {
                    return true;
                }
            }
        }

        return false;
    }

    private function registerGroupMiddleware(string $group)
    {
        app('router')->pushMiddlewareToGroup($group, LoghouseLaravelMiddleware::class);
    }

    private function registerService()
    {
        $this->app->singleton('LoghouseLaravel', function () {

            $isConsole = app()->runningInConsole();
            $request = LoghouseLaravelEntryFactory::createRequest(
                \request(),
                Auth::check() ? Auth::user()->id : null
            );

            return new LoghouseLaravel(
                new LoghouseLaravelConfigImpl(
                    $isConsole,
                    env('LOGHOUSE_LARAVEL_ACCESS_TOKEN'),
                    env('LOGHOUSE_LARAVEL_DEFAULT_BUCKET_ID')
                ),
                new LoghouseLaravelEntriesStorageImpl(
                    $isConsole,
                    $request
                )
            );
        });
    }
}
