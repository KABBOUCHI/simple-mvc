<?php

namespace SimpleMVC;

class App
{
    /** @var Bootstrap bootstrap */
    protected $bootstrap;

    /** @var DependencyInjector dependencyInjector */
    protected $dependencyInjector;

    public function __construct()
    {
        $this->dependencyInjector = DependencyInjector::getInstance();
        $this->bootstrap = new Bootstrap($this->dependencyInjector);
    }

    public function run()
    {
        $this->bootstrap->config();
        $this->bootstrap->session();
        date_default_timezone_set(config('app.timezone'));
        $this->bootstrap->middleware();
        $this->bootstrap->routes();
    }
}
