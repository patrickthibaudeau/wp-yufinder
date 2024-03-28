<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    yufinder
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    yufinder
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

//delete all database tables
function drop_tables()
{


    global $wpdb;

    // Prepare all table names
    $table_instance = $wpdb->prefix . 'yufinder_instance';
    $table_filter = $wpdb->prefix . 'yufinder_filter';
    $table_filter_options = $wpdb->prefix . 'yufinder_filter_options';
    $table_data_fields = $wpdb->prefix . 'yufinder_data_fields';
    $table_platform = $wpdb->prefix . 'yufinder_platform';
    $table_platform_data = $wpdb->prefix . 'yufinder_platform_data';

    // Drop tables

    $wpdb->query("DROP TABLE IF EXISTS $table_filter_options");
    $wpdb->query("DROP TABLE IF EXISTS $table_data_fields");
    $wpdb->query("DROP TABLE IF EXISTS $table_platform_data");
    $wpdb->query("DROP TABLE IF EXISTS $table_platform");
    $wpdb->query("DROP TABLE IF EXISTS $table_filter");
    $wpdb->query("DROP TABLE IF EXISTS $table_instance");

}

//drop options
function drop_options()
{
    delete_option('yufinder_db_version');
}


//run functions
drop_tables();
drop_options();



