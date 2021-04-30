<?php
function checkout_activation_output($atts){
    ob_start();

    $durl = '#';
    if(!empty($atts) && $atts['url']){
        $durl = $atts['url'];
    }else{
        if(!empty(get_option( 'checkout_activation_durl', '' ))){
            $durl = get_option( 'checkout_activation_durl', '' );
        }
    }
     
    // Colors Include
    global $wpdb,$current_user;

    if(defined('SUBSACT_NAME')){
        wp_enqueue_script(CKOUT_NAME);
        wp_localize_script( CKOUT_NAME, 'public_ajax_action', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'file_nonce' => wp_create_nonce( 'file_nonces' )
        ));
        
        ?>
        <div class="ufields">
        <h3 class="section_title"><?php echo __((get_option('checkout_section_title')?get_option('checkout_section_title'):'STEP 2: Download the EA'), 'subsactivations') ?></h3>
            <p><?php echo __(get_option('checkout_section_text_content'), 'subsactivations') ?></p>
            <a class="downloadbtn" id="download-btn" href="<?php echo esc_url($durl); ?>"> <?php echo (get_option( 'checkout_button_text', '' ) ? get_option( 'checkout_button_text', '' ):'Download the EA'); ?> </a>
        </div>
        <?php
    }else{
        print_r("Please contact to administrator!");
        return;
    }
    return ob_get_clean();
}