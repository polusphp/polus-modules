<?php

namespace Polus\Modules\Adapter\Silex;

use Polus\Modules\Adapter\ResponseHandlerInterface;
use Polus\Modules\Payload;
use Silex\Application;

class ResponseHandler implements ResponseHandlerInterface
{
    protected $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function transform(Payload $payload)
    {
        if ($payload->getFormat() === Payload::XHR) {
            return $this->app->json($payload->getJsend());
        } elseif ($payload->getFormat() === Payload::HTML) {
            return serialize($payload->getData());
        }
        return $this->app->abort(404);
    }
}
