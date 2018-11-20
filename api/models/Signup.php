<?php
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
        public function __construct($db, $firstName, $lastName, $age, $country, $state, $address, $phone, $email, $password, $newsletter) {
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


        // validate credentials
        public function validate() {

            //@TODO: do form validation here...

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

        // attempt to create account with given credentials
        public function createAccount() {

            // create account query
            $query = "INSERT INTO 
                      $this->usersTable
                      (`user_id`,
                      `email`,
                      `password`)
                      VALUES
                      (NULL,
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

        // set user data for account
        public function setUserData($id) {

            // set user data query
            $query = "INSERT INTO 
                      $this->usersDataTable
                      (`user_id`, 
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
                      ($id,  
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