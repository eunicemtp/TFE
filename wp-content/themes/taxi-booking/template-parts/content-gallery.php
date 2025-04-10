<div class="blog-grid-layout">
  <div id="post-<?php the_ID(); ?>" <?php post_class('post-box mb-4 p-3 wow zoomIn'); ?>>
    <?php
      if ( ! is_single() ) {
        // If not a single post, highlight the gallery.
        if ( get_post_gallery() ) {
          echo '<div class="entry-gallery">';
            echo ( get_post_gallery() );
          echo '</div>';
        };
      };
    ?>
    <?php if ( get_theme_mod('taxi_booking_blog_admin_enable',true) || get_theme_mod('taxi_booking_blog_comment_enable',true) ) : ?>
      <div class="post-meta my-3">
        <?php if ( get_theme_mod('taxi_booking_blog_admin_enable',true) ) : ?>
          <i class="far fa-user me-2"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>"><?php the_author(); ?></a>
        <?php endif; ?>
        <?php if ( get_theme_mod('taxi_booking_blog_comment_enable',true) ) : ?>
          <span class="ms-3"><i class="far fa-comments me-2"></i> <?php comments_number( esc_attr('0', 'taxi-booking'), esc_attr('0', 'taxi-booking'), esc_attr('%', 'taxi-booking') ); ?> <?php esc_html_e('comments','taxi-booking'); ?></span>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <h3 class="post-title mb-3 mt-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <div class="post-content">
      <?php echo wp_trim_words( get_the_content(), get_theme_mod('taxi_booking_post_excerpt_number',15) ); ?>
    </div>
  </div>
</div>