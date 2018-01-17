<?php

namespace SimpleMVC;

class Config
{
    protected $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function set($key, $value = null)
    {
        $keys = explode('.', $key);

        if (count($keys) > 1) {
            $this->items[$keys[0]][$keys[1]] = $value;
        } else {
            $keys = is_array($key) ? $key : [$key => $value];

            foreach ($keys as $key => $value) {
                $this->items[$key] = $value;
            }
        }
        app()->register('config', $this);
    }

    public function get($key, $default = null)
    {
        $keys = explode('.', $key);

        if (count($keys) == 1) {
            return $this->items[$key];
        }

        return $this->items[$keys[0]][$keys[1]];
    }
}
