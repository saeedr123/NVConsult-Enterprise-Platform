<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$global_settings = nvconsultv2_get_global_settings();
$brand_settings  = isset( $global_settings['brand'] ) ? $global_settings['brand'] : array();
$footer_settings = isset( $global_settings['footer'] ) ? $global_settings['footer'] : array();
$social_settings = isset( $global_settings['social'] ) ? $global_settings['social'] : array();
$social_links    = array( 'facebook_url' => 'F', 'instagram_url' => 'I', 'linkedin_url' => 'L', 'youtube_url' => 'Y' );
?>
<footer class="site-footer">
	<div class="site-footer__inner">
		<div class="footer-grid">
			<div class="footer-brand">
				<div class="footer-brand__logo">
					<?php if ( ! empty( $brand_settings['dark_logo_url'] ) ) : ?><img src="<?php echo esc_url( $brand_settings['dark_logo_url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><?php else : ?><h3><?php esc_html_e( 'NV CONSULT', 'nvconsult-theme-v2' ); ?></h3><?php endif; ?>
				</div>
				<p><?php echo esc_html( isset( $footer_settings['footer_blurb'] ) ? $footer_settings['footer_blurb'] : '' ); ?></p>
				<div class="social-links"><?php foreach ( $social_links as $key => $label ) : if ( ! empty( $social_settings[ $key ] ) ) : ?><a href="<?php echo esc_url( $social_settings[ $key ] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( str_replace( '_url', '', $key ) ) ); ?>"><?php echo esc_html( $label ); ?></a><?php endif; endforeach; ?></div>
				<form class="newsletter-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get"><label class="screen-reader-text" for="footer-newsletter"><?php esc_html_e( 'Email address', 'nvconsult-theme-v2' ); ?></label><input id="footer-newsletter" type="email" name="newsletter_email" placeholder="<?php echo esc_attr__( 'Your email address', 'nvconsult-theme-v2' ); ?>"><button type="submit" class="btn-primary"><?php esc_html_e( 'Subscribe', 'nvconsult-theme-v2' ); ?></button></form>
			</div>
			<div class="footer-column"><h3><?php esc_html_e( 'Study Abroad', 'nvconsult-theme-v2' ); ?></h3><?php wp_nav_menu( array( 'theme_location' => 'footer_study_abroad', 'container' => false, 'menu_class' => 'footer-menu', 'fallback_cb' => false ) ); ?></div>
			<div class="footer-column"><h3><?php esc_html_e( 'Work Abroad', 'nvconsult-theme-v2' ); ?></h3><?php wp_nav_menu( array( 'theme_location' => 'footer_work_abroad', 'container' => false, 'menu_class' => 'footer-menu', 'fallback_cb' => false ) ); ?></div>
			<div class="footer-column"><h3><?php esc_html_e( 'Consultation', 'nvconsult-theme-v2' ); ?></h3><?php wp_nav_menu( array( 'theme_location' => 'footer_consultation', 'container' => false, 'menu_class' => 'footer-menu', 'fallback_cb' => false ) ); ?></div>
			<div class="footer-column"><h3><?php esc_html_e( 'Company', 'nvconsult-theme-v2' ); ?></h3><?php wp_nav_menu( array( 'theme_location' => 'footer_company', 'container' => false, 'menu_class' => 'footer-menu', 'fallback_cb' => false ) ); ?></div>
		</div>
		<div class="footer-bottom"><div><?php echo esc_html( isset( $footer_settings['copyright_text'] ) ? $footer_settings['copyright_text'] : '' ); ?></div><div class="footer-bottom__links"><?php if ( ! empty( $footer_settings['privacy_url'] ) ) : ?><a href="<?php echo esc_url( $footer_settings['privacy_url'] ); ?>"><?php esc_html_e( 'Privacy Policy', 'nvconsult-theme-v2' ); ?></a><?php endif; ?><?php if ( ! empty( $footer_settings['terms_url'] ) ) : ?><a href="<?php echo esc_url( $footer_settings['terms_url'] ); ?>"><?php esc_html_e( 'Terms & Conditions', 'nvconsult-theme-v2' ); ?></a><?php endif; ?></div></div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
