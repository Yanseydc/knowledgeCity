<?php
    class DataBase {
        //params
        private $host = "localhost";
        private $db_name = "test_task";
        private $username = "root";
        private $password = ""; //no password setted
        private $conn;

        public function connect() {
            try {
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
                // set the PDO error mode to exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Connected successfully";
            }
            catch(PDOException $e)
            {
                echo "Connection failed: " . $e->getMessage();
            }

            return $this->conn;
        }

    }
?>