<?php
require_once('../../../../wp-load.php');
//  is this page called from wordpress?
if (!defined('WPINC')) {
    die;
}

global $wpdb;
if (!isset($_GET['action'])) {
    $action = 'edit';
} else {
    $action = $_GET['action'];
}

// Get params from request
$id = $_REQUEST['id'];

$table = $wpdb->prefix . 'yufinder_filter';

// Get last sort order
if ($id == 0) {
    $sort_sql = "SELECT MAX(sortorder) as sortorder FROM $table WHERE instanceid = " . $_REQUEST['instanceid'];
    $sort = $wpdb->get_row($sort_sql, ARRAY_A);
    if ($sort) {
        $sortorder = $sort['sortorder'] + 1;
    } else {
        $sortorder = 0;
    }
}

if ($action == 'edit') {
    // Prepare parameters
    $params = [
        'instanceid' => $_REQUEST['instanceid'],
        'question' => $_REQUEST['question'],
        'type' => $_REQUEST['type'],
        'usermodified' => get_current_user_id(),
        'timemodified' => time()
    ];

    if ($id == 0) {
        $params['sortorder'] = $sortorder;
    }
// Update or insert
    if ($id > 0) {
        $filterid = $id;
        $wpdb->update(
            $table,
            $params,
            array('id' => $id),
            array('%d', '%s', '%s', '%d', '%d', '%d')
        );
    } else {
        $params['timecreated'] = time();
        $wpdb->insert(
            $table,
            $params,
            array('%d', '%s', '%s', '%d', '%d', '%d', '%d')
        );

        $filterid = $wpdb->insert_id;
    }
// Add filter options
    $wpdb->delete($wpdb->prefix . 'yufinder_filter_options', array('filterid' => $id));
    $filter_options = explode("\n", $_REQUEST['filter_options']);
    foreach ($filter_options as $key => $value) {
        $option = trim($value);
        if ($option != '') {
            $wpdb->insert(
                $wpdb->prefix . 'yufinder_filter_options',
                array(
                    'filterid' => $filterid,
                    'value' => $option,
                    'usermodified' => get_current_user_id(),
                    'timemodified' => time(),
                    'timecreated' => time()
                ),
                array('%d', '%s', '%d', '%d', '%d')
            );
        }
    }
} else {
    // Delete filter options
    $wpdb->delete($wpdb->prefix . 'yufinder_filter_options', array('filterid' => $id));
    $wpdb->delete($table, array('id' => $id));
}

wp_redirect(admin_url('admin.php?page=yufinder-view-filters&instanceid=' . $_REQUEST['instanceid']));