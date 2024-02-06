<?php

use App\Http\Request;
use App\Http\Response;
use App\Middlewares\AuthMiddleware;

/**
 * @param array $routes
 * @param array $factories
 * @param PDO   $pdo
 * @return void
 * 
 * @description Dispatch the routes and execute the controller and action
 */
function dispatch(array $routes, array $factories, PDO $pdo): void
{
    $url = '/';

    isset($_GET['url']) && $url .= $_GET['url'];

    $url !== '/' && $url = rtrim($url, '/');

    $routerFound = false;

    $prefixController = 'App\\Controllers\\';

    foreach ($routes as $route) {
        $pattern = '#^' . preg_replace('/{id}/', '(\w+)', $route['path']) . '$#';

        if (preg_match($pattern, $url, $matches)) {
            $routerFound = true;

            array_shift($matches);

            [$controller, $action] = explode('@', $route['controller']);

            if (Request::getMethod() !== $route['method']) {
                Response::json([
                    'error'   => true,
                    'success' => false,
                    'message' => 'Sorry, method not allowed.'
                ], 405);

                exit;
            }

            $userAuth = [];

            foreach ($route['middlewares'] as $middleware) {
               if ($middleware === 'jwt') {
                    $authMiddeleware = new AuthMiddleware();

                    $userAuth = $authMiddeleware->handle(Request::authorization());
               }
            }

            if (array_key_exists($controller, $factories)) {
                $factory       = $factories[$controller];
                $extendFactory = new $factory($pdo, $userAuth);

                $currentController = $prefixController . $controller;
                $extendController  = new $currentController($extendFactory);
                
                $extendController->$action(new Request, new Response, $matches);
            }
        }
    }

    if (!$routerFound) {
        $notFoundController       = $prefixController . 'NotFoundController';
        $extendNotFoundController = new $notFoundController();
        $extendNotFoundController->index(new Request, new Response);
    }
}