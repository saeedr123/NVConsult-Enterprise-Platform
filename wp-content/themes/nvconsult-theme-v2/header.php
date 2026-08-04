<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$global_settings = nvconsultv2_get_global_settings();
$brand_settings  = isset( $global_settings['brand'] ) ? $global_settings['brand'] : array();
$social_settings = isset( $global_settings['social'] ) ? $global_settings['social'] : array();
$login_url       = ! empty( $social_settings['login_url'] ) ? $social_settings['login_url'] : wp_login_url();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
	<div class="site-header__inner">
		<div class="site-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr__( 'NVConsult home', 'nvconsult-theme-v2' ); ?>">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php elseif ( ! empty( $brand_settings['logo_url'] ) ) : ?>
					<img src="<?php echo esc_url( $brand_settings['logo_url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<?php else : ?>
					<span class="site-branding__mark"><?php esc_html_e( 'NV CONSULT', 'nvconsult-theme-v2' ); ?></span>
					<span class="site-branding__tagline"><?php esc_html_e( 'Study & Work Abroad Consultancy', 'nvconsult-theme-v2' ); ?></span>
				<?php endif; ?>
			</a>
		</div>
		<button class="menu-toggle" aria-expanded="false" aria-controls="primary-navigation"><span class="screen-reader-text"><?php esc_html_e( 'Toggle navigation', 'nvconsult-theme-v2' ); ?></span>&#9776;</button>
		<nav id="primary-navigation" class="nav-primary" aria-label="<?php esc_attr_e( 'Primary Navigation', 'nvconsult-theme-v2' ); ?>">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'fallback_cb' => false ) ); ?>
		</nav>
		<div class="site-header__actions"><a class="login-btn" href="<?php echo esc_url( $login_url ); ?>"><?php esc_html_e( 'My NVConsult', 'nvconsult-theme-v2' ); ?></a></div>
	</div>
</header>
