<?php

namespace Polus\Modules\Adapter\Silex;

use Polus\Modules\Adapter\AdapterInterface;
use Polus\Modules\Adapter\ResponseHandlerInterface;
use Polus\Modules\Object\Account;
use ReflectionMethod;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class RouteBuilder implements ControllerProviderInterface, AdapterInterface
{
    protected $routes = [];

    protected $resolver;

    protected $responseHandler;

    public function __construct(ResponseHandlerInterface $responseHandler, Application $app, ActionResolver $resolver)
    {
        $this->responseHandler = $responseHandler;
        $this->resolver = $resolver;
        $this->app = $app;
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        foreach ($this->routes as $routeAction) {
            $method = strtolower($routeAction->getStringVerb());
            $action = function (Application $app, Request $request) use ($routeAction) {
                $methodReflection = new ReflectionMethod($routeAction->getAction(), '__invoke');

                $action = $this->resolver->resolveAction($routeAction->getAction());
                $payload = $methodReflection->invokeArgs(
                    $action,
                    $this->getActionArguments(
                        $app,
                        $request,
                        $methodReflection->getParameters()
                    )
                );
                return $this->responseHandler->transform($payload);
            };
            foreach ($routeAction->getRoutes() as $route) {
                $silexRoute = $controllers->$method($route, $action);
                if ($routeAction->hasTokens()) {
                    foreach ($routeAction->getTokens() as $token => $rule) {
                        $silexRoute->assert($token, $rule);
                    }
                }
            }
        }

        return $controllers;
    }

    public function mount($pathPrefix, array $actions)
    {
        $this->routes = $actions;
        $this->app->mount($pathPrefix, $this);
    }

    protected function getActionArguments(Application $app, Request $request, array $parameters)
    {
        $attr = $request->attributes->all();
        $arguments = [];
        foreach ($parameters as $param) {
            /* @var $param ReflectionParameter */
            if (isset($attr[$param->getName()])) {
                $arguments[] = $attr[$param->getName()];
            } elseif ($param->getName() === 'account') {
                $arguments[] = new Account($app['auth']->user);
            } elseif (isset($app[$param->getName()])) {
                $arguments[] = $app[$param->getName()];
            } else {
                $arguments[] = $param->getDefaultValue();
            }
        }
        return $arguments;
    }
}
