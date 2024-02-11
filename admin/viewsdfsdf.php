<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    yufinder
 * @subpackage yufinder/admin
 */
// Check if page is being called from wordpress
if ( ! defined( 'WPINC' ) ) {
    die;
}
//Our class extends the WP_List_Table class, so we need to make sure that it's there
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-yufinder-instance-table.php';

$yufinder_instance_table = new yufinder_Instance_Table();
$yufinder_instance_table->prepare_items();
$yufinder_instance_table->display();
