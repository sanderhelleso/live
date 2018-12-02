<?php
    /**
     * Signup class that allows users to sign up and create an account for our application
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * This class represent an sign up system that allows users to 
    * sign up and create and account for our application. Required data fields
    * for sign up is the following: 
    *
    * --- CRITERIAS FOR SIGN UP ---
    *   1. Firstname
    *   2. Lastname
    *   3. Age
    *   4. Country
    *   5. State
    *   6. Address
    *   7. Phone Number
    *   8. E-Mail
    *   9. Password
    *   10. Newsletter (Yes/No)
    *
    * NOTE: Avatar is set to null as default but users can update once thei are logged in via settings page
    */

    class Signup {

        // db connection and tables
        private $conn;
        private $usersTable = 'users';
        private $usersDataTable = 'users_data';

        // sign up data properties
        public $firstName;
        public $lastName;
        public $age;
        public $country;
        public $state;
        public $address;
        public $phone;
        public $email;
        public $password;
        public $newsletter;

        // constructor with DB and signup data properties
        public function __construct(
            $db,
            $firstName,
            $lastName,
            $age,
            $country,
            $state,
            $address,
            $phone,
            $email,
            $password,
            $newsletter
        ) {
            $this->conn = $db;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->age = $age;
            $this->country = $country;
            $this->state = $state;
            $this->address = $address;
            $this->phone = $phone;
            $this->email = $email;
            $this->password = $password;
            $this->newsletter = $newsletter;
        }


        /**
         * Attempt to validate the given sign up data,
         * Check for existing E-Mail and validates data
        */  
        public function validate() {

            // check for exsisting email query
            $query = "SELECT * 
                      FROM $this->usersTable 
                      WHERE email = '$this->email'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        /**
         * Attempt to create a new account with the given data
         * This function is reached if validation is successfull
        */ 
        public function createAccount() {

            // create account query
            $query = "INSERT INTO 
                      $this->usersTable
                      (
                      `user_id`,
                      `email`,
                      `password`
                      )
                      VALUES
                      (
                      NULL,
                      '$this->email',
                      SHA1('$this->password')
                      )";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        /**
         * Attempt to store the given data in the database
        */ 
        public function setUserData($id) {

            // set user data query
            $query = "INSERT INTO 
                      $this->usersDataTable
                      (
                      `user_id`, 
                      `first_name`, 
                      `last_name`, 
                      `age`, 
                      `country`, 
                      `state`, 
                      `street_address`,
                      `phone_number`,
                      `avatar`, 
                      `newsletter`
                      ) 
                      VALUES 
                      (
                      '$id',  
                      '$this->firstName', 
                      '$this->lastName', 
                      '$this->age', 
                      '$this->country', 
                      '$this->state', 
                      '$this->address', 
                      '$this->phone',
                      NULL, 
                      '$this->newsletter'
                      )";
                      
            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }
    }
?>