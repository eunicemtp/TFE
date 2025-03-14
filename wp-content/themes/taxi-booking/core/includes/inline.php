<?php

$taxi_booking_custom_css = '';


$taxi_booking_is_dark_mode_enabled = get_theme_mod( 'taxi_booking_is_dark_mode_enabled', false );

if ( $taxi_booking_is_dark_mode_enabled ) {

    $taxi_booking_custom_css .= 'body,.fixed-header,tr:nth-child(2n+2),#site-navigation {';
    $taxi_booking_custom_css .= 'background: #000;';
    $taxi_booking_custom_css .= '}';

    $taxi_booking_custom_css .= '.some {';
    $taxi_booking_custom_css .= 'background: #000 !important;';
    $taxi_booking_custom_css .= '}';

	$taxi_booking_custom_css .= 'button.tablinks i, .sticky .post-content{';
    $taxi_booking_custom_css .= 'color: #000';
    $taxi_booking_custom_css .= '}';

	$taxi_booking_custom_css .= 'h5.product-text a,#featured-product p.price,.card-header a,.comment-content.card-block p,.post-box.sticky a{';
    $taxi_booking_custom_css .= 'color: #000 !important';
    $taxi_booking_custom_css .= '}';

    $taxi_booking_custom_css .= '.vehicle-booking .tablinks{';
    $taxi_booking_custom_css .= 'background: #fff;';
    $taxi_booking_custom_css .= '}';

    $taxi_booking_custom_css .= '.some {';
    $taxi_booking_custom_css .= 'background: #fff !important;';
    $taxi_booking_custom_css .= '}';
	

    $taxi_booking_custom_css .= 'body,h1,h2,h3,h4,h5,p,#main-menu ul li a,.woocommerce .woocommerce-ordering select, .woocommerce form .form-row input.input-text, .woocommerce form .form-row textarea,a,li.menu-item-has-children:after{';
    $taxi_booking_custom_css .= 'color: #fff;';
    $taxi_booking_custom_css .= '}';

    $taxi_booking_custom_css .= 'a.wc-block-components-product-name, .wc-block-components-product-name,.wc-block-components-totals-footer-item .wc-block-components-totals-item__value,
.wc-block-components-totals-footer-item .wc-block-components-totals-item__label,
.wc-block-components-totals-item__label,.wc-block-components-totals-item__value,
.wc-block-components-product-metadata .wc-block-components-product-metadata__description>p,
.is-medium table.wc-block-cart-items .wc-block-cart-items__row .wc-block-cart-item__total .wc-block-components-formatted-money-amount,
.wc-block-components-quantity-selector input.wc-block-components-quantity-selector__input,
.wc-block-components-quantity-selector .wc-block-components-quantity-selector__button,
.wc-block-components-quantity-selector,table.wc-block-cart-items .wc-block-cart-items__row .wc-block-cart-item__quantity .wc-block-cart-item__remove-link,
.wc-block-components-product-price__value.is-discounted,del.wc-block-components-product-price__regular,.logo a,.logo span{';
    $taxi_booking_custom_css .= 'color: #fff !important;';
    $taxi_booking_custom_css .= '}';

	$taxi_booking_custom_css .= '.post-box{';
    $taxi_booking_custom_css .= '    border: 1px solid rgb(229 229 229 / 48%)';
    $taxi_booking_custom_css .= '}';
}

	/*---------------------------text-transform-------------------*/

	$taxi_booking_text_transform = get_theme_mod( 'menu_text_transform_taxi_booking','CAPITALISE');

    if($taxi_booking_text_transform == 'CAPITALISE'){

		$taxi_booking_custom_css .='#main-menu ul li a{';

			$taxi_booking_custom_css .='text-transform: capitalize ; font-size: 14px;';

		$taxi_booking_custom_css .='}';

	}else if($taxi_booking_text_transform == 'UPPERCASE'){

		$taxi_booking_custom_css .='#main-menu ul li a{';

			$taxi_booking_custom_css .='text-transform: uppercase ; font-size: 14px;';

		$taxi_booking_custom_css .='}';

	}else if($taxi_booking_text_transform == 'LOWERCASE'){

		$taxi_booking_custom_css .='#main-menu ul li a{';

			$taxi_booking_custom_css .='text-transform: lowercase ; font-size: 14px;';

		$taxi_booking_custom_css .='}';
	}

		/*---------------------------menu-zoom-------------------*/

		$taxi_booking_menu_zoom = get_theme_mod( 'taxi_booking_menu_zoom','None');

	if($taxi_booking_menu_zoom == 'None'){

		$taxi_booking_custom_css .='#main-menu ul li a{';

			$taxi_booking_custom_css .='';

		$taxi_booking_custom_css .='}';

	}else if($taxi_booking_menu_zoom == 'Zoominn'){

		$taxi_booking_custom_css .='#main-menu ul li a:hover{';

			$taxi_booking_custom_css .='transition: all 0.3s ease-in-out !important; transform: scale(1.2) !important; color: #f9c32b;';

		$taxi_booking_custom_css .='}';
	}

		/*---------------------------Container Width-------------------*/

	$taxi_booking_container_width = get_theme_mod('taxi_booking_container_width');

			$taxi_booking_custom_css .='body{';

				$taxi_booking_custom_css .='width: '.esc_attr($taxi_booking_container_width).'%; margin: auto;';

			$taxi_booking_custom_css .='}';

			/*---------------------------Slider-content-alignment-------------------*/


	$taxi_booking_slider_content_alignment = get_theme_mod( 'taxi_booking_slider_content_alignment','CENTER-ALIGN');

	 if($taxi_booking_slider_content_alignment == 'LEFT-ALIGN'){

			$taxi_booking_custom_css .='.blog_box{';

				$taxi_booking_custom_css .='text-align:left;';

			$taxi_booking_custom_css .='}';


		}else if($taxi_booking_slider_content_alignment == 'CENTER-ALIGN'){

			$taxi_booking_custom_css .='.blog_box{';

				$taxi_booking_custom_css .='text-align:center;';

			$taxi_booking_custom_css .='}';


		}else if($taxi_booking_slider_content_alignment == 'RIGHT-ALIGN'){

			$taxi_booking_custom_css .='.blog_box{';

				$taxi_booking_custom_css .='text-align:right;';

			$taxi_booking_custom_css .='}';

		}

		/*---------------------------Copyright Text alignment-------------------*/

$taxi_booking_copyright_text_alignment = get_theme_mod( 'taxi_booking_copyright_text_alignment','LEFT-ALIGN');

 if($taxi_booking_copyright_text_alignment == 'LEFT-ALIGN'){

		$taxi_booking_custom_css .='.copy-text p{';

			$taxi_booking_custom_css .='text-align:left;';

		$taxi_booking_custom_css .='}';


	}else if($taxi_booking_copyright_text_alignment == 'CENTER-ALIGN'){

		$taxi_booking_custom_css .='.copy-text p{';

			$taxi_booking_custom_css .='text-align:center;';

		$taxi_booking_custom_css .='}';


	}else if($taxi_booking_copyright_text_alignment == 'RIGHT-ALIGN'){

		$taxi_booking_custom_css .='.copy-text p{';

			$taxi_booking_custom_css .='text-align:right;';

		$taxi_booking_custom_css .='}';

	}

	/*---------------------------related Product Settings-------------------*/


$taxi_booking_related_product_setting = get_theme_mod('taxi_booking_related_product_setting',true);

	if($taxi_booking_related_product_setting == false){

		$taxi_booking_custom_css .='.related.products, .related h2{';

			$taxi_booking_custom_css .='display: none;';

		$taxi_booking_custom_css .='}';
	}

		/*---------------------------Scroll to Top Alignment Settings-------------------*/

	$taxi_booking_scroll_top_position = get_theme_mod( 'taxi_booking_scroll_top_position','Right');

	if($taxi_booking_scroll_top_position == 'Right'){

		$taxi_booking_custom_css .='.scroll-up{';

			$taxi_booking_custom_css .='right: 20px;';

		$taxi_booking_custom_css .='}';

	}else if($taxi_booking_scroll_top_position == 'Left'){

		$taxi_booking_custom_css .='.scroll-up{';

			$taxi_booking_custom_css .='left: 20px;';

		$taxi_booking_custom_css .='}';

	}else if($taxi_booking_scroll_top_position == 'Center'){

		$taxi_booking_custom_css .='.scroll-up{';

			$taxi_booking_custom_css .='right: 50%;left: 50%;';

		$taxi_booking_custom_css .='}';
	}

		/*---------------------------Pagination Settings-------------------*/


$taxi_booking_pagination_setting = get_theme_mod('taxi_booking_pagination_setting',true);

	if($taxi_booking_pagination_setting == false){

		$taxi_booking_custom_css .='.nav-links{';

			$taxi_booking_custom_css .='display: none;';

		$taxi_booking_custom_css .='}';
	}


	/*--------------------------- Slider Opacity -------------------*/

	$taxi_booking_slider_opacity_color = get_theme_mod( 'taxi_booking_slider_opacity_color','0.5');

	if($taxi_booking_slider_opacity_color == '0'){

		$taxi_booking_custom_css .='.blog_inner_box img{';

			$taxi_booking_custom_css .='opacity:0';

		$taxi_booking_custom_css .='}';

		}else if($taxi_booking_slider_opacity_color == '0.1'){

		$taxi_booking_custom_css .='.blog_inner_box img{';

			$taxi_booking_custom_css .='opacity:0.1';

		$taxi_booking_custom_css .='}';

		}else if($taxi_booking_slider_opacity_color == '0.2'){

		$taxi_booking_custom_css .='.blog_inner_box img{';

			$taxi_booking_custom_css .='opacity:0.2';

		$taxi_booking_custom_css .='}';

		}else if($taxi_booking_slider_opacity_color == '0.3'){

		$taxi_booking_custom_css .='.blog_inner_box img{';

			$taxi_booking_custom_css .='opacity:0.3';

		$taxi_booking_custom_css .='}';

		}else if($taxi_booking_slider_opacity_color == '0.4'){

		$taxi_booking_custom_css .='.blog_inner_box img{';

			$taxi_booking_custom_css .='opacity:0.4';

		$taxi_booking_custom_css .='}';

		}else if($taxi_booking_slider_opacity_color == '0.5'){

		$taxi_booking_custom_css .='.blog_inner_box img{';

			$taxi_booking_custom_css .='opacity:0.5';

		$taxi_booking_custom_css .='}';

		}else if($taxi_booking_slider_opacity_color == '0.6'){

		$taxi_booking_custom_css .='.blog_inner_box img{';

			$taxi_booking_custom_css .='opacity:0.6';

		$taxi_booking_custom_css .='}';

		}else if($taxi_booking_slider_opacity_color == '0.7'){

		$taxi_booking_custom_css .='.blog_inner_box img{';

			$taxi_booking_custom_css .='opacity:0.7';

		$taxi_booking_custom_css .='}';

		}else if($taxi_booking_slider_opacity_color == '0.8'){

		$taxi_booking_custom_css .='.blog_inner_box img{';

			$taxi_booking_custom_css .='opacity:0.8';

		$taxi_booking_custom_css .='}';

		}else if($taxi_booking_slider_opacity_color == '0.9'){

		$taxi_booking_custom_css .='.blog_inner_box img{';

			$taxi_booking_custom_css .='opacity:0.9';

		$taxi_booking_custom_css .='}';

		}else if($taxi_booking_slider_opacity_color == 'unset'){

		$taxi_booking_custom_css .='.blog_inner_box img{';

			$taxi_booking_custom_css .='opacity:unset';

		$taxi_booking_custom_css .='}';

		}

		/*---------------------------Woocommerce Pagination Alignment Settings-------------------*/

	$taxi_booking_woocommerce_pagination_position = get_theme_mod( 'taxi_booking_woocommerce_pagination_position','Center');

	if($taxi_booking_woocommerce_pagination_position == 'Left'){

		$taxi_booking_custom_css .='.woocommerce nav.woocommerce-pagination{';

			$taxi_booking_custom_css .='text-align: left;';

		$taxi_booking_custom_css .='}';

	}else if($taxi_booking_woocommerce_pagination_position == 'Center'){

		$taxi_booking_custom_css .='.woocommerce nav.woocommerce-pagination{';

			$taxi_booking_custom_css .='text-align: center;';

		$taxi_booking_custom_css .='}';

	}else if($taxi_booking_woocommerce_pagination_position == 'Right'){

		$taxi_booking_custom_css .='.woocommerce nav.woocommerce-pagination{';

			$taxi_booking_custom_css .='text-align: right;';

		$taxi_booking_custom_css .='}';
	}

