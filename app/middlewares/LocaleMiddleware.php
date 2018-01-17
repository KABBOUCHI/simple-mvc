<?php

namespace App\Middlewares;

use SimpleMVC\Contracts\Middleware;

class LocaleMiddleware implements Middleware
{
    public function handle()
    {
        config()->set('app.locale', request('lang'));
    }
}
