<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */

$m = new Mustache_Engine;
echo $m->render('Hello, {{planet}}!', array('planet' => 'World')); // "Hello, World!"
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
