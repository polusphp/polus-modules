<?php

namespace Polus\Modules;

use Aura\Di\Container;

interface ModulesConfigInterface
{
    public function define(Container $di);
    public function getRoutes();
}
