<style>
    :root{
        --subsactivations_purchase_btn_color: <?php 
            if(get_option('subsactivations_purchase_button')){
                echo get_option( 'subsactivations_purchase_button' );
            }else{
                echo '#820182';
            }
        ?>;
        --subsactivations_active_btn_color: <?php 
            if(get_option('subsactivations_activate_button')){
                echo get_option( 'subsactivations_activate_button' );
            }else{
                echo '#3580de';
            }
        ?>;
        --subsactivations_form_txt_color: <?php 
            if(get_option('subsactivations_txt_color')){
                echo get_option( 'subsactivations_txt_color' );
            }else{
                echo '#3a3a3a';
            }
        ?>;
        --subsactivations_heading_color: <?php 
            if(get_option('subsactivations_header_color')){
                echo get_option( 'subsactivations_header_color' );
            }else{
                echo '#3a3a3a';
            }
        ?>;
        --subsactivations_notification_color: <?php 
            if(get_option('subsactivations_notification_color')){
                echo get_option( 'subsactivations_notification_color' );
            }else{
                echo '#fbad5d';
            }
        ?>;
    }
</style>