<?php
/**
Plugin Name: Fast Goto
Plugin URI: http://wordpress.org/plugins/
Description: This plugin adds a search field to admin bar which allows to quickly find and go to WordPress admin pages
Author: WordPress Monsters
Version: 1.0
Author URI: https://www.wpmonsters.org/
*/

// Make sure we don't expose any info if called directly
if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

include_once plugin_dir_path( __FILE__ ) . 'inc/fgt-core.php';
