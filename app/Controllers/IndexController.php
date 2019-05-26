<?php

namespace App\Controllers;

use PDO;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\Twig;

/**
 * @property Twig view
 * @property Router router
 * @property Messages flash
 * @property PDO db
 */
class IndexController extends Controller
{
    public function indexPage(Request $request, Response $response)
    {
        return $this->view->render($response, 'index.twig');
    }
}
