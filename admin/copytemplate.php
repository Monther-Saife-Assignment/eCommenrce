<?php
    
    /**
     * ==================================================
     * == Template Page
     * ==================================================
     */
    ob_start(); // Important -> To Fix Header Error 
    session_start();

    // $noNavbar = '';
    $pageTitle = '';

    if (isset($_SESSION['Username'])){

        
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // Start Manage Page 
        if ($do == 'Manage') { 


        } elseif ($do == 'Add') {


        } elseif ($do == 'Insert') {

            
        } elseif ($do == 'Edit') {

        
        } elseif ($do == 'Update') { 


        } elseif ($do == 'Delete') { 


        } elseif ($do == 'Active') { 


        }

        include $tpl . 'footer.php';

    } else {

        header('Location: index.php');     // Redirect To index Page
        exit();

    }

    ob_end_flush();  // Important -> To Fix Header Error 
