<?php

// Vehicle Booking Custom
function taxi_booking_bn_custom_meta_vehicle() {
    add_meta_box( 'bn_meta', __( 'Vehicle Booking Custom Feilds', 'taxi-booking' ), 'taxi_booking_meta_callback_vehicle', 'post', 'normal', 'high' );
}

if (is_admin()){
  add_action('admin_menu', 'taxi_booking_bn_custom_meta_vehicle');
}

function taxi_booking_meta_callback_vehicle( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'taxi_booking_vehicle_meta_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );
    $vehicle_passenger = get_post_meta( $post->ID, 'taxi_booking_vehicle_passenger', true );
    $vehicle_price = get_post_meta( $post->ID, 'taxi_booking_vehicle_price', true );
    $vehicle_luggage = get_post_meta( $post->ID, 'taxi_booking_vehicle_luggage', true );
    ?>
    <div id="testimonials_custom_stuff">
        <table id="list">
            <tbody id="the-list" data-wp-lists="list:meta">
                <tr id="meta-8">
                    <td class="left">
                        <?php esc_html_e( 'Passenger', 'taxi-booking' )?>
                    </td>
                    <td class="left">
                        <input type="text" name="taxi_booking_vehicle_passenger" id="taxi_booking_vehicle_passenger" value="<?php echo esc_attr($vehicle_passenger); ?>" />
                    </td>
                </tr>
                <tr id="meta-8">
                    <td class="left">
                        <?php esc_html_e( 'Price', 'taxi-booking' )?>
                    </td>
                    <td class="left">
                        <input type="text" name="taxi_booking_vehicle_price" id="taxi_booking_vehicle_price" value="<?php echo esc_attr($vehicle_price); ?>" />
                    </td>
                </tr>
                <tr id="meta-8">
                    <td class="left">
                        <?php esc_html_e( 'Luggage Bags', 'taxi-booking' )?>
                    </td>
                    <td class="left">
                        <input type="text" name="taxi_booking_vehicle_luggage" id="taxi_booking_vehicle_luggage" value="<?php echo esc_attr($vehicle_luggage); ?>" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
}

/* Saves the custom meta input */
function taxi_booking_bn_metadesig_save( $post_id ) {
    if (!isset($_POST['taxi_booking_vehicle_meta_nonce']) || !wp_verify_nonce( strip_tags( wp_unslash( $_POST['taxi_booking_vehicle_meta_nonce']) ), basename(__FILE__))) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save
    if( isset( $_POST[ 'taxi_booking_vehicle_passenger' ] ) ) {
        update_post_meta( $post_id, 'taxi_booking_vehicle_passenger', strip_tags( wp_unslash( $_POST[ 'taxi_booking_vehicle_passenger' ]) ) );
    }

    if( isset( $_POST[ 'taxi_booking_vehicle_price' ] ) ) {
        update_post_meta( $post_id, 'taxi_booking_vehicle_price', strip_tags( wp_unslash( $_POST[ 'taxi_booking_vehicle_price' ]) ) );
    }

    if( isset( $_POST[ 'taxi_booking_vehicle_luggage' ] ) ) {
        update_post_meta( $post_id, 'taxi_booking_vehicle_luggage', strip_tags( wp_unslash( $_POST[ 'taxi_booking_vehicle_luggage' ]) ) );
    }
}
add_action( 'save_post', 'taxi_booking_bn_metadesig_save' );