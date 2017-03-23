<?php

namespace Test\Module\Actions;

use Polus\Modules\PayloadFactory;
use Polus\Modules\ResourceFactory;
use Polus\Modules\RouteAction;

class ViewIndex
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
            ViewIndex::class,
            null,
            [
                '/{id}',
                '/{id}.{format}',
            ],
            [
                'id' => '[0-9]+',
            ]
        );
    }

    public function __invoke($id, $format = 'html')
    {
        $tpl = $this->resourceFactory->resolveTemplatePath('view-test.php');
        return $this->payloadFactory->newPayload([
            'payload' => [
                'test' => "hej:" . $id,
                'tpl' => $tpl,
            ],
            'format' => $format,
            'template' => $tpl,
        ]);
    }
}
