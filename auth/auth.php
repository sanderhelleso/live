<?php

    // redirect user to login page if not authorized to enter auth routes
    function canAccessRoute() {
        if (!isset($_COOKIE['auth_token'])) {
            http_response_code(401); // Unautorized
            header('Location: /login'); 
        }
    }    

    // if user is logged in, redirect user to dashboard
    function isLoggedIn() {
        if (isset($_COOKIE['auth_token'])) {
            header('Location: /dashboard'); 
        }
    }


    // check and validate if url query parameter is a valid reset password url
    function validateResetPassword() {

        /**
         * 
         * remove and destory session
         * we want clean sessions for
         * reset password section
         * 
        **/
        
        if (isset($_SESSION)) {
            session_unset(); 
            session_destroy(); 
        }

        // get url
        $url = $_SERVER['REQUEST_URI'];

        // query array from url
        $queryParams = explode('?', $url);

        // check if a query is present
        if (count($queryParams) == 1) {

            // direct user to 404 if no query is present
            header('Location: /404');
        }

        // query is present
        else {

            // extract code from query array
            $reset_url = $queryParams[1];

            /***
             * perform post request to reset password endpoint
             * and validate the given url from query array
            **/

            // set domain and SSL
            if ($_SERVER['SERVER_NAME'] == 'liveapp') {
                $domain = 'liveapp';
                $ssl = 'http://';
            }

            else {
                $domain = 'demoliveapp.heroku.com';
                $ssl = 'https://';
            }

            $url = $ssl . $domain . '/api/reset-password/reset-password.php';
            $data = array('reset_url' => $reset_url);

            // create request options
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );

            // send request
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            // receive the RAW post data.
            $content = trim($result);

            // decode recieved data
            $data = json_decode($content, true);

            // if response failed, redirect to 404
            if (!$data['success']) {
                http_response_code(401); // Unautorized
                header('Location: /404');
            }

            // create new session containing users ID and URL
            else {
                session_start();
                $_SESSION['reset_password_id'] = $data['id'];
            }
        }
    }

?>