<?php

    class ResetPassword {

        // db connection, tables and domain
        private $conn;
        private $usersTable = 'users';
        private $forgotPasswordTable = 'forgot_password';

        // reset password properties
        public $email;
        public $reset_url;

        // constructor with DB and reset password properties
        public function __construct($db, $reset_url) {
            $this->conn = $db;
            $this->reset_url = $reset_url;
        }

        // validate given url
        public function validateUrl() {

            // find user ID query
            $query = "SELECT user_id
                      FROM 
                      $this->forgotPasswordTable
                      WHERE reset_url = '$this->reset_url'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        // delete a specific reset url
        public function deleteUrl() {

            // delete reset url query
            $query = "DELETE
                      FROM 
                      $this->forgotPasswordTable
                      WHERE reset_url = '$this->reset_url'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }
    }
?>