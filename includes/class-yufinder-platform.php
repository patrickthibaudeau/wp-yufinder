<?php

class yufinder_Platform
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
            'Platform Settings',
            'Add platform',
            'manage_options',
            'yufinder-edit-platform',
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
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
        }
        $instanceid = $_REQUEST['instanceid'];

        $data_fields_sql = 'Select
                        df.id as dfid,
                        df.name,
                        df.shortname,
                        df.type,
                        if (df.required = 1, "required", "optional") as required,
                        if(pd.id is null, 0, pd.id) as pdid,
                        pd.value,
                        pd.platformid
                    From
                        ' . $wpdb->prefix . 'yufinder_data_fields df 
                    Left Join
                        ' . $wpdb->prefix . 'yufinder_platform_data pd On pd.datafieldid = df.id and pd.platformid = ' . $id . '
                    Where
                        df.instanceid = ' . $instanceid;

// Execute SQL query
        $data_fields = $wpdb->get_results($data_fields_sql, ARRAY_A);

        // Set text and textarea fields
        foreach ($data_fields as $key => $value) {
            if ($value['type'] == 'text') {
                $data_fields[$key]['text'] = true;
            } else {
                $data_fields[$key]['textarea'] = true;
            }
        }

        // Get filter options
        $filter_options_sql = 'Select
                                f.id,
                                f.question,
                                f.type,
                                fo.value As text,
                                Lower(Replace(fo.value, \' \', \'_\')) As value
                             
                            From
                                ' . $wpdb->prefix . 'yufinder_filter_options fo Inner Join
                                ' . $wpdb->prefix . 'yufinder_filter f On fo.filterid = f.id
                            Where
                                f.instanceid = ' . $instanceid . '
                            Order By
                                f.sortorder';
        // Execute SQL query
        $filter_options = $wpdb->get_results($filter_options_sql, ARRAY_A);

        foreach ($filter_options as $key => $value) {
            if ($value['type'] == 'checkbox') {
                $data_fields[$key]['checkbox'] = true;
            } else {
                $data_fields[$key]['radio'] = true;
            }
        }
        // Set class property
        if ($id > 0) {

            $this->options = $wpdb->get_row(
                'SELECT * FROM ' . $wpdb->prefix . 'yufinder_platform WHERE id = ' . $id,
                ARRAY_A
            );

        } else {

            $this->options = array(
                'id' => 0,
                'instanceid' => $instanceid,
                'name' => '',
                'filteroptions' => ''
            );
        }
        // Add data_fields to options

        $this->options['data_fields'] = $data_fields;
        $this->options['filter_options'] = $filter_options;

        $path = plugin_dir_url(dirname(__FILE__)) . 'admin/edit_platform.php';
        ?>
        <div class="wrap">
            <h1>Edit Platform</h1>
            <form method="post" action="<?php echo $path ?>">
                <?php
                // This prints out all hidden setting fields
                settings_fields('platforms_group');
                do_settings_sections('yufinder-edit-platform');
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
            'yufinder-edit-platform' // Page
        );

        add_settings_field(
            'id', // ID
            '', // Title
            array($this, 'id_callback'), // Callback
            'yufinder-edit-platform', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'instanceid', // ID
            '', // Title
            array($this, 'instanceid_callback'), // Callback
            'yufinder-edit-platform', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'name',
            'Name',
            array($this, 'name_callback'),
            'yufinder-edit-platform',
            'setting_section_id'
        );

        add_settings_field(
            'description',
            'Description',
            array($this, 'description_callback'),
            'yufinder-edit-platform',
            'setting_section_id'
        );

        add_settings_field(
            'filter_options',
            'Filter Options',
            array($this, 'filter_options_callback'),
            'yufinder-edit-platform',
            'setting_section_id'
        );

        add_settings_field(
            'data_fields',
            null,
            array($this, 'data_fields_callback'),
            'yufinder-edit-platform',
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

        if (isset($input['description'])) {
            $new_input['description'] = sanitize_textarea_field($input['description']);
        }

        if (isset($input['filter_options'])) {
            $new_input['filter_options'] = sanitize_textarea_field($input['filter_options']);
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
            '<input type="text" id="name" name="name" class="question-textarea" value="%s" />',
            isset($this->options['name']) ? esc_attr($this->options['name']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function description_callback()
    {
        $html = '<textarea id="description" name="description" rows="5" class="question-textarea">';
        $html .= isset($this->options['description']) ? esc_attr($this->options['description']) : '';
        $html .= '</textarea>';
        print(
            $html
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function filter_options_callback()
    {
        global $OUTPUT;
        // Get filteroptions from platform table
        $filter_options = json_decode($this->options['filteroptions']);
        $options = [];
        $id = 0;
        foreach ($this->options['filter_options'] as $key => $value) {
            if ($id != $value['id']) {
                // Set $id to new value
                $id = $value['id'];
                // Set $x to 0. Used for select options
                $x = 0;
                $options[$id]['optiongroup'] = $value['question'];

                $options[$id]['options'][$x]['text'] = $value['text'];
                $options[$id]['options'][$x]['value'] = $id . '-' . $value['value'];
                // Check if value is in filter_options
                if (!empty($filter_options) && in_array($id . '-' . $value['value'], $filter_options)) {
                    $options[$id]['options'][$x]['selected'] = 'selected';
                }
                $x++;
            } else {
                $options[$id]['options'][$x]['text'] = $value['text'];
                $options[$id]['options'][$x]['value'] = $value['id'] . '-' . $value['value'];
                // Check if value is in filter_options
                if (!empty($filter_options) && in_array($id . '-' . $value['value'], $filter_options)) {
                    $options[$id]['options'][$x]['selected'] = 'selected';
                }
                $x++;
            }
        }
        $options = array_values($options);

        $template = $OUTPUT->loadTemplate('platform-filter-options');
        $html = $template->render(['filter-options' => $options]);
        print(
        $html
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function data_fields_callback()
    {
        global $OUTPUT;
//        print_object($this->options['data_fields']);
        $template = $OUTPUT->loadTemplate('platform-data-fields');
        $html = $template->render(['data-fields' => $this->options['data_fields']]);
        print(
        $html
        );
    }
}