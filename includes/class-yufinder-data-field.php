<?php

class yufinder_Data_Field
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
            'Data Fields Settings',
            'Add data field',
            'manage_options',
            'yufinder-edit-data-field',
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
        if(isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
        }
        $instanceid = $_REQUEST['instanceid'];

        // Set class property
        if ($id > 0) {
            $this->options = $wpdb->get_row(
                'SELECT * FROM ' . $wpdb->prefix . 'yufinder_data_fields WHERE id = ' . $id,
                ARRAY_A
            );
        } else {
            $this->options = array(
                'id' => 0,
                'instanceid' => $instanceid,
                'name' => '',
                'shortname' => '',
                'type' => '',
                'required' => ''
            );
        }

        $path = plugin_dir_url(dirname(__FILE__)) . 'admin/edit_data_field.php';
        ?>
        <div class="wrap">
            <h1>Edit Data Field</h1>
            <form method="post" action="<?php echo $path ?>">
                <?php
                // This prints out all hidden setting fields
                settings_fields('data_fields_group');
                do_settings_sections('yufinder-edit-data-field');
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
            'yufinder_edit_data_field', // Option name
            array($this, 'sanitize') // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            '', // Title
            array($this, 'print_section_info'), // Callback
            'yufinder-edit-data-field' // Page
        );

        add_settings_field(
            'id', // ID
            '', // Title
            array($this, 'id_callback'), // Callback
            'yufinder-edit-data-field', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'instanceid', // ID
            '', // Title
            array($this, 'instanceid_callback'), // Callback
            'yufinder-edit-data-field', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'name',
            'Name',
            array($this, 'name_callback'),
            'yufinder-edit-data-field',
            'setting_section_id'
        );

        add_settings_field(
            'shortname',
            'Short Name',
            array($this, 'shortname_callback'),
            'yufinder-edit-data-field',
            'setting_section_id'
        );
        add_settings_field(
            'type',
            'Type',
            array($this, 'type_callback'),
            'yufinder-edit-data-field',
            'setting_section_id'
        );

        add_settings_field(
            'required',
            'Required',
            array($this, 'required_callback'),
            'yufinder-edit-data-field',
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
        if (isset($input['id'])) {
            $new_input['id'] = absint($input['id']);
        }

        if (isset($input['instanceid'])) {
            $new_input['instanceid'] = absint($input['id']);
        }

        if (isset($input['name'])) {
            $new_input['name'] = sanitize_text_field($input['name']);
        }

        if (isset($input['shortname'])) {
            $new_input['shortname'] = sanitize_text_field($input['shortname']);
        }
        if (isset($input['type'])) {
            $new_input['type'] = sanitize_text_field($input['type']);
        }

        if (isset($input['required'])) {
            $new_input['required'] = absint($input['required']);
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
    public function instanceid_callback()
    {
        printf(
            '<input type="hidden" id="instanceid" name="instanceid" value="%s" />',
            isset($this->options['instanceid']) ? esc_attr($this->options['instanceid']) : ''
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
     * Get the settings option array and print one of its values
     */
    public function type_callback()
    {
        $text_selected = false;
        $textarea_selected = false;
        if (isset($this->options['type'])) {
            if (esc_attr($this->options['type']) == 'text') {
                $text_selected = 'selected';
            } else {
                $textarea_selected = 'selected';
            }
        }

        print(
            '<select id="type" name="type" required />'
            . '<option value="text" ' . $text_selected . '>Text</option>'
            . '<option value="textarea" ' . $textarea_selected . '>Textarea</option>'
            . '</select>'
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function required_callback()
    {
        $yes_selected = false;
        $no_selected = false;
        if (isset($this->options['required'])) {
            if (esc_attr($this->options['required']) == 1) {
                $yes_selected = 'selected';
            } else {
                $no_selected = 'selected';
            }
        }

        print(
            '<select id="required" name="required" required />'
            . '<option value="0" ' . $no_selected . '>No</option>'
            . '<option value="1" ' . $yes_selected . '>Yes</option>'
            . '</select>'
        );
    }
}