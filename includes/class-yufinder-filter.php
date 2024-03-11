<?php

class yufinder_Filter
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
            'Filter Settings',
            'Add filter',
            'manage_options',
            'yufinder-edit-filter',
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
                'SELECT * FROM ' . $wpdb->prefix . 'yufinder_filter WHERE id = ' . $id,
                ARRAY_A
            );
            $filter_options = $wpdb->get_results(
                'SELECT * FROM ' . $wpdb->prefix . 'yufinder_filter_options WHERE filterid = ' . $id,
                ARRAY_A
            );
            $this->options['options'] = $filter_options;
        } else {
            $this->options = array(
                'id' => 0,
                'instanceid' => $instanceid,
                'question' => '',
                'sortorder' => '',
                'type' => ''
            );
        }

        $path = plugin_dir_url(dirname(__FILE__)) . 'admin/edit_filter.php';
        ?>
        <div class="wrap">
            <h1>Edit Filter</h1>
            <form method="post" action="<?php echo $path ?>">
                <?php
                // This prints out all hidden setting fields
                settings_fields('filters_group');
                do_settings_sections('yufinder-edit-filter');
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
            'yufinder_edit_filter', // Option name
            array($this, 'sanitize') // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            '', // Title
            array($this, 'print_section_info'), // Callback
            'yufinder-edit-filter' // Page
        );

        add_settings_field(
            'id', // ID
            '', // Title
            array($this, 'id_callback'), // Callback
            'yufinder-edit-filter', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'instanceid', // ID
            '', // Title
            array($this, 'instanceid_callback'), // Callback
            'yufinder-edit-filter', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'question',
            'question',
            array($this, 'question_callback'),
            'yufinder-edit-filter',
            'setting_section_id'
        );

        add_settings_field(
            'type',
            'Type',
            array($this, 'type_callback'),
            'yufinder-edit-filter',
            'setting_section_id'
        );


        add_settings_field(
            'filter_options',
            'Filter Options',
            array($this, 'filter_options_callback'),
            'yufinder-edit-filter',
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

        if (isset($input['question'])) {
            $new_input['question'] = sanitize_textarea_field($input['question']);
        }

        if (isset($input['type'])) {
            $new_input['type'] = sanitize_text_field($input['type']);
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
    public function question_callback()
    {
        printf(
            '<textarea id="question" name="question" class="question-textarea" required>%s</textarea>',
            isset($this->options['question']) ? esc_attr($this->options['question']) : ''
        );
    }


    /**
     * Get the settings option array and print one of its values
     */
    public function type_callback()
    {
        $checkbox_selected = false;
        $radio_selected = false;
        if (isset($this->options['type'])) {
            if (esc_attr($this->options['type']) == 'checkbox') {
                $checkbox_selected = 'selected';
            } else {
                $radio_selected = 'selected';
            }
        }

        print(
            '<select id="type" name="type" required />'
            . '<option value="checkbox" ' . $checkbox_selected . '>Checkbox</option>'
            . '<option value="radio" ' . $radio_selected . '>Radio</option>'
            . '</select>'
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function filter_options_callback()
    {
        $html = '<textarea id="filter_options" name="filter_options" class="question-textarea" required>';
        if (isset($this->options['options'])) {
            foreach ($this->options['options'] as $option) {
                $html .= $option['value'] . "\n";
            }
        }
        $html .= '</textarea>';
        print(
           $html
        );
    }
}