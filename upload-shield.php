<?php
/**
 * Plugin Name:       UploadShield
 * Plugin URI:        https://akaeidhasan.com/
 * Description:       Control maximum WordPress image upload sizes for administrators and other users with a clean, lightweight settings interface.
 * Version:           1.0.1
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Akaeid Hasan
 * Author URI:        https://akaeidhasan.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       upload-shield
 * Domain Path:       /languages
 */

namespace UploadShield;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const VERSION = '1.0.1';
const OPTION_KEY = 'upload_shield_settings';
const ACTIVATED_AT_OPTION = 'upload_shield_activated_at';
const NOTICE_META_KEY = 'upload_shield_next_branding_notice';

// Paths and URLs.
define( __NAMESPACE__ . '\\FILE', __FILE__ );
define( __NAMESPACE__ . '\\DIR', plugin_dir_path( __FILE__ ) );
define( __NAMESPACE__ . '\\URL', plugin_dir_url( __FILE__ ) );
define( __NAMESPACE__ . '\\BASENAME', plugin_basename( __FILE__ ) );

require_once DIR . 'includes/class-settings.php';
require_once DIR . 'includes/class-upload-limiter.php';
require_once DIR . 'includes/class-admin-branding.php';
require_once DIR . 'includes/class-plugin.php';

register_activation_hook( __FILE__, array( __NAMESPACE__ . '\\Plugin', 'activate' ) );

Plugin::init();
