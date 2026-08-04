<?php
/**
 * Header template.
 *
 * @package NVConsultTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site-shell">
<header class="site-header">
	<div class="site-header__inner">
		<a class="site-branding" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="site-branding__mark">NV</span>
			<span class="site-branding__text">
				<span class="site-branding__name">CONSULT</span>
				<span class="site-branding__tagline"><?php echo esc_html( get_bloginfo( 'description' ) ? get_bloginfo( 'description' ) : 'Your Global Journey Starts Here' ); ?></span>
			</span>
		</a>
		<div class="site-header__menu">
			<nav class="site-nav" aria-label="Primary navigation">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'fallback_cb'    => 'nvconsult_primary_nav_fallback',
					)
				);
				?>
			</nav>
			<a class="header-account" href="#consultation-plans">
				<span class="header-account__icon">👤</span>
				<span>My NVConsult</span>
			</a>
		</div>
	</div>
</header>
