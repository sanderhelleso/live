<?php

    /**
     * Releated file for OfferHelp.php and User.php classes
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * Server and SQL logic is performed using retrieved data
    */

    // include request validation
    include_once '../../auth/request.php';

    // set JSON header 
    header('Content-Type: application/json');

    // include required db config, user and auth model
    include_once '../models/user/User.php';
    include_once '../../auth/token.php';

    // check for valid token
    if ($valid) {

        // instantiate offer help object
        $user = new User($db, $data['id']);

        // attempt to delete help offer
        $valid = $user->deleteOfferHelp();

        // check if help offer was successfully deleted
        if ($valid->rowCount()) {

            // send back success data
            $deleteOfferHelpSuccess = array(
                'success' => true,
                'message' => 'Offer successfully deleted!',
                'timestamp' => $timestamp
            );

            // send back response to request
            http_response_code(200); // Request was fulfilled
            echo json_encode($deleteOfferHelpSuccess);
        }  

        else {

            // something went wrong when attempt to set offer,
            // send back error response to request
            http_response_code(400); // Bad Request
            echo json_encode(
                array('success' => false,
                    'message' => 'Something went wrong when deleting offer. Please try again',
                    'timestamp' => $timestamp
                )
            );
        }
    }

?>