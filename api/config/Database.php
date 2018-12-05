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
         private $host;
         private $dbName;
         private $username;
         private $password;
         private $conn; 

         /**
         * Set database conenction properties depnding on dev / prod enviorment
        */
         public function setParams() {

            if ($_SERVER['SERVER_NAME'] == 'liveapp') { // running on wamp / localhost

                $this->host = $_ENV['HOST'];
                $this->dbName = $_ENV['DB_NAME'];
                $this->username = $_ENV['DB_USERNAME'];
                $this->password = $_ENV['DB_PASSWORD']; 
            }

            else { // running on heroku

                $this->host = getenv('DB_HOST');
                $this->dbName = getenv('DB_NAME');
                $this->username = getenv('DB_USERNAME');
                $this->password = getenv('DB_PASSWORD'); 
            }
         }


        /**
         * Attempt to connect to database using releated properties
        */
        public function connect() {
            $this->conn = null;
            $this->setParams();

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