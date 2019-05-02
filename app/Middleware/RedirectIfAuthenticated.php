<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Interfaces\RouterInterface;

class RedirectIfAuthenticated
{
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        if (isset($_SESSION['logged'])) {
            return $response->withRedirect($this->router->pathFor('queue'), 302);
        }

        return $next($request, $response);
    }
}