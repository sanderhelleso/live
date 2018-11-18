<?php
  session_start();

    $httpMethod = strtoupper($_SERVER['REQUEST_METHOD']);

    switch($httpMethod) {

        case 'POST':

            $jsonData = json_decode($_POST["email"], true);

            // TODO: do stuff to get the $results which is an associative array
            $results = array($jsonData);

            // Let the client know the format of the data being returned
            header("Content-Type: application/json");

            // Sending back down as JSON
            echo json_encode($results);

            // login failed
            //http_response_code(401);
    }
?>