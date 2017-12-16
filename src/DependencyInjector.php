<?php namespace SimpleMVC;

use Exception;

class DependencyInjector
{
    protected static $instance;
    protected $services = [];

    public function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    // Show us whats defined/available

    public function listServices($string = false)
    {
        $keys = array_keys($this->services);
        if ($string) {
            return implode(',', $keys);
        }

        return $keys;
    }

    // Register a new service

    public function __get($service_name)
    {
        return $this->getService($service_name);
    }

    public function __set($service_name, callable $callable)
    {
        $this->register($service_name, $callable);
    }

    public function getService($service_name, $args = [])
    {
        // Check if the service exists
        if (!array_key_exists($service_name, $this->services)) {
            throw new Exception("The Service: $service_name does not exist.");
        }
        if (!empty($args)) {
            return $this->services[$service_name]($args);
        }

        $value = $this->services[$service_name];
        if ($value instanceof \Closure) {
            return $value();
        } else {
            return $value;
        }
    }

    public function register($service_name, $value)
    {
        $this->services[$service_name] = $value;
    }
}