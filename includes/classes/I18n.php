<?php

namespace SP4CF7;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    SP4CF7
 * @subpackage SP4CF7/includes
 * @author     Performa Technologies <developer1@perfomatechnologies.com>
 */
class I18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(SP4CF7_DOMAIN, false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/');

	}
}
