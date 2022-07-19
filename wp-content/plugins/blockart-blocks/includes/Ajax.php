<?php
/**
 * Class Ajax.
 *
 * @package BlockArt
 * @since x.x.x
 */

namespace BlockArt;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Class Ajax.
 *
 * @since x.x.x
 */
class Ajax {

	/**
	 * Init.
	 *
	 * @since x.x.x
	 * @return void
	 */
	public static function init() {
		self::init_hooks();
	}

	/**
	 * Init hooks.
	 *
	 * @since x.x.x
	 * @return void
	 */
	private static function init_hooks() {
		add_action( 'wp_ajax_blockart_get_library_data', array( __CLASS__, 'get_library_data' ) );
		add_action( 'wp_ajax_blockart_import_content', array( __CLASS__, 'import_content' ) );
	}

	/**
	 * Get library data.
	 *
	 * @since x.x.x
	 * @return void
	 */
	public static function get_library_data() {
		if ( ! check_ajax_referer( '_blockart_nonce', 'security', false ) ) {
			wp_send_json_error( __( 'Nonce verification failed!', 'blockart' ) );
		}

		$refresh = isset( $_POST['refresh'] ) && filter_var( wp_unslash( $_POST['refresh'] ), FILTER_VALIDATE_BOOL );

		if ( $refresh ) {
			delete_transient( '_blockart_library_data' );
		}

		$data = get_transient( '_blockart_library_data' );

		if ( empty( $data ) ) {
			$remote_data = wp_remote_post(
				'https://wpblockart.com/wp-json/blockart-library/v1/all',
				array(
					'method'  => 'POST',
					'timeout' => 120,
				)
			);

			if ( is_wp_error( $remote_data ) ) {
				wp_send_json_error( $remote_data->get_error_message() );
			}

			$data = $remote_data['body'];

			set_transient( '_blockart_library_data', $data, WEEK_IN_SECONDS );
		}

		wp_send_json_success( $data );
	}

	/**
	 * Import content.
	 *
	 * @since x.x.x
	 * @return void
	 */
	public static function import_content() {
		if ( ! check_ajax_referer( '_blockart_nonce', 'security', false ) ) {
			wp_send_json_error();
		}

		$id      = isset( $_POST['id'] ) ? absint( wp_unslash( $_POST['id'] ) ) : 0;
		$content = '';

		if ( $id ) {
			$remote_data = wp_remote_post(
				'https://wpblockart.com/wp-json/blockart-library/v1/content',
				array(
					'method'  => 'POST',
					'timeout' => 120,
					'body'    => array(
						'id' => $id,
					),
				)
			);

			if ( is_wp_error( $remote_data ) ) {
				wp_send_json_error( __( 'Failed to retrieve data!', 'blockart' ) );
			}

			$raw     = json_decode( $remote_data['body'] );
			$content = ImportHelper::process_content( $raw );
		}

		wp_send_json_success( $content );
	}
}
