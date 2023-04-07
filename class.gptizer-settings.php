<?php

if ( ! class_exists( "GPTizer_Settings" ) ) {
	class GPTizer_Settings {
		public static mixed $options;

		public function __construct() {
			self::$options = get_option( 'gptizer_options' );
			add_action( 'admin_init', array( $this, 'admin_init' ) );
		}

		public function admin_init(): void {
			register_setting( 'gptizer_group', 'gptizer_options', array( $this, 'gptizer_validate' ) );

		}
	}
}