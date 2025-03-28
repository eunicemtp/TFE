<?php

class Taxi_Booking_Customizer_Notify {

	private $config = array(); // Declare $config property
	
	private $taxi_booking_recommended_actions;
	
	private $recommended_plugins;
	
	private static $instance;
	
	private $taxi_booking_recommended_actions_title;
	
	private $taxi_booking_recommended_plugins_title;
	
	private $dismiss_button;
	
	private $taxi_booking_install_button_label;
	
	private $taxi_booking_activate_button_label;
	
	private $taxi_booking_deactivate_button_label;

	
	public static function init( $config ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Taxi_Booking_Customizer_Notify ) ) {
			self::$instance = new Taxi_Booking_Customizer_Notify;
			if ( ! empty( $config ) && is_array( $config ) ) {
				self::$instance->config = $config;
				self::$instance->setup_config();
				self::$instance->setup_actions();
			}
		}

	}

	
	public function setup_config() {

		global $taxi_booking_customizer_notify_recommended_plugins;
		global $taxi_booking_customizer_notify_taxi_booking_recommended_actions;

		global $taxi_booking_install_button_label;
		global $taxi_booking_activate_button_label;
		global $taxi_booking_deactivate_button_label;

		$this->taxi_booking_recommended_actions = isset( $this->config['taxi_booking_recommended_actions'] ) ? $this->config['taxi_booking_recommended_actions'] : array();
		$this->recommended_plugins = isset( $this->config['recommended_plugins'] ) ? $this->config['recommended_plugins'] : array();

		$this->taxi_booking_recommended_actions_title = isset( $this->config['taxi_booking_recommended_actions_title'] ) ? $this->config['taxi_booking_recommended_actions_title'] : '';
		$this->taxi_booking_recommended_plugins_title = isset( $this->config['taxi_booking_recommended_plugins_title'] ) ? $this->config['taxi_booking_recommended_plugins_title'] : '';
		$this->dismiss_button            = isset( $this->config['dismiss_button'] ) ? $this->config['dismiss_button'] : '';

		$taxi_booking_customizer_notify_recommended_plugins = array();
		$taxi_booking_customizer_notify_taxi_booking_recommended_actions = array();

		if ( isset( $this->recommended_plugins ) ) {
			$taxi_booking_customizer_notify_recommended_plugins = $this->recommended_plugins;
		}

		if ( isset( $this->taxi_booking_recommended_actions ) ) {
			$taxi_booking_customizer_notify_taxi_booking_recommended_actions = $this->taxi_booking_recommended_actions;
		}

		$taxi_booking_install_button_label    = isset( $this->config['taxi_booking_install_button_label'] ) ? $this->config['taxi_booking_install_button_label'] : '';
		$taxi_booking_activate_button_label   = isset( $this->config['taxi_booking_activate_button_label'] ) ? $this->config['taxi_booking_activate_button_label'] : '';
		$taxi_booking_deactivate_button_label = isset( $this->config['taxi_booking_deactivate_button_label'] ) ? $this->config['taxi_booking_deactivate_button_label'] : '';

	}

	
	public function setup_actions() {

		// Register the section
		add_action( 'customize_register', array( $this, 'taxi_booking_plugin_notification_customize_register' ) );

		// Enqueue scripts and styles
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'taxi_booking_customizer_notify_scripts_for_customizer' ), 0 );

		/* ajax callback for dismissable recommended actions */
		add_action( 'wp_ajax_quality_customizer_notify_dismiss_action', array( $this, 'taxi_booking_customizer_notify_dismiss_recommended_action_callback' ) );

		add_action( 'wp_ajax_ti_customizer_notify_dismiss_recommended_plugins', array( $this, 'taxi_booking_customizer_notify_dismiss_recommended_plugins_callback' ) );

	}

	
	public function taxi_booking_customizer_notify_scripts_for_customizer() {

		wp_enqueue_style( 'taxi-booking-customizer-notify-css', get_template_directory_uri() . '/core/includes/customizer-notice/css/taxi-booking-customizer-notify.css', array());

		wp_enqueue_style( 'plugin-install' );
		wp_enqueue_script( 'plugin-install' );
		wp_add_inline_script( 'plugin-install', 'var pagenow = "customizer";' );

		wp_enqueue_script( 'updates' );

		wp_enqueue_script( 'taxi-booking-customizer-notify-js', get_template_directory_uri() . '/core/includes/customizer-notice/js/taxi-booking-customizer-notify.js', array( 'customize-controls' ));
		wp_localize_script(
			'taxi-booking-customizer-notify-js', 'taxibookingCustomizercompanionObject', array(
				'ajaxurl'            => admin_url( 'admin-ajax.php' ),
				'template_directory' => get_template_directory_uri(),
				'base_path'          => admin_url(),
				'activating_string'  => __( 'Activating', 'taxi-booking' ),
			)
		);

	}

	
	public function taxi_booking_plugin_notification_customize_register( $wp_customize ) {

		
		require_once get_template_directory() . '/core/includes/customizer-notice/taxi-booking-customizer-notify-section.php';

		$wp_customize->register_section_type( 'Taxi_Booking_Customizer_Notify_Section' );

		$wp_customize->add_section(
			new Taxi_Booking_Customizer_Notify_Section(
				$wp_customize,
				'taxi-booking-customizer-notify-section',
				array(
					'title'          => $this->taxi_booking_recommended_actions_title,
					'plugin_text'    => $this->taxi_booking_recommended_plugins_title,
					'dismiss_button' => $this->dismiss_button,
					'priority'       => 0,
				)
			)
		);

	}

	
	public function taxi_booking_customizer_notify_dismiss_recommended_action_callback() {

		global $taxi_booking_customizer_notify_taxi_booking_recommended_actions;

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html( $action_id ); /* this is needed and it's the id of the dismissable required action */ 

		if ( ! empty( $action_id ) ) {
			
			if ( get_option( 'taxi_booking_customizer_notify_show' ) ) {

				$taxi_booking_customizer_notify_show_taxi_booking_recommended_actions = get_option( 'taxi_booking_customizer_notify_show' );
				switch ( $_GET['todo'] ) {
					case 'add':
						$taxi_booking_customizer_notify_show_taxi_booking_recommended_actions[ $action_id ] = true;
						break;
					case 'dismiss':
						$taxi_booking_customizer_notify_show_taxi_booking_recommended_actions[ $action_id ] = false;
						break;
				}
				update_option( 'taxi_booking_customizer_notify_show', $taxi_booking_customizer_notify_show_taxi_booking_recommended_actions );

				
			} else {
				$taxi_booking_customizer_notify_show_taxi_booking_recommended_actions = array();
				if ( ! empty( $taxi_booking_customizer_notify_taxi_booking_recommended_actions ) ) {
					foreach ( $taxi_booking_customizer_notify_taxi_booking_recommended_actions as $taxi_booking_lite_customizer_notify_recommended_action ) {
						if ( $taxi_booking_lite_customizer_notify_recommended_action['id'] == $action_id ) {
							$taxi_booking_customizer_notify_show_taxi_booking_recommended_actions[ $taxi_booking_lite_customizer_notify_recommended_action['id'] ] = false;
						} else {
							$taxi_booking_customizer_notify_show_taxi_booking_recommended_actions[ $taxi_booking_lite_customizer_notify_recommended_action['id'] ] = true;
						}
					}
					update_option( 'taxi_booking_customizer_notify_show', $taxi_booking_customizer_notify_show_taxi_booking_recommended_actions );
				}
			}
		}
		die(); 
	}

	
	public function taxi_booking_customizer_notify_dismiss_recommended_plugins_callback() {

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html( $action_id ); /* this is needed and it's the id of the dismissable required action */

		if ( ! empty( $action_id ) ) {

			$taxi_booking_lite_customizer_notify_show_recommended_plugins = get_option( 'taxi_booking_customizer_notify_show_recommended_plugins' );

			switch ( $_GET['todo'] ) {
				case 'add':
					$taxi_booking_lite_customizer_notify_show_recommended_plugins[ $action_id ] = false;
					break;
				case 'dismiss':
					$taxi_booking_lite_customizer_notify_show_recommended_plugins[ $action_id ] = true;
					break;
			}
			update_option( 'taxi_booking_customizer_notify_show_recommended_plugins', $taxi_booking_lite_customizer_notify_show_recommended_plugins );
		}
		die(); 
	}

}
