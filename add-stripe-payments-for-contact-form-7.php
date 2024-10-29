<?php

/**
 * @link              https://www.pluginspro.io
 * @package           SP4CF7
 *
 * @wordpress-plugin
 * Plugin Name:       Add Stripe Payments for Contact Form 7
 * Plugin URI:        https://www.pluginspro.io
 * Description:       This plugin integrates easily into every Contact Form 7 form and allows you to manage payments through Stripe from any page of your website
 * Version:           2.0.3
 * Author:            Performa Technologies <developer1@performatechnologies.com>
 * Author URI:        https://www.pluginspro.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sp4cf7
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'is_plugin_active' ) )
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

if ( !is_plugin_active('contact-form-7/wp-contact-form-7.php') ) {
	function sp4cf7_plugin_admin_notice(){
	?>
		<div class="error"><p>
		<?php printf( __( '<b>Warning</b> : Install/Activate Contact Form 7 to activate "Add Stripe Payments for Contact Form 7 Pro" plugin', 'sp4cf7' ) ); ?>
		</p></div>
		<?php

		deactivate_plugins( str_replace('\\', '/', dirname(__FILE__)) . '/add-stripe-payments-for-contact-form-7.php' );
	}
	add_action('admin_notices', 'sp4cf7_plugin_admin_notice' );
	
} else {

	define('SP4CF7_VERSION', '2.0.3');
	define('SP4CF7_FCPATH', __FILE__);
	define('SP4CF7_PATH', trailingslashit(dirname(SP4CF7_FCPATH)));
	define('SP4CF7_URI', plugin_dir_url( __FILE__ ));


	// Do PHP version check early, so we can not include incompatible code.
	$sp4cf7_messages = array();
	if ( version_compare( phpversion(), '5.5', '<' ) ) {
		$sp4cf7_messages['php'] = __( '<strong>Add Stripe Payments for Contact Form 7</strong> requires PHP version 5.5 or above.', 'sp4cf7' );
	}

	// empty function used by pro version to check if free version is installed
	function sp4cf7_lite() {
	}

	// check if pro version is attempting to be activated - if so, then deactive this plugin
	if (function_exists('sp4cf7p_pro')) {
		deactivate_plugins('add-stripe-payments-for-contact-form-7-pro/add-stripe-payments-for-contact-form-7-pro.php');
	}

	function sp4cf7_plugin_admin_notice() {
		global $sp4cf7_messages;
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		foreach ( $sp4cf7_messages as $message ) {
			echo '<div class="error"><p>' . $message . '</p></div>';
		}
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		return;
	}

	// Bootstrap things if PHP constraint satisfied.
	if ( ! isset( $sp4cf7_messages['php'] ) ) {
		
		// Run if all dependencies satisfied.
		function run_sp4cf7() {
			global $sp4cf7_messages;

			if ( empty( $sp4cf7_messages ) ) {
				// Add autoloader.
				require_once(SP4CF7_PATH . 'autoloader.php');

				if ( is_admin() ) {
					require_once SP4CF7_PATH . 'includes/functions.php';
				}

				$sp4cf7 = new \SP4CF7\Main();
				$sp4cf7->run();
			}
		}
		add_action( 'plugins_loaded', 'run_sp4cf7', 9 );

	} else 
		add_action( 'admin_notices', 'sp4cf7_plugin_admin_notice' );

}