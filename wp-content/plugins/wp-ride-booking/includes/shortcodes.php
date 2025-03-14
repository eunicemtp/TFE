<?php
function wprb_ride_booking_shortcode() {
    $button_txt = sanitize_text_field(get_option('calculate_button_txt'));
    $map_height = esc_attr(get_option('ride_map_height'));
    $header_footer_bg_color = esc_attr(get_option('ride_header_footer_bg_color'));
    $ride_text_color = esc_attr(get_option('ride_text_color'));
    $submit_button_bg_color = esc_attr(get_option('ride_submit_button_bg_color'));
    $button_bg_hover_color = esc_attr(get_option('ride_button_bg_hover_color'));
    $paypal_id = sanitize_email(get_option('paypal_email'));
    $currency_sel = esc_attr(get_option('ride_currency'));
    $ride_paypal_mode = esc_attr(get_option('ride_paypal_mode'));
    
    if($ride_paypal_mode=="Sandbox"){
        $ride_action = "https://sandbox.paypal.com/cgi-bin/webscr";
    }

    if($ride_paypal_mode=="Live"){
        $ride_action = "https://www.paypal.com/cgi-bin/webscr";
    }
    
    
    return '<table border="0" cellpadding="0" cellspacing="3" width="100%" class="wpride-wrapper">
        <tr>
            <td colspan="12">
            <form class="ride-input-form">
                <div class="txtbox">
                    <span>Source:</span>
                    <input type="text" id="txtSource" name="txtSource" value="" placeholder="Source location"/>
                </div>
                <div class="txtbox">
                    <span>Destination:</span>
                    <input type="text" id="txtDestination" name="txtDestination" value="" placeholder="Destination location"/>
                </div>
                <input type="button" class="button" value="'.$button_txt.'" onclick="GetRoute()"/>
            </form>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <div id="dvDistance"></div>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <div id="dvMap">
                </div>
            </td>
        </tr>
        <tr class="ride_cal" id="ride_col" style="display:none" width="100%">
            <td colspan="4">Per km rate : <span id="rate_per_km"></span></td>
            <td colspan="4">Distance : <span  id="distance"></span></td>
            <td colspan="4">Total Rate : <span  id="total_price"> </span></td> 
        </tr>
        
        <tr><td id="paypal_form" colspan="12" style="display:none;">
        <form action="'. $ride_action .'" method="post">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" id="paypal_id" name="business" value="'.$paypal_id.'">
            <input type="hidden" name="item_name" value="Ride Booking">
            <input type="hidden" name="item_number" value="1">
            <input type="hidden" id="item_amount" name="amount" value="">
            <input type="hidden" name="no_shipping" value="0">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="currency_code" value="'.$currency_sel.'">
            <input type="hidden" name="lc" value="AU">
            <input type="hidden" name="bn" value="PP-BuyNowBF">
            <input type="image" id="pay_button" src="https://www.paypal.com/en_AU/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
            <img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
        </form>
        </td></tr>
</table><style>.ride-input-form, .ride_cal {background:'.$header_footer_bg_color.'; color:'.$ride_text_color.';}.ride-input-form .txtbox span{color:'.$ride_text_color.';}.ride-input-form .button{background:'.$submit_button_bg_color.'; color:'.$ride_text_color.';}.ride-input-form .button:hover{background:'.$button_bg_hover_color.';}.map_area { height:'.$map_height.'px;}</style>';
}
 
function wp_ride_booking_register_shortcode() {
    add_shortcode( 'wp-ride-booking', 'wprb_ride_booking_shortcode' );
} 
add_action( 'init', 'wp_ride_booking_register_shortcode' );
?>