<?php

    /**
     * ResetPassword class that allows user to reset their password
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * This class represent an reset password system that allows for users to 
    * reset their current password into a new password if the criterias are met.
    * This class is releated to ForgotPassword.php and will run when the user is
    * attempting to reset their password from the given generated URL.
    * Once the url has been consumed (site entered with url),
    * delete the url from the system. If the users try to re-access
    * the same route the user will get redirected to 404. User will need
    * to generate a new forgot password url
    * 
    * --- CRITERIAS ---
    *
    *   1. at least 8 characters
    *   2. at least 1 numeric character
    *   3. at least 1 lowercase letter
    *   4. at least 1 uppercase letter
    *   5. at least 1 special character
    *
    * --- REGEX USED ON CLIENT SIDE ---
    *
    *   /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;
    *
    */

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


        /**
         * Attempt to validate the given url
        */  
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

        /**
         * Attempt to delete the given url
        */  
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