<?php

class Transporters_Quoteform_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'quoteform_widget', // Base ID
			__( 'Transporters Quote Form', 'transporters-io' ), // Name
			array( 'description' => __( 'Transporters Quote Form', 'transporters-io' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		
		global $first_cookie;
		global $first_cookie_aff;

		echo wp_kses($args['before_widget']);
		
		$widget_id = $instance['quoteform_id'];
		
		$widget_type = '_w_'.$widget_id;
		
		$fixed = false;
		
		if(get_option('ts_fixed_route_'.$widget_id) == 1) $fixed = true;
				
		$html = '';
		
		//include plugin_dir_path( __FILE__ ) . 'quoteform_scripts_front.php';
		
		require_once plugin_dir_path( __FILE__ ) . 'class-quoteform-common.php';
        $html .= transportersQuoteFormHTML($widget_id, $widget_type, $fixed);

		echo do_shortcode($html);

		echo wp_kses($args['after_widget']);
	}

	public function form( $instance ) {
		$quoteform_id = ! empty( $instance['quoteform_id'] ) ? $instance['quoteform_id'] : 1;
		?>
		<p>
		<label for="<?php echo esc_html($this->get_field_id( 'quoteform_id' )); ?>"><?php esc_html_e( 'Select Quote Form :', 'transporters-io'); ?></label> 
        <select class="widefat" name="<?php echo esc_html($this->get_field_name( 'quoteform_id' )); ?>" id="<?php echo esc_html($this->get_field_id( 'quoteform_id' )); ?>" >
        	<option value="1" <?php if($quoteform_id == 1) echo 'selected="selected"'; ?> >Quote Form 1</option>
            <option value="2" <?php if($quoteform_id == 2) echo 'selected="selected"'; ?> >Quote Form 2</option>
            <option value="3" <?php if($quoteform_id == 3) echo 'selected="selected"'; ?> >Quote Form 3</option>
            <option value="4" <?php if($quoteform_id == 4) echo 'selected="selected"'; ?> >Quote Form 4</option>
            <option value="5" <?php if($quoteform_id == 5) echo 'selected="selected"'; ?> >Quote Form 5</option>
        </select>
		</p>
        <?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['quoteform_id'] = ( ! empty( $new_instance['quoteform_id'] ) ) ? wp_strip_all_tags( $new_instance['quoteform_id'] ) : '';
		return $instance;
	}

}
