<?php
namespace UploadShield;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Upload_Limiter {
	/**
	 * Register upload validation.
	 */
	public function hooks() {
		add_filter( 'wp_handle_upload_prefilter', array( $this, 'validate_image_size' ) );
	}

	/**
	 * Block images that exceed the configured limit.
	 *
	 * @param array $file Uploaded file data.
	 * @return array
	 */
	public function validate_image_size( $file ) {
		if ( empty( $file ) || ! is_array( $file ) || ! empty( $file['error'] ) ) {
			return $file;
		}

		if ( ! $this->is_image( $file ) ) {
			return $file;
		}

		$size = isset( $file['size'] ) ? (int) $file['size'] : 0;
		if ( $size <= 0 ) {
			return $file;
		}

		$settings = Settings::get();
		$is_admin_role = current_user_can( 'manage_options' );

		$enabled = $is_admin_role ? ! empty( $settings['admin_enabled'] ) : ! empty( $settings['users_enabled'] );
		if ( ! $enabled ) {
			return $file;
		}

		$value = $is_admin_role ? absint( $settings['admin_limit'] ) : absint( $settings['users_limit'] );
		$unit  = $is_admin_role ? $settings['admin_unit'] : $settings['users_unit'];
		$limit = $this->to_bytes( $value, $unit );

		if ( $limit > 0 && $size > $limit ) {
			$group = $is_admin_role ? __( 'administrators', 'upload-shield' ) : __( 'other users', 'upload-shield' );
			$file['error'] = sprintf(
				/* translators: 1: user group, 2: allowed size, 3: uploaded image size. */
				__( 'UploadShield blocked this image. Maximum allowed image size for %1$s is %2$s. Your image is %3$s.', 'upload-shield' ),
				$group,
				$this->format_configured_limit( $value, $unit ),
				size_format( $size, 2 )
			);
		}

		return $file;
	}

	/**
	 * Determine whether the upload is an image.
	 *
	 * Uses WordPress image MIME detection when possible, with the browser-provided
	 * MIME value only as a fallback. WordPress still performs its normal upload
	 * validation after this filter.
	 *
	 * @param array $file Uploaded file data.
	 * @return bool
	 */
	private function is_image( $file ) {
		$tmp_name = isset( $file['tmp_name'] ) ? $file['tmp_name'] : '';
		if ( $tmp_name && file_exists( $tmp_name ) && function_exists( 'wp_get_image_mime' ) ) {
			$mime = wp_get_image_mime( $tmp_name );
			if ( is_string( $mime ) && 0 === strpos( $mime, 'image/' ) ) {
				return true;
			}
		}

		$type = isset( $file['type'] ) ? strtolower( (string) $file['type'] ) : '';
		return 0 === strpos( $type, 'image/' );
	}

	/**
	 * Convert configured size to bytes.
	 */
	private function to_bytes( $value, $unit ) {
		$value = absint( $value );
		return 'MB' === strtoupper( $unit ) ? $value * MB_IN_BYTES : $value * KB_IN_BYTES;
	}

	/**
	 * Preserve the administrator's configured display unit in errors.
	 */
	private function format_configured_limit( $value, $unit ) {
		return absint( $value ) . ' ' . strtoupper( sanitize_text_field( $unit ) );
	}
}
