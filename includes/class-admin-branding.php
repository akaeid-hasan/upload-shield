<?php
namespace UploadShield;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Admin_Branding {
	/**
	 * Register dashboard branding hooks.
	 */
	public function hooks() {
		add_action( 'admin_footer-index.php', array( $this, 'render_dashboard_card' ) );
		add_action( 'wp_ajax_upload_shield_dismiss_branding', array( $this, 'dismiss_branding' ) );
	}

	/**
	 * Render a small dashboard-only support card when due.
	 */
	public function render_dashboard_card() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$interval = 15;

		$user_id = get_current_user_id();
		$next    = (int) get_user_meta( $user_id, NOTICE_META_KEY, true );

		if ( ! $next ) {
			$activated_at = (int) get_option( ACTIVATED_AT_OPTION, time() );
			$next = $activated_at + ( DAY_IN_SECONDS * $interval );
		}

		if ( time() < $next ) {
			return;
		}
		?>
		<div id="upload-shield-support-card" class="ush-support-popup" role="region" aria-label="<?php esc_attr_e( 'UploadShield support', 'upload-shield' ); ?>">
			<button type="button" class="ush-support-popup__close" aria-label="<?php esc_attr_e( 'Dismiss', 'upload-shield' ); ?>">&times;</button>
			<div class="ush-support-popup__badge"><span class="dashicons dashicons-shield-alt"></span></div>
			<div class="ush-support-popup__content">
				<span class="ush-support-popup__kicker"><?php esc_html_e( 'A message from UploadShield', 'upload-shield' ); ?></span>
				<strong><?php esc_html_e( 'Need help with WordPress, Elementor or WooCommerce?', 'upload-shield' ); ?></strong>
				<p><?php esc_html_e( 'Get professional WordPress support from Akaeid Hasan.', 'upload-shield' ); ?></p>
				<div class="ush-support-popup__actions">
					<a href="https://akaeidhasan.com/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Visit Website', 'upload-shield' ); ?></a>
					<a href="https://wa.me/8801580726459" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'WhatsApp', 'upload-shield' ); ?></a>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Save the next time the dismissed card may appear.
	 */
	public function dismiss_branding() {
		check_ajax_referer( 'upload_shield_dismiss_notice', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', 'upload-shield' ) ), 403 );
		}

		$interval = 15;
		$next     = time() + ( DAY_IN_SECONDS * $interval );

		update_user_meta( get_current_user_id(), NOTICE_META_KEY, $next );
		wp_send_json_success( array( 'next' => $next ) );
	}
}
