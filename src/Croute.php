<?php namespace Maer\Croute;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Croute
{
    /**
     * Registered paths
     * @var array
     */
    protected $paths;

    /**
     * Fetched routes
     * @var array
     */
    protected $routes;


    /**
     * @param array $paths
     */
    public function __construct($paths = null)
    {
        if (is_string($paths)) {
            $paths = [$paths];
        }

        $this->paths = $paths ?: [];
    }


    /**
     * Add one or more paths where to look for controllers
     *
     * @param  string|array $path
     * @return $this
     */
    public function addPath($path)
    {
        if (is_string($path)) {
            $path = [$path];
        }

        $this->paths = array_merge($this->paths, $path);

        return $this;
    }


    /**
     * Get routes from the regiestered paths
     *
     * @param  boolean $regenerate Regenerate all routes
     * @return array
     */
    public function getRoutes($regenerate = false)
    {
        if ($regenerate === true || is_null($this->routes)) {
            $this->routes = [];

            foreach ($this->paths as $path) {
                if (!$routes = $this->getPathRoutes($path)) {
                    continue;
                }

                $this->routes = array_merge($this->routes, $routes);
            }
        }

        return $this->routes;
    }

    /**
     * Get all routes from a path
     *
     * @param  string $path
     * @return array
     */
    public function getPathRoutes($path)
    {
        if (!file_exists($path)) {
            return [];
        }

        if (is_file($path)) {
            // It's a file, parse it directly
            return (new ClassParser($path))->getRoutes();
        }

        $di     = new RecursiveDirectoryIterator($path);
        $items  = new RecursiveIteratorIterator($di);

        $routes = [];

        foreach ($items as $f) {
            if ($f->isDir()) {
                if ($f->getBasename() != '.' && $f->getBasename() != '..') {
                    $this->getPathRoutes($f->getRealPath());
                }
                continue;
            }

            if (!$f->isDir() && $f->getExtension() != 'php') {
                continue;
            }

            if ($classRoutes = (new ClassParser($f->getRealPath()))->getRoutes()) {
                $routes = array_merge($routes, $classRoutes);
            }
        }

        return $routes;
    }
}
