new RouteAction(
    RouteAction::GET,
    TestAction::class,
    input,
    [
        '/test/{id}',
        '/test/{id}.{format}',
    ],
    [//token matching
        'id' => '[a-z0-9]+',
    ]
);