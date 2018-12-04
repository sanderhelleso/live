<?php

    /**
     * Releated file for Find.php class
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * NOTE - From Find.php: The user performing the request do NOT require to be logged in
    * to the system. However, to actually book and connect with thte helper,
    * the user is required to create an account / log into the application
    */

    // include request validation
    include_once '../../auth/validRequest.php';

    // set JSON header 
    header('Content-Type: application/json');

    // include required db config and find model
    include_once '../config/Database.php';
    include_once '../models/Find.php';

    // instantiate database and connect
    $databse = new Database();
    $db = $databse->connect();

    // instantiate new find object
    $find = new Find(
        $db, 
        $data['child_care'],
        $data['elder_care'],
        $data['animal_care'],
        $data['radius'],
        $data['lat'],
        $data['lng'],
        $data['id']
    );

    // attempt to find releated helpers matching given properties
    $result = $find->find();
    $valid = $result->rowCount();

    // messages
    $successMsg = 'Helper data retrieved successfully';
    $errorMsg = 'No helpers found matching your criterias. Maybe try a larger radius?';

    // check if any matches were found
    if ($valid) {

        // retrieve helpers data
        $helpersData = $result->fetchAll(PDO::FETCH_ASSOC);

        // extract users data
        extract($helpersData);

        // remove results not within requested radius
        foreach ($helpersData as $key => $helperData) {

            // get distance
            $distance = $find->getDistance($data['lat'], $data['lng'], $helperData['latitude'], $helperData['longitude']);
            if ($distance > $data['radius']) {
                unset($helpersData[$key]);
            }
        }

        // check if any results left after radius removal
        $validResult = count($helpersData) > 0 ? true : false;

        // create assoc array containing success response
        $helpersDataRes = array(
            'success' => $validResult,
            'message' => $validResult ? $successMsg : $errorMsg,
            'timestamp' => $timestamp,
            'payload' => $helpersData
        );

        // send back response to request
        http_response_code(200); // Request was fulfilled
        echo json_encode($helpersDataRes);
    }

    else {

        // unable to fetch user data or no match found
        http_response_code(200); // Request was fulfilled
        echo json_encode(
            array(
                'success' => false,
                'message' => $errorMsg,
                'timestamp' => $timestamp
            )
        );
    }
     
?>

