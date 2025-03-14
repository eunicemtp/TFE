<?php
	the_posts_pagination( array(
		'prev_text' => esc_html__( 'Previous page', 'taxi-booking' ),
		'next_text' => esc_html__( 'Next page', 'taxi-booking' ),
	) );