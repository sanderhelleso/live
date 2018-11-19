<?php
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


        // attempt login
        public function login() {

            // login query
            $query = "SELECT * 
                      FROM $this->table 
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