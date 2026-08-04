<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_v2_get_posts_by_meta( $post_type, $meta_key, $meta_value, $limit = -1 ) {
	return new WP_Query(
		array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'meta_query'     => array(
				array(
					'key'   => $meta_key,
					'value' => (string) $meta_value,
				),
			),
			'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
		)
	);
}

function nvconsult_v2_get_country_institutions( $country_id ) { return nvconsult_v2_get_posts_by_meta( 'nvconsult_institution', '_nvconsult_country_id', $country_id ); }
function nvconsult_v2_get_country_jobs( $country_id ) { return nvconsult_v2_get_posts_by_meta( 'nvconsult_job', '_nvconsult_country_id', $country_id ); }
function nvconsult_v2_get_country_programs( $country_id ) { return nvconsult_v2_get_posts_by_meta( 'nvconsult_program', '_nvconsult_country_id', $country_id ); }
function nvconsult_v2_get_country_testimonials( $country_id ) { return nvconsult_v2_get_posts_by_meta( 'nvconsult_testimonial', '_nvconsult_country_id', $country_id ); }
function nvconsult_v2_get_country_articles( $country_id ) { return nvconsult_v2_get_posts_by_meta( 'nvconsult_article', '_nvconsult_country_id', $country_id ); }
function nvconsult_v2_get_featured_countries( $limit = 8 ) { return new WP_Query( array( 'post_type' => 'nvconsult_country', 'post_status' => 'publish', 'posts_per_page' => $limit, 'meta_key' => '_nvconsult_featured', 'meta_value' => '1', 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC' ) ) ); }
function nvconsult_v2_get_featured_jobs( $limit = 8 ) { return new WP_Query( array( 'post_type' => 'nvconsult_job', 'post_status' => 'publish', 'posts_per_page' => $limit, 'meta_key' => '_nvconsult_featured', 'meta_value' => '1', 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC' ) ) ); }
function nvconsult_v2_get_featured_testimonials( $limit = 6 ) { return new WP_Query( array( 'post_type' => 'nvconsult_testimonial', 'post_status' => 'publish', 'posts_per_page' => $limit, 'meta_key' => '_nvconsult_featured', 'meta_value' => '1', 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC' ) ) ); }
function nvconsult_v2_get_latest_articles( $limit = 3 ) { return new WP_Query( array( 'post_type' => 'nvconsult_article', 'post_status' => 'publish', 'posts_per_page' => $limit, 'orderby' => 'date', 'order' => 'DESC' ) ); }
