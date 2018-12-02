<?php

    // include request validation
    include_once '../../auth/validRequest.php';

    // set JSON header 
    header('Content-Type: application/json');

    // include required db config, user and auth model
    include_once '../models/user/User.php';
    include_once '../../auth/validToken.php';

    // check for valid token
    if ($valid) {

        // instantiate user object
        $user = new User($db, $data['id']);

        // compare passwords
        $validPassword = $user->comparePassword($data['password']);

        // check for valid password matching
        if ($validPassword->rowCount()) {

            // update password and send back response
            $user->updatePassword($data['new_password']);

            // create assoc array containing success response
            $passwordData = array(
                'success' => true,
                'message' => 'Password successfully updated!',
                'timestamp' => $timestamp
            );

            // send back response to request
            http_response_code(200); // Request was fulfilled
            echo json_encode($passwordData);
        } 

        else {

            // password did not match,
            // send back error response to request
            http_response_code(401); // Unauthorized
            echo json_encode(
                array('success' => false,
                    'message' => 'Wrong password. Please try again',
                    'timestamp' => $timestamp
                )
            );
        }
    }


?>