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

    // include required db config, user and auth model
    include_once '../config/Database.php';
    include_once '../models/OfferHelp.php';
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

        // instantiate offer help object
        $offerHelp = new OfferHelp(
            $db,
            $data['id'],
            $data['childcare'],
            $data['eldercare'],
            $data['animalcare'],
            $data['start'],
            $data['end'],
            $data['description'],
            $data['price']
        );

        // attempt to set help offer
        $valid = $offerHelp->offerHelp();

        // check if help offer was valid
        if ($valid->rowCount()) {

            // send back success data
            $offerHelpSuccess = array(
                'success' => true,
                'message' => 'Offer successfully listed!',
                'timestamp' => $timestamp
            );

            // send back response to request
            http_response_code(200); // Request was fulfilled
            echo json_encode($offerHelpSuccess);
        }  

        else {

            // something went wrong when attempt to set offer,
            // send back error response to request
            http_response_code(400); // Bad Request
            echo json_encode(
                array('success' => false,
                    'message' => 'Something went wrong when listing offer. Please try again',
                    'timestamp' => $timestamp
                )
            );
        }
    }

?>