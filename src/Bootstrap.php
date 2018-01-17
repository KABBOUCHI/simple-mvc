<?php

namespace SimpleMVC;

use Closure;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use SimpleMVC\Contracts\Middleware;
use function FastRoute\simpleDispatcher;
use Symfony\Component\HttpFoundation\Session\Session;

class Bootstrap
{
    /** @var DependencyInjector $dependencyInjector */
    protected $dependencyInjector;

    public function __construct(DependencyInjector $dependencyInjector)
    {
        $this->dependencyInjector = $dependencyInjector;
    }

    public function routes()
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $route) {
            require __DIR__.'/../app/routes/web.php';
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);

        if ($uri != '/') {
            $uri = rtrim(rawurldecode($uri), '/');
        }

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                echo view('errors.404');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                http_response_code(405);
                echo view('errors.404');
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                $vars = (collect($vars)->flatten()->all());
                if ($handler instanceof Closure) {
                    $handler(...$vars);
                } else {
                    $handler = explode('@', $handler);

                    $class = $handler[0];
                    $method = $handler[1];

                    $class = "App\\Controllers\\{$class}";

                    (new $class)->{$method}(...$vars);
                }

                break;

        }
    }

    public function config()
    {
        $this->dependencyInjector->register('config', function () {
            $files = collect(array_diff(scandir(__DIR__.'/../config/'), ['..', '.']));

            $config = new Config();

            $files->each(function ($file) use (&$config) {
                $config->set(explode('.', $file)[0], include __DIR__.'/../config/'.$file);
            });

            return $config;
        });
    }

    public function middleware()
    {
        collect(\App\Kernel::$middleware)->each(function ($middleware) {
            /** @var Middleware $middleware */
            $middleware = new $middleware;
            $middleware->handle();
        });
    }

    public function session()
    {
        $this->dependencyInjector->register('session', function () {
            return new Session();
        });
    }
}
