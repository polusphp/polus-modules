<?php

namespace Test\Module\Actions;

use Polus\Modules\PayloadFactory;
use Polus\Modules\ResourceFactory;
use Polus\Modules\RouteAction;

class ViewTest2
{
    protected $resourceFactory;
    protected $payloadFactory;

    public function __construct(ResourceFactory $resourceFactory, PayloadFactory $payloadFactory)
    {
        $this->resourceFactory = $resourceFactory;
        $this->payloadFactory = $payloadFactory;
    }

    public static function getRoutes()
    {
        return new RouteAction(
            RouteAction::GET,
            ViewTest2::class,
            null,
            [
                '/test-2',
            ]
        );
    }

    public function __invoke()
    {
        $tpl = $this->resourceFactory->resolveTemplatePath('view-test-2.php');
        return $this->payloadFactory->newPayload([
            'payload' => [
                'test' => "test 2",
                'tpl' => $tpl,
            ],
            'format' => 'html',
            'template' => $tpl,
        ]);
    }
}
