<?php

namespace App\Controllers;

use DateTime;
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
        $stmt = $this->db->prepare('
            SELECT * FROM users WHERE created_on < (
              SELECT created_on FROM users WHERE id = ?
            )
        ');
        $stmt->execute([$_SESSION['userId']]);

        $prevUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $countPrevUsers = count($prevUsers);

        if ($countPrevUsers > 1) {
            return $response->withJson(['st' => 0]);
        } else if ($countPrevUsers > 0) {
            $prevUserCreatedOn = DateTime::createFromFormat('Y-m-d H:i:s', $prevUsers[0]['created_on'])->getTimestamp();
            $now = strtotime("-2 minutes");

            if ($prevUserCreatedOn > $now) {
                return $response->withJson(['st' => 0]);
            }

            $this->db->query('DELETE FROM users WHERE id = ' . $prevUsers[0]['id']);
            $this->db->query('UPDATE users SET status = 1 WHERE id = ' . $_SESSION['id']);
            return $response->withJson(['st' => 1]);

        } else {
            $this->db->query('UPDATE users SET status = 1 WHERE id = ' . $_SESSION['id']);
            return $response->withJson(['st' => 1]);
        }
    }
}
