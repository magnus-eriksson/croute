<?php namespace Maer\Croute;

class Route
{
    public $name;
    public $method;
    public $route;
    public $before = [];
    public $after  = [];
    public $callback;


    /**
     * @param array $route
     */
    public function __construct(array $route = [])
    {
        $this->name     = $route['name'] ?? null;
        $this->method   = $route['method'] ?? null;
        $this->route    = $route['route'] ?? null;
        $this->before   = $route['before'] ?? [];
        $this->after    = $route['after'] ?? [];
        $this->callback = $route['callback'] ?? null;
    }
}
