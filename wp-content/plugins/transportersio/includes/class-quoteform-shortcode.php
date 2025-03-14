<?php

	

	function transporters_quoteform_shortcode($atts){
		
		global $first_cookie;
		global $first_cookie_aff;
		
		$widget_id = $atts['id'];
		
		$widget_type = '_s_'.$widget_id;
		
		$fixed = false;
		$html = '';
        
		if(get_option('ts_fixed_route_'.$widget_id) == 1) $fixed = true;
		
		
		//include plugin_dir_path( __FILE__ ) . 'quoteform_scripts_front.php';

		
		require_once plugin_dir_path( __FILE__ ) . 'class-quoteform-common.php';
        $html .= transportersQuoteFormHTML($widget_id, $widget_type, $fixed);

		return $html;
	}

?>
