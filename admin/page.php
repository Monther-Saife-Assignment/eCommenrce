<?php

    /**
     *  Categories => [ Manage | Edit | Update | Delete | Stats]
     * 
     *      =====Short If=====
     *      Condition ? True : False
     */

    // =====Short If=====
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    /**
     *  If The Page Is Main Page
     */

    if ($do == 'Manage'){

        echo 'Welcome You Are In Manage Category Page';
        echo '<br>' . 'Add New Category Click Here::: ' . '<a href="page.php?do=add">New Category</a>';

    } elseif ($do == 'add') {

        echo 'Welcome You Are In Add Category Page';

    } elseif ($do == 'Insert'){

        echo 'Welcome You Are In Insert Category Page';


    } else {

        echo 'Error There\'s No Page With This Name';

    }


        /*
        // =====Long If=====
                $do = '';

                if (isset($_GET['do'])) {

                    $do = $_GET['do']; 

                } else {

                    $do = 'Manage';
                }

                echo $do;

        */