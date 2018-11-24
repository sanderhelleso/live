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
        //echo json_encode($content);

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

    // include required db config, signup, auth and forgot password model
    include_once '../config/Database.php';
    include_once '../models/Signup.php';

    // instantiate database and connect
    $databse = new Database();
    $db = $databse->connect();

    // instantiate login object
    $signup = new Signup($db, $data['firstName'], $data['lastName'], $data['age'], $data['country'], $data['state'], $data['address'], $data['phone'], $data['email'], $data['password'], $data['newsletter']);

    // check if email is allready in use by another user
    if (emailInUse($signup)) {

        http_response_code(409); // Email allready in use
        echo json_encode(
            array('success' => false,
                  'timestamp' => $timestamp,
                  'message' => 'E-Mail is allready in use by another account'
            )
        );

        return;
    }

    else {

        // attempt to create account
        attemptCreateAccount($signup);

    }


    function emailInUse($signup) {

        // check if email is allready in use by another user
        $result = $signup->validate();
        return $result->rowCount();
    }

    function attemptCreateAccount($signup) {

        $result = $signup->createAccount();
        $valid = $result->rowCount();
    
        // check if create account insertion was successfull
        if ($valid) {
            attemptSetUserData($signup, $GLOBALS['db']->lastInsertId());
        }

        else {
            badRequest();
        }
    }

    function attemptSetUserData($signup, $id) {

        $result = $signup->setUserData($id);
        $valid = $result->rowCount();
    
        // check if set account data insertion was successfull
        if ($valid) {

            // create assoc array containing success response
            $signupData = array(
                'success' => true,
                'message' => 'Account was successfully created',
                'timestamp' => $GLOBALS['timestamp']
            );
    
            // send back response to request
            http_response_code(200); // Request was fulfilled
            echo json_encode($signupData);

        }

        // if insertion failed, send bad request
        else {
            badRequest();
        }
    }

    function badRequest() {

        // unable to create user with given credentials
        // send back error response to request
        http_response_code(400); // Bad request
        echo json_encode(
            array('success' => false,
                'timestamp' => $GLOBALS['timestamp'],
                'message' => 'Unable to create user with given credentials'
            )
        );
    }
?>