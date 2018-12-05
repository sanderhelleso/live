<?php

    /**
     * Releated file for UpdateView.php class
    *
    *  @author Sander Hellesø <shellesoe@csumb.edu>
    *
    * Server and SQL logic is performed using retrieved data
    */

    // include request validation
    include_once '../../auth/request.php';

    // set JSON header 
    header('Content-Type: application/json');

    // include required db config, login and auth model
    include_once '../config/Database.php';
    include_once '../models/Update-View.php';

    // instantiate database and connect
    $databse = new Database();
    $db = $databse->connect();

    // instantiate update view object
    $updateView = new UpdateView($db, $data['id']);

    // run set tota views query
    $result = $updateView->updateTotalViews();
    $valid = $result->rowCount();

    // check for valid view insertions
    if ($valid) {

        // create assoc array containing success response
        $updateData = array(
            'success' => true,
            'message' => 'Updating of current helpers total views count was successfull',
            'timestamp' => $timestamp
        );

        // send back response to request
        http_response_code(200); // Request was fulfilled
        echo json_encode($updateData);
    } 

    else {

        // unable to update views,
        // send back error response to request
        http_response_code(400); // Bad Request
        echo json_encode(
            array(
                'success' => false,
                'message' => 'Updating of current helpers total views count failed',
                'timestamp' => $timestamp
            )
        );
    }
?>