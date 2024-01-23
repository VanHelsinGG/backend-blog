<?php

namespace Api\Php\Router;

use Exception;
use InvalidArgumentException;
use Api\Php\Handler\Request;

class Router
{
    protected $request;
    protected static $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __get($property)
    {
        if ($property === 'routes') {
            return self::$routes;
        }
    }

    public function route()
    {
        $uri = $this->request->uri();
        $method = $this->request->method();

        $routeFound = false;

        foreach (self::$routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                $this->handleRoute($route['controller'], $route['controllerMethod']);
                $routeFound = true;
            }
        }

        if (!$routeFound) {
            $this->handleException(new Exception('No matching route found'), 404);
        }
    }

    protected function handleRoute($controller, $controllerMethod)
    {
        try {
            $controllerClass = '\Api\Php\Controllers\\' . $controller;

            if (!class_exists($controllerClass)) {
                throw new InvalidArgumentException('Controller ' . $controller . ' not found');
            }

            $controllerInstance = new $controllerClass;

            if (!method_exists($controllerInstance, $controllerMethod)) {
                throw new InvalidArgumentException("Method '" . $controllerMethod . "' not exists in controller");
            }

            $controllerInstance->$controllerMethod($this->request);

        } catch (InvalidArgumentException $e) {
            $this->handleException($e, 400);
        } catch (Exception $e) {
            $this->handleException($e, 500);
        }
    }

    protected function handleException($exception, $statusCode)
    {
        header('Content-Type: application/json', true, $statusCode);
        echo json_encode(['error' => $exception->getMessage()]);
        exit;
    }

    protected static function addRoute($method, $path, $controller, $controllerMethod)
    {
        self::$routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
        ];
    }

    public static function get($path, $controller)
    {
        list($controller, $controllerMethod) = self::getController($controller);

        self::addRoute('GET', $path, $controller, $controllerMethod);
    }

    public static function post($path, $controller)
    {
        list($controller, $controllerMethod) = self::getController($controller);

        self::addRoute('POST', $path, $controller, $controllerMethod);
    }

    public static function patch($path, $controller)
    {
        list($controller, $controllerMethod) = self::getController($controller);

        self::addRoute('PATCH', $path, $controller, $controllerMethod);
    }

    public static function delete($path, $controller)
    {
        list($controller, $controllerMethod) = self::getController($controller);

        self::addRoute('DELETE', $path, $controller, $controllerMethod);
    }

    protected static function getController($controller)
    {
        return explode('@', $controller);
    }
}
