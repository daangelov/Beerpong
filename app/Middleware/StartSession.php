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
        session_set_save_handler(new SessionSaveHandler($db), true);
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        session_name($_ENV['SESSION_NAME']);
        session_start();
        return $next($request, $response);
    }
}
