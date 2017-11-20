<?php

if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

if ( ! class_exists( 'WPM_FastGoTo' ) ) {

	class WPM_FastGoTo {

		function __construct() {
			add_action( 'init', [ &$this, 'init' ] );
		}

		function init() {
			if ( is_admin_bar_showing() ) {
				error_log('wpm_gt_init');
				add_action( 'admin_enqueue_scripts', [&$this, 'add_assets' ] );
				add_action( 'wp_enqueue_scripts', [&$this, 'add_assets' ] );
				add_action( 'admin_bar_menu', [ &$this, 'get_locations' ] );
				add_action( 'admin_bar_menu', [&$this, 'setup_toolbar' ], 999 );
			}
		}

		function add_assets() {
			error_log('wpm_gt_init2');
			wp_register_style( 'wpm_gt_style', WPM_GT_PLUGIN_DIR_URL . 'assets/css/fgt-main.css', array(), null, 'all' );
			wp_enqueue_style( 'wpm_gt_style' );
			wp_register_script( 'wpm_gt_fuzzy',  WPM_GT_PLUGIN_DIR_URL . 'assets/js/fuzzy.js', array(), null, true );
			wp_enqueue_script( 'wpm_gt_fuzzy' );
			wp_register_script( 'wpm_gt_main',  WPM_GT_PLUGIN_DIR_URL . 'assets/js/main.js', array( 'jquery', 'wpm_gt_fuzzy' ), null, true );
			wp_enqueue_script( 'wpm_gt_main' );
		}

		function get_locations() {
			global $submenu, $menu, $pagenow;
			if ( is_admin() ) {
				error_log(print_r($menu,true));
				error_log(print_r($submenu,true));
			} else {
				// get locations from cache
			}
		}

		function setup_toolbar( $wp_admin_bar ) {
			$args = array(
				'id'    => 'wpm_gt_toolbar',
				'title' => '<input type="text" id="wpm_gt_search_input" placeholder="Fast GoTo"><ul id="wpm_gt_search_results"></ul>',
				// 'meta'  => array( 'class' => 'wpm_gt_toolbar_class' )
			);
			$wp_admin_bar->add_node( $args );
		}

	}

	$wpm_gt_class = new WPM_FastGoTo;

}