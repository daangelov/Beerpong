<?php

namespace App\Middleware;

use App\Utils\SessionSaveHandler;
use PDO;
use Slim\Http\Request;
use Slim\Http\Response;

class StartSession
{
    public function __construct(PDO $db)
    {
        // Set session name
        session_name($_ENV['SESSION_NAME']);

        // Set session handler
        session_set_save_handler(new SessionSaveHandler($db));
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        // Start session
        session_start();
        return $next($request, $response);
    }
}