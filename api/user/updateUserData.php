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

    // set JSON header 
    header('Content-Type: application/json');

    // include required db config, login and auth model
    include_once '../config/Database.php';
    include_once '../models/user/User.php';
    include_once '../models/Authenticate.php';

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

    // check for valid token
    if ($valid) {

        // instantiate user object
        $user = new User($db, $data['id']);

        // attempt to retrieve user data
        $result = $user->updateUserData(
            $data['first_name'],
            $data['last_name'],
            $data['age'],
            $data['country'],
            $data['state'],
            $data['street_address'],
            $data['phone_number'],
            $data['newsletter']
        );

        // data was updated
        $valid = $result->rowCount();

        // check if update was successfull
        if ($valid) {

            // create assoc array containing success response
            $userDataUpdateRes = array(
                'success' => true,
                'message' => 'Settings successfully updated',
                'timestamp' => $timestamp
            );

            // send back response to request
            http_response_code(200); // Request was fulfilled
            echo json_encode($userDataUpdateRes);
        }

        else {

            // data attempted to update was equal to allready sat data
            $userDataUpdateRes = array(
                'success' => true,
                'message' => 'No need to update! Your settings are equal to what you tried to update',
                'timestamp' => $timestamp
            );

            // send back response to request
            http_response_code(200); // Request was fulfilled
            echo json_encode($userDataUpdateRes);
        }

    } 
    
?>