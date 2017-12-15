<?php require_once __DIR__ . '/../vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
    require __DIR__ . '/../app/routes/web.php';
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

if ($uri != '/')
    $uri = rtrim(rawurldecode($uri), '/');

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $vars = (collect($vars)->flatten()->all());
        if ($handler instanceof Closure) {
            echo $handler(... $vars);
        } else {
            $handler = explode("@", $handler);

            $class = $handler[0];
            $method = $handler[1];

            $class = "App\\Controllers\\{$class}";

           echo (new $class)->{$method}(... $vars);
        }

        break;
}