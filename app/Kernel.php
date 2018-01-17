<?php

namespace App;

class Kernel
{
    public static $middleware = [
        \App\Middlewares\LocaleMiddleware::class
    ];
}
