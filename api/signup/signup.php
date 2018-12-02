<?php

    // include request validation
    include_once '../../auth/validRequest.php';

    // set JSON header 
    header('Content-Type: application/json');

    // include required db config, signup, auth and forgot password model
    include_once '../config/Database.php';
    include_once '../models/Signup.php';

    // instantiate database and connect
    $databse = new Database();
    $db = $databse->connect();

    // instantiate login object
    $signup = new Signup(
        $db,
        $data['firstName'],
        $data['lastName'],
        $data['age'],
        $data['country'],
        $data['state'],
        $data['address'],
        $data['phone'],
        $data['email'],
        $data['password'],
        $data['newsletter']
    );

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
    }
?>