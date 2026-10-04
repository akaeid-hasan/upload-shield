<?php
/**
 * UploadShield uninstall cleanup.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'upload_shield_settings' );
delete_option( 'upload_shield_activated_at' );

global $wpdb;
$wpdb->delete( $wpdb->usermeta, array( 'meta_key' => 'upload_shield_next_branding_notice' ), array( '%s' ) );
