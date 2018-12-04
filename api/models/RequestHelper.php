<?php

    /**
     * RequestHelper class that allows users to request a specific helper
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * This class represent request helper functionality in the application.
    * A user can request individual users or "helpers" that have listed themself
    * as available helpers during the time of request and withing the 
    * categories specified by the user. If the helper decides to accpet the request,
    * the users will exchange contact information (E-Mail, Phone Number, Address) etc
    */

    class RequestHelper {

        // db connection and table
        private $conn;
        private $table = 'helper_requests';

        // request helper properties
        public $id;
        public $requestedId;
        public $childCare;
        public $elderCare;
        public $animalCare;
        public $message;
        public $karma;


        // constructor with DB and request helper properties
        public function __construct(
            $db,
            $id,
            $requestedId,
            $childCare,
            $elderCare,
            $animalCare,
            $message,
            $karma
        ) {
            $this->conn = $db;
            $this->id = $id;
            $this->requestedId = $requestedId;
            $this->childCare = $childCare;
            $this->elderCare = $elderCare;
            $this->animalCare = $animalCare;
            $this->message = $message;
            $this->karma = $karma;
        }

        /**
         * Attempt to set helper request in releation to given ID
        */
        public function setHelperRequest() {

            $now = date('Y-m-d', time());

            // set helper request query
            $query = "INSERT INTO
                      $this->table
                      (
                      `help_id`, 
                      `user_requested`,
                      `message`,
                      `child_care`,
                      `elder_care`,
                      `animal_care`,
                      `date_requested`,
                      `accepted`,
                      `karma`
                      ) 
                      VALUES
                      (
                      '$this->id',
                      '$this->requestedId',
                      '$this->message',
                      '$this->childCare',
                      '$this->elderCare',
                      '$this->animalCare',
                      '$now',
                      NULL,
                      $this->karma
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