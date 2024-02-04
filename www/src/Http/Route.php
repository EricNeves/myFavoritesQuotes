<?php 

namespace App\Http;

class Route 
{
    private static array $routes      = [];
    
    public function __construct(
        private string $method, 
        private string $path, 
        private string $controller, 
        private array  $routeMiddlewares = []
    ) {}

    public static function get(string $path, string $controller): Route  
    {
        return new self('GET', $path, $controller);
    }

    public static function post(string $path, string $controller): Route  
    {
        return new self('POST', $path, $controller);
    }

    public static function put(string $path, string $controller): Route  
    {
        return new self('PUT', $path, $controller);
    }

    public static function delete(string $path, string $controller): Route  
    {
        return new self('DELETE', $path, $controller);
    }

    public function middleware(string ...$middlewares): Route
    {
        $this->routeMiddlewares = $middlewares;
        return $this;
    }

    public function register(): void
    {
        self::$routes[] = [
            'method'      => $this->method,
            'path'        => $this->path,
            'controller'  => $this->controller,
            'middlewares' => $this->routeMiddlewares
        ];
    }

    public static function getRoutes()
    {
        return self::$routes;
    }
}