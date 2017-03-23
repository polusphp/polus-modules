<?php

namespace Polus\Modules\Adapter;

use Polus\Modules\Payload;

interface ResponseHandlerInterface
{
    public function transform(Payload $payload);
}
