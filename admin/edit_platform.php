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

$table = $wpdb->prefix . 'yufinder_platform';

print_object($_REQUEST);
die;

if ($action == 'edit') {
    // Prepare parameters
    $params = [
        'instanceid' => $_REQUEST['instanceid'],
        'name' => $_REQUEST['name'],
        'description' => $_REQUEST['description'],
        'usermodified' => get_current_user_id(),
        'timemodified' => time()
    ];
// Update or insert
    if ($id > 0) {
        $wpdb->update(
            $table,
            $params,
            array('id' => $id),
            array( '%d', '%s', '%s', '%d', '%d')
        );
    } else {
        $params['timecreated'] = time();
        $id = $wpdb->insert(
            $table,
            $params,
            array( '%d', '%s', '%s', '%d', '%d', '%d')
        );
    }
} else {
    $wpdb->delete($table, array('id' => $id));
}

wp_redirect(admin_url('admin.php?page=yufinder-view-data-fields&instanceid=' . $_REQUEST['instanceid']));
