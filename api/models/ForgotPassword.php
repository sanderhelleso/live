<?php
    class ForgotPassword {

        // db connection and table
        private $conn;
        private $usersTable = 'users';
        private $forgotPasswordTable = 'forgot_password';

        // forgot password properties
        public $email;
        public $id;
        public $url;

        // constructor with DB and forgot password properties
        public function __construct($db, $email) {
            $this->conn = $db;
            $this->email = $email;
        }

        // find user ID connected to given E-Mail
        public function getId() {

            // find user ID query
            $query = "SELECT user_id
                      FROM 
                      $this->usersTable 
                      WHERE email = '$this->email'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        // set user ID
        public function setId($id) {
            $this->id = $id;
        }

        public function createUrl() {

            // create a new reset password url
            $this->url = bin2hex(openssl_random_pseudo_bytes(64));
        }

        // add url to forgot_password table
        public function setForgotPasswordUrl() {

            $query = "UPDATE
                      $this->forgotPasswordTable
                      SET 
                      reset_url = '$this->url' 
                      WHERE 
                      user_id = '$this->id'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        // send email containing url link
        public function sendMail() {

            // mail config
            /*ini_set("SMTP","mail.example.com");
            ini_set("smtp_port","25");
            ini_set('live', 'noreply@liveapp.com');

            // send email
            mail($this->email, 'Reset Password', $this->url);
        }*/
    }
?>