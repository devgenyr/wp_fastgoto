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
				add_action( 'admin_bar_menu', [&$this, 'setup_toolbar' ], 999 );
				add_action( 'admin_enqueue_scripts', [&$this, 'add_assets' ] );
			}
		}

		function add_assets() {
			error_log('wpm_fgt_init2');
			wp_register_style( 'wpm_fgt_style', plugins_url( '../assets/css/fgt-main.css', __FILE__ ), array(), null, 'all' );
			wp_enqueue_style( 'wpm_fgt_style' );
		}

		function setup_toolbar( $wp_admin_bar ) {
			$args = array(
				'id'    => 'wpm_fgt_toolbar',
				'title' => '<input type="text" class="wpm_fgt_search_input" placeholder="GoTo">',
				// 'meta'  => array( 'class' => 'wpm_fgt_toolbar_class' )
			);
			$wp_admin_bar->add_node( $args );
		}

	}

	$wpm_fgt_class = new WPM_FastGoTo;

}