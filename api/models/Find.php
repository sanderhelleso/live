<?php

    /**
     * Find class to handle search of helpers in the application
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * This class represent a search and find system that allows
    * users to search and find helpers depending on certain criterias
    * sat by the user performing the request
    *
    * NOTE: The user performing the request do NOT require to be logged in
    * to the system. However, to actually book and connect with thte helper,
    * the user is required to create an account / log into the application
    */
    
    class Find {

        // db connection and table
        private $conn;
        private $helpersTable = 'helpers';
        private $helpersStatsTable = 'help_offer_statistics';
        private $usersDataTable = 'users_data';

        // login properties
        public $childCare;
        public $elderCare;
        public $animalCare;
        public $radius;
        public $lat;
        public $lng;
        public $id;

        // constructor with DB and find properties
        public function __construct(
            $db,
            $childCare,
            $elderCare,
            $animalCare,
            $radius,
            $lat,
            $lng,
            $id
        ) {
            $this->conn = $db;
            $this->childCare = $childCare;
            $this->elderCare = $elderCare;
            $this->animalCare = $animalCare;
            $this->radius = $radius;
            $this->lat = $lat;
            $this->lng = $lng;
            $this->id = $id;
        }


        /**
         * Attempt to find matching helpers based on recieved criterias
        */  
        public function find() {

            // current date
            $now = date('Y-m-d', time());

            // find helpers query
            $query = "SELECT
                      $this->helpersTable.*,
                      $this->helpersStatsTable.total_views,
                      $this->usersDataTable.first_name, last_name, avatar
                      FROM $this->usersDataTable
                      INNER JOIN $this->helpersTable
                      ON $this->helpersTable.user_id = $this->usersDataTable.user_id
                      INNER JOIN $this->helpersStatsTable
                      ON $this->helpersTable.user_id = $this->helpersStatsTable.help_id
                      WHERE NOT
                      $this->helpersTable.user_id = $this->id
                      AND
                      $this->helpersTable.child_care = '$this->childCare'
                      AND
                      $this->helpersTable.elder_care = '$this->elderCare'
                      AND
                      $this->helpersTable.animal_care = '$this->animalCare'
                      AND
                      $this->helpersTable.start_date <= '$now'
                      AND 
                      $this->helpersTable.end_date >= '$now'
                      ";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }
    }
?>