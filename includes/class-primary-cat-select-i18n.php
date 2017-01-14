<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://oddmotion.com
 * @since      1.0.0
 *
 * @package    Primary_Cat_Select
 * @subpackage Primary_Cat_Select/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Primary_Cat_Select
 * @subpackage Primary_Cat_Select/includes
 * @author     Chris Toomajanian <chris@oddmotion.com>
 */
class Primary_Cat_Select_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'primary-cat-select',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
