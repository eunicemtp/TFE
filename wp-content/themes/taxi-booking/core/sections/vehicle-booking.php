<?php if ( get_theme_mod('taxi_booking_vehicle_booking_section_enable',false) ) : ?>

<div class="vehicle-booking py-5">
	<div class="container">
		<?php if ( get_theme_mod('taxi_booking_vehicle_booking_heading_text') ) : ?>
			<h6 class="text-center wow flip"><?php echo esc_html(get_theme_mod('taxi_booking_vehicle_booking_heading_text')); ?></h6>
		<?php endif; ?>
		<?php if ( get_theme_mod('taxi_booking_vehicle_booking_heading') ) : ?>
			<h3 class="pb-4 text-center wow flip"><?php echo esc_html(get_theme_mod('taxi_booking_vehicle_booking_heading')); ?></h3>
		<?php endif; ?>

		<div class="tab text-center wow bounce">
	        <?php $taxi_booking_featured_post = get_theme_mod('taxi_booking_vehicle_booking_number', '');
	          	for ( $j = 1; $j <= $taxi_booking_featured_post; $j++ ){ ?>
          		<button class="tablinks" onclick="taxi_booking_vehicle_booking_tab(event, '<?php $taxi_booking_main_id = get_theme_mod('taxi_booking_vehicle_booking_text'.$j); $taxi_booking_tab_id = str_replace(' ', '-', $taxi_booking_main_id); echo $taxi_booking_tab_id; ?> ')">
	          	<i class="<?php echo esc_attr(get_theme_mod('taxi_booking_vehicle_booking_text'.$j)); ?>"></i></button>
	        <?php }?>
      	</div>

  	  	<?php for ( $j = 1; $j <= $taxi_booking_featured_post; $j++ ){ ?>
	        <div id="<?php $taxi_booking_main_id = get_theme_mod('taxi_booking_vehicle_booking_text'.$j); $taxi_booking_tab_id = str_replace(' ', '-', $taxi_booking_main_id); echo $taxi_booking_tab_id; ?>"  class="tabcontent mt-5">
		        <?php $taxi_booking_args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'category_name' =>  get_theme_mod('taxi_booking_vehicle_booking_category'.$j),
					'posts_per_page' => 9,
				); ?>
				<div class="row">
				    <?php $taxi_booking_arr_posts = new WP_Query( $taxi_booking_args );
				    	if ( $taxi_booking_arr_posts->have_posts() ) :
				      	while ( $taxi_booking_arr_posts->have_posts() ) :
				        $taxi_booking_arr_posts->the_post();
				        ?>
				        <div class="col-lg-6 col-md-6 col-sm-6">
					        <div class="vehicle_booking_inner_box mb-4 wow zoomIn">
					        	<div class="row">
					        		<div class="col-lg-5 col-md-5 col-sm-5">
				        				 <?php
								            if ( has_post_thumbnail() ) :
								              the_post_thumbnail();
								            else:
								              ?>
								              <div class="slider-alternate">
								                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/banner.png'; ?>">
								              </div>
								              <?php
								            endif;
								          ?>
					        		</div>
					        		<div class="col-lg-7 col-md-7 col-sm-7">
					        			<div class="vehicle_booking_content_box">
							        		<h4><?php the_title(); ?></h4>
							        		<?php if( get_post_meta($post->ID, 'taxi_booking_vehicle_passenger', true) ) {?>
							                	<span class="me-3 info"><?php echo esc_html(get_post_meta($post->ID,'taxi_booking_vehicle_passenger',true)); ?> <?php esc_html_e('Seater','taxi-booking'); ?></span>
							              	<?php }?>
							              	<?php if( get_post_meta($post->ID, 'taxi_booking_vehicle_luggage', true) ) {?>
							                	<span class="info"><?php echo esc_html(get_post_meta($post->ID,'taxi_booking_vehicle_luggage',true)); ?> <?php esc_html_e('Luggage Bags','taxi-booking'); ?></span>
							              	<?php }?>
							              	<p class="mt-2"><?php echo wp_trim_words( get_the_content(), 15 ); ?></p>
						              		<p class="slider-button mt-4">
						              			<?php if( get_post_meta($post->ID, 'taxi_booking_vehicle_price', true) ) {?>
								                	<span class="me-4 cab-price"><?php echo esc_html(get_post_meta($post->ID,'taxi_booking_vehicle_price',true)); ?></span>
								              	<?php }?>
						                		<a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php esc_html_e('Book Now','taxi-booking'); ?></a>
						              		</p>
							            </div>
					        		</div>
					        	</div>
					        </div>
					    </div>
				      	<?php
				    endwhile;
				    wp_reset_postdata();
				    endif; ?>
				</div>
			</div>
		<?php }?>
	</div>
</div>

<?php endif; ?>