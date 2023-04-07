<?php
/*
Plugin Name: GPTizer
Plugin URI: https://example.com/gptizer
Description: ChatGPT content improvement plugin
Version: 1.0
Author: David Guras
Author URI: https://www.example.com
License: GPL2
*/

/*
GPTizer is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

GPTizer is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with GPTizer. If not, see {https://www.gnu.org/licenses/gpl-2.0.html}.
*/

// The following line prevents direct access to the plugin file.
defined('ABSPATH') or die('Direct access not allowed.');

if ( ! class_exists( 'GPTizer' ) ) {
	class GPTizer {
		public function __construct() {
			$this->define_constants();

			// add plugin menu item in WordPress dashboard
			add_action( 'admin_menu', array( $this, 'add_menu' ) );

			require_once( GPTIZER_PATH . 'post-types/class.gptizer-cpt.php' );
			$GPTizer_Post_Type = new GPTizer_Post_Type();

			require_once( GPTIZER_PATH . '/class.gptizer-settings.php' );
			$GPTizer_Settings = new GPTizer_Settings();
		}

		public function define_constants(): void {
			define( 'GPTIZER_PATH', plugin_dir_path( __FILE__ ) );
			define( 'GPTIZER_URL', plugin_dir_url( __FILE__ ) );
			define( 'GPTIZER_VERSION', '1.0.0' );
		}

		public static function activate(): void {
			update_option( 'rewrite_rules', '' );
		}

		public static function deadctivate(): void {
			flush_rewrite_rules();
			unregister_post_type( 'gptizer' );
		}

		public static function uninstall(): void {
		}

		public function add_menu(): void {
			add_menu_page(
				'GPTizer Options',
				'GPTizer',
				'manage_options',
				'gptizer_admin',
				array( $this, 'gtpizer_settings_page' ),
				'dashicons-welcome-view-site',
			);

			add_submenu_page(
				'gtpizer_admin',
				'Manage Slides',
				'Manage Slides',
				'manage_options',
				'edit.php?post_type=gptizer',
				null,
			);

			add_submenu_page(
				'gtpizer_admin',
				'Add New Slide',
				'Add New Slide',
				'manage_options',
				'post-new.php?post_type=gptizer',
				null,
			);
		}

		public function gtpizer_settings_page(): void {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}
			if ( isset( $_GET[ 'settings-updated' ] ) ) {
				add_settings_error( 'gtpizer_options', 'gtpizer_message', 'Settings Saved', 'success' );
			}
			settings_errors( 'gtpizer_options' );

			require( GPTIZER_PATH . 'views/class.gptizer-settings.php' );
		}
	}
}

if ( class_exists( 'GPTizer' ) ) {
	register_activation_hook( __FILE__, array( 'GPTizer', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'GPTizer', 'deactivate' ) );
	register_uninstall_hook( __FILE__, array( 'GPTizer', 'uninstall' ) );
	$gtpizer = new GPTizer();
}