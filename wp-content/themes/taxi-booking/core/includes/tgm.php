<?php
	
require get_template_directory() . '/core/includes/class-tgm-plugin-activation.php';

/**
 * Recommended plugins.
 */
function taxi_booking_register_recommended_plugins() {
	$plugins = array(
		array(
			'name'             => __( 'Kirki Customizer Framework', 'taxi-booking' ),
			'slug'             => 'kirki',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'Google Language Translator', 'taxi-booking' ),
			'slug'             => 'google-language-translator',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'Mosaic Gallery Advanced Gallery', 'taxi-booking' ),
			'slug'             => 'mosaic-gallery-advanced-gallery',
			'required'         => false,
			'force_activation' => false,
		),
	);
	$config = array();
	taxi_booking_tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'taxi_booking_register_recommended_plugins' );