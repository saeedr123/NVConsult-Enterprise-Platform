<?php
/**
 * Front page template.
 *
 * @package NVConsultThemeV2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/homepage' );
get_footer();
