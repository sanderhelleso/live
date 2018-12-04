<?php

    /**
     * UpdateView class to handle updating of helpers total views
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * This class represent the way the system update the individual helpers total views
    * count. Every time the user is previewd in the systems "find" section the system
    * will call and update the individals total view counter by 1 aswell as setting the 
    * last seen timestamp in "Y-m-d" format
    */
    
    class UpdateView {

        // db connection and table
        private $conn;
        private $table = 'help_offer_statistics';

        // update view properties
        public $id;

        // constructor with DB and update view properties
        public function __construct($db, $id) {
            $this->conn = $db;
            $this->id = $id;
        }


        /**
         * Attempt to update matching helpers total view count and last seen
        */  
        public function updateTotalViews() {

            $lastViewed = date('Y-m-d', time());


            // total views query
            $query = "UPDATE
                      $this->table 
                      SET
                      total_views = total_views + 1,
                      last_viewed = '$lastViewed'
                      WHERE help_id = '$this->id'";

            // prepeare statement
            $stmt = $this->conn->prepare($query);

            // exceute query
            $stmt->execute();

            // return statement
            return $stmt;
        }
    }
?>