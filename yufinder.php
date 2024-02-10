<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://yorku.ca
 * @since             1.0.0
 * @package           yufinder
 *
 * @wordpress-plugin
 * Plugin Name:       York University Finder
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This plugin is used to find York University Research Storge.
 * Version:           1.0.0
 * Author:            York University UIT Innovation
 * Author URI:        https://yorku.ca
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       yufinder
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'YUFINDER_VERSION', '1.0.0' );

/**
 * DB Version for plugin
 */
define( 'YUFINDER_DB_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_yufinder() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-yufinder-activator.php';
    yufinder_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_yufinder
() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-yufinder-deactivator.php';
    yufinder_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_yufinder' );
register_deactivation_hook( __FILE__, 'deactivate_yufinder' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-yufinder.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_yufinder() {

    $plugin = new yufinder();
    $plugin->run();

}
run_yufinder();
