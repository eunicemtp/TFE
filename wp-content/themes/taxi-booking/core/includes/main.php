<?php

/**
* Get started notice
*/

add_action( 'wp_ajax_taxi_booking_dismissed_notice_handler', 'taxi_booking_ajax_notice_handler' );

function taxi_booking_ajax_notice_handler() {
    if ( isset( $_POST['type'] ) ) {
        $type = sanitize_text_field( wp_unslash( $_POST['type'] ) );
        update_option( 'dismissed-' . $type, TRUE );
    }
}
function taxi_booking_deprecated_hook_admin_notice() {
        if ( ! get_option('dismissed-get_started', FALSE ) ) { ?>
            <?php
            require_once get_template_directory() .'/core/includes/demo-import.php';
            $current_screen = get_current_screen();
			if ( $current_screen->id !== 'appearance_page_taxi-booking-guide-page' && $current_screen->id != 'migy_image_gallery_page_migy_templates' ) {
			$taxi_booking_comments_theme = wp_get_theme(); ?>            
			<div class="taxi-booking-notice-wrapper updated notice notice-get-started-class is-dismissible" data-notice="get_started">
			<div class="taxi-booking-notice">
				<div class="taxi-booking-notice-img">
					<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/admin-logo.png'); ?>" alt="<?php esc_attr_e('logo', 'taxi-booking'); ?>">
				</div>
				<div class="taxi-booking-notice-content">
				<div class="taxi-booking-notice-heading"><?php esc_html_e('Thanks for installing ','taxi-booking'); ?><?php echo esc_html( $taxi_booking_comments_theme ); ?> <?php esc_html_e('Theme','taxi-booking'); ?></div>
				<p><?php echo esc_html('Get started with the wordpress theme installation','taxi-booking'); ?></p>
				<div class="diplay-flex-btn">
					<a class="button button-primary" href="<?php echo esc_url(admin_url('themes.php?page=taxi-booking-guide-page')); ?>"><?php echo esc_html('More Option','taxi-booking'); ?></a>
					<?php if(isset($_GET['import-demo']) && $_GET['import-demo'] == true){ ?>
			    		<a class="button button-success" href="<?php echo esc_url(home_url()); ?>" target="_blank"><?php echo esc_html('Go to Homepage','taxi-booking'); ?></a> <span class="imp-success"><?php echo esc_html('Imported Successfully','taxi-booking'); ?></span>
			    	<?php } else { ?>
					<form id="demo-importer-form" action="<?php echo esc_url(home_url()); ?>/wp-admin/themes.php" method="POST">
			        	<input  type="submit" name="submit" value="<?php esc_attr_e('Demo Import','taxi-booking'); ?>" class="button button-primary">
			    	</form>
			    	<?php } ?>
				</div>
			</div>
			</div>
		</div>
        <?php }
	}
}

add_action( 'admin_notices', 'taxi_booking_deprecated_hook_admin_notice' );

add_action( 'admin_menu', 'taxi_booking_getting_started' );
function taxi_booking_getting_started() {
	add_theme_page( esc_html__('Get Started', 'taxi-booking'), esc_html__('Get Started', 'taxi-booking'), 'edit_theme_options', 'taxi-booking-guide-page', 'taxi_booking_test_guide');
}

function taxi_booking_admin_enqueue_scripts() {
	wp_enqueue_style( 'taxi-booking-admin-style', esc_url( get_template_directory_uri() ).'/css/main.css' );
	wp_enqueue_script( 'taxi-booking-admin-script', get_template_directory_uri() . '/js/taxi-booking-admin-script.js', array( 'jquery' ), '', true );
    wp_localize_script( 'taxi-booking-admin-script', 'taxi_booking_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
    wp_enqueue_script( 'taxi-booking-demo-script', get_template_directory_uri() . '/js/demo-script.js', array( 'jquery' ), '', true );
}
add_action( 'admin_enqueue_scripts', 'taxi_booking_admin_enqueue_scripts' );

if ( ! defined( 'TAXI_BOOKING_DOCS_FREE' ) ) {
define('TAXI_BOOKING_DOCS_FREE',__('https://demo.misbahwp.com/docs/taxi-booking-free-docs/','taxi-booking'));
}
if ( ! defined( 'TAXI_BOOKING_DOCS_PRO' ) ) {
define('TAXI_BOOKING_DOCS_PRO',__('https://demo.misbahwp.com/docs/taxi-booking-pro-docs','taxi-booking'));
}
if ( ! defined( 'TAXI_BOOKING_BUY_NOW' ) ) {
define('TAXI_BOOKING_BUY_NOW',__('https://www.misbahwp.com/products/taxi-wordpress-theme/','taxi-booking'));
}
if ( ! defined( 'TAXI_BOOKING_SUPPORT_FREE' ) ) {
define('TAXI_BOOKING_SUPPORT_FREE',__('https://wordpress.org/support/theme/taxi-booking','taxi-booking'));
}
if ( ! defined( 'TAXI_BOOKING_REVIEW_FREE' ) ) {
define('TAXI_BOOKING_REVIEW_FREE',__('https://wordpress.org/support/theme/taxi-booking/reviews/#new-post','taxi-booking'));
}
if ( ! defined( 'TAXI_BOOKING_DEMO_PRO' ) ) {
define('TAXI_BOOKING_DEMO_PRO',__('https://demo.misbahwp.com/taxi-booking/','taxi-booking'));
}
if( ! defined( 'TAXI_BOOKING_THEME_BUNDLE' ) ) {
define('TAXI_BOOKING_THEME_BUNDLE',__('https://www.misbahwp.com/products/wordpress-bundle','taxi-booking'));
}

function taxi_booking_test_guide() { ?>
	<?php $taxi_booking_theme = wp_get_theme();
	require_once get_template_directory() .'/core/includes/demo-import.php';
	 ?>

	<div class="wrap" id="main-page">
		<div id="lefty">
			<div id="admin_links">
				<a href="<?php echo esc_url( TAXI_BOOKING_DOCS_FREE ); ?>" target="_blank" class="blue-button-1"><?php esc_html_e( 'Documentation', 'taxi-booking' ) ?></a>
				<a href="<?php echo esc_url( admin_url('customize.php') ); ?>" id="customizer" target="_blank"><?php esc_html_e( 'Customize', 'taxi-booking' ); ?> </a>
				<a class="blue-button-1" href="<?php echo esc_url( TAXI_BOOKING_SUPPORT_FREE ); ?>" target="_blank" class="btn3"><?php esc_html_e( 'Support', 'taxi-booking' ) ?></a>
				<a class="blue-button-2" href="<?php echo esc_url( TAXI_BOOKING_REVIEW_FREE ); ?>" target="_blank" class="btn4"><?php esc_html_e( 'Review', 'taxi-booking' ) ?></a>
			</div>
			<div id="description">
				<h3><?php esc_html_e('Welcome! Thank you for choosing ','taxi-booking'); ?><?php echo esc_html( $taxi_booking_theme ); ?>  <span><?php esc_html_e('Version: ', 'taxi-booking'); ?><?php echo esc_html($taxi_booking_theme['Version']);?></span></h3>
				<div class="demo-import-box">
					<h4><?php echo esc_html('Import homepage demo in just one click.','taxi-booking'); ?></h4>
					<p><?php echo esc_html('Get started with the wordpress theme installation','taxi-booking'); ?></p>
					<?php if(isset($_GET['import-demo']) && $_GET['import-demo'] == true){ ?>
			    		<span class="imp-success"><?php echo esc_html('Imported Successfully','taxi-booking'); ?></span>  <a class="button button-success" href="<?php echo esc_url(home_url()); ?>" target="_blank"><?php echo esc_html('Go to Homepage','taxi-booking'); ?></a>
			    	<?php } else { ?>
					<form id="demo-importer-form" action="<?php echo esc_url(home_url()); ?>/wp-admin/themes.php" method="POST">
			        	<input  type="submit" name="submit" value="<?php esc_attr_e('Demo Import','taxi-booking'); ?>" class="button button-primary">
			    	</form>
			    	<?php } ?>
				</div>
				<img class="img_responsive" style="width: 100%;" src="<?php echo esc_url( $taxi_booking_theme->get_screenshot() ); ?>" />
				<div id="description-insidee">
					<?php
						$taxi_booking_theme = wp_get_theme();
						echo wp_kses_post( apply_filters( 'misbah_theme_description', esc_html( $taxi_booking_theme->get( 'Description' ) ) ) );
					?>
				</div>
			</div>
		</div>

		<div id="righty">
			<div class="postboxx donate">
				<h3 class="hndle"><?php esc_html_e( 'Upgrade to Premium', 'taxi-booking' ); ?></h3>
				<div class="insidee">
					<p><?php esc_html_e('Discover upgraded pro features with premium version click to upgrade.','taxi-booking'); ?></p>
					<div id="admin_pro_links">
						<a class="blue-button-2" href="<?php echo esc_url( TAXI_BOOKING_BUY_NOW ); ?>" target="_blank"><?php esc_html_e( 'Go Pro', 'taxi-booking' ); ?></a>
						<a class="blue-button-1" href="<?php echo esc_url( TAXI_BOOKING_DEMO_PRO ); ?>" target="_blank"><?php esc_html_e( 'Live Demo', 'taxi-booking' ) ?></a>
						<a class="blue-button-2" href="<?php echo esc_url( TAXI_BOOKING_DOCS_PRO ); ?>" target="_blank"><?php esc_html_e( 'Pro Docs', 'taxi-booking' ) ?></a>
					</div>
				</div>
				<h3 class="hndle bundle"><?php esc_html_e( 'Go For Theme Bundle', 'taxi-booking' ); ?></h3>
				<div class="insidee theme-bundle">
					<p class="offer"><?php esc_html_e('Get 80+ Perfect WordPress Theme In A Single Package at just $89."','taxi-booking'); ?></p>
					<p class="coupon"><?php esc_html_e('Get Our Theme Pack of 80+ WordPress Themes At 15% Off','taxi-booking'); ?><span class="coupon-code"><?php esc_html_e('"Bundleup15"','taxi-booking'); ?></span></p>
					<div id="admin_pro_linkss">
						<a class="blue-button-1" href="<?php echo esc_url( TAXI_BOOKING_THEME_BUNDLE ); ?>" target="_blank"><?php esc_html_e( 'Theme Bundle', 'taxi-booking' ) ?></a>
					</div>
				</div>
				<div class="d-table">
			    <ul class="d-column">
			      <li class="feature"><?php esc_html_e('Features','taxi-booking'); ?></li>
			      <li class="free"><?php esc_html_e('Pro','taxi-booking'); ?></li>
			      <li class="plus"><?php esc_html_e('Free','taxi-booking'); ?></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('24hrs Priority Support','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('LearnPress Campatiblity','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Kirki Framework','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Advance Posttype','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('One Click Demo Import','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Section Reordering','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Enable / Disable Option','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Multiple Sections','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Advance Color Pallete','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Advance Widgets','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-yes"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Page Templates','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Advance Typography','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
			    <ul class="d-row">
			      <li class="points"><?php esc_html_e('Section Background Image / Color ','taxi-booking'); ?></li>
			      <li class="right"><span class="dashicons dashicons-yes"></span></li>
			      <li class="wrong"><span class="dashicons dashicons-no"></span></li>
			    </ul>
	  		</div>
			</div>
		</div>
	</div>

<?php } ?>
