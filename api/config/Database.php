<?php
    class Database {

        // db params
        private $host = 'localhost';
        private $dbName = 'live';
        private $username = 'root';
        private $password = '123456';
        private $conn;  

        // connect db
        public function connect() {
            $this->conn = null;

            try {
                // attempt to connect to database
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);

                // get potensial query errors
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }

            // if connection error, display out error message
            catch (PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }

            return $this->conn;
        }
    }
?>