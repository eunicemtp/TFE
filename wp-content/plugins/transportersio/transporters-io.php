<?php
/*
 * Plugin Name: Transporters.io
 * Version: 2.1.11
 * Plugin URI: https://transporters.io/
 * Description: Transporters quote form
 * Author: transporters.io
 * Author URI: https://transporters.io/
 * Text Domain: transporters-io
 * Domain Path: /languages
 * Requires at least: 4.0.1
 * Tested up to: 6.7
 * Requires PHP: 7.0
 * License: GPLv2
 */
 
if ( ! defined( 'WPINC' ) ) {
	die;
}

global $first_cookie;

function transporters_activate_quoteform() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quoteform-activator.php';
	Transporters_Quoteform_Activator::transporters_activate();
}


function transporters_deactivate_quoteform() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quoteform-deactivator.php';
	Transporters_Quoteform_Deactivator::transporters_deactivate();
}

function transporters_quoteform_register_widgets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quoteform-widget.php';
	register_widget( 'Transporters_Quoteform_Widget' );
	transporters_check_referal_data();
}

register_activation_hook( __FILE__, 'transporters_activate_quoteform' );
register_deactivation_hook( __FILE__, 'transporters_deactivate_quoteform' );

require_once plugin_dir_path( __FILE__ ) . 'includes/class-quoteform-setting.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-quoteform-includes.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-quoteform-shortcode.php';

add_action( 'init', 'transporters_check_referal_data' );

add_action('admin_menu', 'transporters_quoteform_control_menu');
add_action( 'wp_enqueue_scripts','transporters_quoteform_styles' );
add_action( 'wp_enqueue_scripts','transporters_quoteform_scripts' );
add_action( 'wp_enqueue_scripts', 'transporters_deregister_scripts', 101 );
add_action( 'wp_footer', 'transporters_deregister_scripts_footer', 18 );
add_action( 'wp_print_scripts','transporters_quoteform_scripts' );
add_action( 'admin_enqueue_scripts', 'transporters_quoteform_admin_scripts' );
add_action( 'admin_enqueue_scripts', 'transporters_quoteform_admin_styles' );
add_action( 'admin_enqueue_scripts', 'transporters_deregister_scripts', 101 );
add_shortcode( 'transporters_quote_form', 'transporters_quoteform_shortcode' );

add_action( 'widgets_init', 'transporters_quoteform_register_widgets' );

add_action( 'wp_ajax_get_stage', 'get_stage_callback' );
add_action( 'wp_ajax_nopriv_get_stage', 'get_stage_callback' );

function transportersio_admin_notice() {
    if(!get_option( 'transporters_map_api_key')){
    ?>
    <div class="notice notice-error is-dismissible">
        <p><a href="<?php echo esc_url(admin_url()); ?>admin.php?page=transporters_quoteform"><?php esc_html_e( 'You must setup your Google Maps API key for Transporters.io to work', 'transporters-io' ); ?></a></p>
    </div>
    <?php
    }
}
add_action( 'admin_notices', 'transportersio_admin_notice' );

function get_stage_callback() {
	global $wpdb;
	
	if(isset($_REQUEST['stage']) && isset($_REQUEST['widget_id'])){//phpcs:ignore

	    $script = get_option('transporters_custom_js_'.sanitize_text_field(wp_unslash($_REQUEST['stage'])).'_'.sanitize_text_field(wp_unslash($_REQUEST['widget_id'])));//phpcs:ignore
	    
	    if(strpos(stripslashes($script),'<script') !== false){
		    echo stripslashes($script);//phpcs:ignore
	    }else if($script){
		    echo '<script>'.stripslashes($script).'</script>';//phpcs:ignore
	    }
	}
	
	wp_die();
}

function transporters_check_referal_data(){

	global $first_cookie;
	global $first_cookie_aff;
	if(!isset($_COOKIE['transporters_referer'])) {
		if(isset($_SERVER['HTTP_REFERER']) && strpos(sanitize_text_field(wp_unslash($_SERVER['HTTP_REFERER'])),get_site_url()) === false){

			preg_match("/[\&\?](q|query|wd|search_word|qs|encquery|terms|rdata|text|szukaj|p|s|k|words)=([^&]*)/", sanitize_text_field(wp_unslash($_SERVER['HTTP_REFERER'])), $matches);
		
			$keyword = false;
			if(isset($matches) && is_array($matches) && isset($matches[2])){
				$keyword = $matches[2];
			}
		
			if(!$keyword){
				if(isset($_GET['keyword']) && sanitize_text_field(wp_unslash($_GET['keyword'])) !=''){//phpcs:ignore
				    //standard adwords/analytics format 
					$keyword = sanitize_text_field(wp_unslash($_GET['keyword']));//phpcs:ignore
					if(isset($_GET['matchtype']) && sanitize_text_field(wp_unslash($_GET['matchtype'])) !=''){$keyword .= '~'.sanitize_text_field(wp_unslash($_GET['matchtype'])); }//phpcs:ignore
					if(isset($_GET['device']) && sanitize_text_field(wp_unslash($_GET['device'])) !=''){$keyword .= '~'.sanitize_text_field(wp_unslash($_GET['device'])); }//phpcs:ignore
				}elseif(isset($_GET['q'])){//phpcs:ignore
					$keyword = sanitize_text_field(wp_unslash($_GET['q']));	//phpcs:ignore
				}
			}
		
			setcookie('transporters_referer',sanitize_text_field(wp_unslash($_SERVER['HTTP_REFERER']))."***".$keyword,time()+(3600*24*7));//phpcs:ignore
		
			$first_cookie = sanitize_text_field(wp_unslash($_SERVER['HTTP_REFERER']))."***".$keyword;//phpcs:ignore
		}
	}
	if( isset($_GET['aff']) || isset($_GET['affiliate_id']) ) {//phpcs:ignore
		$aff_id = isset($_GET['aff']) ? sanitize_text_field(wp_unslash($_GET['aff'])) : sanitize_text_field(wp_unslash($_GET['affiliate_id']));//phpcs:ignore
		setcookie('transporters_aff', $aff_id, time()+(3600*24*3));
		$first_cookie_aff = $aff_id;
	}
	
}

function transporters_load_plugin_textdomain() {
    if (load_plugin_textdomain( 'transporters-io', false, dirname(plugin_basename(__FILE__)).'/languages/')) {
		//
	} 
}
add_action( 'plugins_loaded', 'transporters_load_plugin_textdomain' );

?>
