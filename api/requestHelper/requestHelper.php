<?php

    /**
     * Releated file for RequestHelper.php class
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
    include_once '../models/RequestHelper.php';
    include_once '../../auth/validToken.php';

    // check for valid token
    if ($valid) {

        // instantiate request help object
        $requestHelp = new RequestHelper(
            $db,
            $data['helper_id'],
            $data['id'],
            $data['child_care'],
            $data['elder_care'],
            $data['animal_care'],
            $data['message'],
            $data['karma']
        );

        // attempt to set request help
        $valid = $requestHelp->setHelperRequest();

        // check if help offer was valid
        if ($valid->rowCount()) {

            // send back success data
            $requestHelpSuccess = array(
                'success' => true,
                'message' => 'Request successfully sent! You will get notified if the request was accepted',
                'timestamp' => $timestamp
            );

            // send back response to request
            http_response_code(200); // Request was fulfilled
            echo json_encode($requestHelpSuccess);
        }  

        else {

            // something went wrong when attempt to set request,
            // send back error response to request
            http_response_code(400); // Bad Request
            echo json_encode(
                array('success' => false,
                    'message' => 'Something went wrong when requesting helper. Please try again',
                    'timestamp' => $timestamp
                )
            );
        }
    }

?>