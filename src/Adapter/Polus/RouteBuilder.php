<?php

namespace Polus\Modules\Adapter\Polus;

use Aura\Router\Map;
use Aura\Router\Route;
use Polus\DispatchInterface;
use Polus\Modules\Adapter\AdapterInterface;
use Polus\Modules\Adapter\ResponseHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouteBuilder implements AdapterInterface
{
    protected $routes = [];
    protected $map;
    protected $responseHandler;

    public function __construct(ResponseHandlerInterface $responseHandler, Map $map, DispatchInterface $dispatcher)
    {
        $this->map = $map;
        $this->responseHandler = $responseHandler;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(Map $map)
    {
        $dispatcher = $this->dispatcher;
        $responseHandler = $this->responseHandler;

        foreach ($this->routes as $routeAction) {
            $tokens = [];
            if ($routeAction->hasTokens()) {
                $tokens = $routeAction->getTokens();
            }
            $method = strtolower($routeAction->getStringVerb());

            $action = function (Route $route, ServerRequestInterface $request, ResponseInterface $response) use ($dispatcher, $routeAction, $responseHandler) {
                $route->handler($routeAction->getAction());
                $payload = $dispatcher->dispatch($route, $request, $response);
                return $responseHandler->transform($payload, $response);
            };

            foreach ($routeAction->getRoutes() as $route) {
                $auraRute = $map->$method(md5($route), $route, $action);
                $auraRute->tokens($tokens);
            }
        }
    }

    public function mount($pathPrefix, array $actions)
    {
        $this->routes = $actions;
        $this->map->attach(str_replace('/', '_', $pathPrefix) . '.', $pathPrefix, $this);
    }
}
