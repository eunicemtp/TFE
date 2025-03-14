<?php if ( get_theme_mod('taxi_booking_blog_box_enable',false) ) : ?>

<?php $taxi_booking_args = array(
  'post_type' => 'post',
  'post_status' => 'publish',
  'category_name' =>  get_theme_mod('taxi_booking_blog_slide_category'),
  'posts_per_page' => get_theme_mod('taxi_booking_blog_slide_number'),
); ?>

<div class="slider">
  <div class="owl-carousel">
    <?php $taxi_booking_arr_posts = new WP_Query( $taxi_booking_args );
    if ( $taxi_booking_arr_posts->have_posts() ) :
      while ( $taxi_booking_arr_posts->have_posts() ) :
        $taxi_booking_arr_posts->the_post();
        ?>
        <div class="blog_inner_box">
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
          <div class="blog_box wow zoomIn">
            <?php if ( get_theme_mod('taxi_booking_title_unable_disable',true) ) : ?>
            <h3 class="my-3"><?php the_title(); ?></a></h3>
            <?php endif; ?>
            <?php if ( get_theme_mod('taxi_booking_number_unable_disable',true) ) : ?>
              <h4><?php echo esc_html( get_theme_mod('taxi_booking_slider_extra_text' ) ); ?></h4>
            <?php endif; ?>
            <?php if ( get_theme_mod('taxi_booking_button_unable_disable',true) ) : ?>
              <p class="slider-button mt-4">
                <a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php esc_html_e('Booking Now','taxi-booking'); ?></a>
              </p>
            <?php endif; ?>
          </div>
        </div>
      <?php
    endwhile;
    wp_reset_postdata();
    endif; ?>
  </div>
</div>

<?php endif; ?>
