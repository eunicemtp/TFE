<?php
namespace um\admin\core;

use WP_Post;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'um\admin\core\Admin_Columns' ) ) {


	/**
	 * Class Admin_Columns
	 * @package um\admin\core
	 */
	class Admin_Columns {

		/**
		 * Admin_Columns constructor.
		 */
		public function __construct() {

			add_filter( 'manage_edit-um_form_columns', array( &$this, 'manage_edit_um_form_columns' ) );
			add_action( 'manage_um_form_posts_custom_column', array( &$this, 'manage_um_form_posts_custom_column' ), 10, 3 );

			add_filter( 'manage_edit-um_directory_columns', array( &$this, 'manage_edit_um_directory_columns' ) );
			add_action( 'manage_um_directory_posts_custom_column', array( &$this, 'manage_um_directory_posts_custom_column' ), 10, 3 );

			add_filter( 'post_row_actions', array( &$this, 'post_row_actions' ), 99, 2 );

			// Add a post display state for special UM pages.
			add_filter( 'display_post_states', array( &$this, 'add_display_post_states' ), 10, 2 );

			add_filter( 'post_row_actions', array( &$this, 'remove_bulk_actions_um_form_inline' ), 10, 2 );
		}

		/**
		 * This will remove the "Edit" bulk action, which is actually quick edit.
		 *
		 * @param array $actions
		 * @param WP_Post $post
		 *
		 * @return array
		 */
		public function remove_bulk_actions_um_form_inline( $actions, $post ) {
			$remove_quick_edit = array(
				'um_form',
				'um_directory',
			);
			$remove_quick_edit = apply_filters( 'um_cpt_remove_quick_edit', $remove_quick_edit );

			if ( in_array( $post->post_type, $remove_quick_edit, true ) ) {
				unset( $actions['inline hide-if-no-js'] );
			}

			return $actions;
		}

		/**
		 * Custom row actions
		 *
		 * @param array $actions
		 * @param WP_Post $post
		 *
		 * @return mixed
		 */
		public function post_row_actions( $actions, $post ) {
			//check for your post type
			if ( 'um_form' === $post->post_type ) {
				$actions['um_duplicate'] = '<a href="' . esc_url( $this->duplicate_uri( $post->ID ) ) . '">' . __( 'Duplicate', 'ultimate-member' ) . '</a>';
			}
			return $actions;
		}

		/**
		 * Duplicate a form
		 *
		 * @param int $id
		 *
		 * @return string
		 */
		private function duplicate_uri( $id ) {
			$url = add_query_arg(
				array(
					'post_type'     => 'um_form',
					'um_adm_action' => 'duplicate_form',
					'post_id'       => $id,
					'_wpnonce'      => wp_create_nonce( "um-duplicate_form{$id}" ),
				),
				admin_url( 'edit.php' )
			);

			return $url;
		}

		/**
		 * Custom columns for Form
		 *
		 * @param array $columns
		 *
		 * @return array
		 */
		function manage_edit_um_form_columns( $columns ) {
			$new_columns['cb'] = '<input type="checkbox" />';
			$new_columns['title'] = __( 'Title', 'ultimate-member' );
			$new_columns['id'] = __('ID', 'ultimate-member' );
			$new_columns['mode'] = __( 'Type', 'ultimate-member' );
			$new_columns['is_default'] = __( 'Default', 'ultimate-member' );
			$new_columns['shortcode'] = __( 'Shortcode', 'ultimate-member' );
			$new_columns['date'] = __( 'Date', 'ultimate-member' );

			return $new_columns;
		}


		/**
		 * Custom columns for Directory
		 *
		 * @param array $columns
		 *
		 * @return array
		 */
		function manage_edit_um_directory_columns( $columns ) {
			$new_columns['cb'] = '<input type="checkbox" />';
			$new_columns['title'] = __( 'Title', 'ultimate-member' );
			$new_columns['id'] = __( 'ID', 'ultimate-member' );
			$new_columns['is_default'] = __( 'Default', 'ultimate-member' );
			$new_columns['shortcode'] = __( 'Shortcode', 'ultimate-member' );
			$new_columns['date'] = __( 'Date', 'ultimate-member' );

			return $new_columns;
		}


		/**
		 * Display custom columns for Form
		 *
		 * @param string $column_name
		 * @param int $id
		 */
		function manage_um_form_posts_custom_column( $column_name, $id ) {
			switch ( $column_name ) {
				case 'id':
					echo '<span class="um-admin-number">'.$id.'</span>';
					break;

				case 'shortcode':
					$is_default = UM()->query()->get_attr( 'is_default', $id );

					if ( $is_default ) {
						echo UM()->shortcodes()->get_default_shortcode( $id );
					} else {
						echo UM()->shortcodes()->get_shortcode( $id );
					}

					break;

				case 'is_default':
					$is_default = UM()->query()->get_attr( 'is_default', $id );
					echo empty( $is_default ) ? __( 'No', 'ultimate-member' ) : __( 'Yes', 'ultimate-member' );
					break;

				case 'mode':
					$mode = UM()->query()->get_attr( 'mode', $id );
					echo UM()->form()->display_form_type( $mode, $id );
					break;
			}
		}


		/**
		 * Display custom columns for Directory
		 *
		 * @param string $column_name
		 * @param int $id
		 */
		function manage_um_directory_posts_custom_column( $column_name, $id ) {
			switch ( $column_name ) {
				case 'id':
					echo '<span class="um-admin-number">'.$id.'</span>';
					break;
				case 'shortcode':
					$is_default = UM()->query()->get_attr( 'is_default', $id );

					if ( $is_default ) {
						echo UM()->shortcodes()->get_default_shortcode( $id );
					} else {
						echo UM()->shortcodes()->get_shortcode( $id );
					}
					break;
				case 'is_default':
					$is_default = UM()->query()->get_attr( 'is_default', $id );
					echo empty( $is_default ) ? __( 'No', 'ultimate-member' ) : __( 'Yes', 'ultimate-member' );
					break;
			}
		}


		/**
		 * Add a post display state for special UM pages in the page list table.
		 *
		 * @param array $post_states An array of post display states.
		 * @param WP_Post $post The current post object.
		 *
		 * @return mixed
		 */
		public function add_display_post_states( $post_states, $post ) {

			foreach ( UM()->config()->core_pages as $page_key => $page_value ) {
				$page_id = UM()->options()->get( UM()->options()->get_predefined_page_option_key( $page_key ) );

				if ( $page_id == $post->ID ) {
					$post_states[ 'um_core_page_' . $page_key ] = sprintf( 'UM %s', $page_value['title'] );
				}
			}

			return $post_states;
		}

	}
}
