<?php

namespace App\Utils;

use PDO;
use SessionHandlerInterface;

class SessionSaveHandler implements SessionHandlerInterface
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function open($save_path, $name)
    {
        if ($this->db) {
            //$this->gc();
            return true;
        }
        return false;
    }

    public function close()
    {
        return true;
    }

    public function read($session_id)
    {
        $stmt = $this->db->prepare('SELECT session_data FROM sessions WHERE session_id = ?');
        if ($stmt->execute([$session_id])) {
            $session = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($session) {
                return $session['session_data'];
            }
            return '';
        }

        return '';
    }

    public function write($session_id, $session_data)
    {
        $stmt = $this->db->prepare('INSERT INTO sessions (session_id, session_data) VALUES(:session_id, :session_data) ON DUPLICATE KEY UPDATE session_data = :session_data, updated_on = CURRENT_TIMESTAMP');
        if ($stmt->execute([':session_id' => $session_id, ':session_data' => $session_data])) {
            return true;
        }
        return false;
    }

    public function destroy($session_id)
    {
        $stmt = $this->db->prepare('DELETE FROM sessions WHERE session_id = ?');
        if ($stmt->execute([$session_id])) {
            return true;
        }
        return false;
    }

    public function gc($maxlifetime = 120)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM sessions WHERE updated_on < CURRENT_TIMESTAMP - INTERVAL :lifetime SECOND;
            DELETE FROM users WHERE updated_on < CURRENT_TIMESTAMP - INTERVAL :lifetime SECOND;");
        if ($stmt->execute([':lifetime' => $maxlifetime])) {
            return true;
        }
        return false;
    }
}
