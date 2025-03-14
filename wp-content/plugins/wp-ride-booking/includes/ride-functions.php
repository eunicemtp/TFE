<?php
/* get currency symboles */
function get_currency_symbol($cc = 'INR')
{
	$cc = strtoupper($cc);
	$currency = array(
	"USD" => "$" , //U.S. Dollar
	"GBP" => "£" , //Pound Sterling
	"AUD" => "$" , //Australian Dollar
	"CAD" => "C$" , //Canadian Dollar
	"EUR" => "€" , //Euro
	"INR" => "₹", //Indian Rupee
	);
	
	if(array_key_exists($cc, $currency)){
		return $currency[$cc];
	}
}

add_action("wp_ajax_ride_price","wprb_ride_calculation");
add_action("wp_ajax_nopriv_ride_price","wprb_ride_calculation");
function wprb_ride_calculation(){
 	$distance = (float) str_replace(",","",$_POST['distance']);
	$rate = get_option("per_km_rate");
	$total_rate = $distance * $rate;
    $currency = get_option('ride_currency');
	$currency_sym = get_currency_symbol($currency);
	$res_data = array("currency" => $currency_sym,"rate"=>$rate,"total_rate"=>round($total_rate,2));
	echo json_encode($res_data);
exit();
}


?>