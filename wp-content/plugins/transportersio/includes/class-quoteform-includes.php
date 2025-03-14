<?php

function transporters_quoteform_styles(){
	//wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
	//wp_enqueue_style( 'jquery-ui' ); 
	//wp_enqueue_style( 'quoteform-style', plugin_dir_url( __FILE__ ) . '../css/quoteform_styles_front.css', false );
	wp_enqueue_style( 'quoteform-font-awesome', plugin_dir_url( __FILE__ ) . '../plugins/css/font-awesome.min.css', false, '1.1.1' );
	wp_enqueue_style( 'transporters-style', plugin_dir_url( __FILE__ ) . '../css/quoteform_style.css?v=1.7', false, '1.1.3' );
}

function transporters_quoteform_scripts(){

    wp_enqueue_script('jquery');
	wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . '../plugins/js/bootstrap-3.3.7.min.js', false, '1.1.1' , false );
	wp_enqueue_script( 'jquery-blockui', plugin_dir_url( __FILE__ ) . '../plugins/js/jquery.blockUI.js', false, '1.1.1', false  );
	wp_enqueue_script( 'jquery-validate', plugin_dir_url( __FILE__ ) . '../plugins/js/jquery.validate.min.js', false, '1.1.1', false );
	wp_enqueue_script( 'jquery-validate-methods', plugin_dir_url( __FILE__ ) . '../plugins/js/additional-methods.min.js', false, '1.1.1' , false );
	//wp_enqueue_script( 'bootstrap-datepicker', plugin_dir_url( __FILE__ ) . '../plugins/js/bootstrap-datepicker-1.9.0.min.js', false, '1.1.1' , false );
	wp_enqueue_script( 'transporters-datepicker', plugin_dir_url( __FILE__ ) . '../plugins/js/transporters-datepicker.min.js', false, '1.1.2' , false );
	//wp_enqueue_script( 'bootstrap-timepicker', plugin_dir_url( __FILE__ ) . '../plugins/js/bootstrap-timepicker.min.js', false, '1.1.1', false  );
	wp_enqueue_script( 'transporters-timepicker', plugin_dir_url( __FILE__ ) . '../plugins/js/transporters-timepicker.min.js', false, '1.1.2', false  );
	wp_enqueue_script( 'bootstrap-touchspin', plugin_dir_url( __FILE__ ) . '../plugins/js/jquery.bootstrap-touchspin.min.js', false, '1.1.1', false  );
	wp_enqueue_script( 'moment-trans', plugin_dir_url( __FILE__ ) . '../plugins/js/momentx.min.js', [], '1.1.2', false );
	wp_enqueue_script( 'moment-timezone', plugin_dir_url( __FILE__ ) . '../plugins/js/moment-timezone-with-data-2010-2020.min.js', [], '1.1.1', false );
	
	wp_enqueue_script( 'quoteform-fullscreencontrol-script', plugin_dir_url( __FILE__ ) . '../js/FullScreenControl.js', false, '1.1.1', false  );
	//[TODO - why do we have a broken link here?? ]
	wp_enqueue_script( 'ajax-script', plugin_dir_url( __FILE__ ) . '../plugins/js/my-ajax-script.js', array('jquery'), '1.1.1', false  );
    wp_localize_script( 'ajax-script', 'transporters_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    
    wp_enqueue_script( 'quoteform-script-front', plugin_dir_url( __FILE__ ) . '../js/quoteform_scripts_front.js?v=24', [], '1.1.3', false );
}

function transporters_quoteform_admin_scripts(){
    wp_enqueue_script( 'quoteform-script', plugin_dir_url( __FILE__ ) . '../js/quoteform_scripts.js', false, '1.1.3', false  );
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('wp-color-picker');
}

function transporters_quoteform_admin_styles(){
    wp_enqueue_style( 'quoteform-style', plugin_dir_url( __FILE__ ) . '../css/quoteform_style.css?v=1.7', false, '1.1.3', false  ); 
	wp_enqueue_style('transportersio-admin-ui-css',
                plugin_dir_url( __FILE__ ) . '../css/jquery-ui.css',
                false,
                '1.0',
                false);
	wp_enqueue_style( 'wp-color-picker' ); 			
}


function transporters_deregister_scripts(){
	//WCP OpenWeather - prevent double maps code
	//wp_deregister_script('rpw-gm');
	//wp_register_script('rpw-gm',  plugin_dir_url( __FILE__ ) . '../plugins/js/my-ajax-script.js', false );
	//wp_enqueue_script( 'rpw-gm');
	
	//Prevent double google maps code - universal
	global $wp_scripts; $gmapsenqueued = false;

    foreach ($wp_scripts->registered as $key => $script) {
    	if(!is_array($script->src)){
		    if (preg_match('#maps\.google(?:\w+)?\.com/maps/api/js#', $script->src)) {
		        wp_deregister_script($key);
				wp_register_script($key,  plugin_dir_url( __FILE__ ) . '../plugins/js/my-ajax-script.js', false, '1.1.1', false  );
				wp_enqueue_script( $key);
		    }
		    elseif (preg_match('#jquery\-1\.7#', $script->src)) {//Bootstrap requires jquery 1.9
		        wp_deregister_script($key);
				wp_register_script($key,   plugin_dir_url( __FILE__ ) . '../js/jquery1.9.min.js', false , '1.1.1', false);
				wp_enqueue_script( $key);
		    }
        }
    }
    wp_deregister_script('jquery-validate');
	wp_deregister_script('google-maps');
	wp_deregister_script('wpforms-validation');
	if(get_option('transporters_map_api_key')){
		wp_register_script('google-maps', 'https://maps.googleapis.com/maps/api/js?libraries=geometry,places&key='.get_option('transporters_map_api_key'), false , '1.1.1', false);
	}else{
		//wp_register_script('google-maps', 'https://maps.googleapis.com/maps/api/js?libraries=geometry,places', false );
	}
	wp_enqueue_script('google-maps');
}
function transporters_deregister_scripts_footer(){
    //wp_deregister_script('wpforms-validation-js');
    wp_deregister_script('wpforms-validation');
    wp_dequeue_script('wpforms-validation');
//    die();
}
?>
