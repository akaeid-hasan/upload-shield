<?php
namespace UploadShield;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings {
	/**
	 * Default plugin settings.
	 *
	 * @return array
	 */
	public static function defaults() {
		return array(
			'admin_enabled'      => 1,
			'admin_limit'        => 300,
			'admin_unit'         => 'KB',
			'users_enabled'      => 1,
			'users_limit'        => 300,
			'users_unit'         => 'KB',
		);
	}

	/**
	 * Register hooks.
	 */
	public function hooks() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_filter( 'plugin_action_links_' . BASENAME, array( $this, 'plugin_action_links' ) );
	}

	/**
	 * Get merged settings.
	 *
	 * @return array
	 */
	public static function get() {
		$saved = get_option( OPTION_KEY, array() );
		return wp_parse_args( is_array( $saved ) ? $saved : array(), self::defaults() );
	}

	/**
	 * Register the settings page.
	 */
	public function admin_menu() {
		add_options_page(
			__( 'UploadShield', 'upload-shield' ),
			__( 'UploadShield', 'upload-shield' ),
			'manage_options',
			'upload-shield',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Register option and sanitization.
	 */
	public function register_settings() {
		register_setting(
			'upload_shield_group',
			OPTION_KEY,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize' ),
				'default'           => self::defaults(),
			)
		);
	}

	/**
	 * Sanitize settings.
	 *
	 * @param array $input Raw settings.
	 * @return array
	 */
	public function sanitize( $input ) {
		$defaults = self::defaults();
		$input    = is_array( $input ) ? $input : array();
		$output   = array();

		$output['admin_enabled'] = ! empty( $input['admin_enabled'] ) ? 1 : 0;
		$output['users_enabled'] = ! empty( $input['users_enabled'] ) ? 1 : 0;

		$output['admin_limit'] = $this->sanitize_limit( $input['admin_limit'] ?? $defaults['admin_limit'] );
		$output['users_limit'] = $this->sanitize_limit( $input['users_limit'] ?? $defaults['users_limit'] );

		$output['admin_unit'] = $this->sanitize_unit( $input['admin_unit'] ?? $defaults['admin_unit'] );
		$output['users_unit'] = $this->sanitize_unit( $input['users_unit'] ?? $defaults['users_unit'] );


		return $output;
	}

	/**
	 * Limit values to a sensible range.
	 */
	private function sanitize_limit( $value ) {
		$value = absint( $value );
		if ( $value < 1 ) {
			$value = 1;
		}
		if ( $value > 10240 ) {
			$value = 10240;
		}
		return $value;
	}

	/**
	 * Sanitize unit.
	 */
	private function sanitize_unit( $unit ) {
		$unit = strtoupper( sanitize_text_field( $unit ) );
		return in_array( $unit, array( 'KB', 'MB' ), true ) ? $unit : 'KB';
	}

	/**
	 * Load admin CSS/JS only where needed.
	 *
	 * @param string $hook_suffix Current admin page hook.
	 */
	public function enqueue_assets( $hook_suffix ) {
		$is_settings  = 'settings_page_upload-shield' === $hook_suffix;
		$is_dashboard = 'index.php' === $hook_suffix;

		if ( ! $is_settings && ! $is_dashboard ) {
			return;
		}

		wp_enqueue_style(
			'upload-shield-admin',
			URL . 'assets/css/admin.css',
			array(),
			VERSION
		);

		wp_enqueue_script(
			'upload-shield-admin',
			URL . 'assets/js/admin.js',
			array( 'jquery' ),
			VERSION,
			true
		);

		wp_localize_script(
			'upload-shield-admin',
			'UploadShieldAdmin',
			array(
				'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
				'dismissNonce' => wp_create_nonce( 'upload_shield_dismiss_notice' ),
			)
		);
	}

	/**
	 * Add Settings link on Plugins screen.
	 *
	 * @param array $links Existing links.
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'options-general.php?page=upload-shield' ) ),
			esc_html__( 'Settings', 'upload-shield' )
		);

		array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * Human-readable limit label.
	 */
	private function limit_label( $enabled, $value, $unit ) {
		if ( ! $enabled ) {
			return __( 'No limit', 'upload-shield' );
		}
		return absint( $value ) . ' ' . esc_html( $unit );
	}

	/**
	 * Render settings page.
	 */
	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$settings = self::get();
		?>
		<div class="wrap upload-shield-wrap">
			<div class="upload-shield-shell">
				<div class="ush-brandbar">
					<div class="ush-brandbar__content">
						<span class="ush-brandbar__eyebrow"><?php esc_html_e( 'WORDPRESS SUPPORT', 'upload-shield' ); ?></span>
						<strong><?php esc_html_e( 'Need help with WordPress, Elementor or WooCommerce?', 'upload-shield' ); ?></strong>
						<span><?php esc_html_e( 'Get professional WordPress support from Akaeid Hasan.', 'upload-shield' ); ?></span>
					</div>
					<div class="ush-brandbar__actions">
						<a class="button ush-button-light" href="https://akaeidhasan.com/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Visit Website', 'upload-shield' ); ?></a>
						<a class="button ush-button-whatsapp" href="https://wa.me/8801580726459" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'WhatsApp', 'upload-shield' ); ?></a>
					</div>
				</div>

				<div class="ush-hero">
					<div class="ush-shield" aria-hidden="true">
						<svg viewBox="0 0 24 24" role="img"><path d="M12 2 20 5v6c0 5.05-3.41 9.74-8 11-4.59-1.26-8-5.95-8-11V5l8-3Zm0 3.18L7 7.05V11c0 3.45 2.13 6.86 5 7.96 2.87-1.1 5-4.51 5-7.96V7.05l-5-1.87Zm-1 3.32h2v6h-2v-6Zm0 7.5h2v2h-2v-2Z"/></svg>
					</div>
					<div>
						<div class="ush-kicker"><?php esc_html_e( 'Image Upload Protection', 'upload-shield' ); ?></div>
						<h1><?php esc_html_e( 'UploadShield', 'upload-shield' ); ?></h1>
						<p><?php esc_html_e( 'Stop oversized images before they enter your Media Library. Set separate upload limits for administrators and other users.', 'upload-shield' ); ?></p>
					</div>
					<div class="ush-status"><span></span><?php esc_html_e( 'Protection Active', 'upload-shield' ); ?></div>
				</div>

				<div class="ush-stat-grid">
					<div class="ush-stat-card"><span><?php esc_html_e( 'Administrator limit', 'upload-shield' ); ?></span><strong><?php echo esc_html( $this->limit_label( $settings['admin_enabled'], $settings['admin_limit'], $settings['admin_unit'] ) ); ?></strong></div>
					<div class="ush-stat-card"><span><?php esc_html_e( 'Other users limit', 'upload-shield' ); ?></span><strong><?php echo esc_html( $this->limit_label( $settings['users_enabled'], $settings['users_limit'], $settings['users_unit'] ) ); ?></strong></div>
				</div>

				<form method="post" action="options.php" class="ush-form">
					<?php settings_fields( 'upload_shield_group' ); ?>

					<div class="ush-grid">
						<section class="ush-card">
							<div class="ush-card__head">
								<div><span class="ush-card__icon dashicons dashicons-admin-users"></span><h2><?php esc_html_e( 'Administrator Upload Limit', 'upload-shield' ); ?></h2></div>
								<label class="ush-switch"><input type="checkbox" name="<?php echo esc_attr( OPTION_KEY ); ?>[admin_enabled]" value="1" <?php checked( $settings['admin_enabled'], 1 ); ?>><span></span></label>
							</div>
							<p><?php esc_html_e( 'Maximum image size allowed for users who can manage WordPress options.', 'upload-shield' ); ?></p>
							<div class="ush-limit-control">
								<input type="number" min="1" max="10240" name="<?php echo esc_attr( OPTION_KEY ); ?>[admin_limit]" value="<?php echo esc_attr( $settings['admin_limit'] ); ?>" aria-label="<?php esc_attr_e( 'Administrator image size limit', 'upload-shield' ); ?>">
								<select name="<?php echo esc_attr( OPTION_KEY ); ?>[admin_unit]" aria-label="<?php esc_attr_e( 'Administrator limit unit', 'upload-shield' ); ?>">
									<option value="KB" <?php selected( $settings['admin_unit'], 'KB' ); ?>>KB</option>
									<option value="MB" <?php selected( $settings['admin_unit'], 'MB' ); ?>>MB</option>
								</select>
							</div>
						</section>

						<section class="ush-card">
							<div class="ush-card__head">
								<div><span class="ush-card__icon dashicons dashicons-groups"></span><h2><?php esc_html_e( 'Other Users Upload Limit', 'upload-shield' ); ?></h2></div>
								<label class="ush-switch"><input type="checkbox" name="<?php echo esc_attr( OPTION_KEY ); ?>[users_enabled]" value="1" <?php checked( $settings['users_enabled'], 1 ); ?>><span></span></label>
							</div>
							<p><?php esc_html_e( 'Maximum image size for editors, authors, contributors, customers and other non-administrator users.', 'upload-shield' ); ?></p>
							<div class="ush-limit-control">
								<input type="number" min="1" max="10240" name="<?php echo esc_attr( OPTION_KEY ); ?>[users_limit]" value="<?php echo esc_attr( $settings['users_limit'] ); ?>" aria-label="<?php esc_attr_e( 'Other users image size limit', 'upload-shield' ); ?>">
								<select name="<?php echo esc_attr( OPTION_KEY ); ?>[users_unit]" aria-label="<?php esc_attr_e( 'Other users limit unit', 'upload-shield' ); ?>">
									<option value="KB" <?php selected( $settings['users_unit'], 'KB' ); ?>>KB</option>
									<option value="MB" <?php selected( $settings['users_unit'], 'MB' ); ?>>MB</option>
								</select>
							</div>
						</section>
					</div>


					<div class="ush-savebar">
						<div><strong><?php esc_html_e( 'UploadShield v1.0.1', 'upload-shield' ); ?></strong><span><?php esc_html_e( 'Built by Akaeid Hasan · Dhaka, Bangladesh', 'upload-shield' ); ?></span></div>
						<?php submit_button( __( 'Save UploadShield Settings', 'upload-shield' ), 'primary ush-save-button', 'submit', false ); ?>
					</div>
				</form>

				<div class="ush-author">
					<div><strong><?php esc_html_e( 'Akaeid Hasan', 'upload-shield' ); ?></strong><span><?php esc_html_e( 'WordPress Developer · Elementor · WooCommerce', 'upload-shield' ); ?></span></div>
					<div class="ush-author__links">
						<a href="mailto:akaeidhasan.bd@gmail.com">akaeidhasan.bd@gmail.com</a>
						<a href="https://akaeidhasan.com/" target="_blank" rel="noopener noreferrer">akaeidhasan.com</a>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
