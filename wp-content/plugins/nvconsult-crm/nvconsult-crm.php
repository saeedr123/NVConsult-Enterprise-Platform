<?php
/**
 * Plugin Name: NVConsult CRM
 * Description: Lightweight CRM integration plugin for contacts and opportunities.
 * Version: 1.0.0
 * Author: NVConsult
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NVConsult_CRM {
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_types' ) );
	}

	public static function register_post_types() {
		register_post_type(
			'nvconsult_lead',
			array(
				'labels' => array(
					'name'          => __( 'Leads', 'nvconsult-crm' ),
					'singular_name' => __( 'Lead', 'nvconsult-crm' ),
				),
				'public'       => false,
				'show_ui'      => true,
				'supports'     => array( 'title', 'editor' ),
				'menu_icon'    => 'dashicons-groups',
			)
		);
	}
}

NVConsult_CRM::init();
