<?php
if (!function_exists('request')) {
    function request($key = null)
    {
        $symfony_request = (new \Symfony\Component\HttpFoundation\Request(
            $_GET,
            $_POST,
            array(),
            $_COOKIE,
            $_FILES,
            $_SERVER
        ));

        $request = collect($symfony_request->query);

        $request = $request->merge($symfony_request->request);

        if ($key) return $request->get($key);

        return $request;
    }
}

if (!function_exists('view')) {
    function view($name)
    {
        $name = str_replace('.', '/', $name) . '.php';

        return file_get_contents(__DIR__ . '/views/' . $name);
    }
}