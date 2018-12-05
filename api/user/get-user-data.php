<?php

    /**
     * Releated file for User.php class
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * Server and SQL logic is performed using retrieved data
    */

    // include request validation
    include_once '../../auth/request.php';

    // set JSON header 
    header('Content-Type: application/json');

    // include required db config, login and auth model
    include_once '../models/user/User.php';
    include_once '../../auth/token.php';

    // check for valid token
    if ($valid) {

        // instantiate user object
        $user = new User($db, $data['id']);

        // attempt to retrieve user data
        $result = $user->getUserData();
        $valid = $result->rowCount();

        // check if data retrieval was successfull
        if ($valid) {

            // retrieve users data
            $userData = $result->fetch(PDO::FETCH_ASSOC);

            // extract users data
            extract($userData);

            // create assoc array containing success response
            $userDataRes = array(
                'success' => true,
                'message' => 'User data retrieved successfully',
                'timestamp' => $timestamp,
                'payload' => $userData
            );

            // send back response to request
            http_response_code(200); // Request was fulfilled
            echo json_encode($userDataRes);
        } 

        else {

            // unable to fetch user data,
            // send back error response to request
            http_response_code(400); // Bad request
            echo json_encode(
                array('success' => false,
                    'message' => 'Something went wrong when attempting to fetch user data',
                    'timestamp' => $timestamp
                )
            );
        }

    } 
    
?>