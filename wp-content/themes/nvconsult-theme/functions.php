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
		'hero_title' => 'Operational clarity for growth-ready teams',
		'hero_intro' => 'NVConsult helps founders and operators modernize delivery with strategy, execution, and CRM alignment under one roof.',
		'hero_primary_button_label' => 'Book a discovery call',
		'hero_primary_button_url' => '#contact',
		'hero_secondary_button_label' => 'View the roadmap',
		'hero_secondary_button_url' => '#services',
		'hero_card_title' => 'Sprints delivered with measurable momentum',
		'hero_card_copy' => 'From foundational design to launch-ready workflows, our team ships clear milestones and keeps your stakeholders informed.',
		'section_services_title' => 'What we deliver',
		'services_intro' => 'A focused set of services that cover brand, technology, CRM, and delivery operations.',
		'service_1_title' => 'Platform Strategy',
		'service_1_text' => 'Future-ready operating models tailored to the pace of your team.',
		'service_2_title' => 'Website Systems',
		'service_2_text' => 'Custom WordPress architecture designed for speed, extensibility, and editability.',
		'service_3_title' => 'Revenue Enablement',
		'service_3_text' => 'CRM flows that align technology, people, and customer experience.',
		'section_about_title' => 'Designed to feel calm, clear, and credible',
		'about_intro' => 'We combine strategy, product thinking, and execution to create premium digital experiences that support real growth.',
		'about_points' => 'Editable content blocks that remain consistent across the site.\nFlexible modules that can be adapted in future sprints.\nA strong foundation for performance and maintainability.',
		'stats_1_value' => '12+',
		'stats_1_label' => 'Years of advisory delivery',
		'stats_2_value' => '30%',
		'stats_2_label' => 'Typical workflow efficiency lift',
		'stats_3_value' => '100%',
		'stats_3_label' => 'Editable content framework',
		'stats_4_value' => '4',
		'stats_4_label' => 'Focused platform sprints',
		'about_card_title' => 'Platform blueprint',
		'about_card_body' => 'The homepage remains intentionally frozen in structure while each message, CTA, and service card can be updated through settings.',
		'section_cta_title' => 'Ready to move faster?',
		'cta_text' => 'Let us help you connect your brand, your operations, and your growth engine.',
		'cta_button_label' => 'Start a conversation',
		'cta_button_url' => '#contact',
		'footer_text' => '© 2026 NVConsult. Built for modern operators.',
	);

	return wp_parse_args( $settings, $defaults );
}

function nvconsult_get_homepage_value( $key, $default = '' ) {
	$settings = nvconsult_get_homepage_settings();

	return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
}
