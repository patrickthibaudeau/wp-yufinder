<?php
require_once('../../../../wp-load.php');
//  is this page called from wordpress?
if (!defined('WPINC')) {
    die;
}

$instanceid = $_REQUEST['instanceid'];

$table = $wpdb->prefix . 'yufinder_instance';
// Set instance id
if ($instanceid == 0) {
    $instanceid = $this->id;
}
//        $platform
$sql = "SELECT * FROM $table WHERE id = $instanceid";
$instance = $wpdb->get_row($sql, ARRAY_A);

// Get data from data_fields table based on instanceid
$table = $wpdb->prefix . 'yufinder_data_fields';
$sql = "SELECT * FROM $table WHERE instanceid = $instanceid";
$data_fields = $wpdb->get_results($sql, ARRAY_A);
// Add results to instance array
$instance['data_fields'] = $data_fields;

// Get data from filters table based on instanceid
$table = $wpdb->prefix . 'yufinder_filter';
$sql = "SELECT * FROM $table WHERE instanceid = $instanceid";
$filters = $wpdb->get_results($sql, ARRAY_A);
// For each $filters, get data from filter_options table
foreach ($filters as $key => $filter) {
    $table = $wpdb->prefix . 'yufinder_filter_options';
    $sql = "SELECT * FROM $table WHERE filterid = " . $filter['id'];
    $filter_options = $wpdb->get_results($sql, ARRAY_A);
//            print_object($filter_options);
    $filters[$key]['options'] = $filter_options;
}
// Add results to instance array
$instance['filters'] = $filters;

// Get data from platforms table based on instanceid
$table = $wpdb->prefix . 'yufinder_platform';
$sql = "SELECT * FROM $table WHERE instanceid = $instanceid";
$platforms = $wpdb->get_results($sql, ARRAY_A);

// For each $platforms, get data from platform_data table
foreach ($platforms as $key => $platform) {
    $table = $wpdb->prefix . 'yufinder_platform_data';
    $sql = "SELECT * FROM $table WHERE platformid = " . $platform['id'];
    $platform_data = $wpdb->get_results($sql, ARRAY_A);
    $platforms[$key]['data'] = $platform_data;
}
// Add results to instance array
$instance['platforms'] = $platforms;

// Convert to json
$json = json_encode($instance, JSON_PRETTY_PRINT);
// Download json
$filename = 'yufinder_' . strtolower(str_replace(" ","_", $instance['name'])). '.json';
header('Content-disposition: attachment; filename=' . $filename);
header('Content-type: application/json');
echo $json;