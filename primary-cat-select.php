<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://oddmotion.com
 * @since             1.0.0
 * @package           Primary_Cat_Select
 *
 * @wordpress-plugin
 * Plugin Name:       Primary Category Select
 * Plugin URI:        https://github.com/oddmotion/
 * Description:       Allows the user to choose a primary category for all post types.  Posts with primary categories selected can be displayed on a page.
 * Version:           1.0.0
 * Author:            Chris Toomajanian
 * Author URI:        https://oddmotion.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       primary-cat-select
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-primary-cat-select-activator.php
 */
function activate_primary_cat_select() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-primary-cat-select-activator.php';
	Primary_Cat_Select_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-primary-cat-select-deactivator.php
 */
function deactivate_primary_cat_select() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-primary-cat-select-deactivator.php';
	Primary_Cat_Select_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_primary_cat_select' );
register_deactivation_hook( __FILE__, 'deactivate_primary_cat_select' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-primary-cat-select.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_primary_cat_select() {

	$plugin = new Primary_Cat_Select();
	$plugin->run();

}
run_primary_cat_select();
