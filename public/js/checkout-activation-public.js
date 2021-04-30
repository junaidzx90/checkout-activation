jQuery(function ($) {
    $('#download-btn').on('click', function (e) {
        e.preventDefault();
        let file_url = $(this).attr('href');
        let originaltxt = $('#download-btn').text();

        $.ajax({
            type: "post",
            url: public_ajax_action.ajaxurl,
            data: {
                action: 'get_my_file_from_server',
                file_url: file_url,
                file_nonce: public_ajax_action.file_nonce
            },
            cache: 'false',
            beforeSend: ()=>{
                $('#download-btn').text('Processing...')
            },
            success: function (response) {
                location.href = response;
                $('#download-btn').text(originaltxt);
            }
        });
    });
});