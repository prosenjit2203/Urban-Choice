<?php

class Database {

    private $host = "localhost";
    private $db = "urban_choice";
    private $user = "root";
    private $pass = "";

    public $conn;

    public function connect() {

        try {

            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db}",
                $this->user,
                $this->pass
            );

            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $this->conn;

        } catch (Exception $e) {

            die(
                "Database Connection Failed : "
                . $e->getMessage()
            );
        }
    }
}
?>