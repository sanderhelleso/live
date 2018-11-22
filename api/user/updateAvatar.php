<?php

    // set required headers
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}"); // only allow same domain requests
    header('Access-Control-Allow-Methods: POST'); // only allow POST request to hit endpoint

    // get timestamp of request
    $timestamp = round(microtime(true) * 1000);

    // retrieve content type
    $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

    // check if content is of correct format (multipart/form-data)
    if ($contentType === "multipart/form-data") {

        // receive the RAW post data.
        $content = trim(file_get_contents('php://input'));

        // get the id from request
        $id = trim(explode('-', explode('name="id"', $content)[1])[0]);      
        
        // get image type (png/jpg)
        $type = strpos($content, 'Content-Type: image/png') ? 'Content-Type: image/png' : 'Content-Type: image/jpeg';

        // get the raw binary data from image
        $image = explode($type, $content)[1];
        $image = trim(explode('------', $image)[0]);

    }

    // set JSON header 
    header('Content-Type: application/json');

    // include required db config, user and auth model
    include_once '../config/Database.php';
    include_once '../models/user/User.php';
    include_once '../models/Authenticate.php';

    // instantiate database and connect
    $databse = new Database();
    $db = $databse->connect();

    // insantiate auth object
    $auth = new Authenticate($db, $id);

    /** 
     *  compare bearer header with users auth token
    **/

    // get bearer header
    $bearerToken = $auth->getBearerToken();

    // compare tokens
    $result = $auth->compareToken($id, $bearerToken);
    $valid = $result->rowCount();

    // check for valid token
    if ($valid) {

        // instantiate user object
        $user = new User($db, $id);

        // upload image
        $upload = $user->updateAvatar(base64_encode($image)); // encode to base64

        // check if upload was successfull
        if ($upload->rowCount()) {

            // create assoc array containing success response
            $uploadAvatarData = array(
                'success' => true,
                'message' => 'Avatar successfully updated!',
                'timestamp' => $timestamp
            );

            // send back response to request
            http_response_code(200); // Request was fulfilled
            echo json_encode($uploadAvatarData);
        } 

        else {

            // unable to update avatar,
            // send back error response to request
            http_response_code(400); // Bad request
            echo json_encode(
                array('success' => false,
                    'message' => 'Something went wrong when attempting to upload image',
                    'timestamp' => $timestamp
                )
            );
        }
    }
?>