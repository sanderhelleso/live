<?php
    class Database {

        // db params 

        // *NOTE* Before live, change properties and store i safe file thats not commited
        private $host = 'localhost';
        private $dbName = 'live';
        private $username = 'live_administrator';
        private $password = 'GznUDh1AN8n60JlE'; 
        private $conn;  

        // connect db
        public function connect() {
            $this->conn = null;

            try {
                // attempt to connect to database
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName, $this->username, $this->password);

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