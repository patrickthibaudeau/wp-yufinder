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
$table = $wpdb->prefix . 'yufinder_instance';

if ($action == 'edit') {
    $name = $_REQUEST['name'];
    $shortname = str_replace(' ', '_', $_REQUEST['shortname']);
    $params = array(
        'name' => $name,
        'shortname' => $shortname,
        'usermodified' => get_current_user_id(),
        'timemodified' => time()
    ),
// Update or insert
    if ($id > 0) {
        $wpdb->update(
            $table,
            $params,
            array('id' => $id),
            array('%s', '%s', '%d', '%d')
        );
    } else {
        $params['timecreated'] = time();
        $newid = $wpdb->insert(
            $table,
            $params,
            array('%s', '%s', '%d', '%d', '%d')
        );
    }
} else {
    $wpdb->delete($table, array('id' => $id));
}

wp_redirect(admin_url('admin.php?page=yufinder'));
