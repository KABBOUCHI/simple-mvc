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
    function view($view_name, $data = [])
    {
        $view_name = str_replace('.', '/', $view_name) . '.php';

        extract($data);

        $compiled_view = include __DIR__ . '/views/' . $view_name;

        return $compiled_view;
    }
}

if (!function_exists('config')) {
    function config($name)
    {
        $name = explode('.', $name);
        $config = include __DIR__ . '/config/' . $name[0] . '.php';

        return $config[$name[1]];
    }
}

if (!function_exists('trans')) {
    function trans($name)
    {
        $name = explode('.', $name);
        $path = __DIR__ . '/languages/' . config('app.locale') . '/' . $name[0] . '.php';
        $fallback_path = __DIR__ . '/languages/' . config('app.fallback_locale') . '/' . $name[0] . '.php';

        if (file_exists($path))
            $config = include $path;
        else
            $config = include $fallback_path;

        return $config[$name[1]];
    }
}