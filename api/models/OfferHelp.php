<?php

    /**
     * OfferHelp class that allows user to set up a offer for users to see and book
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * This class represent offer help system that allows users to
    * create an offer and allow other users to search and book
    * based on what they need. Offer includes areas interested to help,
    * time available, description and price (optional, an be free)
    * The system also depends on statistics and will store total views
    * and last seen date regarding the offer
    */

    class OfferHelp {

        // db connection and table
        private $conn;
        private $offerHelpTable = 'helpers';
        private $offerHelpStatsTable = 'help_offer_statistics';

        // offer help properties
        public $id;
        public $childCare;
        public $elderCare;
        public $animalCare;
        public $startDate;
        public $endDate;
        public $description;
        public $price;
        public $latitude;
        public $longitude;

        // constructor with DB and offer help properties
        public function __construct(
            $db,
            $id,
            $childCare,
            $elderCare,
            $animalCare,
            $startDate,
            $endDate,
            $description,
            $price,
            $latitude,
            $longitude
        ) {
            $this->conn = $db;
            $this->id = $id;
            $this->childCare = $childCare;
            $this->elderCare = $elderCare;
            $this->animalCare = $animalCare;
            $this->startDate = $startDate;
            $this->endDate = $endDate;
            $this->description = $description;
            $this->price = $price;
            $this->latitude = $latitude;
            $this->longitude = $longitude;
        }

        /**
         * Attempt to create offer and store in releation to given user ID
        */  
        public function offerHelp() {

            $query = "INSERT INTO
                      $this->offerHelpTable
                      (
                      `user_id`, 
                      `child_care`,
                      `elder_care`,
                      `animal_care`,
                      `start_date`,
                      `end_date`,
                      `description`,
                      `price`,
                      `latitude`,
                      `longitude`
                      ) 
                      VALUES
                      (
                      '$this->id',
                      '$this->childCare',
                      '$this->elderCare',
                      '$this->animalCare',
                      '$this->startDate',
                      '$this->endDate',
                      '$this->description',
                      '$this->price',
                      '$this->latitude',
                      '$this->longitude'
                      )
                      ON DUPLICATE KEY UPDATE
                      child_care = '$this->childCare',
                      elder_care = '$this->elderCare',
                      animal_care = '$this->animalCare',
                      start_date = '$this->startDate',
                      end_date = '$this->endDate',
                      description = '$this->description',
                      price = '$this->price',
                      latitude = '$this->latitude',
                      longitude = '$this->longitude'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }

        /**
         * Attempt to create offer statistics and store in releation to given user ID
        */
        public function setOfferStatistics() {

            $query = "INSERT INTO
                      $this->offerHelpStatsTable
                      (
                      `help_id`, 
                      `last_viewed`,
                      `total_views`
                      ) 
                      VALUES
                      (
                      '$this->id',
                      NULL,
                      0
                      )
                      ON DUPLICATE KEY UPDATE
                      last_viewed = NULL,
                      total_views = 0";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }
    }
?>