<?php

namespace Polus\Modules;

class Payload
{
    const HTML = 1;
    const XHR = 2;

    public function __construct(
        array $payload,
        $format = self::HTML,
        $meta = [],
        $template = '',
        $jsendStatus = 'success'
    ) {
        $this->payload = $payload;
        $this->format = $format;
        $this->meta = $meta;
        $this->template = $template;
        $this->jsendStatus = $jsendStatus;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getJsend()
    {
        if ($this->jsendStatus === 'error') {
            return [
                'status' => 'error',
                'message' => $this->payload['message'] ?: '',
                'code' => $this->payload['code'] ?: 0,
                'data' => $this->payload ?: [],
            ];
        }
        $data = $this->payload;
        if ($this->meta) {
            $data['meta'] = $this->meta;
        }
        return [
            'status' => $this->jsendStatus,
            'data' => $data,
        ];
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function getData()
    {
        return $this->payload;
    }
}
