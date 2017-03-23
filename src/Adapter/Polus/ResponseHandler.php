<?php

namespace Polus\Modules\Adapter\Polus;

use Polus\Modules\Adapter\ResponseHandlerInterface;
use Polus\Modules\Payload;

class ResponseHandler implements ResponseHandlerInterface
{
    public function transform(Payload $payload, $response = null)
    {
        if ($payload->getFormat() === Payload::XHR) {
            $response = $response->withHeader('Content-type', 'application/json');
            $response->getBody()->write(json_encode($payload->getJsend()));
        } elseif ($payload->getFormat() === Payload::HTML) {
            $response->getBody()->write(serialize($payload->getData()));
        } else {
            $response = $response->withStatus(404);
        }
        return $response;
    }
}
