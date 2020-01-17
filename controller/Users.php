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

        public function paginate($pageNo, $records_per_page) {

            $offset = $pageNo * $records_per_page;

            //build query, LIMIT clause that is used to specify the number of records to return.
            $query = "SELECT * FROM $this->table LIMIT $offset, $records_per_page";

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //execute query
            $stmt->execute();

            return $stmt;
        }
    }
?>