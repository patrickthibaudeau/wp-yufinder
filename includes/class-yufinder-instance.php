<?php

class yufinder_Instance
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    private $id;

    /**
     * Start up
     */
    public function __construct($id = 0)
    {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
        $this->id = $id;
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_submenu_page(
            null, // do not display as submenu option
            'Instance Settings',
            'Add instance',
            'manage_options',
            'yufinder-edit-instance',
            array($this, 'create_admin_page')
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        global $wpdb;
        $id = $_REQUEST['id'];

        // Set class property
        if ($id > 0) {
            $this->options = $wpdb->get_row(
                    'SELECT * FROM ' . $wpdb->prefix . 'yufinder_instance WHERE id = ' . $id,
                    ARRAY_A
            );
        } else {
            $this->options = array('id' => 0, 'name' => '', 'shortname' => '');
        }

        $path = plugin_dir_url(dirname(__FILE__)) . 'admin/edit_instance.php';
        ?>
        <div class="wrap">
            <h1>Edit instance</h1>
            <form method="post" action="<?php echo $path?>">
                <?php
                // This prints out all hidden setting fields
                settings_fields('my_option_group');
                do_settings_sections('yufinder-edit-instance');
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
            'yufinder_edit_instance', // Option name
            array($this, 'sanitize') // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            '', // Title
            array($this, 'print_section_info'), // Callback
            'yufinder-edit-instance' // Page
        );

        add_settings_field(
            'id', // ID
            '', // Title
            array($this, 'id_callback'), // Callback
            'yufinder-edit-instance', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'name',
            'Name',
            array($this, 'name_callback'),
            'yufinder-edit-instance',
            'setting_section_id'
        );
        add_settings_field(
            'shortname',
            'Short Name',
            array($this, 'shortname_callback'),
            'yufinder-edit-instance',
            'setting_section_id'
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
        if (isset($input['id']))
            $new_input['id'] = absint($input['id']);

        if (isset($input['name']))
            $new_input['name'] = sanitize_text_field($input['name']);

        if (isset($input['shortname']))
            $new_input['shortname'] = sanitize_text_field($input['shortname']);

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
    public function name_callback()
    {
        printf(
            '<input type="text" id="name" name="name" value="%s" required />',
            isset($this->options['name']) ? esc_attr($this->options['name']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function shortname_callback()
    {
        printf(
            '<input type="text" id="shortname" name="shortname" value="%s" required />',
            isset($this->options['shortname']) ? esc_attr($this->options['shortname']) : ''
        );
    }

    /**
     * @param $instanceid
     * @return array|object|null
     */
    public function get_data_tree() {
        global $wpdb;
        $table = $wpdb->prefix . 'yufinder_instance';
        $sql = "SELECT * FROM $table WHERE id = $this->id";
        $instance = $wpdb->get_row($sql, ARRAY_A);
//        $instance['filters'] = $this->get_filters($this->id);
        return $instance;
    }
}