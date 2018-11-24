<?php

    // set required headers
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}"); // only allow same domain requests
    header('Access-Control-Allow-Methods: POST'); // only allow POST request to hit endpoint

    // get timestamp of request
    $timestamp = round(microtime(true) * 1000);

    // retrieve content type
    $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

    // check if content is of correct JSON format
    if ($contentType === "application/json") {

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
    }

    /**
     * 
     * NOTE: we send back same response even if email acctually exsists our 
     * or not. We dont want to reveal if a certain email is in our system.
     * We also send request back BEFORE running email script due to wait
     * if email exists and an email is actually sendt to the address.
     * 
    **/

    // set JSON header 
    header('Content-Type: application/json');

    // create assoc array containing success response
    $forgotPasswordData = array(
        'success' => true,
        'message' => 'If a matching account was found an email was sent to<br><strong>' . $data['email'] . '</strong><br>to allow you to reset your password.<br>Remember to check your spam folder.',
        'timestamp' => $timestamp
    );

    // send back response to request
    http_response_code(200); // Request was fulfilled
    echo json_encode($forgotPasswordData);

    // include required db config and forgot password model
    include_once '../config/Database.php';
    include_once '../models/ForgotPassword.php';

    // instantiate database and connect
    $databse = new Database();
    $db = $databse->connect();

    // instantiate forgot password object
    $forgotPassword = new ForgotPassword($db, $data['email']);

    // get users ID
    $getId = $forgotPassword->getId();

    // check if email belongs to user
    if ($getId->rowCount()) {

        // retrieve users data
        $userData = $getId->fetch(PDO::FETCH_ASSOC);

        // extract users data
        extract($userData);

        // set user id
        $forgotPassword->setId($userData['user_id']);

        // create reset password url
        $forgotPassword->createUrl();

        // set reset password url
        $forgotPassword->setForgotPasswordUrl();

        // send reset password email
        $forgotPassword->sendMail();
    }
?>