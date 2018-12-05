<?php

    /**
     * Releated file for Logout.php class
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
    include_once '../config/Database.php';
    include_once '../models/Authenticate.php';

    // instantiate database and connect
    $databse = new Database();
    $db = $databse->connect();

    // instantiate auth object
    $auth = new Authenticate($db, $data['id']);

    // remove current auth token from user
    $result = $auth->removeToken();
    $valid = $result->rowCount();

    // check for valid token removal
    if ($valid) {

        // create assoc array containing success response
        $logoutData = array(
            'success' => true,
            'message' => 'Logout successfull',
            'timestamp' => $timestamp
        );

        // clear auth cookie
        if (isset($_COOKIE['auth_token'])) {
            unset($_COOKIE['auth_token']);
            setcookie('auth_token', '', time() - 3600, '/'); // empty value and old timestamp
        }

        // send back response to request
        http_response_code(200); // Request was fulfilled
        echo json_encode($logoutData);
    } 
?>