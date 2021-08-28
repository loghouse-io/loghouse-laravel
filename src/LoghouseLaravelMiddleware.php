<?php

namespace LoghouseIo\LoghouseLaravel;

use Closure;
use LoghouseIo\LoghouseLaravel\Facades\LoghouseLaravel;

/**
 * Class LoghouseLaravelMiddleware
 * @package LoghouseIo\LoghouseLaravel
 */
class LoghouseLaravelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @return void
     */
    public function terminate()
    {
        LoghouseLaravel::send();
    }
}