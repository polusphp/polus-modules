<?php

namespace Test\_Config;

use Aura\Di\Container;

class Common
{
    public function define(Container $di)
    {
        $base = dirname(__DIR__);
        $di->setter['Actus\Path']['setAliases'] = [
            'template' => [
                $base . '/template/',
            ],
        ];

        $di->set('polus:dispatch_resolver', $di->lazyNew('Polus\Modules\Adapter\Polus\DispatcherResolver', ['container' => $di]));
    }
}
