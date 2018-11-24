<?php

    header('Access-Control-Allow-Methods: POST'); // only allow POST request to hit endpoint

    // retrieve content type
    $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

    // include required db config, user and reset password model
    include_once '../config/Database.php';
    include_once '../models/user/User.php';
    include_once '../models/ResetPassword.php';

    // instantiate database and connect
    $databse = new Database();
    $db = $databse->connect();

    // get timestamp of request
    $timestamp = round(microtime(true) * 1000);

    /**
     *
     *  RECIEVE AND VALIDATE RESET PASSWORD URL 
     * 
    **/
    
    if ($contentType === 'application/x-www-form-urlencoded') {

        // set data to given reset_url recieved in post reqyest
        $reset_url = $_POST['reset_url'];

        // instantiate new reset password object
        $resetPassword = new ResetPassword($db, $reset_url);

        // validate given url
        $valid = $resetPassword->validateUrl();

        // see if url is valid
        if ($valid->rowCount()) {

            // delete url from database to make it no longer available
            $resetPassword->deleteUrl();

            // retrieve forgot password data
            $valid = $valid->fetch(PDO::FETCH_ASSOC);

            // extract forgot password data
            extract($valid);

            // send response back to request
            http_response_code(200); // Success
            echo json_encode(
                array('success' => true,
                    'timestamp' => $timestamp,
                    'message' => 'Reset Password URL is valid',
                    'id' => $user_id
                )
            );
        }

        else {

            // given url is not valid or no longer in system
            // redirect user to homepage
            // send response back to request
            http_response_code(200); // Bad Request
            echo json_encode(
                array('success' => false,
                    'timestamp' => $timestamp,
                    'message' => 'Url is invalid or expired'
                )
            );
        }
    }

    /**
     * 
     * RECIEVE AND VALIDATE GIVEN NEW PASSWORD FOR USER
     * CONNECTED TO VALIDATED RESET PASSWORD URL ID
     * 
    **/

    // check if content is of correct JSON format
    else if ($contentType === 'application/json') {

        // receive the RAW post data.
        $content = trim(file_get_contents('php://input'));

        // decode recieved data
        $data = json_decode($content, true);

        //If json_decode failed, the JSON is invalid.
        if(!is_array($data)) {

            // send response back to request
            http_response_code(422); // Unprocessable Entity
            echo json_encode(
                array('success' => false,
                    'timestamp' => $timestamp,
                    'message' => 'Missing required properties to perform request'
                )
            );

            return;
        }

        // set JSON header 
        header('Content-Type: application/json');

        // start session and retireve sat user ID
        session_start();

        // instantiate new user object
        $user = new User($db, $_SESSION['reset_password_id']);

        // set new password for user
        $valid = $user->updatePassword($data['new_password']);

        // check if update password was successfull
        if ($valid->rowCount()) {

            // create assoc array containing success response
            $passwordData = array(
                'success' => true,
                'message' => 'Password successfully updated! You can now login with the new password',
                'timestamp' => $timestamp
            );

            // send back response to request
            http_response_code(200); // Request was fulfilled
            echo json_encode($passwordData);

            // unset and destory session data
            if (isset($_SESSION)) {
                session_unset(); 
                session_destroy();
            }
        }

        // something went wrong when attempting to update password
        else {

            // send back error response to request
            http_response_code(400); // Bad Request
            echo json_encode(
                array('success' => false,
                    'message' => 'Something went wrong while attempting to update password. Please try again',
                    'timestamp' => $timestamp
                )
            );
        }
    }
?>