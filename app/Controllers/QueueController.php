<?php

namespace App\Controllers;

use PDO;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

/**
 * @property PDO db
 * @property Twig view
 */
class QueueController extends Controller
{
    public function queuePage(Request $request, Response $response)
    {
        return $this->view->render($response, 'queue.twig');
    }

    public function checkQueue(Request $request, Response $response)
    {
        $users = $this->db
            ->query('SELECT * FROM users ORDER BY created_on')
            ->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as &$user) {
            $user['badgeColor'] = $user['status'] == 0 ? 'badge-warning' : 'badge-success';
            $user['status'] = $user['status'] == 0 ? 'Waiting' : 'Playing';
            $user['bgColor'] = $user['username'] == $_SESSION['username'] ? 'bg-success' : '';
        }
        return $response->withJson(['st' => 1, 'users' => $users]);
    }

    public function checkStart(Request $request, Response $response)
    {
        return $response->withJson(['st' => 0, 'msg' => 'Go play. Feels like I am babysitting lil J']);
    }
}
