<?php

    function lang( $phrase ) {

        static $lang = array(

            // 'MESSAGE' => 'Wellcom',
            // 'ADMIN' => 'Administrator'

            // DashBoard Page
            'DEFAULT'       => 'Admin Area',
            'HOME_ADMIN'    => 'Home',
            'CATEGORIES'    => 'Sections',
            'ITEMS'         => 'Items',
            'MEMBERS'       => 'Members',
            'COMMENTS'       => 'Comments',
            'STATISTICS'    => 'Statistics',
            'LOGS'          => 'Logs',
            'HOME_PAGE' => 'Homepage',
            '' => '',
            '' => '',
            '' => '',
            '' => '',

        );

        return $lang[$phrase];

    } 


