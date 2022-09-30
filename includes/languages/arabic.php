<?php

    function lang( $phrase ) {

        static $lang = array(

            'MESSAGE' => 'مرحبا',
            'ADMIN' => 'ايها المدير'

        );

        return $lang[$phrase];

    } 


