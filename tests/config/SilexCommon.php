<?php

namespace Test\_Config;

use Aura\Di\Container;

class SilexCommon
{
    public function define(Container $di)
    {
        $base = dirname(__DIR__);
        $di->setter['Actus\Path']['setAliases'] = [
            'template' => [
                $base . '/template/',
            ],
        ];
    }
}
