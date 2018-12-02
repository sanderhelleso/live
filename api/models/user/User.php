<?php

    /**
     * User class that represents a user and its following abilities
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * This class represent a user in our application and allows for core functions as
    * Data retrieval, E-Mail, Password and data comparison for settings, deleting of account
    * and updating of user avatar
    */

    class User {

        // db connection and table
        private $conn;
        private $usersTable = 'users';
        private $helpersTable = 'helpers';
        private $helpersStatsTable = 'help_offer_statistics';
        private $usersDataTable = 'users_data';
        private $usersAuthTable = 'users_auth';

        // user properties
        public $id;

        // constructor with DB and user id
        public function __construct($db, $id) {
            $this->conn = $db;
            $this->id = $id;
        }


        /**
         * Attempt to fetch users releated data in releation to given users ID
        */
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

        /**
         * Attempt to fetch users releated offer help data in releation to given users ID
        */
        public function getOfferData() {

            // retieve offer data query
            $query = "SELECT 
                      $this->helpersTable.*,
                      $this->helpersStatsTable.*
                      FROM $this->helpersTable
                      INNER JOIN $this->helpersStatsTable
                      ON
                      $this->helpersTable.user_id = $this->helpersStatsTable.help_id
                      WHERE 
                      $this->helpersTable.user_id = '$this->id'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }


        /**
         * Check if given E-Mail is free in the system, used in update E-Mail (settings)
        */
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

        /**
         * Update the users current E-Mail with the new recieved
        */
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

        /**
         * Update the users current changed data with exception of password, E-Mail and avatar
        */
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

        /**
         * Compare and validate if password is equal to users current password
        */
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

        /**
         * Update the current users password of criterias are met
        */
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

        /**
         * Update the current users avatar
        */
        public function updateAvatar($avatarFile) {

            // update user avatar query
            $query = "UPDATE
                      $this->usersDataTable
                      SET 
                      avatar = '$avatarFile'  
                      WHERE 
                      user_id = '$this->id'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        /**
         * Delete the users account from the system,
         * removing all traces and data due to "ON DELETE CASCADE"
         * with foregin key constraints on users Primary Key
        */
        public function deleteAccount() {

            // delete user account query
            $query = "DELETE
                      FROM 
                      $this->usersTable
                      WHERE 
                      user_id = '$this->id'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        /**
         * Delete the users current active offer help.
         * Also removes the offers releated statistics
        */
        public function deleteOfferHelp() {

            // delete current offer query
            $query = "DELETE
                      FROM 
                      $this->helpersTable
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