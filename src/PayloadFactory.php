<?php

namespace Polus\Modules;

use Polus\Modules\Payload;

class PayloadFactory
{
    protected function getFormat($format)
    {
        if ($format == 'json') {
            return Payload::XHR;
        }
        return Payload::HTML;
    }

    public function newPayload($data)
    {
        return new Payload(
            $data['payload'] ?: [],
            $this->getFormat($data['format']),
            $data['meta'] ?? false,
            $data['template'] ?: false,
            $data['status'] ?? 'success'
        );
    }
}
