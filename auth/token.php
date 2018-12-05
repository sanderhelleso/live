<?php

    // include required db config and auth model
    include_once '../../api/config/Database.php';
    include_once '../../api/models/Authenticate.php';

    // instantiate database and connect
    $databse = new Database();
    $db = $databse->connect();

    // insantiate auth object
    $auth = new Authenticate($db, $data['id']);

    /** 
     *  compare bearer header with users auth token
    **/

    // get bearer header
    $bearerToken = $auth->getBearerToken();

    // compare tokens
    $result = $auth->compareToken($data['id'], $bearerToken);
    $valid = $result->rowCount();

    if (!$valid) {

        // token validation failed,
        // send back error response to request
        http_response_code(403); // Unauthorized
        echo json_encode(
            array('success' => false,
                'message' => 'Something went wrong when attempting to perform request',
                'timestamp' => $timestamp
            )
        );

        // return early
        return;
    }
?>