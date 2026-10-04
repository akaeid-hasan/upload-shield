<?php
namespace UploadShield;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {
	/**
	 * Boot the plugin.
	 */
	public static function init() {
		$settings = new Settings();
		$settings->hooks();

		$limiter = new Upload_Limiter();
		$limiter->hooks();

		$branding = new Admin_Branding();
		$branding->hooks();
	}

	/**
	 * Set defaults on first activation without overwriting existing settings.
	 */
	public static function activate() {
		if ( false === get_option( OPTION_KEY, false ) ) {
			add_option( OPTION_KEY, Settings::defaults() );
		}

		if ( false === get_option( ACTIVATED_AT_OPTION, false ) ) {
			add_option( ACTIVATED_AT_OPTION, time() );
		}
	}
}
