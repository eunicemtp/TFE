<?php 

/* Template Name: Front Page Template */

get_header(); ?>

<div id="content">
	<?php get_template_part( 'core/sections/car-slider' ); ?>
	<?php get_template_part( 'core/sections/vehicle-booking' ); ?>
	<?php get_template_part( 'core/sections/additional-content' ); ?>
</div>

<?php get_footer(); ?>