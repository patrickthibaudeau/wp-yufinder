<?php

class yufinder_Import
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_submenu_page(
            null, // do not display as submenu option
            'Import Instance',
            'Import',
            'manage_options',
            'yufinder-import-instance',
            array($this, 'create_admin_page')
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        global $wpdb;
        $id = 0;
        if (isset($_REQUEST['instanceid'])) {
            $id = $_REQUEST['instanceid'];
        }
        $table = $wpdb->prefix . 'yufinder_instance';
        $sql = "SELECT * FROM $table WHERE id = $id";
        $data = $wpdb->get_row($sql, ARRAY_A);
        $this->options = $data;

        $path = plugin_dir_url(dirname(__FILE__)) . 'admin/import_instance.php';
        ?>
        <div class="wrap">
            <form method="post" action="<?php echo $path ?>" enctype="multipart/form-data">
                <?php
                // This prints out all hidden setting fields
                settings_fields('my_option_group');
                do_settings_sections('yufinder-import-instance');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            '_group', // Option group
            'yufinder_edit_platform', // Option name
            array($this, 'sanitize') // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            '', // Title
            array($this, 'print_section_info'), // Callback
            'yufinder-import-instance' // Page
        );

        add_settings_field(
            'id', // ID
            '', // Title
            array($this, 'id_callback'), // Callback
            'yufinder-import-instance', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'json_file', // ID
            '', // Title
            array($this, 'json_file_callback'), // Callback
            'yufinder-import-instance', // Page
            'setting_section_id' // Section
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input)
    {
        $new_input = array();
        if (isset($input['id'])) {
            $new_input['id'] = absint($input['id']);
        }

        if (isset($input['json_file'])) {
            $new_input['json_file'] = sanitize_file_name($input['json_file']);
        }

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print '';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function id_callback()
    {
        printf(
            '<input type="hidden" id="id" name="id" value="%s" />',
            isset($this->options['id']) ? esc_attr($this->options['id']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function json_file_callback()
    {
        printf(
            '<input type="file" id="json_file" name="json_file" />',
            isset($this->options['id']) ? esc_attr($this->options['id']) : ''
        );
    }


}