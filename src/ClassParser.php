<?php namespace Maer\Croute;

use ReflectionClass;
use Reflector;

class ClassParser
{
    /**
     * File to parse
     * @var string
     */
    protected $file;

    /**
     * Qualified class name
     * @var string
     */
    protected $className;

    /**
     * Class annotations
     * @var string
     */
    protected $classAnnotations = [];

    /**
     * Valid class & method annotations
     * @var array
     */
    protected $validAnnotaions = [
        'class' => [
            'routePrefix' => 'prefix',
            'routeBefore' => 'before',
            'routeAfter'  => 'after',
        ],
        'method' => [
            'route'       => 'route',
            'routeName'   => 'name',
            'routeBefore' => 'before',
            'routeAfter'  => 'after',
        ],
    ];


    /**
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file             = $file;
        $this->className        = $this->getClassName();
    }


    /**
     * Get all class routes
     *
     * @return array
     */
    public function getRoutes()
    {
        if (!$this->className) {
            return [];
        }

        $class = new ReflectionClass($this->className);
        $this->classAnnotations = $this->getAnnotations('class', $class);

        $routes = [];
        foreach ($class->getMethods() as $method) {
            if ($route = $this->getAnnotations('method', $method)) {
                $route['callback'] = $this->className . '@' . $method->getName();
                $routes[] = new Route($route);
            }
        }

        return $routes;
    }


    /**
     * Get the class qualified name
     *
     * @param  string $filePath
     * @return string|null
     */
    protected function getClassName()
    {
        $getNs    = false;
        $getClass = false;
        $ns    = '';
        $class = '';

        foreach (token_get_all(file_get_contents($this->file)) as $token) {
            $type  = $token[0] ?? null;
            $value = trim(is_array($token) ? $token[1] : $token);

            if (T_NAMESPACE === $type) {
                $getNs = true;
                continue;
            }

            if (T_CLASS === $type) {
                $getClass = true;
                continue;
            }

            if (';' == $value || '{' == $value) {
                $getNs = $getClass = false;
                continue;
            }

            $ns    .= $getNs ? $value : '';
            $class .= $getClass ? $value : '';
        }

        return $ns ? $ns . '\\' . $class : $class;
    }


    /**
     * Get all relevant doc comment annotations
     *
     * @param  string    $type
     * @param  Reflector $class
     * @return array
     */
    protected function getAnnotations($type, Reflector $class)
    {
        $comments = $class->getDocComment();
        preg_match_all('/\@(\w+)\s+([^\s]+)\s+([^\*\s]+)?/i', $comments, $matches);

        if (empty($matches[1])) {
            return [];
        }

        $annotations = [];

        if ('method' == $type) {
            $annotations = [
                'route'  => $this->classAnnotations['prefix'] ?? '',
                'before' => $this->classAnnotations['before'] ?? [],
                'after'  => $this->classAnnotations['after'] ?? [],
            ];
        }

        foreach ($matches[1] as $index => $match) {
            $key   = $this->validAnnotaions[$type][$match] ?? null;
            $value = $matches[2][$index] ?? null;

            if (!$key || !$value) {
                continue;
            }

            if ('route' == $key && !empty($matches[3][$index])) {
                $annotations['route']  .= '/' . ltrim($matches[3][$index], '/');
                $annotations['method']  = $value;
                continue;
            }

            if ('name' == $key) {
                $annotations['name'] = $value;
                continue;
            }

            if ('prefix' == $key) {
                $annotations['prefix'] = '/' . trim($value, '/');
                continue;
            }

            if ('before' == $key || 'after' == $key) {
                $annotations[$key][] = $value;
            }
        }

        if ('method' == $type) {
            return !empty($annotations['method']) ? $annotations : [];
        }

        return $annotations;
    }
}
