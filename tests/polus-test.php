<?php
require '../vendor/autoload.php';

$urlsToTest = [
    '/test/15.json',
    '/test/15',
    '/test/test-2',
];

use Polus\App;
use Zend\Diactoros\ServerRequestFactory;

$app = new App('Test');

$container = $app->getContainer();
$container->set('polus/modules:route_builder', $container->lazyNew('Polus\Modules\Adapter\Polus\RouteBuilder', [
    'responseHandler' => $container->lazyNew('Polus\Modules\Adapter\Polus\ResponseHandler'),
    'map' => $app->getMap(),
    'dispatcher' => $app->getDispatcher(),
]));

$actionResolver = $container->get('polus:dispatch_resolver');

$module = new Polus\Modules\Module('Test\Module', '/test', $actionResolver, $container);
$module->attach();

foreach ($urlsToTest as $url) {
    echo "Test url: $url\n";
    $_SERVER['REQUEST_URI'] = $url;
    $app->setRequest(ServerRequestFactory::fromGlobals());
    $app->run();

    echo "\n-----------------------------------------\n";
}
