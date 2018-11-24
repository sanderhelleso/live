<?php

    /**
     * 
     * NOTE: Due to using gmail account as sender, sometimes the emails may not arrive
     * Also because we are sending HTML, there is a risk that emails appear in "spam" folder 
     * 
    **/

    // import api keys
    include_once('../../enviorment.php');

    // require PHPMailer classes
    require("../../libs/PHPMailer/src/PHPMailer.php");
    require("../../libs/PHPMailer/src/SMTP.php");
    require("../../libs/PHPMailer/src/Exception.php");

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

        // send email containing url link
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

        // create email body containing url to reset password
        private function emailBody() {

            // reset password full url
            $url = 'http://' . $this->domain . '/forgot-password' . '/' . $this->url;

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