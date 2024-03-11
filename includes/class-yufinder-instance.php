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
            <form method="post" action="<?php echo $path ?>">
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
    public function get_data_tree()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'yufinder_instance';
//        $platform
        $sql = "SELECT * FROM $table WHERE id = $this->id";
        $instance = $wpdb->get_row($sql, ARRAY_A);
        $instance['filters'] = $this->get_filters($this->id);
        $instance['platforms'] = $this->get_platforms($this->id);
        $instance['data_fields'] = $this->get_data_fields($this->id);
        $instance['platform_table_filter_buttons'] = $this->get_platform_filter_buttons($this->id);
        // Set platform table data
        $instance['platform_table_data'] = $instance['platforms']['table_data'];
        // Remove table data from platforms
        unset($instance['platforms']['table_data']);
// Set platform table row data
        $instance['platform_table_row_data'] = $instance['platforms']['table_row_data'];
        // Remove table data from platforms
        unset($instance['platforms']['table_row_data']);

// print_object($instance['platform_table_row_data']);
        return $instance;
    }


    private function get_data_fields($instanceid)
    {
        global $wpdb;
        $datafields_table = $wpdb->prefix . 'yufinder_data_fields';

// Get the filters
        $datafields_sql = "SELECT id,name FROM $datafields_table WHERE instanceid = $instanceid";
        $datafields = $wpdb->get_results($datafields_sql, ARRAY_A);

        return $datafields;
    }

    /**
     * get instance platforms
     * @param $instanceid int id for instance
     * @return array of platforms with data
     */
    private function get_platforms($instanceid)
    {
        global $wpdb;
        $platform_table = $wpdb->prefix . 'yufinder_platform';
        $data_table = $wpdb->prefix . 'yufinder_platform_data';
        //get platforms
        $sql = 'SELECT p.id as pid, p.name, p.description, p.filteroptions, d.id ,d.datafieldid as dataid, d.platformid, d.value
        FROM ' . $platform_table . ' as p
        LEFT JOIN ' . $data_table . ' as d on p.id = d.platformid
        WHERE p.instanceid = ' . $instanceid . '
        ORDER BY p.name, d.datafieldid';

        $platforms = $wpdb->get_results($sql, ARRAY_A);

        // return $platforms;
//         print_object($platforms);

        $data = [];
        foreach ($platforms as $platform) {
            $filter_options = json_decode($platform['filteroptions']);
            $filter_option_data = [];
            if (!empty($filter_options)) {
                foreach ($filter_options as $key => $option) {
                    $filter_option_data[$key]['name'] = $option;
                }
                $name = $platform["name"];
                if (!isset($data[$name])) {
                    $data[$name] = [
                        "name" => $name,
                        "platformid" => $platform["pid"],
                        "description" => $platform["description"],
                        "filteroptions" => $filter_option_data,
                        "data" => []
                    ];
                }
                $data[$name]["data"][] = ["dataid" => $platform["dataid"], "value" => $platform["value"]];
            }
        }

        $platforms = [];
        // Prepare data for table
        $i = 0;
        foreach ($data as $platform) {
            $platforms['table_data'][$i] = $platform;
            $i++;
        }

        // Prepare table column data
        $data_fields = $this->get_data_fields($instanceid);
        $table_data = [];
        $i = 0;

        $data_row = 0;
        foreach ($data_fields as $data_field) {
            $x = 0;
            $table_data[$i]['rows'][$x]['text'] = $data_field['name'];
            $table_data[$i]['rows'][$x]['platform_id'] = '';
            $table_data[$i]['rows'][$x]['hide'] = false;
            $x++;

            foreach ($data as $platform) {
                if (isset($platform['data'][$data_row])) {
                    $table_data[$i]['rows'][$x]['text'] = $platform['data'][$data_row]['value'];
                    $table_data[$i]['rows'][$x]['platform_id'] = $platform['platformid'];
                    $table_data[$i]['rows'][$x]['platform_name'] = $platform['name'];
                    $table_data[$i]['rows'][$x]['hide'] = true;
                    $x++;
                }
            }
            $data_row++;
            $i++;
        }

        $platforms['table_row_data'] = $table_data;

        // loop through the data and create a new array with the correct number of columns nased on the number of rows
        // number of columns for display
        $number_of_columns = 4;
        $row = 0;
        $i = 0;
        foreach ($data as $platform) {
            $platforms[$row]['columns'][] = $platform;
            $i++;
            if ($i % $number_of_columns == 0) {
                $row++;
            }
        }
        return $platforms;

    }

    /**
     * get instance filters
     * @param $instanceid int id for instance
     * @return array of filters with options
     */
    private
    function get_platform_filter_buttons($instanceid)
    {
        global $wpdb;
        $platform_table = $wpdb->prefix . 'yufinder_platform';
        $sql = "SELECT id as platformid, name FROM $platform_table WHERE instanceid = $instanceid ORDER BY name ASC";
        $platforms = $wpdb->get_results($sql, ARRAY_A);
        $data = [];
        $number_of_columns = 10;
        $row = 0;
        $i = 0;
        foreach ($platforms as $platform) {
            $data[$row]['buttons'][] = $platform;
            $i++;
            if ($i % $number_of_columns == 0) {
                $row++;
            }
        }
        return $data;
    }

    /**
     * get instance filters
     * @param $instanceid int id for instance
     * @return array of filters with options
     */
    private
    function get_filters($instanceid)
    {
        global $wpdb;
        $filter_table = $wpdb->prefix . 'yufinder_filter';
        $options_table = $wpdb->prefix . 'yufinder_filter_options';

// Get the filters
        $filter_sql = "SELECT id,question,type FROM $filter_table WHERE instanceid = $instanceid";
        $filters = $wpdb->get_results($filter_sql, ARRAY_A);

// Get the options
        $options_sql = "SELECT id,value,filterid, LOWER(REPLACE(value, ' ', '_')) AS shortname FROM $options_table";
        $options = $wpdb->get_results($options_sql, ARRAY_A);

        $options_by_filter_id = [];
        foreach ($options as $option) {
            $options_by_filter_id[$option['filterid']][] = $option;
        }

// Combine the filters with their options
        foreach ($filters as &$filter) {
            $filter['options'] = $options_by_filter_id[$filter['id']] ?? [];
        }
        unset($filter); // Unset reference to last element

        return $filters;
    }

    private
    function get_platform_table_data($instanceid)
    {
        global $wpdb;
        $datafields_table = $wpdb->prefix . 'yufinder_data_fields';
        $platformdata_table = $wpdb->prefix . 'yufinder_platform_data';

// Get the filters
        $datafields_sql = "SELECT id,name FROM $datafields_table WHERE instanceid = $instanceid";
        $datafields = $wpdb->get_results($datafields_sql, ARRAY_A);

// Get the options
        $platformdata_sql = "SELECT id,platformid,datafieldid,value FROM $platformdata_table";
        $platformdata = $wpdb->get_results($platformdata_sql, ARRAY_A);

        $platformdata_by_datafield_id = [];
        foreach ($platformdata as $platform) {
            $platformdata_by_datafield_id[$platform['datafieldid']][] = $platform;
        }

// Combine the filters with their options
        foreach ($datafields as &$datafield) {
            $datafield['platforms_data'] = $platformdata_by_datafield_id[$datafield['id']] ?? [];
        }
        unset($datafield); // Unset reference to last element


        return $datafields;
    }

    private
    function get_platform_table_title_desc($instanceid)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'yufinder_platform';

// Get the filters
        $table_sql = "SELECT id,name,description FROM $table WHERE instanceid = $instanceid";
        $result = $wpdb->get_results($table_sql, ARRAY_A);

        return $result;
    }

}