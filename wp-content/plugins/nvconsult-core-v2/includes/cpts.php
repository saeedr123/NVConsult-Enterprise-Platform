<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_v2_get_cpt_definitions() {
	$supports_public  = array( 'title', 'editor', 'thumbnail', 'page-attributes' );
	$supports_private = array( 'title', 'editor', 'page-attributes' );

	return array(
		'nvconsult_country' => array(
			'label'       => __( 'Countries', 'nvconsult-core-v2' ),
			'public'      => true,
			'has_archive' => true,
			'supports'    => $supports_public,
			'rewrite'     => array( 'slug' => 'country' ),
		),
		'nvconsult_institution' => array(
			'label'       => __( 'Institutions', 'nvconsult-core-v2' ),
			'public'      => true,
			'has_archive' => true,
			'supports'    => $supports_public,
			'rewrite'     => array( 'slug' => 'institution' ),
		),
		'nvconsult_program' => array(
			'label'       => __( 'Programs', 'nvconsult-core-v2' ),
			'public'      => true,
			'has_archive' => true,
			'supports'    => $supports_public,
			'rewrite'     => array( 'slug' => 'program' ),
		),
		'nvconsult_job' => array(
			'label'       => __( 'Jobs', 'nvconsult-core-v2' ),
			'public'      => true,
			'has_archive' => true,
			'supports'    => $supports_public,
			'rewrite'     => array( 'slug' => 'job' ),
		),
		'nvconsult_scholarship' => array(
			'label'       => __( 'Scholarships', 'nvconsult-core-v2' ),
			'public'      => true,
			'has_archive' => true,
			'supports'    => $supports_public,
			'rewrite'     => array( 'slug' => 'scholarship' ),
		),
		'nvconsult_article' => array(
			'label'       => __( 'Articles', 'nvconsult-core-v2' ),
			'public'      => true,
			'has_archive' => true,
			'supports'    => $supports_public,
			'rewrite'     => array( 'slug' => 'article' ),
		),
		'nvconsult_testimonial' => array(
			'label'       => __( 'Testimonials', 'nvconsult-core-v2' ),
			'public'      => false,
			'show_ui'     => true,
			'has_archive' => false,
			'supports'    => $supports_public,
		),
		'nvconsult_faq' => array(
			'label'       => __( 'FAQs', 'nvconsult-core-v2' ),
			'public'      => false,
			'show_ui'     => true,
			'has_archive' => false,
			'supports'    => $supports_private,
		),
		'nvconsult_banner' => array(
			'label'       => __( 'Banners', 'nvconsult-core-v2' ),
			'public'      => false,
			'show_ui'     => true,
			'has_archive' => false,
			'supports'    => array( 'title', 'thumbnail', 'page-attributes' ),
		),
	);
}

function nvconsult_v2_register_cpts() {
	foreach ( nvconsult_v2_get_cpt_definitions() as $post_type => $args ) {
		$labels = array(
			'name'          => $args['label'],
			'singular_name' => $args['label'],
			'add_new_item'  => sprintf( __( 'Add New %s', 'nvconsult-core-v2' ), $args['label'] ),
			'edit_item'     => sprintf( __( 'Edit %s', 'nvconsult-core-v2' ), $args['label'] ),
			'new_item'      => sprintf( __( 'New %s', 'nvconsult-core-v2' ), $args['label'] ),
			'view_item'     => sprintf( __( 'View %s', 'nvconsult-core-v2' ), $args['label'] ),
			'search_items'  => sprintf( __( 'Search %s', 'nvconsult-core-v2' ), $args['label'] ),
			'menu_name'     => $args['label'],
		);

		register_post_type(
			$post_type,
			array(
				'labels'              => $labels,
				'public'              => $args['public'],
				'show_ui'             => isset( $args['show_ui'] ) ? $args['show_ui'] : true,
				'has_archive'         => $args['has_archive'],
				'supports'            => $args['supports'],
				'rewrite'             => isset( $args['rewrite'] ) ? $args['rewrite'] : false,
				'show_in_rest'        => true,
				'menu_position'       => 25,
				'menu_icon'           => 'dashicons-admin-post',
				'publicly_queryable'  => $args['public'],
				'exclude_from_search' => ! $args['public'],
				'hierarchical'        => false,
			)
		);
	}
}
add_action( 'init', 'nvconsult_v2_register_cpts' );
