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
				error_log('wpm_fgt_init');
				add_action( 'admin_enqueue_scripts', [&$this, 'add_assets' ] );
				add_action( 'wp_enqueue_scripts', [&$this, 'add_assets' ] );
				add_action( 'admin_bar_menu', [ &$this, 'get_locations' ] );
				add_action( 'admin_bar_menu', [&$this, 'setup_toolbar' ], 999 );
			}
		}

		function add_assets() {
			error_log('wpm_fgt_init2');
			wp_register_style( 'wpm_fgt_style', WPM_FGT_PLUGIN_DIR_URL . 'assets/css/fgt-main.css', array(), null, 'all' );
			wp_enqueue_style( 'wpm_fgt_style' );
			wp_register_script( 'wpm_fgt_fuzzy',  WPM_FGT_PLUGIN_DIR_URL . 'assets/js/fuzzy.js', array(), null, true );
			wp_enqueue_script( 'wpm_fgt_fuzzy' );
			wp_register_script( 'wpm_fgt_main',  WPM_FGT_PLUGIN_DIR_URL . 'assets/js/main.js', array( 'wpm_fgt_fuzzy' ), null, true );
			wp_enqueue_script( 'wpm_fgt_main' );
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
				'id'    => 'wpm_fgt_toolbar',
				'title' => '<input type="text" class="wpm_fgt_search_input" placeholder="Fast GoTo"><ul id="wpm_fgt_search_results"></ul>',
				// 'meta'  => array( 'class' => 'wpm_fgt_toolbar_class' )
			);
			$wp_admin_bar->add_node( $args );
		}

	}

	$wpm_fgt_class = new WPM_FastGoTo;

}