<?php

class yufinder_Platforms_Table extends WP_List_Table
{

    private $instanceid;

    /**
     * Constructor, we override the parent to pass our own arguments
     * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
     */
    public function __construct($instanceid)
    {
        parent::__construct(array(
            'singular' => 'yufinder_platform', //Singular label
            'plural' => 'yufinder_platforms', //plural label, also this well be one of the table css class
            'ajax' => false //We won't support Ajax for this table
        ));

        $this->instanceid = $instanceid;
    }

    /**
     * Add extra markup in the toolbars before or after the list
     * @param string $which , helps you decide if you add the markup after (bottom) or before (top) the list
     */
    public function extra_tablenav($which)
    {
        if ($which == "top") {
            //The code that goes before the table is here
            echo '<div class="wrap">';
            echo '<h1 class="wp-heading-inline">Filters</h1>';
            echo '<a href="admin.php?page=yufinder-edit-platform&instanceid=' . $this->instanceid . '" class="page-title-action">Add New</a>';
            echo '<hr class="wp-header-end">';

        }
        if ($which == "bottom") {
            //The code that goes after the table is there
            echo "</div>";
        }
    }

    /**
     * Define the columns that are going to be used in the table
     * @return array $columns, the array of columns to use with the table
     */
    public function get_columns()
    {
        return $columns = array(
            'id' => __('ID'),
            'instanceid' => __('Instance ID'),
            'name' => __('Name')
        );
    }

    /**
     * Decide which columns to activate the sorting functionality on
     * @return array $sortable, the array of columns that can be sorted by the user
     */
    public function get_sortable_columns()
    {
        return $sortable = array(
            'name' => 'Name',
        );
    }


    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();

        $perPage = 10;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args(array(
            'total_items' => $totalItems,
            'per_page' => $perPage
        ));

        $data = array_slice($data, (($currentPage - 1) * $perPage), $perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array('id', 'instanceid');
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
        global $wpdb, $OUTPUT;
        $table = $wpdb->prefix . 'yufinder_platform';
        // Prepare SQL query
        $sql = "SELECT id, instanceid, name FROM $table";
        $sql .= " WHERE instanceid = " . $this->instanceid;
        // Add sorting order
        $orderby = !empty($_GET["orderby"]) ? $_GET["orderby"] : 'name';
        $order = !empty($_GET["order"]) ? $_GET["order"] : 'asc';;
        if (!empty($orderby) && !empty($order)) {
            $sql .= ' ORDER BY ' . $orderby . ' ' . $order;
        }
        // Fetch the items
        $data = $wpdb->get_results($sql, ARRAY_A);
        $template = $OUTPUT->loadTemplate('table-actions');
        foreach ($data as $key => $value) {
            $params = [
                'name' => $value['name'],
                'actions' => [
                    [
                        'action' => 'edit',
                        'url' => admin_url(
                            'admin.php?page=yufinder-edit-platform&id='
                            . $value['id'] . '&instanceid=' . $value['instanceid']
                        ),
                        'label' => 'Edit',
                        'title' => 'Edit',
                        'separator' => ' | '
                    ],
                    [
                        'action' => 'delete',
                        'url' => $path = plugin_dir_url(dirname(__FILE__)
                            . 'admin/edit_platform.php?action=delete&id='
                            . $value['id'] . '&instanceid=' . $value['instanceid']
                        ),
                        'label' => 'Delete',
                        'title' => 'Delete',
                        'separator' => ''
                    ]
                ],
            ];
            $data[$key]['question'] = $template->render($params);
        }
        return $data;
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param Array $item Data
     * @param String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'name':
                return $item[$column_name];

            default:
                return print_r($item, true);
        }
    }

}