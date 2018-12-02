<?php

    /**
     * Releated file for OfferHelp.php class
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * Server and SQL logic is performed using retrieved data
    */

    // include request validation
    include_once '../../auth/validRequest.php';

    // set JSON header 
    header('Content-Type: application/json');

    // include required db config, user and auth model
    include_once '../models/OfferHelp.php';
    include_once '../../auth/validToken.php';

    // check for valid token
    if ($valid) {

        // instantiate offer help object
        $offerHelp = new OfferHelp(
            $db,
            $data['id'],
            $data['childcare'],
            $data['eldercare'],
            $data['animalcare'],
            $data['start'],
            $data['end'],
            $data['description'],
            $data['price'],
            $data['latitude'],
            $data['longitude']
        );

        // attempt to set help offer
        $valid = $offerHelp->offerHelp();

        // check if help offer was valid
        if ($valid->rowCount()) {

            // set stats data
            $offerHelp->setOfferStatistics();

            // send back success data
            $offerHelpSuccess = array(
                'success' => true,
                'message' => 'Offer successfully listed!',
                'timestamp' => $timestamp
            );

            // send back response to request
            http_response_code(200); // Request was fulfilled
            echo json_encode($offerHelpSuccess);
        }  

        else {

            // something went wrong when attempt to set offer,
            // send back error response to request
            http_response_code(400); // Bad Request
            echo json_encode(
                array('success' => false,
                    'message' => 'Something went wrong when listing offer. Please try again',
                    'timestamp' => $timestamp
                )
            );
        }
    }

?>