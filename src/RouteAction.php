<?php

namespace Polus\Modules;

class RouteAction
{
    const GET = 1;
    const PUT = 2;
    const POST = 3;
    const PATCH = 4;
    const DELETE = 5;

    const VERB_MAP = [
        1 => 'GET',
        2 => 'PUT',
        3 => 'POST',
        4 => 'PATCH',
        5 => 'DELETE',
    ];

    protected $verb;
    protected $action;
    protected $routes;
    protected $tokens;

    public function __construct($verb, $action, $input, array $routes, array $tokens = [])
    {
        $this->verb = $verb;
        $this->action = $action;
        $this->input = $input;
        $this->routes = $routes;
        $this->tokens = $tokens;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function hasTokens()
    {
        return count($this->tokens);
    }

    public function getTokens()
    {
        return $this->tokens;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getVerb()
    {
        return $this->verb;
    }

    public function getStringVerb()
    {
        return self::VERB_MAP[$this->verb];
    }
}
