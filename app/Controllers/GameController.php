<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

/**
 * @property Twig view
 */
class GameController extends Controller
{
    public function gamePage(Request $request, Response $response)
    {
        return $this->view->render($response, 'game.twig');
    }
}
