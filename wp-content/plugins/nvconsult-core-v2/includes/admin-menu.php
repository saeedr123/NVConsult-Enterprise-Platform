<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_v2_register_admin_menu() {
	add_menu_page(
		__( 'NVConsult V2', 'nvconsult-core-v2' ),
		__( 'NVConsult V2', 'nvconsult-core-v2' ),
		'manage_options',
		'nvconsult-v2',
		'nvconsult_v2_render_homepage_builder_page',
		'dashicons-admin-site-alt3',
		58
	);

	add_submenu_page( 'nvconsult-v2', __( 'Homepage Builder', 'nvconsult-core-v2' ), __( 'Homepage Builder', 'nvconsult-core-v2' ), 'manage_options', 'nvconsult-v2', 'nvconsult_v2_render_homepage_builder_page' );
	add_submenu_page( 'nvconsult-v2', __( 'Hero Settings', 'nvconsult-core-v2' ), __( 'Hero Settings', 'nvconsult-core-v2' ), 'manage_options', 'nvconsult-v2-hero', 'nvconsult_v2_render_hero_settings_page' );
	add_submenu_page( 'nvconsult-v2', __( 'Journey Cards', 'nvconsult-core-v2' ), __( 'Journey Cards', 'nvconsult-core-v2' ), 'manage_options', 'nvconsult-v2-journey-cards', 'nvconsult_v2_render_journey_cards_page' );
	add_submenu_page( 'nvconsult-v2', __( 'Consultation Plans', 'nvconsult-core-v2' ), __( 'Consultation Plans', 'nvconsult-core-v2' ), 'manage_options', 'nvconsult-v2-consultation-plans', 'nvconsult_v2_render_consultation_plans_page' );
	add_submenu_page( 'nvconsult-v2', __( 'Global Settings', 'nvconsult-core-v2' ), __( 'Global Settings', 'nvconsult-core-v2' ), 'manage_options', 'nvconsult-v2-global', 'nvconsult_v2_render_global_settings_page' );
}
add_action( 'admin_menu', 'nvconsult_v2_register_admin_menu' );
