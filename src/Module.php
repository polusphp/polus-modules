<?php

namespace Polus\Modules;

use Aura\Di\Container;
use Polus\Modules\Adapter\ActionResolverInterface;

class Module
{
    public function __construct($ns, $pathPrefix, ActionResolverInterface $actionResolver, Container $factory)
    {
        $configClass = $ns . '\_Config\Config';
        $config = new $configClass();
        $config->define($factory);

        $actionResolver->addModule($ns);

        $this->routes = $config->getRoutes();

        $this->pathPrefix = $pathPrefix;
        $this->factory = $factory;
    }

    public function attach()
    {
        $builder = $this->factory->get('polus/modules:route_builder');
        return $builder->mount($this->pathPrefix, $this->routes);
    }
}
