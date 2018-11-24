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