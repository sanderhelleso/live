<?php
  session_start();

    $httpMethod = strtoupper($_SERVER['REQUEST_METHOD']);

    switch($httpMethod) {

        case 'POST':

            // get body json data
            $data = file_get_contents("php://input");

            // do login credential validation here
            if ($data) {
                http_response_code(200);
                return;
            }

            // login failed
            http_response_code(401);
    }
?>