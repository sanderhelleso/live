<?php

    /**
     * Releated file for OfferHelp.pgp and User.php class
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * Server and SQL logic is performed using retrieved data
    */

    // include request validation
    include_once '../../auth/request.php';

    // include required db config, login and auth model
    include_once '../models/user/User.php';
    include_once '../../auth/token.php';

    // check for valid token
    if ($valid) {

        // instantiate user object
        $user = new User($db, $data['id']);

        // attempt to retrieve offer data
        $result = $user->getOfferData();
        $valid = $result->rowCount();

        // check if data retrieval was successfull
        if ($valid) {

            // retrieve offer data
            $offerData = $result->fetch(PDO::FETCH_ASSOC);

            // extract offer data
            extract($offerData);

            // create assoc array containing success response
            $userDataRes = array(
                'success' => true,
                'message' => 'Offer data retrieved successfully',
                'timestamp' => $timestamp,
                'payload' => $offerData
            );

            // send back response to request
            http_response_code(200); // Request was fulfilled
            echo json_encode($userDataRes);
        }

        else {

            // unable to fetch offer data,
            // send back error response to request
            http_response_code(400); // Bad request
            echo json_encode(
                array('success' => false,
                    'message' => 'Something went wrong when attempting to fetch offer data',
                    'timestamp' => $timestamp
                )
            );
        } 
    }
    
?>