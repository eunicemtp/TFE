<?php
if (isset($_GET['import-demo']) && $_GET['import-demo'] == true) {
    class TaxiBookingDemoImporter {

        public function taxi_booking_customizer_primary_menu() {
            // Create Primary Menu
            $taxi_booking_themename = 'Taxi Booking'; // Define the theme name
            $taxi_booking_menuname = $taxi_booking_themename . 'Main Menus';
            $taxi_booking_bpmenulocation = 'main-menu';
            $taxi_booking_menu_exists = wp_get_nav_menu_object($taxi_booking_menuname);

            if (!$taxi_booking_menu_exists) {
                $taxi_booking_menu_id = wp_create_nav_menu($taxi_booking_menuname);

                wp_update_nav_menu_item($taxi_booking_menu_id, 0, array(
                    'menu-item-title' => __('Home', 'taxi-booking'),
                    'menu-item-classes' => 'home',
                    'menu-item-url' => home_url('/'),
                    'menu-item-status' => 'publish',
                ));

                wp_update_nav_menu_item($taxi_booking_menu_id, 0, array(
                    'menu-item-title' => __('About', 'taxi-booking'),
                    'menu-item-classes' => 'about',
                    'menu-item-url' => get_permalink(get_page_id_by_title('about')),
                    'menu-item-status' => 'publish',
                ));


                wp_update_nav_menu_item($taxi_booking_menu_id, 0, array(
                    'menu-item-title' => __('Services', 'taxi-booking'),
                    'menu-item-classes' => 'services',
                    'menu-item-url' => get_permalink(get_page_id_by_title('services')),
                    'menu-item-status' => 'publish',
                ));

                wp_update_nav_menu_item($taxi_booking_menu_id, 0, array(
                    'menu-item-title' => __('Blog', 'taxi-booking'),
                    'menu-item-classes' => 'blog',
                    'menu-item-url' => get_permalink(get_page_id_by_title('blog')),
                    'menu-item-status' => 'publish',
                ));

                wp_update_nav_menu_item($taxi_booking_menu_id, 0, array(
                    'menu-item-title' => __('Pages', 'taxi-booking'),
                    'menu-item-classes' => 'pages',
                    'menu-item-url' => get_permalink(get_page_id_by_title('pages')),
                    'menu-item-status' => 'publish',
                ));

                wp_update_nav_menu_item($taxi_booking_menu_id, 0, array(
                    'menu-item-title' => __('Contact Us', 'taxi-booking'),
                    'menu-item-classes' => 'contact-us',
                    'menu-item-url' => get_permalink(get_page_id_by_title('contact-us')),
                    'menu-item-status' => 'publish',
                ));

                if (!has_nav_menu($taxi_booking_bpmenulocation)) {
                    $locations = get_theme_mod('nav_menu_locations');
                    $locations[$taxi_booking_bpmenulocation] = $taxi_booking_menu_id;
                    set_theme_mod('nav_menu_locations', $locations);
                }
            }
        }

        public function setup_widgets() {

        $taxi_booking_home_id='';
        $taxi_booking_home_content = '';
        $taxi_booking_home_title = 'Home';
        $taxi_booking_home = array(
            'post_type' => 'page',
            'post_title' => $taxi_booking_home_title,
            'post_content' => $taxi_booking_home_content,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_slug' => 'home'
        );
        $taxi_booking_home_id = wp_insert_post($taxi_booking_home);

        add_post_meta( $taxi_booking_home_id, '_wp_page_template', 'frontpage.php' );

        update_option( 'page_on_front', $taxi_booking_home_id );
        update_option( 'show_on_front', 'page' );

                        // Create a Posts Page
            $taxi_booking_blog_title = 'About';
            $taxi_booking_blog_check = get_page_id_by_title($taxi_booking_blog_title);

            if ($taxi_booking_blog_check == 1) {
                $taxi_booking_blog = array(
                    'post_type' => 'page',
                    'post_title' => $taxi_booking_blog_title,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_name' => 'about',
                    'post_content' => '"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."',
                );
                $taxi_booking_blog_id = wp_insert_post($taxi_booking_blog);

                if (!is_wp_error($taxi_booking_blog_id)) {
                    // update_option('page_for_posts', $taxi_booking_blog_id);
                }
            }

                        // Create a Posts Page
            $taxi_booking_blog_title = 'Services';
            $taxi_booking_blog_check = get_page_id_by_title($taxi_booking_blog_title);

            if ($taxi_booking_blog_check  == 1) {
                $taxi_booking_blog = array(
                    'post_type' => 'page',
                    'post_title' => $taxi_booking_blog_title,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_name' => 'services',
                    'post_content' => '"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."',
                );
                $taxi_booking_blog_id = wp_insert_post($taxi_booking_blog);

                if (!is_wp_error($taxi_booking_blog_id)) {
                    // update_option('page_for_posts', $taxi_booking_blog_id);
                }
            }

                         // Create a Posts Page
            $taxi_booking_blog_title = 'Blog';
            $taxi_booking_blog_check = get_page_id_by_title($taxi_booking_blog_title);

            if ($taxi_booking_blog_check  == 1) {
                $taxi_booking_blog = array(
                    'post_type' => 'page',
                    'post_title' => $taxi_booking_blog_title,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_name' => 'blog',
                    'post_content' => '"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."',
                );
                $taxi_booking_blog_id = wp_insert_post($taxi_booking_blog);

                if (!is_wp_error($taxi_booking_blog_id)) {
                    // update_option('page_for_posts', $taxi_booking_blog_id);
                }
            }

                         // Create a Posts Page
            $taxi_booking_blog_title = 'Pages';
            $taxi_booking_blog_check = get_page_id_by_title($taxi_booking_blog_title);

            if ($taxi_booking_blog_check  == 1) {
                $taxi_booking_blog = array(
                    'post_type' => 'page',
                    'post_title' => $taxi_booking_blog_title,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_name' => 'pages',
                    'post_content' => '"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."',
                );
                $taxi_booking_blog_id = wp_insert_post($taxi_booking_blog);

                if (!is_wp_error($taxi_booking_blog_id)) {
                    // update_option('page_for_posts', $taxi_booking_blog_id);
                }
            }

                                     // Create a Posts Page
            $taxi_booking_blog_title = 'Contact Us';
            $taxi_booking_blog_check = get_page_id_by_title($taxi_booking_blog_title);

            if ($taxi_booking_blog_check  == 1) {
                $taxi_booking_blog = array(
                    'post_type' => 'page',
                    'post_title' => $taxi_booking_blog_title,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_name' => 'contact-us',
                    'post_content' => '"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."',
                );
                $taxi_booking_blog_id = wp_insert_post($taxi_booking_blog);

                if (!is_wp_error($taxi_booking_blog_id)) {
                    // update_option('page_for_posts', $taxi_booking_blog_id);
                }
            }

                                                 // Create a Posts Page
            $taxi_booking_blog_title = 'CONTACT';
            $taxi_booking_blog_check = get_page_id_by_title($taxi_booking_blog_title);

            if ($taxi_booking_blog_check  == 1) {
                $taxi_booking_blog = array(
                    'post_type' => 'page',
                    'post_title' => $taxi_booking_blog_title,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_name' => 'contact',
                    'post_content' => '"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."',
                );
                $taxi_booking_blog_id = wp_insert_post($taxi_booking_blog);

                if (!is_wp_error($taxi_booking_blog_id)) {
                    // update_option('page_for_posts', $taxi_booking_blog_id);
                }
            }

		//---Header--//

		set_theme_mod( 'taxi_booking_header_hire_us_txt', 'Book Now');
		set_theme_mod( 'taxi_booking_header_hire_us_lnk', '#');

		set_theme_mod('taxi_booking_social_links_settings', array(
		    array(
		        "link_text" => "fab fa-facebook-f",
		        "link_url" => "#"
		    ),
		    array(
		        "link_text" => "fab fa-linkedin",
		        "link_url" => "#"
		    ),
		    array(
		        "link_text" => "fab fa-whatsapp",
		        "link_url" => "#"
		    ),
		    array(
		        "link_text" => "fab fa-instagram",
		        "link_url" => "#"
		    )
		    
		));

		set_theme_mod('taxi_booking_extra_links_settings', array(
		    array(
		        "link_text" => "Enquiry",
		        "link_url" => "#"
		    ),
		    array(
		        "link_text" => "Cancellation",
		        "link_url" => "#"
		    ),
		    array(
		        "link_text" => "Booking Status",
		        "link_url" => "#"
		    ),
		    array(
		        "link_text" => "Tariffs",
		        "link_url" => "#"
		    ),
		     array(
		        "link_text" => "Live Location",
		        "link_url" => "#"
		    )
		    
		));

		//-----Slider-----//

		set_theme_mod( 'taxi_booking_blog_box_enable', true);

		set_theme_mod( 'taxi_booking_blog_slide_number', '3' );
		$taxi_booking_latest_post_category = wp_create_category('Slider Post');
			set_theme_mod( 'taxi_booking_blog_slide_category', 'Slider Post' ); 

			set_theme_mod( 'taxi_booking_slider_extra_text', '+81 254781-134445' ); 

		for($i=1; $i<=3; $i++) {

			$slider_title=array('The best way to get wherever you are going', 'The best method to get to where you’re going.', 'The fastest route to reach your destination.');

			// Create post object
			$taxi_booking_my_post = array(
				'post_title'    => wp_strip_all_tags( $slider_title[$i-1] ),
				'post_status'   => 'publish',
				'post_type'     => 'post',
				'post_category' => array($taxi_booking_latest_post_category) 
			);

			// Insert the post into the database
			$taxi_booking_post_id = wp_insert_post( $taxi_booking_my_post );

			$taxi_booking_image_url = get_template_directory_uri().'/assets/images/slider'.$i.'.jpg';

			$taxi_booking_image_name= 'slider'.$i.'.jpg';
			$taxi_booking_upload_dir       = wp_upload_dir(); 
			// Set upload folder
			$taxi_booking_image_data       = file_get_contents($taxi_booking_image_url); 
			 
			// Get image data
			$taxi_booking_unique_file_name = wp_unique_filename( $taxi_booking_upload_dir['path'], $taxi_booking_image_name ); 
			// Generate unique name
			$filename= basename( $taxi_booking_unique_file_name ); 
			// Create image file name
			// Check folder permission and define file location
			if( wp_mkdir_p( $taxi_booking_upload_dir['path'] ) ) {
				$file = $taxi_booking_upload_dir['path'] . '/' . $filename;
			} else {
				$file = $taxi_booking_upload_dir['basedir'] . '/' . $filename;
			}
			if ( ! function_exists( 'WP_Filesystem' ) ) {
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                }
                
                WP_Filesystem();
                global $wp_filesystem;
                
                if ( ! $wp_filesystem->put_contents( $file, $taxi_booking_image_data, FS_CHMOD_FILE ) ) {
                    wp_die( 'Error saving file!' );
                }
			$wp_filetype = wp_check_filetype( $filename, null );
			$taxi_booking_attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title'     => sanitize_file_name( $filename ),
				'post_content'   => '',
				'post_type'     => 'post',
				'post_status'    => 'inherit'
			);
			$attach_id = wp_insert_attachment( $taxi_booking_attachment, $file, $taxi_booking_post_id );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
				wp_update_attachment_metadata( $attach_id, $attach_data );
				set_post_thumbnail( $taxi_booking_post_id, $attach_id );
		}

		//----- Choose Cab Section---//

		set_theme_mod( 'taxi_booking_vehicle_booking_section_enable', true);

		set_theme_mod( 'taxi_booking_vehicle_booking_heading_text', 'Choose Your Cab');
     	set_theme_mod( 'taxi_booking_vehicle_booking_heading', 'Select your favorite vehicle ');

		set_theme_mod( 'taxi_booking_vehicle_booking_number', '3');

		$tab_icon=array('fas fa-car','fas fa-motorcycle','fas fa-car');

		for($i=1; $i<=3; $i++) {

        	set_theme_mod('taxi_booking_vehicle_booking_text' . $i, $tab_icon[$i - 1]);
		
			$cab_category = wp_create_category('Cab Booking');
  		    set_theme_mod( 'taxi_booking_vehicle_booking_category'.$i, 'Cab Booking' ); 
		}

     	$cab_name=array('Auto Booking','Taxi Booking');
 
		for($i=1; $i<=2; $i++) {

			$title =$cab_name[$i-1];
			$content = 'Toll and State Tax: Included Free cancellation 24/7 customer helpline';

			// Create post object
			$my_post = array(
				'post_title'    => wp_strip_all_tags( $title ),
				'post_content'  => $content,
				'post_status'   => 'publish',
				'post_type'     => 'post',
				'post_category' => array($cab_category) 
			);

			// Insert the post into the database
			$post_id = wp_insert_post( $my_post );

			update_post_meta( $post_id, 'taxi_booking_vehicle_passenger', '4 Seater');
			update_post_meta( $post_id, 'taxi_booking_vehicle_luggage', '2 Luggage Bags');
			update_post_meta( $post_id, 'taxi_booking_vehicle_price', '$230');

			$image_url = get_template_directory_uri().'/assets/images/cab'.$i.'.jpg';

			$image_name= 'cab'.$i.'.jpg';
			$upload_dir       = wp_upload_dir(); 
			// Set upload folder
			$image_data       = file_get_contents($image_url); 
			 
			// Get image data
			$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); 
			// Generate unique name
			$filename= basename( $unique_file_name ); 
			// Create image file name
			// Check folder permission and define file location
			if( wp_mkdir_p( $upload_dir['path'] ) ) {
				$file = $upload_dir['path'] . '/' . $filename;
			} else {
				$file = $upload_dir['basedir'] . '/' . $filename;
			}
			if ( ! function_exists( 'WP_Filesystem' ) ) {
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                }
                
                WP_Filesystem();
                global $wp_filesystem;
                
                if ( ! $wp_filesystem->put_contents( $file, $image_data, FS_CHMOD_FILE ) ) {
                    wp_die( 'Error saving file!' );
                }
			$wp_filetype = wp_check_filetype( $filename, null );
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title'     => sanitize_file_name( $filename ),
				'post_content'   => '',
				'post_type'     => 'post',
				'post_status'    => 'inherit',
			);
			$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
				wp_update_attachment_metadata( $attach_id, $attach_data );
				set_post_thumbnail( $post_id, $attach_id );
		}

	}
}
	// Instantiate the class and call its methods
    $demo_importer = new TaxiBookingDemoImporter();
    $demo_importer->setup_widgets();
    $demo_importer->taxi_booking_customizer_primary_menu();
	}
?>