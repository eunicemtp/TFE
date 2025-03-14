<?php

/*-----------------------------------------------------------------------------------*/
/* Enqueue script and styles */
/*-----------------------------------------------------------------------------------*/

function taxi_booking_enqueue_google_fonts() {

	require_once get_theme_file_path( 'core/includes/wptt-webfont-loader.php' );

	wp_enqueue_style( 'google-fonts-outfit', 'https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap' );

	wp_enqueue_style( 'google-fonts-pacifico', 'https://fonts.googleapis.com/css2?family=Pacifico&display=swap' );
}
add_action( 'wp_enqueue_scripts', 'taxi_booking_enqueue_google_fonts' );

if (!function_exists('taxi_booking_enqueue_scripts')) {

	function taxi_booking_enqueue_scripts() {

		wp_enqueue_style(
			'bootstrap-css',
			get_template_directory_uri() . '/css/bootstrap.css',
			array(),'4.5.0'
		);

		wp_enqueue_style(
			'fontawesome-css',
			get_template_directory_uri() . '/css/fontawesome-all.css',
			array(),'4.5.0'
		);

		wp_enqueue_style(
			'owl-carousel-css',
			get_template_directory_uri() . '/css/owl.carousel.css',
			array(),'2.3.4'
		);

		wp_enqueue_style('taxi-booking-style', get_stylesheet_uri(), array() );

		wp_style_add_data('taxi-booking-style', 'rtl', 'replace');

		wp_enqueue_style(
			'taxi-booking-media-css',
			get_template_directory_uri() . '/css/media.css',
			array(),'2.3.4'
		);

		wp_enqueue_style(
			'taxi-booking-woocommerce-css',
			get_template_directory_uri() . '/css/woocommerce.css',
			array(),'2.3.4'
		);

		wp_enqueue_style('dashicons');

		wp_enqueue_script(
			'taxi-booking-navigation',
			get_template_directory_uri() . '/js/navigation.js',
			FALSE,
			'1.0',
			TRUE
		);

		wp_enqueue_script(
			'owl-carousel-js',
			get_template_directory_uri() . '/js/owl.carousel.js',
			array('jquery'),
			'2.3.4',
			TRUE
		);

		wp_enqueue_script(
			'taxi-booking-script',
			get_template_directory_uri() . '/js/script.js',
			array('jquery'),
			'1.0',
			TRUE
		);

		if ( get_theme_mod( 'taxi_booking_animation_enabled', true ) ) {
			wp_enqueue_script(
				'taxi-booking-wow-script',
				get_template_directory_uri() . '/js/wow.js',
				array( 'jquery' ),
				'1.0',
				true
			);

			wp_enqueue_style(
				'taxi-booking-animate',
				get_template_directory_uri() . '/css/animate.css',
				array(),
				'4.1.1'
			);
		}

		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

		$taxi_booking_css = '';

		if ( get_header_image() ) :

			$taxi_booking_css .=  '
				#site-navigation{
					background-image: url('.esc_url(get_header_image()).');
					-webkit-background-size: cover !important;
					-moz-background-size: cover !important;
					-o-background-size: cover !important;
					background-size: cover !important;
				}';

		endif;

		wp_add_inline_style( 'taxi-booking-style', $taxi_booking_css );

		// Theme Customize CSS.
		require get_template_directory(). '/core/includes/inline.php';
		wp_add_inline_style( 'taxi-booking-style',$taxi_booking_custom_css );

	}

	add_action( 'wp_enqueue_scripts', 'taxi_booking_enqueue_scripts' );

}

/*-----------------------------------------------------------------------------------*/
/* Setup theme */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('taxi_booking_after_setup_theme')) {

	function taxi_booking_after_setup_theme() {

		load_theme_textdomain( 'taxi-booking', get_stylesheet_directory() . '/languages' );
		if ( ! isset( $taxi_booking_content_width ) ) $taxi_booking_content_width = 900;

		register_nav_menus( array(
			'main-menu' => esc_html__( 'Main menu', 'taxi-booking' ),
		));

		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'align-wide' );
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support( 'wp-block-styles' );
		add_theme_support('post-thumbnails');
		add_theme_support( 'custom-background', array(
		  'default-color' => 'f3f3f3'
		));

		add_theme_support( 'custom-logo', array(
			'height'      => 70,
			'width'       => 70,
		) );

		add_theme_support( 'custom-header', array(
			'header-text' => false,
			'width' => 1920,
			'height' => 100
		));

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'post-formats', array('image','video','gallery','audio',) );

		add_editor_style( array( '/css/editor-style.css' ) );
	}

	add_action( 'after_setup_theme', 'taxi_booking_after_setup_theme', 999 );

}

require get_template_directory() .'/core/includes/customizer-notice/taxi-booking-customizer-notify.php';
require get_template_directory() .'/core/includes/theme-breadcrumb.php';
require get_template_directory() .'/core/includes/main.php';
require get_template_directory() .'/core/includes/tgm.php';
require get_template_directory() . '/core/includes/customizer.php';
require get_template_directory() . '/core/includes/vehicle-booking-cf.php';
load_template( trailingslashit( get_template_directory() ) . '/core/includes/class-upgrade-pro.php' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue theme logo style */
/*-----------------------------------------------------------------------------------*/

function taxi_booking_logo_resizer() {

    $taxi_booking_theme_logo_size_css = '';
    $taxi_booking_logo_resizer = get_theme_mod('taxi_booking_logo_resizer');

	$taxi_booking_theme_logo_size_css = '
		.custom-logo{
			height: '.esc_attr($taxi_booking_logo_resizer).'px !important;
			width: '.esc_attr($taxi_booking_logo_resizer).'px !important;
		}
	';
    wp_add_inline_style( 'taxi-booking-style',$taxi_booking_theme_logo_size_css );

}
add_action( 'wp_enqueue_scripts', 'taxi_booking_logo_resizer' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue Global color style */
/*-----------------------------------------------------------------------------------*/
function taxi_booking_global_color() {

    $taxi_booking_theme_color_css = '';
    $taxi_booking_global_color = get_theme_mod('taxi_booking_global_color');
    $taxi_booking_global_color_2 = get_theme_mod('taxi_booking_global_color_2');
    $taxi_booking_copyright_bg = get_theme_mod('taxi_booking_copyright_bg');

	$taxi_booking_theme_color_css = '
		.topheader,.vehicle_booking_content_box p.slider-button a:hover,.wp-block-button__link,#main-menu ul.children li a:hover,
#main-menu ul.sub-menu li a:hover,.post-button a,p.slider-button a,.slider button.owl-prev i:hover, .slider button.owl-next i:hover,.pagination .nav-links a:hover,.pagination .nav-links a:focus,.pagination .nav-links span.current,.taxi-booking-pagination span.current,.taxi-booking-pagination span.current:hover,.taxi-booking-pagination span.current:focus,.taxi-booking-pagination a span:hover,.taxi-booking-pagination a span:focus,.woocommerce nav.woocommerce-pagination ul li span.current,.comment-respond input#submit,.comment-reply a,.sidebar-area h4.title, .sidebar-area h1.wp-block-heading,.sidebar-area h2.wp-block-heading,.sidebar-area h3.wp-block-heading,.sidebar-area h4.wp-block-heading,.sidebar-area h5.wp-block-heading,.sidebar-area h6.wp-block-heading,.sidebar-area .wp-block-search__label,.sidebar-area .tagcloud a, p.wp-block-tag-cloud a,.searchform input[type=submit], .sidebar-area .wp-block-search__button,.searchform input[type=submit]:hover ,.searchform input[type=submit]:focus,.scroll-up a,nav.woocommerce-MyAccount-navigation ul li,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce a.added_to_cart,.wp-block-woocommerce-cart .wc-block-cart__submit-button, .wc-block-components-checkout-place-order-button, .wc-block-components-totals-coupon__button,.triangle35b:nth-child(1),.triangle35b:nth-child(3){
		background: '.esc_attr($taxi_booking_global_color).';
		}
		@media screen and (min-width: 320px) and (max-width: 767px) {
		    .menu-toggle, .dropdown-toggle,.search-cart,button.close-menu {
		        background: '.esc_attr($taxi_booking_global_color).';
		    }
		}
		.vehicle-booking .tablinks:hover, .vehicle-booking .tablinks.active,.vehicle_booking_inner_box{
			border-color: '.esc_attr($taxi_booking_global_color).';
		}
		.blog_box h4,.vehicle-booking .tablinks:hover, .vehicle-booking .tablinks.active,.vehicle-booking h6,span.info,a:hover,
a:focus,#main-menu a:hover,#main-menu ul li a:hover,#main-menu li:hover > a,#main-menu a:focus,#main-menu ul li a:focus,#main-menu li.focus > a,#main-menu li:focus > a,#main-menu ul li.current-menu-item > a,#main-menu ul li.current_page_item > a,#main-menu ul li.current-menu-parent > a,#main-menu ul li.current_page_ancestor > a,#main-menu ul li.current-menu-ancestor > a,.post-meta i,.bread_crumb a:hover,.bread_crumb span,.woocommerce ul.products li.product .price,.woocommerce div.product p.price, .woocommerce div.product span.price{
			color: '.esc_attr($taxi_booking_global_color).';
		}
    	.copyright {
			background: '.esc_attr($taxi_booking_copyright_bg).';
		}
	';
    wp_add_inline_style( 'taxi-booking-style',$taxi_booking_theme_color_css );
    wp_add_inline_style( 'taxi-booking-woocommerce-css',$taxi_booking_theme_color_css );

}
add_action( 'wp_enqueue_scripts', 'taxi_booking_global_color' );



/*-----------------------------------------------------------------------------------*/
/* Get post comments */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('taxi_booking_comment')) :
    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     */
    function taxi_booking_comment($comment, $taxi_booking_args, $depth){

        if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) : ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class('media'); ?>>
            <div class="comment-body">
                <?php esc_html_e('Pingback:', 'taxi-booking');
                comment_author_link(); ?><?php edit_comment_link(__('Edit', 'taxi-booking'), '<span class="edit-link">', '</span>'); ?>
            </div>

        <?php else : ?>

        <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($taxi_booking_args['has_children']) ? '' : 'parent'); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body media mb-4">
                <a class="pull-left" href="#">
                    <?php if (0 != $taxi_booking_args['avatar_size']) echo get_avatar($comment, $taxi_booking_args['avatar_size']); ?>
                </a>
                <div class="media-body">
                    <div class="media-body-wrap card">
                        <div class="card-header">
                            <h5 class="mt-0"><?php /* translators: %s: author */ printf('<cite class="fn">%s</cite>', get_comment_author_link() ); ?></h5>
                            <div class="comment-meta">
                                <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                    <time datetime="<?php comment_time('c'); ?>">
                                        <?php /* translators: %s: Date */ printf( esc_attr('%1$s at %2$s', '1: date, 2: time', 'taxi-booking'), esc_attr( get_comment_date() ), esc_attr( get_comment_time() ) ); ?>
                                    </time>
                                </a>
                                <?php edit_comment_link( __( 'Edit', 'taxi-booking' ), '<span class="edit-link">', '</span>' ); ?>
                            </div>
                        </div>

                        <?php if ('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'taxi-booking'); ?></p>
                        <?php endif; ?>

                        <div class="comment-content card-block">
                            <?php comment_text(); ?>
                        </div>

                        <?php comment_reply_link(
                            array_merge(
                                $taxi_booking_args, array(
                                    'add_below' => 'div-comment',
                                    'depth' => $depth,
                                    'max_depth' => $taxi_booking_args['max_depth'],
                                    'before' => '<footer class="reply comment-reply card-footer">',
                                    'after' => '</footer><!-- .reply -->'
                                )
                            )
                        ); ?>
                    </div>
                </div>
            </article>

            <?php
        endif;
    }
endif; // ends check for taxi_booking_comment()

if (!function_exists('taxi_booking_widgets_init')) {

	function taxi_booking_widgets_init() {

		register_sidebar(array(

			'name' => esc_html__('Sidebar','taxi-booking'),
			'id'   => 'taxi-booking-sidebar',
			'description'   => esc_html__('This sidebar will be shown next to the content.', 'taxi-booking'),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

		register_sidebar(array(

			'name' => esc_html__('Sidebar 2','taxi-booking'),
			'id'   => 'taxi-booking-sidebar-2',
			'description'   => esc_html__('This sidebar will be shown next to the content.', 'taxi-booking'),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

		register_sidebar(array(

			'name' => esc_html__('Sidebar 3','taxi-booking'),
			'id'   => 'taxi-booking-sidebar-3',
			'description'   => esc_html__('This sidebar will be shown next to the content.', 'taxi-booking'),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

		register_sidebar(array(

			'name' => esc_html__('Footer sidebar','taxi-booking'),
			'id'   => 'taxi-booking-footer-sidebar',
			'description'   => esc_html__('This sidebar will be shown next at the bottom of your content.', 'taxi-booking'),
			'before_widget' => '<div id="%1$s" class="col-lg-3 col-md-3 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

	}

	add_action( 'widgets_init', 'taxi_booking_widgets_init' );

}

function taxi_booking_get_categories_select() {
	$taxi_booking_teh_cats = get_categories();
	$results = array();
	$taxi_booking_count = count($taxi_booking_teh_cats);
	for ($i=0; $i < $taxi_booking_count; $i++) {
	if (isset($taxi_booking_teh_cats[$i]))
  		$results[$taxi_booking_teh_cats[$i]->slug] = $taxi_booking_teh_cats[$i]->name;
	else
  		$taxi_booking_count++;
	}
	return $results;
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'taxi_booking_loop_columns');
if (!function_exists('taxi_booking_loop_columns')) {
	function taxi_booking_loop_columns() {
		$taxi_booking_columns = get_theme_mod( 'taxi_booking_per_columns', 3 );
		return $taxi_booking_columns;
	}
}

//Change number of products that are displayed per page (shop page)
add_filter( 'loop_shop_per_page', 'taxi_booking_per_page', 20 );
function taxi_booking_per_page( $taxi_booking_cols ) {
  	$taxi_booking_cols = get_theme_mod( 'taxi_booking_product_per_page', 9 );
	return $taxi_booking_cols;
}

// Add filter to modify the number of related products
add_filter( 'woocommerce_output_related_products_args', 'taxi_booking_products_args' );
function taxi_booking_products_args( $args ) {
    $args['posts_per_page'] = get_theme_mod( 'custom_related_products_number', 6 );
    $args['columns'] = get_theme_mod( 'custom_related_products_number_per_row', 3 );
    return $args;
}

function taxi_booking_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

add_action('after_switch_theme', 'taxi_booking_setup_options');
function taxi_booking_setup_options () {
    update_option('dismissed-get_started', FALSE );
}

//add animation class
if ( class_exists( 'WooCommerce' ) ) { 
	add_filter('post_class', function($taxi_booking, $class, $product_id) {
	    if( is_shop() || is_product_category() ){
	        
	        $taxi_booking = array_merge(['wow','zoomIn'], $taxi_booking);
	    }
	    return $taxi_booking;
	},10,3);
}

function get_page_id_by_title($pagename){

    $args = array(
        'post_type' => 'page',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'title' => $pagename
    );
    $query = new WP_Query( $args );

    $page_id = '1';
    if (isset($query->post->ID)) {
        $page_id = $query->post->ID;
    }

    return $page_id;
}

add_action( 'customize_register', 'taxi_booking_remove_setting', 20 );
function taxi_booking_remove_setting( $wp_customize ) {
    // Check if the setting or control exists before removing
    if ( $wp_customize->get_setting( 'header_textcolor' ) ) {
        $wp_customize->remove_setting( 'header_textcolor' );
    }

    if ( $wp_customize->get_control( 'header_textcolor' ) ) {
        $wp_customize->remove_control( 'header_textcolor' );
    }
}

// edit link option
if (!function_exists('taxi_booking_edit_link')) :

    function taxi_booking_edit_link($view = 'default')
    {
        global $post;
            edit_post_link(
                sprintf(
                    wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                        __('Edit <span class="screen-reader-text">%s</span>', 'taxi-booking'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                ),
                '<span class="edit-link"><i class="fas fa-edit"></i>',
                '</span>'
            );

    }
endif;?>