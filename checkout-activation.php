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
    if(!defined('SUBSACT_NAME')){
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
        '<strong>' . esc_html__( 'Activations', 'checkout_activation' ) . '</strong>'
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

    // Register Menu
    add_action('admin_menu', function(){
        add_menu_page( 'Checkout Activation', 'Checkout Activation', 'manage_options', 'checkout_activation', 'checkout_activation_menupage_display', 'dashicons-yes-alt', 45 );
    
        // Settings
        add_settings_section( 'checkout_view_section', '', '', 'checkout_view_section_page' );
    
         // checkout_section_title
        add_settings_field( 'checkout_section_title', 'Section Title', 'checkout_section_title_func', 'checkout_view_section_page', 'checkout_view_section');
        register_setting( 'checkout_view_section', 'checkout_section_title');

        // checkout_section_text_content
        add_settings_field( 'checkout_section_text_content', 'Section Title', 'checkout_section_text_content_func', 'checkout_view_section_page', 'checkout_view_section');
        register_setting( 'checkout_view_section', 'checkout_section_text_content');

        // checkout_button_text
        add_settings_field( 'checkout_button_text', 'Button Text', 'checkout_button_text_func', 'checkout_view_section_page', 'checkout_view_section');
        register_setting( 'checkout_view_section', 'checkout_button_text');
    });

    //checkout_section_title
    function checkout_section_title_func(){
        echo '<input type="text" name="checkout_section_title" value="'.(get_option( 'checkout_section_title', '' ) ? get_option( 'checkout_section_title', '' ):'').'" placeholder="STEP 2: Download the EA">';
    }

    //checkout_section_title
    function checkout_section_text_content_func(){
        echo '<textarea placeholder="Description" name="checkout_section_text_content" id="checkout_section_text_content" cols="23" style="resize: horizontal; max-width: 80%" rows="">'.(get_option( 'checkout_section_text_content', '' ) ? get_option( 'checkout_section_text_content', '' ):'').'</textarea>';
    }

    //Button text
    function checkout_button_text_func(){
        echo '<input type="text" name="checkout_button_text" value="'.(get_option( 'checkout_button_text', '' ) ? get_option( 'checkout_button_text', '' ):'').'" placeholder="Download the EA">';
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
        <?php
        echo '<form action="options.php" method="post" id="checkout_activation_settings">';
        echo '<h1>Checkout Activations Settings</h1><hr>';
        echo '<table class="form-table">';

        settings_fields( 'checkout_view_section' );
        do_settings_fields( 'checkout_view_section_page', 'checkout_view_section' );

        echo '</table>';
        submit_button();
        echo '</form>';
    }

    // Output with Shortcode
    add_shortcode('checkout_activation_v1', 'checkout_activation_output');
    require_once 'inc/checkout-activation-output.php';
}