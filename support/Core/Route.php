<?php

namespace Support\Core;

use Support\Core\View;
use ReflectionFunction;
use ReflectionMethod;

class Route
{
    protected static array $routes = [];
    protected static string $prefix = '';
    protected static array $globalWheres = [];
    protected static array $groupMiddleware = [];
    public static function prefix(string $prefix, callable $callback): void
    {
        $previousPrefix = self::$prefix;
        self::$prefix = rtrim($previousPrefix . '/' . trim($prefix, '/'), '/');
        $callback();
        self::$prefix = $previousPrefix;
    }

    public static function get($path, $callback): RouteFluent
    {
        $fullPath = self::fullPath($path);
        $route = new RouteFluent('GET', $fullPath, $callback);
        $route->middleware = self::$groupMiddleware; 
        self::$routes['GET'][$fullPath] = $route;
        return $route;
    }

    public static function post($path, $callback): RouteFluent
    {
        $fullPath = self::fullPath($path);
        $route = new RouteFluent('POST', $fullPath, $callback);
        $route->middleware = self::$groupMiddleware; 
        self::$routes['POST'][$fullPath] = $route;
        return $route;
    }

    public static function middleware(array $middlewares, ?callable $callback = null)
    {
        if ($callback) {
            $previousMiddleware = self::$groupMiddleware;
            self::$groupMiddleware = array_merge(self::$groupMiddleware, $middlewares);
            $callback();
            self::$groupMiddleware = $previousMiddleware;
        } else {
            return function (RouteFluent $route) use ($middlewares) {
                $route->middleware = array_merge($route->middleware, $middlewares);
                return $route;
            };
        }
    }
    public static function where(array $wheres): void
    {
        self::$globalWheres = $wheres;
    }

    protected static function fullPath(string $path): string
    {
        $combined = rtrim(self::$prefix . '/' . ltrim($path, '/'), '/');
        return $combined === '' ? '/' : $combined;
    }

    public static function dispatch()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = rtrim($requestUri, '/');
        $requestUri = $requestUri === '' ? '/' : $requestUri;
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes[$requestMethod] as $path => $route) {
            $paramNames = [];
            $regex = self::generateRegex($route->path, $paramNames, $route->wheres);

            if (preg_match($regex, $requestUri, $matches)) {
                array_shift($matches);
                $params = array_combine($paramNames, $matches) ?: [];

                $controllerCallback = function () use ($route, $params) {
                    if (is_array($route->callback)) {
                        $controller = new $route->callback[0]();
                        $method = $route->callback[1];

                        $reflection = new ReflectionMethod($controller, $method);
                        $arguments = [];

                        if ($reflection->getNumberOfParameters() > 0) {
                            $firstParam = $reflection->getParameters()[0];
                            if ($firstParam->getType() && $firstParam->getType()->getName() === \Support\Core\Request::class) {
                                $request = new \Support\Core\Request();
                                $arguments[] = $request;
                            }
                        }

                        $arguments = array_merge($arguments, $params);

                        return call_user_func_array([$controller, $method], $arguments);
                    }

                    if (is_callable($route->callback)) {
                        return call_user_func_array($route->callback, $params);
                    }
                };

                if (!empty($route->middleware)) {
                    return self::runMiddlewares($route->middleware, $_REQUEST, $controllerCallback);
                } else {
                    return $controllerCallback();
                }
            }
        }

        http_response_code(404);
        return View::render('errors/404', ['message' => 'Page with the specified address not found']);
        
        //http_response_code(403);
        //return View::render('errors/403', ['message' => 'Forbidden']);
        
        //http_response_code(401);
        //return View::render('errors/401', ['message' => 'Unauthorized']);
        
    }

    private static function runMiddlewares(array $middlewares, $request, $controllerCallback)
    {
        $pipeline = array_reduce(
            array_reverse($middlewares),
            function ($next, $middlewareClass) {
                return function ($request) use ($middlewareClass, $next) {
                    $middleware = new $middlewareClass();
                    return $middleware->handle($request, $next);
                };
            },
            $controllerCallback
        );

        return $pipeline($request);
    }

    private static function generateRegex(string $path, array &$paramNames = [], array $wheres = []): string
    {
        $wheres = array_merge(self::$globalWheres, $wheres);

        $regex = preg_replace_callback('#\{([^}]+)\}#', function ($matches) use (&$paramNames, $wheres) {
            $paramNames[] = $matches[1];
            $param = $matches[1];

            if (isset($wheres[$param])) {
                return '(' . $wheres[$param] . ')';
            }

            return '([^/]+)';
        }, $path);

        return '#^' . $regex . '$#';
    }
}