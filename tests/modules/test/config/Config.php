<?php

namespace Test\Module\_Config;

use Aura\Di\Container;
use Polus\Modules\ModulesConfigInterface;
use Test\Module\Actions\ViewIndex;
use Test\Module\Actions\ViewTest2;

class Config implements ModulesConfigInterface
{
    public function define(Container $di)
    {
        $base = dirname(__DIR__);
        $di->set('test/module:resource_factory', $di->newInstance('Polus\Modules\ResourceFactory', [
            'resourcePath' => $base . '/resources',
            'resolver' => $di->lazyNew('Actus\Path'),
            'ns' => 'test',
        ]));
    }

    public function getRoutes()
    {
        $routes = [];
        $routes[] = ViewIndex::getRoutes();
        $routes[] = ViewTest2::getRoutes();

        return $routes;
    }
}
