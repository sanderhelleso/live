<?php
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

        public function createTokenSpot() {

            // create token query
            $query = "INSERT INTO 
                     $this->table 
                     (`user_id`,
                     `token`,
                     `issued_at`)
                     VALUES
                     ('$this->id',
                     NULL,
                     NULL
                     )";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        public function createToken() {

            // generate a new auth token
            $this->token= bin2hex(openssl_random_pseudo_bytes(64));

            // get timestamp token was issued at
            $this->issuedAt = round(microtime(true) * 1000);

            // update token query
            $query = "UPDATE
                      $this->table 
                      SET 
                      token = '$this->token',
                      issued_at = '$this->issuedAt'
                      WHERE 
                      user_id = '$this->id'";


            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        public function removeToken() {

            // remove token query
            $query = "UPDATE
                      $this->table 
                      SET 
                      token = NULL,
                      issuedAt = NULL
                      WHERE 
                      user_id = '$this->id'";


            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

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
    }
?>