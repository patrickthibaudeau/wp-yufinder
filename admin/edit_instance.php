<?php
global $OUTPUT, $wpdb;

$template = $OUTPUT->loadTemplate('edit_instance');

// Get id from URL. If not set, set to 0
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
} else {
    $id = 0;
}

if ($id != 0) {
    $instance = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}instances WHERE id = $id");
    $data = [
        'id' => $instance->id,
        'name' => $instance->name,
        'shortname' => $instance->description,
        'timecreated' => $instance->timecreated,
        'timemodified' => $instance->timemodified,
    ];
} else {
    $data = [
        'id' => 0,
        'name' => '',
        'description' => '',
        'timecreated' => time(),
        'timemodified' => time(),
    ];
}

echo $template->render($data);

