<?php
    class Auth {
        private $conn;
        private $table = "api_users";

        // properties
        public $id;
        public $username;
        public $password;

        //construct

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = "SELECT u.username FROM $this->table as u 
                    WHERE u.username = '$this->username'
                    AND u.password = '$this->password' 
                    ORDER BY u.username ASC";
                 
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //execute query
            $stmt->execute();

            return $stmt;
        }
    }
?>