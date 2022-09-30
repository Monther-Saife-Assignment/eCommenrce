$(function () {
    'use strict';

    // Dashboard

    $('.toggle-info').click(function () {

        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(200);

        if ($(this).hasClass('selected')) {

            $(this).html('<i class="fa fa-minus fa-lg"></i>');

        } else {

            $(this).html('<i class="fa fa-plus fa-lg"></i>');

        }

    });


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


    // Convert Password Field To Text Field On Haver

    var passField = $('.password');

    $('.show-pass').hover(function () {

        passField.attr('type', 'text');

    }, function () {

        passField.attr('type', 'password');
        
    });

    // Category View Option

    $('.cat h3').click(function () {

        $(this).next('.full-view').fadeToggle(200);
        
    });


    
    $('.option span').click(function () {

        $(this).addClass('active').siblings('span').removeClass('active');

        if ($(this).data('view') == 'full') {

            $('.cat .full-view').fadeIn(200);

        } else {

            $('.cat .full-view').fadeOut(200);


        }
    });


    // Show Delete Button On Child Cats

    $('.show-link').hover(function () {

        $(this).find('.show-delete').fadeIn(400);

    }, function () {

        $(this).find('.show-delete').fadeOut(400);

    });


});

    //Confirmation Message On Button

    $('.confirm').click(function () {

        return confirm("Are Tou Sure?");

    });


// setTimeout(function ($param) {
//     window.location.href=$param;
// },5000);


// $(function () {
//     $('[placeholder]').focus(function () {
//       $(this).attr('data-text', $(this).attr('placeholder'));
//       $(this).removeAttr('placeholder');
//     }).blur(function () {
//       $(this).attr('placeholder', $(this).attr('data-text'));
//     });
//   });


