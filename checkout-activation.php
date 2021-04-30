<?php
 /**
 *
 * @link              https://github.com/mql4Expert/checkout_activation
 * @since             1.0.0
 * @package           checkout_activation
 *
 * @wordpress-plugin
 * Plugin Name:       Checkout Activation
 * Plugin URI:        https://github.com/mql4Expert/checkout_activation
 * Description:       This plugin parts of the Activations Plugin.
 * Version:           1.0.0
 * Author:            Mql4Expert
 * Author URI:        https://github.com/mql4Expert/about
 * Text Domain:       checkout_activation
 * Domain Path:       /languages
 */

// If this file is called directly, abort.

define( 'CKOUT_NAME', 'checkout_activation' );
define( 'CKOUT_PATH', plugin_dir_path( __FILE__ ) );

if ( ! defined( 'WPINC' ) && ! defined('CKOUT_NAME') && ! defined('CKOUT_PATH')) {
	die;
}

add_action( 'plugins_loaded', 'checkout_activation_init' );
function checkout_activation_init() {
    if(!class_exists('WC_Subscriptions')){
        add_action( 'admin_notices', 'checkout_activation_admin_noticess' );
    }else{
        add_action('init', 'checkout_activation_run');
    }

    load_plugin_textdomain( 'checkout_activation', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

function checkout_activation_admin_noticess(){
    $message = sprintf(
        /* translators: 1: Plugin Name 2: Elementor */
        esc_html__( '%1$s requires %2$s to be installed and activated.', 'checkout_activation' ),
        '<strong>' . esc_html__( 'Checkout Activation', 'checkout_activation' ) . '</strong>',
        '<strong>' . esc_html__( 'Woocommerce Subscriptions', 'checkout_activation' ) . '</strong>'
    );

    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
}

// Main Function iitialize
function checkout_activation_run(){

    register_activation_hook( __FILE__, 'activate_checkout_activation_cplgn' );
    register_deactivation_hook( __FILE__, 'deactivate_checkout_activation_cplgn' );

    // Activision function
    function activate_checkout_activation_cplgn(){
        // Nothing For Now
    }

    // Dectivision function
    function deactivate_checkout_activation_cplgn(){
        // Nothing For Now
    }

    // WP Enqueue Scripts
    add_action('wp_enqueue_scripts',function(){
        wp_register_style( CKOUT_NAME, plugin_dir_url( __FILE__ ).'public/css/checkout-activation-public.css', array(), microtime(), 'all' );
        wp_enqueue_style(CKOUT_NAME);

        wp_register_script( CKOUT_NAME, plugin_dir_url( __FILE__ ).'public/js/checkout-activation-public.js', array(), 
        microtime(), true );
    });

    // WP Enqueue Scripts
    add_action('admin_enqueue_scripts',function(){
        wp_register_script( CKOUT_NAME, plugin_dir_url( __FILE__ ).'public/js/checkout-activation-admin.js', array(), microtime(), true );
        wp_enqueue_script(CKOUT_NAME);
        wp_localize_script( CKOUT_NAME, 'admin_ajax_actions', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ));
    });

    // Register Menu
    add_action('admin_menu', function(){
        add_menu_page( 'Checkout Activation', 'Checkout Activation', 'manage_options', 'checkout_activation', 'checkout_activation_menupage_display', 'dashicons-yes-alt', 45 );
    
        // Settings
        add_settings_section( 'checkout_colors_section', '', '', 'checkout_colors_section_page' );
        // Settings
        add_settings_section( 'checkout_view_section', '', '', 'checkout_view_section_page' );
    

        /**
         * STEP1
         */
        // subsactivations_section_title
        add_settings_field( 'subsactivations_section_title', 'Step1 Title', 'subsactivations_section_title_func', 'checkout_view_section_page', 'checkout_view_section');
        register_setting( 'checkout_view_section', 'subsactivations_section_title');

        // subsactivations_section_text_content
        add_settings_field( 'subsactivations_section_text_content', 'Step1 Description', 'subsactivations_section_text_content_func', 'checkout_view_section_page', 'checkout_view_section');
        register_setting( 'checkout_view_section', 'subsactivations_section_text_content');

        // subsactivations_shortcode
        add_settings_field( 'subsactivations_shortcode', 'Step1 Shortcode', 'subsactivations_shortcode_func', 'checkout_view_section_page', 'checkout_view_section');
        register_setting( 'checkout_view_section', 'subsactivations_shortcode');

        /**
         * STEP2
         */
         // checkout_section_title
        add_settings_field( 'checkout_section_title', 'Step2 Title', 'checkout_section_title_func', 'checkout_view_section_page', 'checkout_view_section');
        register_setting( 'checkout_view_section', 'checkout_section_title');

        // checkout_section_text_content
        add_settings_field( 'checkout_section_text_content', 'Step2 Description', 'checkout_section_text_content_func', 'checkout_view_section_page', 'checkout_view_section');
        register_setting( 'checkout_view_section', 'checkout_section_text_content');

        // Step2 Download Link
        add_settings_field( 'checkout_section_download_link', 'Step2 Download Link', 'checkout_section_download_link_func', 'checkout_view_section_page', 'checkout_view_section');
        register_setting( 'checkout_view_section', 'checkout_section_download_link');

        // checkout_button_text
        add_settings_field( 'checkout_button_text', 'Step2 Button Text', 'checkout_button_text_func', 'checkout_view_section_page', 'checkout_view_section');
        register_setting( 'checkout_view_section', 'checkout_button_text');


        /**
         * COLORS
         */
        //Dwonload Button
        add_settings_field( 'subsactivations_activate_button', 'Dwonload Button', 'checkout_activate_button_func', 'checkout_colors_section_page', 'checkout_colors_section');
        register_setting( 'checkout_colors_section', 'subsactivations_activate_button');
        // Purchase Button
        add_settings_field( 'subsactivations_purchase_button', 'Purchase Button', 'checkout_purchase_button_func', 'checkout_colors_section_page', 'checkout_colors_section');
        register_setting( 'checkout_colors_section', 'subsactivations_purchase_button');
        // Section header color
        add_settings_field( 'subsactivations_header_color', 'Section heading color', 'checkout_header_color_func', 'checkout_colors_section_page', 'checkout_colors_section');
        register_setting( 'checkout_colors_section', 'subsactivations_header_color');
        // Section texts color
        add_settings_field( 'subsactivations_txt_color', 'Section texts color', 'checkout_txt_color_func', 'checkout_colors_section_page', 'checkout_colors_section');
        register_setting( 'checkout_colors_section', 'subsactivations_txt_color');
        // Notification color
        add_settings_field( 'subsactivations_notification_color', 'Notification color', 'checkout_notification_color_button_func', 'checkout_colors_section_page', 'checkout_colors_section');
        register_setting( 'checkout_colors_section', 'subsactivations_notification_color');
    });


    //subsactivations_section_title
    function subsactivations_section_title_func(){
        echo '<input type="text" name="subsactivations_section_title" value="'.(get_option( 'subsactivations_section_title', '' ) ? get_option( 'subsactivations_section_title', '' ):'').'" placeholder="Active your Licenses">';
    }

    //subsactivations_section_title
    function subsactivations_section_text_content_func(){
        echo '<textarea placeholder="Description" name="subsactivations_section_text_content" id="subsactivations_section_text_content" cols="23" style="resize: horizontal; max-width: 80%" rows="">'.(get_option( 'subsactivations_section_text_content', '' ) ? get_option( 'subsactivations_section_text_content', '' ):'').'</textarea>';
    }

    //subsactivations_shortcode_func
    function subsactivations_shortcode_func(){
        echo '<input type="text" name="subsactivations_shortcode" value="'.(get_option( 'subsactivations_shortcode', '' ) ? esc_html(get_option( 'subsactivations_shortcode', '' )):'').'" placeholder="[activations_v1 url=\'example.com\']">';
    }


    //checkout_section_title
    function checkout_section_title_func(){
        echo '<input type="text" name="checkout_section_title" value="'.(get_option( 'checkout_section_title', '' ) ? get_option( 'checkout_section_title', '' ):'').'" placeholder="STEP 2: Download the EA">';
    }

    //checkout_section_title
    function checkout_section_text_content_func(){
        echo '<textarea placeholder="Description" name="checkout_section_text_content" id="checkout_section_text_content" cols="23" style="resize: horizontal; max-width: 80%" rows="">'.(get_option( 'checkout_section_text_content', '' ) ? get_option( 'checkout_section_text_content', '' ):'').'</textarea>';
    }
    
    //checkout_section_download_link
    function checkout_section_download_link_func(){
        echo '<input type="url" name="checkout_section_download_link" value="'.(get_option( 'checkout_section_download_link', '' ) ? get_option( 'checkout_section_download_link', '' ):'').'" placeholder="example.com/filename.ext">';
    }

    //Button text
    function checkout_button_text_func(){
        echo '<input type="text" name="checkout_button_text" value="'.(get_option( 'checkout_button_text', '' ) ? get_option( 'checkout_button_text', '' ):'').'" placeholder="Download the EA">';
    }

    // checkout_reset_colors
    add_action("wp_ajax_checkout_reset_colors", "checkout_reset_colors");
    add_action("wp_ajax_nopriv_checkout_reset_colors", "checkout_reset_colors");
    function checkout_reset_colors(){
        delete_option( 'subsactivations_activate_button' );
        delete_option( 'subsactivations_purchase_button' );
        delete_option( 'subsactivations_txt_color' );
        delete_option( 'subsactivations_notification_color' );
        delete_option('subsactivations_header_color');
        echo 'Success';
        wp_die();
    }
    
    /**
     * COLORS
     */

    // activate/Dwonload Button colors
    function checkout_activate_button_func(){
        echo '<input type="color" name="subsactivations_activate_button" id="subsactivations_activate_button" value="'.(get_option( 'subsactivations_activate_button', '' ) ? get_option( 'subsactivations_activate_button', '' ):'#3580de').'">';
    }
    //purchase_button colors
    function checkout_purchase_button_func(){
        echo '<input type="color" name="subsactivations_purchase_button" id="subsactivations_purchase_button" value="'.(get_option( 'subsactivations_purchase_button', '' ) ? get_option( 'subsactivations_purchase_button', '' ):'#820182').'">';
    }
    //txt_color_button
    function checkout_header_color_func(){
        echo '<input type="color" name="subsactivations_header_color" id="subsactivations_header_color" value="'.(get_option( 'subsactivations_header_color', '' ) ? get_option( 'subsactivations_header_color', '' ):'#3a3a3a').'">';
    }
    //txt_color_button
    function checkout_txt_color_func(){
        echo '<input type="color" name="subsactivations_txt_color" id="subsactivations_txt_color" value="'.(get_option( 'subsactivations_txt_color', '' ) ? get_option( 'subsactivations_txt_color', '' ):'#3a3a3a').'">';
    }
    //notification_color
    function checkout_notification_color_button_func(){
        echo '<input type="color" name="subsactivations_notification_color" id="subsactivations_notification_color" value="'.(get_option( 'subsactivations_notification_color', '' ) ? get_option( 'subsactivations_notification_color', '' ):'#fbad5d').'">';
    }

    // get_my_file_from_server
    add_action("wp_ajax_get_my_file_from_server", "get_my_file_from_server");
    add_action("wp_ajax_nopriv_get_my_file_from_server", "get_my_file_from_server");

    function get_my_file_from_server(){
        
        if(wp_verify_nonce( $_POST['file_nonce'], 'file_nonces' )){
            
            if(isset($_POST['file_url'])){
                $url = esc_url($_POST['file_url']);
                echo plugin_dir_url( __FILE__ ).'public/download.php?file_url='.$url;
                wp_die();
            }
            wp_die();
        }
        wp_die();
    }

    // Menu callback funnction
    function checkout_activation_menupage_display(){
        wp_enqueue_script(CKOUT_NAME);
        ?>
        <style>
            p.submit { display: inline-block; }
            button#rest_colors { padding: 7px 10px; background: red; border: none; outline: none; border-radius: 3px; margin-left: 10px; color: #fff; cursor: pointer; opacity: .7; } button#rest_colors:hover{ opacity: 1;}
        </style>
        <?php
        echo '<form action="options.php" method="post" id="checkout_settings">';
        echo '<h1>Checkout Settings</h1><hr>';
        echo '<table class="form-table">';

        settings_fields( 'checkout_view_section' );
        do_settings_fields( 'checkout_view_section_page', 'checkout_view_section' );

        echo '</table>';
        submit_button();
        echo '</form>';

        echo '<form action="options.php" method="post" id="checkout_colors">';
        echo '<h1>Checkout Colors</h1><hr>';
        echo '<table class="form-table">';

        settings_fields( 'checkout_colors_section' );
        do_settings_fields( 'checkout_colors_section_page', 'checkout_colors_section' );

        echo '</table>';
        submit_button('Save');
        echo '<button id="rest_colors">Reset</button>';
        echo '</form>';
    }

    
    // Output with Shortcode
    add_shortcode('checkout_activation_v1', 'checkout_activation_output');
    require_once 'inc/checkout-activation-output.php';
}