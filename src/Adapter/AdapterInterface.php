<?php

namespace Polus\Modules\Adapter;

interface AdapterInterface
{
    public function mount($pathPrefix, array $actions);
}
