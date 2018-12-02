<?php

    /**
     * Database class that connects the application to the given database
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * This class represent Database that connects the application to the given database
    * and is used in all API calls to communicate with the database. Class is usually 
    * connected as "conn". The class requires the following properties to be enable
    * to connect:
    *
    * --- PROPERTIES ---

    *   1. HOST
    *   2. DATABASE NAME
    *   3. USERNAME
    *   4. PASSWORD
    */

    class Database {

        /**
         *NOTE* Before going prodcution, change properties and store in safe file thats not commited
        */

        // db params 
        private $host = 'localhost';
        private $dbName = 'live';
        private $username = 'live_administrator';
        private $password = 'GznUDh1AN8n60JlE'; 
        private $conn;  

        /**
         * Attempt to connect to database using releated properties
        */
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
                echo 'Connection Error: ' . $e->getMessage() . '<br>Attempting to reconnect...';

                // attempt to reconnect after 5 secounds
                sleep(5);
                $this->connect();
            }

            return $this->conn;
        }
    }
?>