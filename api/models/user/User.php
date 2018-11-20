<?php
    class User {

        // db connection and table
        private $conn;
        private $usersTable = 'users';
        private $usersDataTable = 'users_data';

        // user properties
        public $id;

        // constructor with DB and login properties
        public function __construct($db, $id) {
            $this->conn = $db;
            $this->id = $id;
        }


        // fetch user data
        public function getUserData() {

            // retieve users data query
            $query = "SELECT 
                      $this->usersDataTable.*,
                      $this->usersTable.email 
                      FROM $this->usersDataTable
                      INNER JOIN $this->usersTable
                      ON
                      $this->usersDataTable.user_id = $this->usersTable.user_id
                      WHERE '$this->id'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }
    }
?>