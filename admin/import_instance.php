<?php
require_once('../../../../wp-load.php');
//  is this page called from wordpress?
if (!defined('WPINC')) {
    die;
}

global $wpdb;


// Get params from request
$instanceid = $_REQUEST['id'];

// Get uploaded file from json_file field
$uploaded_file = $_FILES['json_file'];
$filename = $uploaded_file['name'];
// Save in uploads directory
$upload_dir = wp_upload_dir();
$upload_path = $upload_dir['path'];
$upload_file = $upload_path . '/' . $filename;
move_uploaded_file($uploaded_file['tmp_name'], $upload_file);

// Open the file and read the contents
$handle = fopen($upload_file, "r");
$contents = fread($handle, filesize($upload_file));
fclose($handle);
// Convert json content to an array
$data = json_decode($contents);

// Prepare arrays based on the data array
$data_fields = $data->data_fields;
$filters = $data->filters;
$platforms = $data->platforms;

// Store new data fields ids in an array where the key is the original id and the value is the new id
$data_fields_values = [];
// Iterate through data_fields and insert records into the yufinder_data_fields table
foreach ($data_fields as $data_field) {
    $wpdb->insert(
        $wpdb->prefix . 'yufinder_data_fields',
        array(
            'instanceid' => $instanceid, // This is the instance id
            'name' => $data_field->name,
            'shortname' => $data_field->shortname,
            'type' => $data_field->type,
            'required' => $data_field->required,
            'usermodified' => get_current_user_id(),
            'timecreated' => time(),
            'timemodified' => time()
        ),
        array('%d','%s', '%s','%s', '%d', '%d', '%d', '%d')
    );
    // Get the id of the inserted record and store it in the $data_fields_values array
    $data_fields_values[$data_field->id] = $wpdb->insert_id;
}

// Store new filter ids in an array where the key is the original id and the value is the new id
$filter_values = [];
// Iterate through filters and insert records into the yufinder_filters table
foreach ($filters as $filter) {
    $wpdb->insert(
        $wpdb->prefix . 'yufinder_filter',
        array(
            'instanceid' => $instanceid, // This is the instance id
            'question' => $filter->question,
            'sortorder' => $filter->sortorder,
            'type' => $filter->type,
            'published' => $filter->published,
            'usermodified' => get_current_user_id(),
            'timecreated' => time(),
            'timemodified' => time()
        ),
        array('%d','%s', '%s','%s', '%d', '%d', '%d', '%d')
    );
    $new_filter_id = $wpdb->insert_id;
    // Get the id of the inserted record and store it in the $filter_values array
    $filter_values[$filter->id] = $new_filter_id;
    // Store new filter options ids in an array where the key is the original id and the value is the new id
    $filter_options_values = [];
    // Get filter options and insert records into the yufinder_filter_options table
    foreach ($filter->options as $option) {
        $wpdb->insert(
            $wpdb->prefix . 'yufinder_filter_options',
            array(
                'filterid' => $new_filter_id,
                'value' => $option->value,
                'usermodified' => get_current_user_id(),
                'timecreated' => time(),
                'timemodified' => time()
            ),
            array('%d','%s', '%s', '%d', '%d', '%d', '%d')
        );
        // Get the id of the inserted record and store it in the $filter_options_values array
        $filter_options_values[$option->id] = $wpdb->insert_id;
    }
}

// Iterate through platforms and insert records into the yufinder_platform table
foreach ($platforms as $platform) {
    // Replace values for filteroptions with new ids found on filters
    $filter_options = $platform->filteroptions;
    foreach ($filter_values as $key => $value) {
       $filter_options = str_replace($key, $value, $filter_options);
    }
    $wpdb->insert(
        $wpdb->prefix . 'yufinder_platform',
        array(
            'instanceid' => $instanceid, // This is the instance id
            'name' => $platform->name,
            'description' => $platform->description,
            'filteroptions' => $filter_options,
            'usermodified' => get_current_user_id(),
            'timecreated' => time(),
            'timemodified' => time()
        ),
        array('%d','%s', '%s','%s', '%d', '%d', '%d', '%d')
    );
    $new_platform_id = $wpdb->insert_id;
    // Store new platform data ids in an array where the key is the original id and the value is the new id
    $platform_data_values = [];
    // Get platform data and insert records into the yufinder_platform_data table
    foreach ($platform->data as $data) {
        $wpdb->insert(
            $wpdb->prefix . 'yufinder_platform_data',
            array(
                'platformid' => $new_platform_id,
                'datafieldid' => $data_fields_values[$data->datafieldid],
                'value' => $data->value,
                'usermodified' => get_current_user_id(),
                'timecreated' => time(),
                'timemodified' => time()
            ),
            array('%d','%d', '%s', '%d', '%d', '%d', '%d')
        );
    }
}
// Delete the file
unlink($upload_file);


wp_redirect(admin_url('admin.php?page=yufinder'));