jQuery(function ($) {
    $('#rest_colors').on('click', function (e) {
        e.preventDefault();
       $.ajax({
           type: "post",
           url: admin_ajax_actions.ajaxurl,
           data: {
               action: 'checkout_reset_colors'
           },
           success: function (response) {
               location.reload();
           }
       }); 
    });
});