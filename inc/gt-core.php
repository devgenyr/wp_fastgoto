<?php

if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

if ( ! class_exists( 'WPM_FastGoTo' ) ) {

	class WPM_FastGoTo {

		private $searchable = array();

		function __construct() {
			add_action( 'init', [ &$this, 'init' ] );
		}

		function init() {
			if ( is_admin_bar_showing() ) {
				add_action( 'admin_enqueue_scripts', [ &$this, 'add_assets' ] );
				add_action( 'wp_enqueue_scripts', [ &$this, 'add_assets' ] );
				add_action( 'admin_init', [ &$this, 'get_locations' ] );
				add_action( 'admin_bar_menu', [ &$this, 'setup_toolbar' ], 999 );
			}
		}

		function add_assets() {
			wp_register_style( 'wpm_gt_style', WPM_GT_PLUGIN_DIR_URL . 'assets/css/fgt-main.css', array(), null, 'all' );
			wp_enqueue_style( 'wpm_gt_style' );
			wp_register_script( 'wpm_gt_fuzzy',  WPM_GT_PLUGIN_DIR_URL . 'assets/js/fuzzy.js', array(), null, true );
			wp_enqueue_script( 'wpm_gt_fuzzy' );
			wp_register_script( 'wpm_gt_main',  WPM_GT_PLUGIN_DIR_URL . 'assets/js/main.js', array( 'jquery', 'wpm_gt_fuzzy' ), null, true );
			wp_enqueue_script( 'wpm_gt_main' );
			wp_add_inline_script( 'wpm_gt_main', 'var wpm_gt_admin_url = "' . admin_url() . '";' ."\n" .
			                                     'var wpm_gt_locations = ' . json_encode($this->searchable) . ';', 'before' );
		}

		function get_locations() {
			global $submenu, $menu, $pagenow;
			if ( is_admin() ) {
				$index = 0;
				foreach ( $menu as $menu_item ) {
					if ( isset( $menu_item[0] ) && ! empty( $menu_item[0] ) ) {
						$main_menu_link = isset( $menu_item[2] ) && ! empty( $menu_item[2] ) ? $menu_item[2] : '';
						$this->searchable[] = array(
							'isSubmenu' => false,
							'title' => wp_strip_all_tags( $menu_item[0], true ),
							'link' => $main_menu_link,
						);
						$offset = 0;
						foreach ( $submenu as $parent_link => $sub_items ) {
							if ( $parent_link === $main_menu_link ) {
								foreach ( $sub_items as $sub_item ) {
									if ( isset( $sub_item[0] ) && ! empty( $sub_item[0] ) ) {
										$offset += 1;
										$sub_menu_link = isset( $sub_item[2] ) && ! empty( $sub_item[2] ) ? $sub_item[2] : '';
										$this->searchable[] = array(
											'isSubmenu' => true,
											'title' => wp_strip_all_tags( $sub_item[0], true ),
											'link' => $sub_menu_link,
											'parent' => $index,
										);
									}
								}
							}
						}
						$index += $offset + 1;
					}
				}
				// error_log('wpm2');
				// error_log(print_r($this->searchable, true));
				// error_log(print_r(json_encode($this->searchable), true));
				// error_log(print_r($pagenow, true));
				// error_log(print_r($menu, true));
				// error_log(print_r($submenu,true));
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