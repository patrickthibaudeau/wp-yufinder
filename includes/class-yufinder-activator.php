<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class yufinder_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

        global $wpdb;

        $table_instance = $wpdb->prefix . 'yufinder_instance';
        $table_filter = $wpdb->prefix . 'yufinder_filter';
        $table_filter_options = $wpdb->prefix . 'yufinder_filter_options';
        $table_data_fields = $wpdb->prefix . 'yufinder_data_fields';
        $table_platform = $wpdb->prefix . 'yufinder_platform';
        $table_platform_data = $wpdb->prefix . 'yufinder_platform_data';
        // Set charset collate
        $charset_collate = $wpdb->get_charset_collate();

        // Create instance table
        $sql_instance = "CREATE TABLE IF NOT EXISTS $table_instance (
                id int(11) NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL,
                shortname varchar(255) NOT NULL,
                usermodified int(10) NULL,
                timecreated int(16) DEFAULT 0,
                timemodified int(16) DEFAULT 0,
                PRIMARY KEY (`id`)
        ) $charset_collate;";

        // Create filter table
        $sql_filter = "CREATE TABLE IF NOT EXISTS $table_filter (
                id int(11) NOT NULL AUTO_INCREMENT,
                instanceid int(11) NOT NULL,
                question varchar(255) NOT NULL,
                sortorder int(4) DEFAULT 0,
                type varchar(25) NOT NULL,
                published int(1) DEFAULT 0,
                usermodified int(10) NULL,
                timecreated int(16) DEFAULT 0,
                timemodified int(16) DEFAULT 0,
                PRIMARY KEY (`id`)
        ) $charset_collate;";

        // Create filter options table
        $sql_filter_options = "CREATE TABLE IF NOT EXISTS $table_filter_options (
                id int(11) NOT NULL AUTO_INCREMENT,
                filterid int(11) NOT NULL,
                value varchar(255) NOT NULL,
                usermodified int(10) NULL,
                timecreated int(16) DEFAULT 0,
                timemodified int(16) DEFAULT 0,
                PRIMARY KEY (`id`)
        ) $charset_collate;";

        // Create data fields table
        $sql_data_fields = "CREATE TABLE IF NOT EXISTS $table_data_fields (
                id int(11) NOT NULL AUTO_INCREMENT,
                instanceid int(11) NOT NULL,
                name varchar(255) NOT NULL,
                shortname varchar(255) NOT NULL,
                type varchar(25) NOT NULL,
                required int(1) DEFAULT 0,
                usermodified int(10) NULL,
                timecreated int(16) DEFAULT 0,
                timemodified int(16) DEFAULT 0,
                PRIMARY KEY (`id`)
        ) $charset_collate;";

        // Create platform table
        $sql_platform = "CREATE TABLE IF NOT EXISTS $table_platform (
                id int(11) NOT NULL AUTO_INCREMENT,
                instanceid int(11) NOT NULL,
                name varchar(255) NOT NULL,
                filteroptions longtext,
                usermodified int(10) NULL,
                timecreated int(16) DEFAULT 0,
                timemodified int(16) DEFAULT 0,
                PRIMARY KEY (`id`)
        ) $charset_collate;";

        // Create platform data table
        $sql_platform_data = "CREATE TABLE IF NOT EXISTS $table_platform_data (
                id int(11) NOT NULL AUTO_INCREMENT,
                platformid int(11) NOT NULL,
                datafieldid int(11) NOT NULL,
                value longtext,
                usermodified int(10) NULL,
                timecreated int(16) DEFAULT 0,
                timemodified int(16) DEFAULT 0,
                PRIMARY KEY (`id`)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql_instance );
        dbDelta( $sql_filter );
        dbDelta( $sql_filter_options );
        dbDelta( $sql_data_fields );
        dbDelta( $sql_platform );
        dbDelta( $sql_platform_data );

        add_option( 'yufinder_db_version', YUFINDER_DB_VERSION );
	}

}
