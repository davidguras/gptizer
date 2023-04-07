<?php

if ( ! class_exists( 'GPTizer_Post_Type' ) ) {
	class GPTizer_Post_Type {
		public function __construct() {
			add_action( 'init', array( $this, 'create_post_type' ) );
		}

		public function create_post_type(): void {
			register_post_type(
				'gptizer',
				array(
					'label'               => 'GPTizer',
					'description'         => 'GPTizer',
					'labels'              => array(
						'name'          => 'GPTizer',
						'singular_name' => 'GPTizer',
					),
					'public'              => true,
					'supports'            => array( 'title', 'editor', 'thumbnail' ),
					'hierarchical'        => false,
					'show_ui'             => true,
					'show_in_menu'        => false,
					'menu_position'       => 5,
					'show_in_admin_bar'   => true,
					'show_in_nav_menus'   => true,
					'can_export'          => true,
					'has_archive'         => false,
					'exclude_from_search' => false,
					'publicly_queryable'  => true,
					'show_in_rest'        => true,
					'menu_icon'           => 'dashicons-welcome-view-site',
				)
			);
		}
	}
}