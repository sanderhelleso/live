<?php
    class User {

        // db connection and table
        private $conn;
        private $usersTable = 'users';
        private $usersDataTable = 'users_data';

        // user properties
        public $id;

        // constructor with DB and user id
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
                      WHERE 
                      $this->usersTable.user_id = '$this->id'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }


        // see if email is free
        public function isEmailFree($email) {

            // check for exsisting email query
            $query = "SELECT * 
                      FROM $this->usersTable 
                      WHERE email = '$email'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        public function updateEmail($email) {

            // update user email query
            $query = "UPDATE
                      $this->usersTable
                      SET 
                      email = '$email'
                      WHERE 
                      user_id = '$this->id'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        // update user data
        public function updateUserData(
            $firstName,
            $lastName, 
            $age, 
            $country,
            $state, 
            $address, 
            $phone, 
            $newsletter
        ) {

            // update user data query
            $query = "UPDATE
                      $this->usersDataTable 
                      SET 
                      first_name = '$firstName', 
                      last_name = '$lastName',
                      age = '$age', 
                      country = '$country', 
                      state = '$state', 
                      street_address = '$address',
                      phone_number = '$phone',
                      newsletter = '$newsletter'
                      WHERE 
                      user_id = '$this->id'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        // compare and validate if password is equal to users current password
        public function comparePassword($password) {

            // check password query
            $query = "SELECT * 
                      FROM $this->usersTable 
                      WHERE  
                      user_id = '$this->id' 
                      AND
                      password = SHA('$password')";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        // update a users password
        public function updatePassword($password) {

            // update user password query
            $query = "UPDATE
                      $this->usersTable
                      SET 
                      password = SHA('$password')  
                      WHERE 
                      user_id = '$this->id'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }
    }
?>