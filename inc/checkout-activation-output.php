<?php
function checkout_activation_output($atts){
    ob_start();

    $durl = '#';
    if(!empty($atts) && $atts['url']){
        $durl = $atts['url'];
    }else{
        if(!empty(get_option( 'checkout_section_download_link', '' ))){
            $durl = get_option( 'checkout_section_download_link', '' );
        }
    }
    global $current_user;
    // Colors
    require_once CKOUT_PATH.'inc/checkout-activation-colors.php';

    if(class_exists('WC_Subscriptions')){
        $_subscriptions = wcs_get_users_subscriptions($current_user->ID);
        $accessed = false;
        foreach ($_subscriptions as $subscription){
            if ($subscription->has_status(array('active'))) {
                $accessed = true;
            }
        }

        if($accessed == true):
            wp_enqueue_script(CKOUT_NAME);
            wp_localize_script( CKOUT_NAME, 'public_ajax_action', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'file_nonce' => wp_create_nonce( 'file_nonces' )
            ));
            
            // Section1
            echo do_shortcode( get_option('subsactivations_shortcode','') );
            ?>
            <!-- SECTION2 -->
            <div class="ufields">
            <h3 class="section_title"><?php echo __((get_option('checkout_section_title')?get_option('checkout_section_title'):'STEP 2: Download the EA'), 'subsactivations') ?></h3>
                <p><?php echo __(get_option('checkout_section_text_content'), 'subsactivations') ?></p>
                <a class="downloadbtn" id="download-btn" href="<?php echo esc_url($durl); ?>"> <?php echo (get_option( 'checkout_button_text', '' ) ? get_option( 'checkout_button_text', '' ):'Download the EA'); ?> </a>
            </div>
            <?php
        else:
            ?>
            <div class="purchase_btnwrap">
                <a id="purchase-btn" href="<?php echo esc_url(get_option( 'subsactivations_url', '' )); ?>"> Please start the subscription </a>
            </div>
            <?php
        endif;
    }else{
        print_r("Please contact to administrator!");
    }
    
    return ob_get_clean();
}