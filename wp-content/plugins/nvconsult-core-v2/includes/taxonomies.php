<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_v2_register_taxonomies() {
	$taxonomies = array(
		'nvconsult_industry' => array(
			'label'        => __( 'Industries', 'nvconsult-core-v2' ),
			'post_types'   => array( 'nvconsult_job' ),
			'hierarchical' => false,
		),
		'nvconsult_faq_category' => array(
			'label'        => __( 'FAQ Categories', 'nvconsult-core-v2' ),
			'post_types'   => array( 'nvconsult_faq' ),
			'hierarchical' => true,
		),
		'nvconsult_article_category' => array(
			'label'        => __( 'Article Categories', 'nvconsult-core-v2' ),
			'post_types'   => array( 'nvconsult_article' ),
			'hierarchical' => true,
		),
		'nvconsult_article_tag' => array(
			'label'        => __( 'Article Tags', 'nvconsult-core-v2' ),
			'post_types'   => array( 'nvconsult_article' ),
			'hierarchical' => false,
		),
		'nvconsult_program_level' => array(
			'label'        => __( 'Program Levels', 'nvconsult-core-v2' ),
			'post_types'   => array( 'nvconsult_program' ),
			'hierarchical' => true,
		),
	);

	foreach ( $taxonomies as $taxonomy => $config ) {
		register_taxonomy(
			$taxonomy,
			$config['post_types'],
			array(
				'labels'            => array(
					'name'          => $config['label'],
					'singular_name' => $config['label'],
				),
				'hierarchical'      => $config['hierarchical'],
				'show_admin_column' => true,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'rewrite'           => array( 'slug' => sanitize_title( wp_strip_all_tags( $config['label'] ) ) ),
			)
		);
	}
}
add_action( 'init', 'nvconsult_v2_register_taxonomies' );
