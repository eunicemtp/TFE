<?php
/*
Plugin Name: WP Ride Booking - Best Taxi Booking Solution for WordPress
Plugin URI: 
Description: WP Ride Booking is a best solution to create a ride booking system in wordpress.
Version: 2.4		
Author: GBS Developer
Author URI: https://profiles.wordpress.org/gbsdeveloper#content-plugins`
License: GPLv2+
Text Domain: wp_ride_booking
*/

define('wprb_VERSION', '2.4');
define('wprb_FILE', basename(__FILE__));
define('wprb_NAME', str_replace('.php', '', wprb_FILE));
define('wprb_PATH', plugin_dir_path(__FILE__));
define('wprb_URL', plugin_dir_url(__FILE__));

include_once( wprb_PATH . 'includes/shortcodes.php' );
include_once( wprb_PATH . 'includes/ride-functions.php' );


add_action('wp_head','wprb_ride_ajaxurl');
function wprb_ride_ajaxurl() {
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}


add_action('admin_head', 'wprb_ride_custom_css');
function wprb_ride_custom_css() {
  echo '<style>
 .paypal_settings {
   	width: 100%;
	padding: 10px 0;
}
.paypal_settings tbody tr{
	height:50px;
}
.paypal_settings tbody tr td input[type="text"]{
	padding-bottom: 8px;
    padding-top: 8px;
    width: 100%;
}
.wprb-color-picker { padding:2px 5px!important;}
form.ride_seting_form h1{
margin-top:50px;
}
    
  </style>';?>

<script type="text/javascript">

jQuery(document).ready(function () {  
	var selected_currency = jQuery('.currency_sel').val(); 
	jQuery(".selected_currency ").text(selected_currency);

	jQuery('.currency_sel').on('change', function() {
		jQuery(".selected_currency").text(this.value);
	});

}); 
</script>
  <?php
}
function wprb_ride_booking_scripts() {
    // Ensure jQuery is enqueued
    wp_enqueue_script('jquery');

    // Check for transient to see if the Google Maps API has been enqueued
    if (false === get_transient('google_maps_api_loaded')) {
        $api_key = get_option('google_map_api');
        $script_url = "//maps.googleapis.com/maps/api/js?libraries=places&key=$api_key";

        // Output the script tag with the async attribute directly
        echo '<script async src="' . esc_url($script_url) . '" id="google-maps-api"></script>';
        
        // Set a transient to remember that the API script has been loaded
        set_transient('google_maps_api_loaded', true, 12 * HOUR_IN_SECONDS);
    } else {
        // If the API is already loaded, directly include the distance.js script
        wp_enqueue_script('ride-jscript', wprb_URL . 'includes/distance.js', array('google-maps-api'), null, true);
    }

    // Enqueue additional styles
    wp_enqueue_style('map-style', wprb_URL . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'wprb_ride_booking_scripts');


function wprb_clear_google_maps_transient() {
    delete_transient('google_maps_api_loaded');
}
register_deactivation_hook(__FILE__, 'wprb_clear_google_maps_transient');


function wprb_ride_booking_install() {
    wprb_ride_booking_activate(); 
}
register_activation_hook( __FILE__, 'wprb_ride_booking_install' );



add_action( 'admin_menu', 'wprb_ride_booking_activate' );

function wprb_ride_booking_activate() {
	add_option('ride_header_footer_bg_color','#a52a2a');
	add_option('ride_text_color','#ffffff');
	add_option('ride_submit_button_bg_color','#696969');
	add_option('ride_button_bg_hover_color','#000000');
	add_option('ride_paypal_mode','Sandbox');
	
    add_options_page("WP Ride Booking","WP Ride Booking","administrator", "wp-ride-booking", "wprb_booking_setting", plugin_dir_url( __FILE__ )."ride_icon.png" );
}

add_action( 'admin_enqueue_scripts', 'wprb_add_color_picker' );
function wprb_add_color_picker( $hook ) {
 
    if( is_admin() ) { 
     
        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'wprb_script-handle', plugins_url( 'js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}


function wprb_booking_setting(){
	if(isset($_POST['setting_submit'])){
		$paypal_id = sanitize_text_field($_POST['paypal_id']);
		$paypal_mode = sanitize_text_field($_POST['paypal_mode']);		
		$ride_rate = (float) $_POST['ride_rate'];
		$map_api = sanitize_text_field($_POST['map_api']);
		$button_txt = sanitize_text_field($_POST['button_txt']);
		$map_height = sanitize_text_field($_POST['map_height']);
		$currency = sanitize_text_field($_POST['currency']);		
		$header_footer_bg_color = sanitize_text_field($_POST['header_footer_bg_color']);
		$ride_text_color = sanitize_text_field($_POST['ride_text_color']);
		$submit_button_bg_color = sanitize_text_field($_POST['submit_button_bg_color']);
		$button_bg_hover_color = sanitize_text_field($_POST['button_bg_hover_color']);
		update_option("google_map_api",sanitize_text_field($map_api));
		update_option("paypal_email",sanitize_text_field($paypal_id));
		update_option("ride_paypal_mode",sanitize_text_field($paypal_mode));
		update_option("per_km_rate",$ride_rate);
		update_option("calculate_button_txt",sanitize_text_field($button_txt));
		update_option('ride_map_height', sanitize_text_field($map_height));
		update_option('ride_currency', sanitize_text_field($currency));
		update_option('ride_header_footer_bg_color', sanitize_text_field($header_footer_bg_color));
		update_option('ride_text_color', sanitize_text_field($ride_text_color));
		update_option('ride_submit_button_bg_color', sanitize_text_field($submit_button_bg_color));
		update_option('ride_button_bg_hover_color', sanitize_text_field($button_bg_hover_color));
	}	
	
	    $paypal_mode =  esc_attr(get_option('ride_paypal_mode'));
		$api_key = esc_attr(get_option('google_map_api'));
		$paypal_id = sanitize_email(get_option('paypal_email'));
		$ride_rate = get_option('per_km_rate');
		$button_txt = esc_attr(get_option('calculate_button_txt'));
		$map_height_new = esc_attr(get_option('ride_map_height'));
		$currency_sel = esc_attr(get_option('ride_currency'));
		$header_footer_bg_color_new = esc_attr(get_option('ride_header_footer_bg_color'));
		$ride_text_color_new = esc_attr(get_option('ride_text_color'));
		$submit_button_bg_color_new = esc_attr(get_option('ride_submit_button_bg_color'));
		$ride_button_bg_hover_color = esc_attr(get_option('ride_button_bg_hover_color'));
	?>
	<form method="post" class="ride_seting_form"><table class="paypal_settings"><h1>WP Ride Booking Setting</h1>
	<tr>
		<td valign="top">
			<table width="90%">
								<tr><td><strong>Payment Mode</strong></td><td>
								
									<input type="radio" name="paypal_mode" id="paypal_mode_sandbox" value="Sandbox" <?php  echo ($paypal_mode=="Sandbox")?'checked=chekced':'';?>>Sandbox<br><input type="radio" name="paypal_mode" id="paypal_mode_Live" value="Live" <?php  echo ($paypal_mode=="Live")?'checked=chekced':'';?>>Live</td></tr>
				<tr><td><strong>Google Map API Key</strong></td><td><input type="text" name="map_api" id="map_api" value="<?php echo esc_attr($api_key);?>"></td></tr>
				<tr><td><strong>Google Map Height</strong></td><td><select name="map_height">
				<?php $sel = (isset( $map_height_new ) &&  $map_height_new === '300') ? 'selected' : '' ; ?>
				 <option value="300" <?php echo $sel;?>>300px</option>
				 
				 <?php $sel = (isset( $map_height_new ) &&  $map_height_new === '400') ? 'selected' : '' ; ?>
				 <option value="400" <?php echo $sel;?>>400px</option>
				 
				 <?php $sel = (isset( $map_height_new ) &&  $map_height_new === '500') ? 'selected' : '' ; ?>
				 <option value="500" <?php echo $sel;?>>500px</option>
				 
				 <?php $sel = (isset( $map_height_new ) &&  $map_height_new === '600') ? 'selected' : '' ; ?>
				 <option value="600" <?php echo $sel;?>>600px</option>
				 
				 <?php $sel = (isset( $map_height_new ) &&  $map_height_new === '700') ? 'selected' : '' ; ?>
				 <option value="700" <?php echo $sel;?>>700px</option></select></td></tr>

				<tr><td><strong>Currency</strong></td><td><select name="currency" class="currency_sel">
				<?php $selected = (isset( $currency_sel ) &&  $currency_sel === 'USD') ? 'selected' : '' ; ?>
				<option value="USD" <?php echo $selected;?>>United States dollar ($)</option>

				<?php $selected = (isset( $currency_sel ) &&  $currency_sel === 'EUR') ? 'selected' : '' ; ?>
				<option value="EUR" <?php echo $selected;?>>Euro (€)</option>

				<?php $selected = (isset( $currency_sel ) &&  $currency_sel === 'GBP') ? 'selected' : '' ; ?>
				<option value="GBP" <?php echo $selected;?>>United Kingdom Pound (£)</option>

				<?php $selected = (isset( $currency_sel ) &&  $currency_sel === 'AUD') ? 'selected' : '' ; ?>
				<option value="AUD" <?php echo $selected;?>>Australian dollar ($)</option>

				<?php $selected = (isset( $currency_sel ) &&  $currency_sel === 'CAD') ? 'selected' : '' ; ?>
				<option value="CAD" <?php echo $selected;?>>Canadian dollar ($)</option>

				<?php $selected = (isset( $currency_sel ) &&  $currency_sel === 'INR') ? 'selected' : '' ; ?>
				<option value="INR" <?php echo $selected;?>>Indian rupee (₹)</option>
			</select></td></tr>
				<tr><td><strong>Paypal email id</strong></td><td><input type="text" name="paypal_id" id="paypal_id" value="<?php echo sanitize_email($paypal_id); ?>"></td></tr>
				<tr><td><strong>Per km rate (<span class="selected_currency"></span>)</strong></td><td><input type="text" name="ride_rate" id="ride_rate" value="<?php echo $ride_rate;?>"></td></tr>
				<tr><td><strong>Submit Button Text</strong></td><td><input type="text" name="button_txt" id="button_txt" value="<?php if($button_txt){ echo esc_attr($button_txt);} else {echo "Submit";}?>"></td></tr>
			</table>
		</td>
		<td valign="top">
			<table width="80%">
				<tr><td valign="top"><strong>Header / Footer Background Color</strong></td><td valign="top"><input type="text" name="header_footer_bg_color" value="<?php echo esc_attr($header_footer_bg_color_new); ?>" class="wprb-color-picker"></td></tr>
				<tr><td valign="top"><strong>Text Color</strong></td><td valign="top"><input type="text" name="ride_text_color" value="<?php echo esc_attr($ride_text_color_new); ?>" class="wprb-color-picker"></td></tr>
				
				<tr><td valign="top"><strong>Submit Button Background Color</strong></td><td valign="top"><input type="text" name="submit_button_bg_color" value="<?php echo esc_attr($submit_button_bg_color_new); ?>"  class="wprb-color-picker"></td></tr>
				<tr><td valign="top"><strong>Button Background Hover Color</strong></td><td valign="top"><input type="text" name="button_bg_hover_color" id="button_txt" value="<?php echo esc_attr($ride_button_bg_hover_color); ?>" class="wprb-color-picker"></td></tr>
				<tr><td colspan="2" style="margin-top:15px; display:inline-block;"><input type="submit" name="setting_submit" value="Save Changes" class="button button-primary"></td></tr>
			</table>
		</td>
	</tr>
	</table></form>
	<?php 
}?>