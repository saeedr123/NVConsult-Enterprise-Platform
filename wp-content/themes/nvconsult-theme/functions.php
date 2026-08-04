<?php
/**
 * Theme functions for NVConsult.
 *
 * @package NVConsultTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 220, 'flex-height' => true, 'flex-width' => true ) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'nvconsult-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'nvconsult_theme_setup' );

function nvconsult_theme_enqueue_assets() {
	wp_enqueue_style( 'nvconsult-theme-style', get_stylesheet_uri(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'nvconsult_theme_enqueue_assets' );

function nvconsult_primary_nav_fallback() {
	$items = array(
		__( 'Home', 'nvconsult-theme' )               => '#top',
		__( 'Work Abroad', 'nvconsult-theme' )        => '#work-abroad',
		__( 'Study Abroad', 'nvconsult-theme' )       => '#study-abroad',
		__( 'Consultation Plans', 'nvconsult-theme' ) => '#consultation-plans',
		__( 'CV Maker', 'nvconsult-theme' )           => '#resources',
		__( 'Blog', 'nvconsult-theme' )               => '#resources',
		__( 'About Us', 'nvconsult-theme' )           => '#why-choose-us',
		__( 'Contact', 'nvconsult-theme' )            => '#site-footer',
	);

	echo '<ul>';

	foreach ( $items as $label => $url ) {
		$current = '#top' === $url ? ' class="current-menu-item"' : '';
		echo '<li' . $current . '><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}

	echo '</ul>';
}

function nvconsult_get_homepage_settings() {
	$settings = get_option( 'nvconsult_homepage_settings', array() );

	$defaults = array(
		'hero_title'                  => 'Your Global Journey Starts Here.',
		'hero_study_label'            => 'Study Abroad. Work Abroad.',
		'hero_intro'                  => 'Professional Guidance Every Step of the Way.',
		'hero_primary_button_label'   => 'Study Abroad',
		'hero_primary_button_url'     => '#study-abroad',
		'hero_secondary_button_label' => 'Work Abroad',
		'hero_secondary_button_url'   => '#work-abroad',
		'pathways_title'              => 'What brings you here today?',
		'pathway_study_title'         => 'I Want to Study Abroad',
		'pathway_study_text'          => 'Explore top countries, world-class institutions and programs to build your future.',
		'pathway_work_title'          => 'I Want to Work Abroad',
		'pathway_work_text'           => 'Discover international career opportunities and take the next step in your professional journey.',
		'study_destinations_title'    => 'Featured Study Destinations',
		'opportunities_title'         => 'Featured Opportunities',
		'why_choose_title'            => 'Why Choose NVConsult?',
		'consultation_title'          => 'Consultation Plans',
		'stories_title'               => 'Success Stories',
		'resources_title'             => 'Latest Resources',
		'footer_text'                 => '© 2026 NVConsult. All Rights Reserved.',
	);

	return wp_parse_args( $settings, $defaults );
}

function nvconsult_get_homepage_value( $key, $default = '' ) {
	$settings = nvconsult_get_homepage_settings();

	return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
}
