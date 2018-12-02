<?php

    // include request validation
    include_once '../../auth/validRequest.php';

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