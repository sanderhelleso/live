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

    // include required db config, user and auth model
    include_once '../models/user/User.php';
    include_once '../../auth/token.php';

    // check for valid token
    if ($valid) {

        // instantiate user object
        $user = new User($db, $data['id']);

        // compare passwords
        $validPassword = $user->comparePassword($data['password']);

        // check for valid password matching
        if ($validPassword->rowCount()) {

            // attempt to delete account
            $delete = $user->deleteAccount();

            // check if delete was successfull
            if ($delete->rowCount()) {

                // create assoc array containing success response
                $deleteAccountData = array(
                    'success' => true,
                    'message' => 'Account successfully deleted',
                    'timestamp' => $timestamp
                );

                // clear auth cookie
                if (isset($_COOKIE['auth_token'])) {
                    unset($_COOKIE['auth_token']);
                    setcookie('auth_token', '', time() - 3600, '/'); // empty value and old timestamp
                }

                // send back response to request
                http_response_code(200); // Request was fulfilled
                echo json_encode($deleteAccountData);
            }            
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