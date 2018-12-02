<?php

    /**
     * Authentication class to handle authentication aspects of the application
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * This class represent a JWT or token based authentication system.
    * On login users get awared with a token containing a unique 128 bit token.
    * The server stores this token in the database and send back to the client 
    * wich then store the token in localstorage on the client, all following
    * requests to secure endponints will include the token and compare. If for some
    * reason the token dont match (user modify via chrome extension etc) the system
    * will clear the token and logout the user on the next secure route request
    */

    class Authenticate {

        // db connection and table
        private $conn;
        private $table = 'users_auth';

        // auth token properties
        public $id;
        public $token;
        public $issuedAt;

        // constructor with DB and auth properties
        public function __construct($db, $id) {
            $this->conn = $db;
            $this->id = $id;
        }
        
        /**
         * Generate a brand new token and store in the releated user
         * NOTE: If entry allready exists in DB, update record instead of creating new
        */  
        public function createToken() {

            // generate a new auth token
            $this->token= bin2hex(openssl_random_pseudo_bytes(64));

            // get timestamp token was issued at
            $this->issuedAt = round(microtime(true) * 1000);

            // create token query
            $query = "INSERT INTO 
                     $this->table 
                     (
                     `user_id`,
                     `token`,
                     `issued_at`
                     )
                     VALUES
                     (
                     '$this->id',
                     '$this->token',
                     '$this->issuedAt'
                     )
                     ON DUPLICATE KEY UPDATE
                     token = '$this->token',
                     issued_at = '$this->issuedAt'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        /**
         * Remove a specific token releated to given user ID
        */
        public function removeToken() {

            // remove token query
            $query = "DELETE
                      FROM
                      $this->table
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
         * Compare given token against sat user token releated to gived user ID
        */
        public function compareToken($id, $token) {

            // compare token query
            $query = "SELECT * 
                      FROM 
                      $this->table 
                      WHERE
                      user_id = '$id'
                      AND
                      token = '$token'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;

        }

        /**
         * Validate a specific token releated to given user ID
         * Compares both token and issued at timestamp 
        */
        public function validateToken() {

            // validate token query
            $query = "SELECT * 
                      FROM 
                      $this->table 
                      WHERE
                      user_id = '$this->id'
                      AND
                      token = '$this->token'
                      AND
                      issued_at = '$this->issuedAt'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        /**
         * Retrieve authorization header from request
        */
        public function getAuthorizationHeader() {

            // initialize headers as empty
            $headers = null;

            // fetch headers
            if (isset($_SERVER['Authorization'])) {
                $headers = trim($_SERVER["Authorization"]);
            }

            //Nginx or fast CGI
            else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { 
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            } 
            
            // apache
            else if (function_exists('apache_request_headers')) {

                $requestHeaders = apache_request_headers();

                // server-side fix for bug in old Android versions 
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));

                if (isset($requestHeaders['Authorization'])) {
                    $headers = trim($requestHeaders['Authorization']);
                }
            }

            return $headers;
        }

        /**
         * Retrieve beared header containing token from request header
        */
        public function getBearerToken() {

            // get auth token from header
            $headers = $this->getAuthorizationHeader();

            // HEADER: Get the access token from the header
            if (!empty($headers)) {
                if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                    return $matches[1];
                }
            }
            
            return null;
        }
    }
?>