<?php
global $OUTPUT;

$template = $OUTPUT->loadTemplate('view'); // loads __DIR__.'/views/foo.mustache';

$data = [
    'plugin_url' => plugin_dir_url(__FILE__),
    'instances' => [
        ['name' => 'foo', 'id=1'],
        ['name' => 'bar', 'id=2']
    ],
];
echo $template->render($data);
