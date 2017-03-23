<?php

namespace Polus\Modules\_Common;

use Aura\Di\Container;

class Config
{
    public function define(Container $di)
    {
        if (!$di->has('polus/modules:payload_factory')) {
            $di->set('polus/modules:payload_factory', $di->lazyNew('Polus\Modules\PayloadFactory'));
        }
    }
}
