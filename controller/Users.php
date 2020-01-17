<?php
    class Users {
        private $conn;
        private $table = "students";

        // properties
        public $id;
        public $firstName;
        public $lastName;
        public $group;

        //construct

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = "SELECT * FROM $this->table ORDER BY first_name ASC";
                 
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //execute query
            $stmt->execute();

            return $stmt;
        }
    }
?>