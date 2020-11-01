<?php namespace App;

class Database {
    private $mysqli;
    public function __construct($user, $pw, $db) {
        $this->mysqli = new \mysqli("localhost", $user, $pw, $db);
    }

    public function query($q) {
        return $this->mysqli->query($q);

        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
        }
    }

}