<?php

if ( class_exists("Kirki")){

	// LOGO

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'taxi_booking_logo_resizer',
		'label'       => esc_html__( 'Adjust Your Logo Size ', 'taxi-booking' ),
		'section'     => 'title_tagline',
		'default'     => 70,
		'choices'     => [
			'min'  => 10,
			'max'  => 300,
			'step' => 10,
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_enable_logo_text',
		'section'     => 'title_tagline',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Site Title and Tagline', 'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_display_header_title',
		'label'       => esc_html__( 'Site Title Enable / Disable Button', 'taxi-booking' ),
		'section'     => 'title_tagline',
		'default'     => true,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_display_header_text',
		'label'       => esc_html__( 'Tagline Enable / Disable Button', 'taxi-booking' ),
		'section'     => 'title_tagline',
		'default'     => false,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );

	// FONT STYLE TYPOGRAPHY

	Kirki::add_panel( 'taxi_booking_panel_id', array(
	    'priority'    => 10,
	    'title'       => esc_html__( 'Typography', 'taxi-booking' ),
	) );

	Kirki::add_section( 'taxi_booking_font_style_section', array(
		'title'      => esc_html__( 'Typography Option',  'taxi-booking' ),
		'priority'   => 2,
		'capability' => 'edit_theme_options',
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_font_style_section',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. More Font Family Options </p><p>3. Color Pallete Setup </p><p>4. Section Reordering Facility</p><p>5. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_all_headings_typography',
		'section'     => 'taxi_booking_font_style_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Heading Of All Sections',  'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'global', array(
		'type'        => 'typography',
		'settings'    => 'taxi_booking_all_headings_typography',
		'label'       => esc_html__( 'Heading Typography',  'taxi-booking' ),
		'description' => esc_html__( 'Select the typography options for your heading.',  'taxi-booking' ),
		'section'     => 'taxi_booking_font_style_section',
		'priority'    => 10,
		'default'     => array(
			'font-family'    => '',
			'variant'        => '',
		),
		'output' => array(
			array(
				'element' => array( 'h1','h2','h3','h4','h5','h6', ),
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_body_content_typography',
		'section'     => 'taxi_booking_font_style_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Body Content',  'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'global', array(
		'type'        => 'typography',
		'settings'    => 'taxi_booking_body_content_typography',
		'label'       => esc_html__( 'Content Typography',  'taxi-booking' ),
		'description' => esc_html__( 'Select the typography options for your content.',  'taxi-booking' ),
		'section'     => 'taxi_booking_font_style_section',
		'priority'    => 10,
		'default'     => array(
			'font-family'    => '',
			'variant'        => '',
		),
		'output' => array(
			array(
				'element' => array( 'body', ),
			),
		),
	) );

		// PANEL
	Kirki::add_panel( 'taxi_booking_panel_id_5', array(
	    'priority'    => 10,
	    'title'       => esc_html__( 'Theme Animations', 'taxi-booking' ),
	) );

	// ANIMATION SECTION
	Kirki::add_section( 'taxi_booking_section_animation', array(
	    'title'          => esc_html__( 'Animations', 'taxi-booking' ),
	    'priority'       => 2,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_section_animation',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
	]);

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_animation_enabled',
		'label'       => esc_html__( 'Turn To Show Animation', 'taxi-booking' ),
		'section'     => 'taxi_booking_section_animation',
		'default'     => true,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );

	// PANEL
	Kirki::add_panel( 'taxi_booking_panel_id_2', array(
	    'priority'    => 10,
	    'title'       => esc_html__( 'Theme Dark Mode', 'taxi-booking' ),
	) );

	// DARK MODE SECTION
	Kirki::add_section( 'taxi_booking_section_dark_mode', array(
	    'title'          => esc_html__( 'Dark Mode', 'taxi-booking' ),
	    'priority'       => 3,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_section_dark_mode',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
	]);

	Kirki::add_field( 'theme_config_id', [
	    'type'        => 'custom',
	    'settings'    => 'taxi_booking_dark_colors',
	    'section'     => 'taxi_booking_section_dark_mode',
	    'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Dark Appearance', 'taxi-booking' ) . '</h3>',
	    'priority'    => 10,
	]);

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_is_dark_mode_enabled',
		'label'       => esc_html__( 'Turn To Dark Mode', 'taxi-booking' ),
		'section'     => 'taxi_booking_section_dark_mode',
		'default'     => false,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );


	// PANEL
	Kirki::add_panel( 'taxi_booking_panel_id_3', array(
	    'priority'    => 10,
	    'title'       => esc_html__( '404 Settings', 'taxi-booking' ),
	) );

	// 404 SECTION
	Kirki::add_section( 'taxi_booking_section_404', array(
	    'title'          => esc_html__( '404 Settings', 'taxi-booking' ),
	    'priority'       => 3,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_section_404',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
		'priority'    => 10,
	]);

	Kirki::add_field( 'theme_config_id', [
	    'type'        => 'custom',
	    'settings'    => 'taxi_booking_not_found_heading',
	    'section'     => 'taxi_booking_section_404',
	    'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Not Found Heading', 'taxi-booking' ) . '</h3>',
	    'priority'    => 10,
	]);

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'taxi_booking_404_page_title',
		'section'  => 'taxi_booking_section_404',
		'default'  => esc_html__('404 Not Found', 'taxi-booking'),
		'priority' => 10,
	] );

		Kirki::add_field( 'theme_config_id', [
	    'type'        => 'custom',
	    'settings'    => 'taxi_booking_not_found_text',
	    'section'     => 'taxi_booking_section_404',
	    'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Not Found Content', 'taxi-booking' ) . '</h3>',
	    'priority'    => 10,
	]);

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'taxi_booking_404_page_content',
		'section'  => 'taxi_booking_section_404',
		'default'  => esc_html__('Sorry, no posts matched your criteria.', 'taxi-booking'),
		'priority' => 10,
	] );

	// PANEL

	Kirki::add_panel( 'taxi_booking_panel_id', array(
	    'priority'    => 10,
	    'title'       => esc_html__( 'Theme Options', 'taxi-booking' ),
	) );

		Kirki::add_section( 'taxi_booking_section_color', array(
	    'title'          => esc_html__( 'Global Color', 'taxi-booking' ),
	    'panel'          => 'taxi_booking_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_section_color',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_global_colors',
		'section'     => 'taxi_booking_section_color',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Here you can change your theme color on one click.', 'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'color',
		'settings'    => 'taxi_booking_global_color',
		'label'       => __( 'choose your Appropriate Color', 'taxi-booking' ),
		'section'     => 'taxi_booking_section_color',
		'default'     => '#f9c32b',
	] );


	// Addtional Settings

	Kirki::add_section( 'taxi_booking_additional_settings', array(
	    'title'          => esc_html__( 'Additional Settings', 'taxi-booking' ),
	    'panel'          => 'taxi_booking_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_additional_settings',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'taxi_booking_scroll_enable_setting',
		'label'       => esc_html__( 'Here you can enable or disable your scroller.', 'taxi-booking' ),
		'section'     => 'taxi_booking_additional_settings',
		'default'     => '1',
		'priority'    => 10,
	] );

	new \Kirki\Field\Radio_Buttonset([
		'settings'    => 'taxi_booking_scroll_top_position',
		'label'       => esc_html__( 'Alignment for Scroll To Top', 'taxi-booking' ),
		'section'     => 'taxi_booking_additional_settings',
		'default'     => 'Right',
		'priority'    => 10,
		'choices'     => [
			'Left'   => esc_html__( 'Left', 'taxi-booking' ),
			'Center' => esc_html__( 'Center', 'taxi-booking' ),
			'Right'  => esc_html__( 'Right', 'taxi-booking' ),
		],
	]
	);

	new \Kirki\Field\Select(
	[
		'settings'    => 'menu_text_transform_taxi_booking',
		'label'       => esc_html__( 'Menus Text Transform', 'taxi-booking' ),
		'section'     => 'taxi_booking_additional_settings',
		'default'     => 'CAPITALISE',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'CAPITALISE' => esc_html__( 'CAPITALISE', 'taxi-booking' ),
			'UPPERCASE' => esc_html__( 'UPPERCASE', 'taxi-booking' ),
			'LOWERCASE' => esc_html__( 'LOWERCASE', 'taxi-booking' ),

		],
	]
	);

	new \Kirki\Field\Select(
	[
		'settings'    => 'taxi_booking_menu_zoom',
		'label'       => esc_html__( 'Menu Transition', 'taxi-booking' ),
		'section'     => 'taxi_booking_additional_settings',
		'default' => 'None',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'None' => __('None','taxi-booking'),
            'Zoominn' => __('Zoom Inn','taxi-booking'),
            
		],
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'taxi_booking_menu_zoom',
		'label'       => esc_html__( 'Menu Transition', 'taxi-booking' ),
		'section'     => 'taxi_booking_additional_settings',
		'default' => 'None',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'None' => __('None','taxi-booking'),
            'Zoominn' => __('Zoom Inn','taxi-booking'),
            
		],
	] );


	Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'taxi_booking_container_width',
		'label'       => esc_html__( 'Theme Container Width', 'taxi-booking' ),
		'section'     => 'taxi_booking_additional_settings',
		'default'     => 100,
		'choices'     => [
			'min'  => 50,
			'max'  => 100,
			'step' => 1,
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'taxi_booking_sticky_header',
		'label'       => esc_html__( 'Here you can enable or disable your Sticky Header.', 'taxi-booking' ),
		'section'     => 'taxi_booking_additional_settings',
		'default'     => false,
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'taxi_booking_site_loader',
		'label'       => esc_html__( 'Here you can enable or disable your Site Loader.', 'taxi-booking' ),
		'section'     => 'taxi_booking_additional_settings',
		'default'     => false,
		'priority'    => 10,
	] );

			new \Kirki\Field\Select(
	[
		'settings'    => 'taxi_booking_preloader_type',
		'label'       => esc_html__( 'Preloader Type', 'taxi-booking' ),
		'section'     => 'taxi_booking_additional_settings',
		'default' => 'four-way-loader',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'four-way-loader' => __('Type 1','taxi-booking'),
            'cube-loader' => __('Type 2','taxi-booking'),
		],
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'taxi_booking_page_layout',
		'label'       => esc_html__( 'Page Layout Setting', 'taxi-booking' ),
		'section'     => 'taxi_booking_additional_settings',
		'default' => 'Right Sidebar',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'Left Sidebar' => __('Left Sidebar','taxi-booking'),
            'Right Sidebar' => __('Right Sidebar','taxi-booking'),
            'One Column' => __('One Column','taxi-booking')
		],
	] );

	if ( class_exists("woocommerce")){

	// Woocommerce Settings

	Kirki::add_section( 'taxi_booking_woocommerce_settings', array(
			'title'          => esc_html__( 'Woocommerce Settings', 'taxi-booking' ),
			'panel'          => 'taxi_booking_panel_id',
			'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_woocommerce_settings',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'taxi_booking_shop_sidebar',
		'label'       => esc_html__( 'Here you can enable or disable shop page sidebar.', 'taxi-booking' ),
		'section'     => 'taxi_booking_woocommerce_settings',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'taxi_booking_product_sidebar',
		'label'       => esc_html__( 'Here you can enable or disable product page sidebar.', 'taxi-booking' ),
		'section'     => 'taxi_booking_woocommerce_settings',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'taxi_booking_related_product_setting',
		'label'       => esc_html__( 'Here you can enable or disable your related products.', 'taxi-booking' ),
		'section'     => 'taxi_booking_woocommerce_settings',
		'default'     => true,
		'priority'    => 10,
	] );

	new \Kirki\Field\Number(
	[
		'settings' => 'taxi_booking_per_columns',
		'label'    => esc_html__( 'Product Per Row', 'taxi-booking' ),
		'section'  => 'taxi_booking_woocommerce_settings',
		'default'  => 3,
		'choices'  => [
			'min'  => 1,
			'max'  => 4,
			'step' => 1,
		],
	]
	);

	new \Kirki\Field\Number(
	[
		'settings' => 'taxi_booking_product_per_page',
		'label'    => esc_html__( 'Product Per Page', 'taxi-booking' ),
		'section'  => 'taxi_booking_woocommerce_settings',
		'default'  => 9,
		'choices'  => [
			'min'  => 1,
			'max'  => 15,
			'step' => 1,
		],
	]
	);

	new \Kirki\Field\Number(
	[
		'settings' => 'custom_related_products_number_per_row',
		'label'    => esc_html__( 'Related Product Per Column', 'taxi-booking' ),
		'section'  => 'taxi_booking_woocommerce_settings',
		'default'  => 3,
		'choices'  => [
			'min'  => 1,
			'max'  => 4,
			'step' => 1,
		],
	]
	);

	new \Kirki\Field\Number(
	[
		'settings' => 'custom_related_products_number',
		'label'    => esc_html__( 'Related Product Per Page', 'taxi-booking' ),
		'section'  => 'taxi_booking_woocommerce_settings',
		'default'  => 3,
		'choices'  => [
			'min'  => 1,
			'max'  => 10,
			'step' => 1,
		],
	]
	);

	new \Kirki\Field\Select(
	[
		'settings'    => 'taxi_booking_shop_page_layout',
		'label'       => esc_html__( 'Shop Page Layout Setting', 'taxi-booking' ),
		'section'     => 'taxi_booking_woocommerce_settings',
		'default' => 'Right Sidebar',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'Left Sidebar' => __('Left Sidebar','taxi-booking'),
            'Right Sidebar' => __('Right Sidebar','taxi-booking')
		],
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'taxi_booking_product_page_layout',
		'label'       => esc_html__( 'Product Page Layout Setting', 'taxi-booking' ),
		'section'     => 'taxi_booking_woocommerce_settings',
		'default' => 'Right Sidebar',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'Left Sidebar' => __('Left Sidebar','taxi-booking'),
            'Right Sidebar' => __('Right Sidebar','taxi-booking')
		],
	] );

		new \Kirki\Field\Radio_Buttonset(
	[
		'settings'    => 'taxi_booking_woocommerce_pagination_position',
		'label'       => esc_html__( 'Woocommerce Pagination Alignment', 'taxi-booking' ),
		'section'     => 'taxi_booking_woocommerce_settings',
		'default'     => 'Center',
		'priority'    => 10,
		'choices'     => [
			'Left'   => esc_html__( 'Left', 'taxi-booking' ),
			'Center' => esc_html__( 'Center', 'taxi-booking' ),
			'Right'  => esc_html__( 'Right', 'taxi-booking' ),
		],
	]
	);

}

	// POST SECTION

	Kirki::add_section( 'taxi_booking_section_post', array(
	    'title'          => esc_html__( 'Post Settings', 'taxi-booking' ),
	    'panel'          => 'taxi_booking_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_section_post',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_enable_post_heading',
		'section'     => 'taxi_booking_section_post',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Post Settings.', 'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_blog_admin_enable',
		'label'       => esc_html__( 'Post Author Enable / Disable Button', 'taxi-booking' ),
		'section'     => 'taxi_booking_section_post',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_blog_comment_enable',
		'label'       => esc_html__( 'Post Comment Enable / Disable Button', 'taxi-booking' ),
		'section'     => 'taxi_booking_section_post',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'taxi_booking_post_excerpt_number',
		'label'       => esc_html__( 'Post Content Range', 'taxi-booking' ),
		'section'     => 'taxi_booking_section_post',
		'default'     => 15,
		'choices'     => [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'taxi_booking_pagination_setting',
		'label'       => esc_html__( 'Here you can enable or disable your Pagination.', 'taxi-booking' ),
		'section'     => 'taxi_booking_section_post',
		'default'     => true,
		'priority'    => 10,
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'taxi_booking_archive_sidebar_layout',
		'label'       => esc_html__( 'Archive Post Sidebar Layout Setting', 'taxi-booking' ),
		'section'     => 'taxi_booking_section_post',
		'default' => 'Right Sidebar',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'Left Sidebar' => __('Left Sidebar','taxi-booking'),
            'Right Sidebar' => __('Right Sidebar','taxi-booking'),
            'Three Column' => __('Three Column','taxi-booking'),
            'Four Column' => __('Four Column','taxi-booking'),
            'Grid Layout Without Sidebar' => __('Grid Layout Without Sidebar','taxi-booking'),
            'Grid Layout With Right Sidebar' => __('Grid Layout With Right Sidebar','taxi-booking'),
            'Grid Layout With Left Sidebar' => __('Grid Layout With Left Sidebar','taxi-booking')
		],
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'taxi_booking_single_post_sidebar_layout',
		'label'       => esc_html__( 'Single Post Sidebar Layout Setting', 'taxi-booking' ),
		'section'     => 'taxi_booking_section_post',
		'default' => 'Right Sidebar',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'Left Sidebar' => __('Left Sidebar','taxi-booking'),
            'Right Sidebar' => __('Right Sidebar','taxi-booking'),
		],
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'taxi_booking_search_sidebar_layout',
		'label'       => esc_html__( 'Search Page Sidebar Layout Setting', 'taxi-booking' ),
		'section'     => 'taxi_booking_section_post',
		'default' => 'Right Sidebar',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'Left Sidebar' => __('Left Sidebar','taxi-booking'),
            'Right Sidebar' => __('Right Sidebar','taxi-booking'),
            'Three Column' => __('Three Column','taxi-booking'),
            'Four Column' => __('Four Column','taxi-booking'),
            'Grid Layout Without Sidebar' => __('Grid Layout Without Sidebar','taxi-booking'),
            'Grid Layout With Right Sidebar' => __('Grid Layout With Right Sidebar','taxi-booking'),
            'Grid Layout With Left Sidebar' => __('Grid Layout With Left Sidebar','taxi-booking')
		],
	] );

	// Breadcrumb
	Kirki::add_section( 'taxi_booking_bradcrumb', array(
	    'title'          => esc_html__( 'Breadcrumb Settings', 'taxi-booking' ),
	    'panel'          => 'taxi_booking_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_bradcrumb',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_enable_breadcrumb_heading',
		'section'     => 'taxi_booking_bradcrumb',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Single Page Breadcrumb', 'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_breadcrumb_enable',
		'label'       => esc_html__( 'Breadcrumb Enable / Disable', 'taxi-booking' ),
		'section'     => 'taxi_booking_bradcrumb',
		'default'     => true,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
        'type'     => 'text',
        'default'     => '/',
        'settings' => 'taxi_booking_breadcrumb_separator' ,
        'label'    => esc_html__( 'Breadcrumb Separator',  'taxi-booking' ),
        'section'  => 'taxi_booking_bradcrumb',
    ] );

	// HEADER SECTION

	Kirki::add_section( 'taxi_booking_section_header', array(
	    'title'          => esc_html__( 'Header Settings', 'taxi-booking' ),
	    'panel'          => 'taxi_booking_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_section_header',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_enable_hire_us',
		'section'     => 'taxi_booking_section_header',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Hire Us Button', 'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'label'       => esc_html__( 'Button Text', 'taxi-booking' ),
		'settings' => 'taxi_booking_header_hire_us_txt',
		'section'  => 'taxi_booking_section_header',
		'default'  => '',
		'priority' => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'link',
		'label'       => esc_html__( 'Button Link', 'taxi-booking' ),
		'settings' => 'taxi_booking_header_hire_us_lnk',
		'section'  => 'taxi_booking_section_header',
		'default'  => '',
		'priority' => 10,
	] );


	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_enable_extra_link',
		'section'     => 'taxi_booking_section_header',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Top Header Links', 'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'repeater',
		'section'     => 'taxi_booking_section_header',
		'priority'    => 11,
		'row_label' => [
			'type'  => 'field',
			'value' => esc_html__( 'Text', 'taxi-booking' ),
			'field' => 'link_text',
		],
		'button_label' => esc_html__('Add New Link Text', 'taxi-booking' ),
		'settings'     => 'taxi_booking_extra_links_settings',
		'default'      => '',
		'fields' 	   => [
			'link_text' => [
				'type'        => 'text',
				'label'       => esc_html__( 'Text', 'taxi-booking' ),
				'description' => esc_html__( 'Add the text ex: "Enquiry".', 'taxi-booking' ),
				'default'     => '',
			],
			'link_url' => [
				'type'        => 'url',
				'label'       => esc_html__( 'URL', 'taxi-booking' ),
				'description' => esc_html__( 'Add the url here ex: "www.example.com".', 'taxi-booking' ),
				'default'     => '',
			],
		],
		'choices' => [
			'limit' => 5
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_enable_socail_link',
		'section'     => 'taxi_booking_section_header',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Social Media Link', 'taxi-booking' ) . '</h3>',
		'priority'    => 12,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'repeater',
		'section'     => 'taxi_booking_section_header',
		'priority'    => 13,
		'row_label' => [
			'type'  => 'field',
			'value' => esc_html__( 'Social Icon', 'taxi-booking' ),
			'field' => 'link_text',
		],
		'button_label' => esc_html__('Add New Social Icon', 'taxi-booking' ),
		'settings'     => 'taxi_booking_social_links_settings',
		'default'      => '',
		'fields' 	   => [
			'link_text' => [
				'type'        => 'text',
				'label'       => esc_html__( 'Icon', 'taxi-booking' ),
				'description' => esc_html__( 'Add the fontawesome class ex: "fab fa-facebook-f".', 'taxi-booking' ),
				'default'     => '',
			],
			'link_url' => [
				'type'        => 'url',
				'label'       => esc_html__( 'Social Link', 'taxi-booking' ),
				'description' => esc_html__( 'Add the social icon url here.', 'taxi-booking' ),
				'default'     => '',
			],
		],
		'choices' => [
			'limit' => 5
		],
	] );

	// SLIDER SECTION

	Kirki::add_section( 'taxi_booking_blog_slide_section', array(
        'title'          => esc_html__( 'Slider Settings', 'taxi-booking' ),
        'panel'          => 'taxi_booking_panel_id',
        'priority'       => 160,
    ) );

    Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_blog_slide_section',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_enable_heading',
		'section'     => 'taxi_booking_blog_slide_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Slider', 'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_blog_box_enable',
		'label'       => esc_html__( 'Section Enable / Disable', 'taxi-booking' ),
		'section'     => 'taxi_booking_blog_slide_section',
		'default'     => false,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_title_unable_disable',
		'label'       => esc_html__( 'Slide Title Enable / Disable', 'taxi-booking' ),
		'section'     => 'taxi_booking_blog_slide_section',
		'default'     => true,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_button_unable_disable',
		'label'       => esc_html__( 'Slide Button Enable / Disable', 'taxi-booking' ),
		'section'     => 'taxi_booking_blog_slide_section',
		'default'     => true,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_number_unable_disable',
		'label'       => esc_html__( 'Slide Number Enable / Disable', 'taxi-booking' ),
		'section'     => 'taxi_booking_blog_slide_section',
		'default'     => true,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );


    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_slider_heading',
		'section'     => 'taxi_booking_blog_slide_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Slider', 'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'number',
		'settings'    => 'taxi_booking_blog_slide_number',
		'label'       => esc_html__( 'Number of slides to show', 'taxi-booking' ),
		'section'     => 'taxi_booking_blog_slide_section',
		'default'     => 0,
		'choices'     => [
			'min'  => 1,
			'max'  => 5,
			'step' => 1,
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'select',
		'settings'    => 'taxi_booking_blog_slide_category',
		'label'       => esc_html__( 'Select the category to show slider ( Image Dimension 1600 x 600 )', 'taxi-booking' ),
		'section'     => 'taxi_booking_blog_slide_section',
		'default'     => '',
		'placeholder' => esc_html__( 'Select an category...', 'taxi-booking' ),
		'priority'    => 10,
		'choices'     => taxi_booking_get_categories_select(),
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'label'    => esc_html__( 'Toll Free Number', 'taxi-booking' ),
		'settings' => 'taxi_booking_slider_extra_text',
		'section'  => 'taxi_booking_blog_slide_section',
		'default'  => '',
		'priority' => 10,
		'sanitize_callback' => 'taxi_booking_sanitize_phone_number',
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'taxi_booking_slider_content_alignment',
		'label'       => esc_html__( 'Slider Content Alignment', 'taxi-booking' ),
		'section'     => 'taxi_booking_blog_slide_section',
		'default'     => 'CENTER-ALIGN',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'LEFT-ALIGN' => esc_html__( 'LEFT-ALIGN', 'taxi-booking' ),
			'CENTER-ALIGN' => esc_html__( 'CENTER-ALIGN', 'taxi-booking' ),
			'RIGHT-ALIGN' => esc_html__( 'RIGHT-ALIGN', 'taxi-booking' ),

		],
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'taxi_booking_slider_opacity_color',
		'label'       => esc_html__( 'Slider Opacity Option', 'taxi-booking' ),
		'section'     => 'taxi_booking_blog_slide_section',
		'default'     => '0.5',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'0' => esc_html__( '0', 'taxi-booking' ),
			'0.1' => esc_html__( '0.1', 'taxi-booking' ),
			'0.2' => esc_html__( '0.2', 'taxi-booking' ),
			'0.3' => esc_html__( '0.3', 'taxi-booking' ),
			'0.4' => esc_html__( '0.4', 'taxi-booking' ),
			'0.5' => esc_html__( '0.5', 'taxi-booking' ),
			'0.6' => esc_html__( '0.6', 'taxi-booking' ),
			'0.7' => esc_html__( '0.7', 'taxi-booking' ),
			'0.8' => esc_html__( '0.8', 'taxi-booking' ),
			'0.9' => esc_html__( '0.9', 'taxi-booking' ),
			'unset' => esc_html__( 'unset', 'taxi-booking' ),
			

		],
	] );

	 Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_overlay_option',
		'label'       => esc_html__( 'Enable / Disable Slider Overlay', 'taxi-booking' ),
		'section'     => 'taxi_booking_blog_slide_section',
		'default'     => false,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );

	 Kirki::add_field( 'theme_config_id', [
		'type'        => 'color',
		'settings'    => 'taxi_booking_slider_image_overlay_color',
		'label'       => __( 'choose your Appropriate Overlay Color', 'taxi-booking' ),
		'section'     => 'taxi_booking_blog_slide_section',
		'default'     => '',
	] );

	// VEHICLE BOOKING SECTION

	Kirki::add_section( 'taxi_booking_vehicle_booking_section', array(
	    'title'          => esc_html__( 'Vehicle Booking Settings', 'taxi-booking' ),
	    'panel'          => 'taxi_booking_panel_id',
	    'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_vehicle_booking_section',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
	    'priority'    => 1,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_enable_heading',
		'section'     => 'taxi_booking_vehicle_booking_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Vehicle Booking',  'taxi-booking' ) . '</h3>',
		'priority'    => 1,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_vehicle_booking_section_enable',
		'label'       => esc_html__( 'Section Enable / Disable', 'taxi-booking' ),
		'section'     => 'taxi_booking_vehicle_booking_section',
		'default'     => false,
		'priority'    => 2,
		'choices'     => [
			'on'  => esc_html__( 'Enable',  'taxi-booking' ),
			'off' => esc_html__( 'Disable',  'taxi-booking' ),
		],
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_vehicle_booking_text_heading',
		'section'     => 'taxi_booking_vehicle_booking_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Vehicle Booking', 'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'label'       => esc_html__( 'Text', 'taxi-booking' ),
		'settings' => 'taxi_booking_vehicle_booking_heading_text',
		'section'  => 'taxi_booking_vehicle_booking_section',
		'default'  => '',
		'priority' => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'label'       => esc_html__( 'Heading', 'taxi-booking' ),
		'settings' => 'taxi_booking_vehicle_booking_heading',
		'section'  => 'taxi_booking_vehicle_booking_section',
		'default'  => '',
		'priority' => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'number',
		'settings'    => 'taxi_booking_vehicle_booking_number',
		'label'       => esc_html__( 'Number of Tabs to show', 'taxi-booking' ),
		'section'     => 'taxi_booking_vehicle_booking_section',
		'default'     => '',
		'choices'     => [
			'min'  => 0,
			'max'  => 80,
			'step' => 1,
		],
	] );

	$taxi_booking_featured_post = get_theme_mod('taxi_booking_vehicle_booking_number','');
    	for ( $j = 1; $j <= $taxi_booking_featured_post; $j++ ) :

    	Kirki::add_field( 'theme_config_id', [
	        'type'        => 'text',
	        'settings'    => 'taxi_booking_vehicle_booking_text' .$j,
	        'label'       => esc_html__( 'Tab Icon ', 'taxi-booking' ).$j,
	        'description' => esc_html__( 'Add fontawesome icon class ex: fas fa-car', 'taxi-booking' ),
	        'section'     => 'taxi_booking_vehicle_booking_section',
	        'default'     => '',
	    ] );

		Kirki::add_field( 'theme_config_id', [
			'type'        => 'select',
			'settings'    => 'taxi_booking_vehicle_booking_category'.$j,
			'label'       => esc_html__( 'Select the category to show vehicle booking ', 'taxi-booking' ).$j,
			'section'     => 'taxi_booking_vehicle_booking_section',
			'default'     => '',
			'placeholder' => esc_html__( 'Select an category...', 'taxi-booking' ),
			'priority'    => 10,
			'choices'     => taxi_booking_get_categories_select(),
		] );

	endfor;

	// FOOTER SECTION

	Kirki::add_section( 'taxi_booking_footer_section', array(
        'title'          => esc_html__( 'Footer Settings', 'taxi-booking' ),
        'panel'          => 'taxi_booking_panel_id',
        'priority'       => 160,
    ) );

    Kirki::add_field( 'theme_config_id', [
	    'label'       => '<span class="custom-label-class">' . esc_html__( 'INFORMATION ABOUT PREMIUM VERSION :-', 'taxi-booking' ) . '</span>',
	    'default'     => '<a class="premium_info_btn" target="_blank" href="' . esc_url( TAXI_BOOKING_BUY_NOW ) . '">' . __( 'GO TO PREMIUM', 'taxi-booking' ) . '</a>',
	    'type'        => 'custom',
	    'section'     => 'taxi_booking_footer_section',
	    'description' => '<div class="custom-description-class">' . __( '<p>1. One Click Demo Importer </p><p>2. Color Pallete Setup </p><p>3. Section Reordering Facility</p><p>4. For More Options kindly Go For Premium Version.</p>', 'taxi-booking' ) . '</div>',
	    'priority'    => 1,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_footer_enable_heading',
		'section'     => 'taxi_booking_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Footer Link', 'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'taxi_booking_copyright_enable',
		'label'       => esc_html__( 'Section Enable / Disable', 'taxi-booking' ),
		'section'     => 'taxi_booking_footer_section',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'taxi-booking' ),
			'off' => esc_html__( 'Disable', 'taxi-booking' ),
		],
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_footer_text_heading',
		'section'     => 'taxi_booking_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Footer Copyright Text', 'taxi-booking' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'taxi_booking_footer_text',
		'section'  => 'taxi_booking_footer_section',
		'default'  => '',
		'priority' => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
	'type'        => 'custom',
	'settings'    => 'taxi_booking_footer_text_heading_2',
	'section'     => 'taxi_booking_footer_section',
	'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Footer Copyright Alignment', 'taxi-booking' ) . '</h3>',
	'priority'    => 10,
	] );

	new \Kirki\Field\Select(
	[
		'settings'    => 'taxi_booking_copyright_text_alignment',
		'label'       => esc_html__( 'Copyright text Alignment', 'taxi-booking' ),
		'section'     => 'taxi_booking_footer_section',
		'default'     => 'LEFT-ALIGN',
		'placeholder' => esc_html__( 'Choose an option', 'taxi-booking' ),
		'choices'     => [
			'LEFT-ALIGN' => esc_html__( 'LEFT-ALIGN', 'taxi-booking' ),
			'CENTER-ALIGN' => esc_html__( 'CENTER-ALIGN', 'taxi-booking' ),
			'RIGHT-ALIGN' => esc_html__( 'RIGHT-ALIGN', 'taxi-booking' ),

		],
	] );

	Kirki::add_field( 'theme_config_id', [
	'type'        => 'custom',
	'settings'    => 'taxi_booking_footer_text_heading_1',
	'section'     => 'taxi_booking_footer_section',
	'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Footer Copyright Background Color', 'taxi-booking' ) . '</h3>',
	'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'color',
		'settings'    => 'taxi_booking_copyright_bg',
		'label'       => __( 'Choose Your Copyright Background Color', 'taxi-booking' ),
		'section'     => 'taxi_booking_footer_section',
		'default'     => '',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'taxi_booking_enable_footer_socail_link',
		'section'     => 'taxi_booking_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Social Media Link', 'taxi-booking' ) . '</h3>',
		'priority'    => 11,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'repeater',
		'section'     => 'taxi_booking_footer_section',
		'priority'    => 11,
		'row_label' => [
			'type'  => 'field',
			'value' => esc_html__( 'Footer Social Icon', 'taxi-booking' ),
			'field' => 'link_text',
		],
		'button_label' => esc_html__('Add New Social Icon', 'taxi-booking' ),
		'settings'     => 'taxi_booking_footer_social_links_settings',
		'default'      => '',
		'fields' 	   => [
			'link_text' => [
				'type'        => 'text',
				'label'       => esc_html__( 'Icon', 'taxi-booking' ),
				'description' => esc_html__( 'Add the fontawesome class ex: "fab fa-facebook-f".', 'taxi-booking' ),
				'default'     => '',
			],
			'link_url' => [
				'type'        => 'url',
				'label'       => esc_html__( 'Social Link', 'taxi-booking' ),
				'description' => esc_html__( 'Add the social icon url here.', 'taxi-booking' ),
				'default'     => '',
			],
		],
		'choices' => [
			'limit' => 5
		],
	] );
}

/*
 *  Customizer Notifications
 */

$taxi_booking_config_customizer = array(
    'recommended_plugins' => array( 
        'kirki' => array(
            'recommended' => true,
            'description' => sprintf( 
                /* translators: %s: plugin name */
                esc_html__( 'If you want to show all the sections of the FrontPage, please install and activate %s plugin', 'taxi-booking' ), 
                '<strong>' . esc_html__( 'Kirki Customizer', 'taxi-booking' ) . '</strong>'
            ),
        ),
    ),
    'taxi_booking_recommended_actions'       => array(),
    'taxi_booking_recommended_actions_title' => esc_html__( 'Recommended Actions', 'taxi-booking' ),
    'taxi_booking_recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'taxi-booking' ),
    'taxi_booking_install_button_label'      => esc_html__( 'Install and Activate', 'taxi-booking' ),
    'taxi_booking_activate_button_label'     => esc_html__( 'Activate', 'taxi-booking' ),
    'taxi_booking_deactivate_button_label'   => esc_html__( 'Deactivate', 'taxi-booking' ),
);

Taxi_Booking_Customizer_Notify::init( apply_filters( 'taxi_booking_customizer_notify_array', $taxi_booking_config_customizer ) );