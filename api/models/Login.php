<?php

    /**
     * Login class to handle login users of the system
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * This class represent a login system that allow users to log into
    * our application. On login the class will search for matching E-Mail
    * and password and compare. If match we set token from Authenticate.php
    * and log the user in to our application
    */
    
    class Login {

        // db connection and table
        private $conn;
        private $table = 'users';

        // login properties
        public $email;
        public $password;

        // constructor with DB and login properties
        public function __construct($db, $email, $password) {
            $this->conn = $db;
            $this->email = $email;
            $this->password = $password;
        }


        /**
         * Attempt to find matching user to given credentials
        */  
        public function login() {

            // login query
            $query = "SELECT * 
                      FROM 
                      $this->table 
                      WHERE email = '$this->email'
                      AND 
                      password = SHA('$this->password')";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }
    }
?>