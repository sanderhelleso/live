<?php

    //print_r($_COOKIE);

    // redirect user to login page if not authorized to enter auth routes
    function canAccessRoute() {
        if (!isset($_COOKIE['auth_token'])) {
            http_response_code(401); // Unautorized
            header("Location: /login/login.php"); 
        }
    }    

    // if user is logged in, redirect user to dashboard
    function isLoggedIn() {
        if (isset($_COOKIE['auth_token'])) {
            header("Location: /dashboard/dashboard.php"); 
        }
    }

?>