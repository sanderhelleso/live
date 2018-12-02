<?php

    /**
     * Releated file for Login.php class
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * Server and SQL logic is performed using retrieved data
    */

    // include request validation
    include_once '../../auth/validRequest.php';

    // set JSON header 
    header('Content-Type: application/json');

    // include required db config, login and auth model
    include_once '../config/Database.php';
    include_once '../models/Login.php';
    include_once '../models/Authenticate.php';

    // instantiate database and connect
    $databse = new Database();
    $db = $databse->connect();

    // instantiate login object
    $login = new Login($db, $data['email'], $data['password']);

    // run login query
    $result = $login->login();
    $valid = $result->rowCount();

    // check for valid login
    if ($valid) {

        // retrieve login data
        $valid = $result->fetch(PDO::FETCH_ASSOC);

        // extract login data
        extract($valid);

        // create assoc array containing success response
        $loginData = array(
            'success' => true,
            'message' => 'Login successfull',
            'timestamp' => $timestamp,
            'token' => setToken($user_id, $data['rememberMe'])
        );

        // send back response to request
        http_response_code(200); // Request was fulfilled
        echo json_encode($loginData);
    } 

    else {

        // no user with matching credentials,
        // send back error response to request
        http_response_code(401); // Unauthorized
        echo json_encode(
            array('success' => false,
                  'timestamp' => $timestamp,
                  'message' => 'Invalid username or password'
            )
        );
    }

    /**
     * Attempt to set the users token if login was successfull
    */
    function setToken($id, $expire) {

        // get db connection and logged in users ID
        $auth = new Authenticate($GLOBALS['db'], $id);

        // create a new auth token
        $token = $auth->createToken();

        // validate and retrieve token
        $validate = $auth->validateToken();
        $validToken = $validate->rowCount();

        // check for valid token
        if ($validToken) {
    
            // retrieve token data
            $validToken = $validate->fetch(PDO::FETCH_ASSOC);
    
            // extract token data
            extract($validToken);

            // send back token data
            $tokenData = array(
                'id' => $user_id,
                'token' => $token,
                'issued_at' => $issued_at
            );

            // store token in cookie
            setcookie('auth_token', $token, $expire ? 2147483647 : 0, '/');
            return $tokenData;
        }

        else {

            // unable to set auth token
            http_response_code(403); // Forbidden
            echo json_encode(
                array('success' => false,
                    'timestamp' => $GLOBALS['timestamp'],
                    'message' => 'Unable to log in at this time. Please try again.'
                )
            );
        }
    }
?>