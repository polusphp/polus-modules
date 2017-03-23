<?php

namespace Polus\Modules\Adapter\Polus;

use Aura\Di\Container;
use Polus\DispatchResolverInterface;
use Polus\Modules\Adapter\ActionResolverInterface;

class DispatcherResolver implements DispatchResolverInterface, ActionResolverInterface
{
    protected $container;
    protected $ns = [];

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function addModule($ns)
    {
        $this->ns[] = $ns;
    }

    public function resolveController($controllerName)
    {
        $custom = false;
        foreach ($this->ns as $ns) {
            if (stripos($controllerName, $ns) === 0) {
                $custom = $ns;
                break;
            }
        }

        $params = [];
        if ($custom) {
            $map = [
                'payload_factory' => 'payloadFactory',
                'resource_factory' => 'resourceFactory',
                'model_factory' => 'moduleModel',
            ];
            $baseKey = strtolower(str_replace('\\', '/', $custom));
            foreach ($map as $key => $var) {
                if ($this->container->has($baseKey . ':' . $key)) {
                    $params[$var] = $this->container->lazyGet($baseKey . ':' . $key);
                } elseif ($this->container->has('polus/modules:' . $key)) {
                    $params[$var] = $this->container->lazyGet('polus/modules:' . $key);
                }
            }
        }

        $controller = $this->container->newInstance($controllerName, $params);
        return $controller;
    }
}
