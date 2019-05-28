<?php

namespace App\Controllers;

use PDO;
use Slim\Http\Body;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

/**
 * @property Twig view
 * @property PDO db
 */
class GameController extends Controller
{
    public function gamePage(Request $request, Response $response)
    {
        return $this->view->render($response, 'game.twig');
    }

    public function robotIp(Request $request, Response $response)
    {
        $body = new Body(fopen('php://temp', 'r+'));
        $body->write('SHIT');
        return $response->withHeader('Content-Type', 'text/plain')->withBody($body);
    }

    public function robotHit(Request $request, Response $response)
    {
        $id = $request->getParam('id');
        $pulse = $request->getParam('pulse');

        $userPlaying = $this->db
            ->query('SELECT id FROM users WHERE status = ' . USER_STATUS_PLAYING)
            ->fetch(PDO::FETCH_ASSOC);

        if ($id == '0451') {
            if ($pulse == 0) {
                $stmt = $this->db->prepare('UPDATE users SET miss = miss + 1 WHERE id = ?');
                $stmt->execute([$userPlaying['id']]);
            } else {
                $stmt = $this->db->prepare('UPDATE users SET hit = hit + 1 WHERE id = ?');
                $stmt->execute([$userPlaying['id']]);
            }
            return $response;
        }
        return 'You are HACKER';
    }
}
