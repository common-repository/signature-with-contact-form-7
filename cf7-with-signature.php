<?php  
/**
 * Plugin Name: Signature With Contact Form 7
 * Description: Add a signature field type to the popular Contact Form 7 plugin.
 * Version: 1.0
 * Copyright:2019
*/
if (!defined('ABSPATH')) {
    die('-1');
}
if (!defined('OCSWCF_PLUGIN_NAME')) {
    define('OCSWCF_PLUGIN_NAME', 'Signature With Contact Form 7');
}
if (!defined('OCSWCF_PLUGIN_VERSION')) {
    define('OCSWCF_PLUGIN_VERSION', '1.0.0');
}
if (!defined('OCSWCF_PLUGIN_FILE')) {
    define('OCSWCF_PLUGIN_FILE', __FILE__);
}
if (!defined('OCSWCF_PLUGIN_DIR')) {
    define('OCSWCF_PLUGIN_DIR',plugins_url('', __FILE__));
}
if (!defined('OCSWCF_DOMAIN')) {
    define('OCSWCF_DOMAIN', 'ocswcf');
}
if (!defined('OCSWCF_BASE_NAME')) {
    define('OCSWCF_BASE_NAME', plugin_basename(OCSWCF_PLUGIN_FILE));
}
if (!defined('PAGE_SLUG')) {
    define('PAGE_SLUG', "cf7signature_pro_version");
}
if (!class_exists('OCSWCF')) {
 	class OCSWCF {
      	protected static $OCSWCF_instance;
     	//Load all includes files
    	function includes() {
      	   include_once('admin/signature-with-cf7.php');
        }
    	function init() {
            add_action( 'admin_init', array($this, 'OCSWCF_load_plugin'), 11 );
            add_action( 'wp_enqueue_scripts',  array($this, 'OCSWCF_load_script_style'));
            add_action( 'admin_enqueue_scripts', array($this, 'OCSWCF_load_script_style_admin'));
            add_filter( 'plugin_row_meta', array( $this, 'OCSWCF_plugin_row_meta' ), 10, 2 );
        }
      	function OCSWCF_load_plugin() {
            if ( ! ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) ) {
            add_action( 'admin_notices', array($this,'OCSWCF_install_error') );
            }
        }
      	function OCSWCF_install_error() {
            deactivate_plugins( plugin_basename( __FILE__ ) );
                ?>
                <div class="error">
                  <p>
                    <?php _e( 'cf7 calculator plugin is deactivated because it require <a href="plugin-install.php?tab=search&s=contact+form+7">Contact Form 7</a> plugin installed and activated.', OCSWCF_DOMAIN ); ?>
                  </p>
                </div>
         <?php
      	}

        function OCSWCF_plugin_row_meta( $links, $file ) {
            if ( OCSWCF_BASE_NAME === $file ) {
                $row_meta = array(
                    'rating'    =>  '<a href="https://www.xeeshop.com/support-us/?utm_source=aj_plugin&utm_medium=plugin_support&utm_campaign=aj_support&utm_content=aj_wordpress" target="_blank">Support</a> |<a href="#" target="_blank"><img src="'.OCSWCF_PLUGIN_DIR.'/includes/images/star.png" class="ocswcf_rating_div"></a>',
                );
                return array_merge( $links, $row_meta );
            }
            return (array) $links;
        }
        //Add JS and CSS on Frontend
        function OCSWCF_load_script_style() {
         	wp_enqueue_script( 'OCSWCF-front-js', OCSWCF_PLUGIN_DIR . '/includes/js/front.js', array("jquery"), '2.0.0' );
         	wp_enqueue_style( 'OCSWCF-style-css',OCSWCF_PLUGIN_DIR . '/includes/css/style.css', false, '2.0.0' );
          	wp_enqueue_script( 'OCSWCF-jquery-sign-js', OCSWCF_PLUGIN_DIR .'/includes/js/signature_pad.js', false, '2.0.0' );

        }
        function OCSWCF_load_script_style_admin() {
          	wp_enqueue_style( 'OCSWCF-back_style-css',OCSWCF_PLUGIN_DIR . '/includes/css/back_style.css', false, '2.0.0' );
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker-alpha', OCSWCF_PLUGIN_DIR . '/includes/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.0.0', true );

        }
 
        //Plugin Rating
        public static function do_activation() {
          set_transient('ocswcf-first-rating', true, MONTH_IN_SECONDS);
        }
        public static function OCSWCF_instance() {
          if (!isset(self::$OCSWCF_instance)) {
            self::$OCSWCF_instance = new self();
            self::$OCSWCF_instance->init();
            self::$OCSWCF_instance->includes();
          }
          return self::$OCSWCF_instance;
        }
    }
    add_action('plugins_loaded', array('OCSWCF', 'OCSWCF_instance'));
    register_activation_hook(OCSWCF_PLUGIN_FILE, array('OCSWCF', 'do_activation'));
}