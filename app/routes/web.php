<?php /** @var FastRoute\RouteCollector $route */

use App\Models\User;

$route->get('/', function () {
    return view('welcome',[
        'message' => "Simple MVC"
    ]);
});

$route->get('/home', 'HomeController@index');

$route->get('/users', function () {
    return User::all();
});
$route->get('/users/{id}', function ($id) {
    return User::find($id);
});

$route->get('/{name}', function ($name) {
    return "<h1> Hi, {$name}! </h1>";
});

$route->get('/home/show', 'HomeController@show');