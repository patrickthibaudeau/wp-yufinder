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

$table = $wpdb->prefix . 'yufinder_data_fields';

if ($action == 'edit') {
    // Prepare parameters
    $params = [
        'instanceid' => $_REQUEST['instanceid'],
        'name' => $_REQUEST['name'],
        'shortname' => strtolower(str_replace(' ', '_', $_REQUEST['shortname'])),
        'type' => $_REQUEST['type'],
        'required' => $_REQUEST['required'],
        'usermodified' => get_current_user_id(),
        'timemodified' => time()
    ];
// Update or insert
    if ($id > 0) {
        $wpdb->update(
            $table,
            $params,
            array('id' => $id),
            array( '%d', '%s', '%s', '%s', '%d', '%d', '%d')
        );
    } else {
        $params['timecreated'] = time();
        $newid = $wpdb->insert(
            $table,
            $params,
            array( '%d', '%s', '%s', '%s', '%d', '%d', '%d', '%d')
        );
    }
} else {
    $wpdb->delete($table, array('id' => $id));
}

wp_redirect(admin_url('admin.php?page=yufinder-view-data-fields&instanceid=' . $_REQUEST['instanceid']));
