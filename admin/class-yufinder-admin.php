<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *u
 * @package    plugin_name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class yufinder_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/yufinder-admin.css',
            array(),
            $this->version,
            'all'
        );
		wp_enqueue_style(
            $this->plugin_name . '_datatables',
            plugin_dir_url( __FILE__ ) . 'css/datatables.min.css',
            array(),
            $this->version,
            'all'
        );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'js/yufinder-admin.js',
            array( 'jquery' ),
            $this->version,
            false
        );
	}

    /**
     * Options page html
     * @return void
     */
    public function options_page_html() {
        if(!class_exists('WP_List_Table')){
            require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
        }

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-yufinder-instance-table.php';

        $yufinder_instance_table = new yufinder_Instance_Table();
        $yufinder_instance_table->prepare_items();
        $yufinder_instance_table->display();
    }
    // Add options page
    public function options_page()
    {
        add_menu_page(
            'Yufinder Plugin',
            'Yufinder Options',
            'manage_options',
            'yufinder',
            [$this, 'options_page_html'],
            'dashicons-admin-generic',
            20
        );
    }

    /**
     * Data Fields page html
     */
    public function data_fields_page_html()
    {
        if (!class_exists('WP_List_Table')) {
            require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
        }

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-yufinder-data-fields-table.php';
        $instanceid = $_REQUEST['instanceid'];
        $yufinder_data_fields_table = new yufinder_Data_Fields_Table($instanceid);
        $yufinder_data_fields_table->prepare_items();
        $yufinder_data_fields_table->display();
    }

    // Load submenu page
    public function data_fields_page()
    {
        // Get instance id
        add_submenu_page(
            null, // do not display as submenu option
            'Data Fields',
            'Data Fields',
            'manage_options',
            'yufinder-view-data-fields',
            [$this, 'data_fields_page_html']
        );
    }

    /**
     * Filter page html
     */
    public function filters_page_html()
    {
        if (!class_exists('WP_List_Table')) {
            require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
        }

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-yufinder-filters-table.php';
        $instanceid = $_REQUEST['instanceid'];
        $yufinder_data_fields_table = new yufinder_Filters_Table($instanceid);
        $yufinder_data_fields_table->prepare_items();
        $yufinder_data_fields_table->display();
    }

    // Load submenu page
    public function filters_page()
    {
        // Get instance id
        add_submenu_page(
            null, // do not display as submenu option
            'Filters',
            'Filters',
            'manage_options',
            'yufinder-view-filters',
            [$this, 'filters_page_html']
        );
    }

    /**
     * Platform page html
     */
    public function platforms_page_html()
    {
        if (!class_exists('WP_List_Table')) {
            require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
        }

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-yufinder-platforms-table.php';
        $instanceid = $_REQUEST['instanceid'];
        $yufinder_data_fields_table = new yufinder_Platforms_Table($instanceid);
        $yufinder_data_fields_table->prepare_items();
        $yufinder_data_fields_table->display();
    }

    // Load submenu page
    public function platforms_page()
    {
        // Get instance id
        add_submenu_page(
            null, // do not display as submenu option
            'Platforms',
            'Platforms',
            'manage_options',
            'yufinder-view-platforms',
            [$this, 'platforms_page_html']
        );
    }

    public function import_page_html() {
        global $wpdb;
        $instanceid = $_REQUEST['instanceid'];
        // Get record form db
        $table = $wpdb->prefix . 'yufinder_instance';
        $sql = "SELECT * FROM $table WHERE id = $instanceid";
        $data = $wpdb->get_row($sql, ARRAY_A);
        echo '<div class="wrap"><h2>Import for ' . $data['name'] . '</h2></div>';
    }

    public function import_page()
    {
        // Get instance id
        add_submenu_page(
            null, // do not display as submenu option
            'Import',
            'Import',
            'manage_options',
            'yufinder-import-instance',
            [$this, 'import_page_html']
        );
    }

}
