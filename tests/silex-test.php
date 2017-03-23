<?php
require '../vendor/autoload.php';

$urlsToTest = [
    '/test/15.json',
    '/test/15',
    '/test/test-2',
];

use Aura\Di\Container;
use Aura\Di\Factory;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

$app = new Application();
$container = new Container(new Factory);
$config = new Test\_Config\SilexCommon;
$config->define($container);

$actionResolver = $container->newInstance('Polus\Modules\Adapter\Silex\ActionResolver', ['container' => $container]);
$container->set('polus/modules:route_builder', $container->lazyNew('Polus\Modules\Adapter\Silex\RouteBuilder', [
    'responseHandler' => $container->lazyNew('Polus\Modules\Adapter\Silex\ResponseHandler'),
    'app' => $app,
    'resolver' => $actionResolver,
]));

$module = new Polus\Modules\Module('Test\Module', '/test', $actionResolver, $container);
$module->attach();

foreach ($urlsToTest as $url) {
    echo "Test url: $url\n";
    $_SERVER['REQUEST_URI'] = $url;
    $request = Request::createFromGlobals();
    $app->run($request);

    echo "\n-----------------------------------------\n";
}
