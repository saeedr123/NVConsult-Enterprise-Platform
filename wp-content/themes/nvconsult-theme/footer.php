<?php
/**
 * Footer template.
 *
 * @package NVConsultTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="site-footer">
	<div class="site-footer__inner">
		<p><?php echo esc_html( nvconsult_get_homepage_value( 'footer_text', __( '© 2026 NVConsult.', 'nvconsult-theme' ) ) ); ?></p>
		<p>Built for modern operators.</p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
