<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_v2_expand_search_post_types( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}

	$query->set(
		'post_type',
		array(
			'nvconsult_country',
			'nvconsult_institution',
			'nvconsult_program',
			'nvconsult_job',
			'nvconsult_article',
			'nvconsult_faq',
		)
	);
}
add_action( 'pre_get_posts', 'nvconsult_v2_expand_search_post_types' );
