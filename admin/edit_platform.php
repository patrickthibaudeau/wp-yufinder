<?php
require_once('../../../../wp-load.php');


/**
TODO: figure out if we want error processing on insert/update

 */
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
$data_table = $wpdb->prefix . 'yufinder_platform_data';

if (isset($_REQUEST['filter_options'])) {
    $filteroptions = json_encode($_REQUEST['filter_options']);
} else {
    $filteroptions = '';
}

if ($action == 'edit') {
    // Prepare parameters
    $params = [
        'instanceid' => $_REQUEST['instanceid'],
        'name' => $_REQUEST['name'],
        'description' => $_REQUEST['description'],
        'filteroptions' => $filteroptions,
        'usermodified' => get_current_user_id(),
        'timemodified' => time()
    ];
// Update or insert
    if ($id > 0) {
        $wpdb->update(
            $table,
            $params,
            array('id' => $id),
            array('%d', '%s', '%s', '%s', '%d', '%d' )
        );
    } else {
        $params['timecreated'] = time();
        $wpdb->insert(
            $table,
            $params,
            array('%d', '%s', '%s', '%s', '%d', '%d', '%d')
        );
        $id=$wpdb->insert_id;

    }
    // Save platform data fields
    $data = $_REQUEST['data'];

    foreach ($data as $key => $value) {
        if ((strpos($key, '_platform_data_id') !== false) || (strpos($key, '_data_field_id') !== false)) {
           continue;
        } else {
            // Get platform_data_id
            $platform_data_id = $data[$key . '_platform_data_id'];
            // Get data_field_id
            $data_field_id = $data[$key . '_data_field_id'];

            $params = [
                'platformid' => $id,
                'datafieldid' => $data_field_id,
                'value' => str_replace('\\\\', '\\', $value),
                'usermodified' => get_current_user_id(),
                'timemodified' => time()
            ];
            // Update or insert
            if ($platform_data_id > 0) {
                $wpdb->update(
                    $data_table,
                    $params,
                    array('id' => $platform_data_id),
                    array( '%d', '%d', '%s', '%d', '%d')
                );
            } else {
                $params['timecreated'] = time();
                $wpdb->insert(
                    $data_table,
                    $params,
                    array( '%d', '%d', '%s', '%d', '%d', '%d')
                );
            }
        }
    }
}
if ($action == 'delete') {
    // Delete platform data
    $wpdb->delete($data_table, array('platformid' => $id));
    $wpdb->delete($table, array('id' => $id));
}

if ($action== 'duplicate') {
    // Get platform data
    $platform = $wpdb->get_row("SELECT * FROM $table WHERE id = $id", ARRAY_A);
    // Duplicate platform
    $wpdb->insert(
        $table,
        [
            'instanceid' => $platform['instanceid'],
            'name' => $platform['name'] . ' (copy)',
            'description' => $platform['description'],
            'filteroptions' => $platform['filteroptions'],
            'usermodified' => get_current_user_id(),
            'timemodified' => time(),
            'timecreated' => time()
        ],
        array('%d', '%s', '%s', '%s', '%d', '%d', '%d')
    );
    $new_id = $wpdb->insert_id;
    // Duplicate platform data
    $platform_data = $wpdb->get_results("SELECT * FROM $data_table WHERE platformid = $id", ARRAY_A);
    foreach ($platform_data as $data) {
        $wpdb->insert(
            $data_table,
            [
                'platformid' => $new_id,
                'datafieldid' => $data['datafieldid'],
                'value' => $data['value'],
                'usermodified' => get_current_user_id(),
                'timemodified' => time(),
                'timecreated' => time()
            ],
            array('%d', '%d', '%s', '%d', '%d', '%d')
        );
    }



}



wp_redirect(admin_url('admin.php?page=yufinder-view-platforms&instanceid=' . $_REQUEST['instanceid']));
