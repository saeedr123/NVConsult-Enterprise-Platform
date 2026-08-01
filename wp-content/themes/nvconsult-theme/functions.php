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
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );

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

function nvconsult_get_homepage_settings() {
	$settings = get_option( 'nvconsult_homepage_settings', array() );

	$defaults = array(
		'hero_title' => 'Study abroad with clarity and confidence',
		'hero_intro' => 'Explore opportunities, plan your journey, and connect with trusted guidance for your next move.',
		'hero_card_title' => 'Designed for the full study-abroad journey',
		'hero_card_copy' => 'From choosing a destination to preparing your application, the experience stays clear and practical at every step.',
		'section_destinations_title' => 'Featured study destinations',
		'destinations_intro' => 'Choose from a curated list of destinations that support both academic goals and lifestyle priorities.',
		'section_opportunities_title' => 'Featured opportunities',
		'opportunities_intro' => 'Explore programs, services, and support that help you move forward with confidence.',
		'section_consultation_title' => 'Consultation plans',
		'consultation_intro' => 'Choose a consultation approach that fits your stage and your priorities.',
		'consultation_card_title' => 'Start with a guided conversation',
		'consultation_card_body' => 'We help you understand your options, timeline, and next steps in a simple and structured way.',
		'section_cta_title' => 'Let’s plan your next move',
		'cta_text' => 'Start your study-abroad journey with expert support that keeps the process organised and focused.',
		'footer_text' => '© 2026 NVConsult. Built for modern operators.',
	);

	return wp_parse_args( $settings, $defaults );
}

function nvconsult_get_homepage_value( $key, $default = '' ) {
	$settings = nvconsult_get_homepage_settings();

	return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
}
