<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Interfaces\RouterInterface;

/**
 * We can use the logic from the controllers and create an abstract
 * class Middleware that takes $container. But this is less heavy
 * because we are passing just the router.
 *
 */
class RedirectIfUnauthenticated
{
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        if (!isset($_SESSION['logged'])) {
            if ($request->isXhr()) {
                return $response->withJson(['st' => 2]);
            }
            return $response->withRedirect($this->router->pathFor('index'), 302);
        }

        return $next($request, $response);
    }
}
