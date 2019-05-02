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

    public function login(Request $request, Response $response)
    {
        $username = $request->getParam('username');

        // Validate username
        $usernameLength = strlen($username);
        if ($usernameLength < 1 || $usernameLength > 255) {
            $this->flash->addMessage('error', 'Invalid username');
            return $response->withRedirect($this->router->pathFor('index'));
        }



        $_SESSION['username'] = $username;
        $_SESSION['logged'] = true;

        return $response->withRedirect($this->router->pathFor('queue'));
    }

    public function queuePage(Request $request, Response $response)
    {
        $users = $this->db->query('SELECT * FROM sessions')->fetchAll(PDO::FETCH_ASSOC);

        return $this->view->render($response, 'queue.twig', $users);
    }
}