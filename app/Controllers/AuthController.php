<?php

namespace App\Controllers;

use PDO;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @property Messages flash
 * @property PDO db
 */
class AuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        $username = $request->getParam('username');

        // Validate username
        $usernameLength = strlen($username);
        if ($usernameLength < 1) {
            $this->flash->addMessage('error', 'Please enter username');
            return $response->withRedirect($this->router->pathFor('index'));
        }

        if ($usernameLength > 255) {
            $this->flash->addMessage('error', 'Username too long');
            return $response->withRedirect($this->router->pathFor('index'));
        }

        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user) {
            $this->flash->addMessage('error', 'This username is already taken');
            return $response->withRedirect($this->router->pathFor('index'));
        }

        // Everything is OK
        $stmt = $this->db->prepare('INSERT INTO users (username) VALUES (?)');
        $stmt->execute([$username]);

        $_SESSION['username'] = $username;
        $_SESSION['logged'] = true;

        return $response->withRedirect($this->router->pathFor('queue'));
    }

    public function logout(Request $request, Response $response)
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE username = ?');
        $stmt->execute([$_SESSION['username']]);

        session_unset();
        session_destroy();
        return $response->withRedirect($this->router->pathFor('index'));
    }
}
