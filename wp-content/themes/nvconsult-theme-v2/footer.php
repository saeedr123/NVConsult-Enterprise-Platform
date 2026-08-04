<?php
/**
 * Footer template.
 *
 * @package NVConsultThemeV2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="site-footer">
	<div class="site-footer__inner">
		<p><?php echo esc_html( nvconsultv2_get_homepage_value( 'footer_text', __( '© 2026 NVConsult.', 'nvconsult-theme-v2' ) ) ); ?></p>
		<p>Built for modern operators.</p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
