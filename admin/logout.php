<?php

    session_start();    // Start The Session

    session_unset();    // Unset The Session

    session_destroy();  // Destroy The Session

    header('Location: index.php');

    exit();     // We Use It To Avoid The Out_Put Error


    /**
     *      ===The Advanced Example===
     *      
     *      ///Initialize The Session
     *     ///If You Are Using session_name("something"), Don't Forget It Now!!!
     *      session_start();
     * 
     *    ///Unset All Of The Session Variale
     *      $_SESSION = array();
     * 
     *    ///If Its Desired To Kill The Session, Also To delete The Session Cookie
     *    ///Note: This Will Destroy The Session, And Not Just The Session Data
     *         if(ini_get("session.use_cookies")) {
     *         $params = session_get_cookie_params();
     *         setcookie(session_name(), '', time() - 42000,
     *         $params['path'], $params['domain'],
     *         $params['secure'], $params['httponly']
     *         };
     *    ///Finally, Destroy The Session
     *      session_destroy();
     */


