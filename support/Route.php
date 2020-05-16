<?php


namespace Support;




use RuntimeException;

/**
 * @method static get(string $path, string $callback)
 * @method static post(string $path, string $callback)
 * @method static delete(string $path, string $callback)
 * @method static put(string $path, string $callback)
 * @method static patch(string $path, string $callback)
 * @method static options(string $path, string $callback)
 */
class Route
{

    private static $namespace = 'App\\Controllers\\Http\\';

    private static $routes = [];


    public static function __callStatic($method, $arguments)
    {

        $path = array_shift($arguments);
        $handler = array_shift($arguments);
        $name = array_shift($arguments);

        if (!$path || !$handler) {
            throw new RuntimeException('Route path and callback required');
        }

        self::$routes[] = [
            'as' => $name ?? $method.'-'.$path,
            'path' => $path,
            'methods' => [$method],
            'callback' => explode('::', self::$namespace.$handler,2)
        ];
    }


    public static function add(array $methods,string $path,string $handler)
    {
        foreach ($methods as $method)
        {
            self::$method($path,$handler);
        }
    }


    public static function setNamespace(string $namespace)
    {
        self::$namespace = $namespace;
    }


    public static function getRoutes(): array
    {
        return self::$routes;
    }

}