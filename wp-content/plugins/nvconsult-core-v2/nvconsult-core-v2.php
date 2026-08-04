<?php
/**
 * Plugin Name: NVConsult Core V2
 * Description: Core functionality for the NVConsult V2 platform.
 * Version: 1.0.0
 * Author: NVConsult
 * Text Domain: nvconsult-core-v2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_v2_load_plugin_files() {
	$base_path = plugin_dir_path( __FILE__ ) . 'includes/';
	$files     = array(
		'cpts.php',
		'taxonomies.php',
		'meta-boxes.php',
		'admin-menu.php',
		'homepage-builder.php',
		'hero-settings.php',
		'journey-cards.php',
		'consultation-plans.php',
		'global-settings.php',
		'search.php',
		'relationships.php',
	);

	foreach ( $files as $file ) {
		require_once $base_path . $file;
	}
}
add_action( 'plugins_loaded', 'nvconsult_v2_load_plugin_files' );

function nvconsult_v2_activate_plugin() {
	nvconsult_v2_register_cpts();
	nvconsult_v2_register_taxonomies();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'nvconsult_v2_activate_plugin' );

function nvconsult_v2_deactivate_plugin() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'nvconsult_v2_deactivate_plugin' );
