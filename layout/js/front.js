$(function () {
    'use strict';

    // Switch Between Login And SignUp
    $('.login-page h1 span').click(function() {

        $(this).addClass('selected').siblings().removeClass('selected');

        $('.login-page form').hide();

        $('.' + $(this).data('class')).fadeIn(200);
    });


     // Trigger The SelectBoxIt

    //  $("select").selectBocIt({
    //     autoWidth: false
    // });


    // Hide Place Holder On Form Focus

    $('[placeholder]').focus(function () {

        $(this).attr('data-text', $(this).attr('placeholder'));

        $(this).attr('placeholder', '');

    }).blur(function () {

        $(this).attr('placeholder', $(this).attr('data-text'));
        
    });


    // Add Asterisk On Required Field
    // Lesson 25 On eCommerce 
    $('input').each(function () {

        if($(this).attr('required') === 'required') {

            $(this).after('<span class="asterisk">*</span>');

        }
    });


    //Confirmation Message On Button

    $('.confirm').click(function () {

        return confirm("Are Tou Sure?");

    });


    // Live Changing Text 
    $('.live-name').keyup(function () {    // Put This Class On The Text You Want To Write On
        $('.live-preview .caption h3').text($(this).val());   // Follow The Place Where You Will Write The Text
    });

    $('.live-desc').keyup(function () {
        $('.live-preview .caption p').text($(this).val());
    });
    
    $('.live-price').keyup(function () {
        $('.live-preview .price-tag').text('$' + $(this).val());
    });


});



