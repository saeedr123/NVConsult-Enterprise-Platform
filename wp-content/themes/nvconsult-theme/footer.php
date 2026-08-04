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
<footer class="site-footer" id="site-footer">
	<div class="site-footer__inner">
		<div class="footer-brand">
			<div class="footer-brand__mark">NV</div>
			<div class="footer-brand__name">CONSULT</div>
			<p class="footer-brand__copy">We help students and professionals achieve their dreams of studying and working abroad.</p>
			<div class="footer-socials" aria-label="Social links">
				<span>f</span>
				<span>◎</span>
				<span>in</span>
				<span>▶</span>
			</div>
		</div>
		<div class="footer-links">
			<h3>Study Abroad</h3>
			<ul>
				<li><a href="#featured-destinations">Countries</a></li>
				<li><a href="#study-abroad">Institutions</a></li>
				<li><a href="#study-abroad">Programs</a></li>
				<li><a href="#consultation-plans">Scholarships</a></li>
				<li><a href="#resources">Visa Guide</a></li>
				<li><a href="#resources">FAQs</a></li>
			</ul>
		</div>
		<div class="footer-links">
			<h3>Work Abroad</h3>
			<ul>
				<li><a href="#featured-opportunities">All Opportunities</a></li>
				<li><a href="#featured-opportunities">Countries</a></li>
				<li><a href="#featured-opportunities">Industries</a></li>
				<li><a href="#featured-opportunities">Visa Sponsorship</a></li>
				<li><a href="#consultation-plans">Recruitment Process</a></li>
				<li><a href="#resources">FAQs</a></li>
			</ul>
		</div>
		<div class="footer-links">
			<h3>Consultation</h3>
			<ul>
				<li><a href="#consultation-plans">Consultation Plans</a></li>
				<li><a href="#consultation-plans">Book Consultation</a></li>
				<li><a href="#consultation-plans">Full Support</a></li>
				<li><a href="#consultation-plans">Free Consultation</a></li>
			</ul>
		</div>
		<div class="newsletter">
			<h3>Newsletter</h3>
			<p class="newsletter__text">Subscribe to get the latest updates and opportunities.</p>
			<form class="newsletter__field">
				<label class="screen-reader-text" for="newsletter-email">Email address</label>
				<input id="newsletter-email" type="email" name="newsletter-email" placeholder="Enter your email">
				<button type="submit">Subscribe</button>
			</form>
		</div>
	</div>
	<div class="site-footer__bottom">
		<p><?php echo esc_html( nvconsult_get_homepage_value( 'footer_text', __( '© 2026 NVConsult. All Rights Reserved.', 'nvconsult-theme' ) ) ); ?></p>
		<p><a href="#top">Privacy Policy</a> &nbsp; | &nbsp; <a href="#top">Terms &amp; Conditions</a></p>
	</div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
