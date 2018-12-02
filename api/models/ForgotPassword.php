<?php

    // import api keys
    include_once('../../enviorment.php');

    // require PHPMailer classes
    require("../../libs/PHPMailer/src/PHPMailer.php");
    require("../../libs/PHPMailer/src/SMTP.php");
    require("../../libs/PHPMailer/src/Exception.php");

    /**
     * Forgot Password class that allows for resetting of user password
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * This class represents a custom forgot password system that allows users to send a 
    * reset password to the accounts releated E-Mail. If the E-Mail recieved
    * is not in our system, the same response message is send back to the client
    * to prevent potensial phising for user information (we dont want to reveal users)
    *
    * NOTE: Due to using gmail account as sender, sometimes the emails may not arrive
    * Also because we are sending HTML, there is a risk that emails appear in "spam" folder 
    */
    
    class ForgotPassword {

        // db connection, tables and domain
        private $conn;
        private $usersTable = 'users';
        private $forgotPasswordTable = 'forgot_password';
        private $domain = 'liveapp';

        // forgot password properties
        public $email;
        public $id;
        public $url;

        // constructor with DB and forgot password properties
        public function __construct($db, $email) {
            $this->conn = $db;
            $this->email = $email;
        }

        /**
         * Search and find for connected user ID releated to given E-Mail
        */  
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

        /**
         * Set user ID to member variable
        */  
        public function setId($id) {
            $this->id = $id;
        }

        /**
         * Generate a brand new unique 128 bit URL wich
        */  
        public function createUrl() {

            // create a new reset password url
            $this->url = bin2hex(openssl_random_pseudo_bytes(64));
        }

        /**
         * Store created url in releated authenticaton table
         * in releatin to the given user ID
        */  
        public function setForgotPasswordUrl() {

            $query = "INSERT INTO
                      $this->forgotPasswordTable
                      (
                      `user_id`, 
                      `reset_url`
                      ) 
                      VALUES
                      (
                      '$this->id',
                      '$this->url'
                      )
                      ON DUPLICATE KEY UPDATE
                      reset_url = '$this->url'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        /**
         * Send E-Mail containing link to reset password URL
         * to the given users E-Mail address
         * 
         * --- CONFIGURATIONS ---
         *  1. SMTP ENABLED
         *  2. PORT 587
         *  3. HOST "in-v3.mailjet.com"
         *  4. USERNAME AND PASSWORD RETIREVED FROM ENV
         *  5. HTML BODY IS ALLOWED
        */  
        public function sendMail() {

            // instantiate new mailer object
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            /**
             * MAIL CONFIGURATION SETTINGS
            **/

            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPAuth = true; // authentication enabled
            $mail->Port = 587; // port
            $mail->Host = "in-v3.mailjet.com"; // host
            $mail->Username = $_ENV['MAILJET_PUBLIC_KEY']; // username
            $mail->Password = $_ENV['MAILJET_PRIVATE_KEY']; // password

            /**
             * MAIL CONTENT SETTINGS
            **/

            $mail->SetFrom('liveappmailer@gmail.com'); 
            $mail->Subject = 'Reset Password for LIVE'; // email subject
            $mail->IsHTML(true); // set as HTML
            $mail->Body = $this->emailBody(); // email body content
            $mail->AddAddress($this->email, 'noreply@liveapp.com'); // to email, from name

            // send email
            $mail->send();
        }

        /**
         * Create the releated HTML E-Mail body 
        */  
        private function emailBody() {

            // reset password full url
            $url = 'http://' . $this->domain . '/reset-password?' . $this->url;

            // email body
            $body = '<html><main>';
            $body .= '<h2>Reset Password for LIVE</h2>';
            $body .= '<h5>A reset password for the LIVE account connected to this E-Mail was requested.</h5>';
            $body .= '<p>If you did not request to reset your password, ignore this mail.';
            $body .= '<br><br>';
            $body .= '<a href="' . $url . '" target="_blank">Click here to set a new password and get back into LIVE</a>';
            $body .= '<br><br>';
            $body .= '<span>Please do not reply to this E-Mail. It was sendt from an automatic sender';
            $body .= '</main></html>';

            // return created email body
            return $body;
        }
    }
?>