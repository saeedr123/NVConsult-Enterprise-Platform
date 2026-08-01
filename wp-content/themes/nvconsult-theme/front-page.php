<?php
/**
 * Front page template for the approved homepage.
 *
 * @package NVConsultTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content">
	<section class="hero">
		<div class="hero__inner">
			<div class="hero__content">
				<div>
					<h1><?php echo esc_html( nvconsult_get_homepage_value( 'hero_title', 'Study abroad with clarity and confidence' ) ); ?></h1>
					<p><?php echo esc_html( nvconsult_get_homepage_value( 'hero_intro', 'Explore opportunities, plan your journey, and connect with trusted guidance for your next move.' ) ); ?></p>
					<div class="hero__actions">
						<a class="button button--primary" href="#consultation">Book a consultation</a>
						<a class="button button--secondary" href="#destinations">Discover destinations</a>
					</div>
				</div>
				<div class="hero__card">
					<h3><?php echo esc_html( nvconsult_get_homepage_value( 'hero_card_title', 'Designed for the full study-abroad journey' ) ); ?></h3>
					<p><?php echo esc_html( nvconsult_get_homepage_value( 'hero_card_copy', 'From choosing a destination to preparing your application, the experience stays clear and practical at every step.' ) ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="section" id="destinations">
		<div class="section__inner">
			<div class="section__heading">
				<h2><?php echo esc_html( nvconsult_get_homepage_value( 'section_destinations_title', 'Featured study destinations' ) ); ?></h2>
				<p><?php echo esc_html( nvconsult_get_homepage_value( 'destinations_intro', 'Choose from a curated list of destinations that support both academic goals and lifestyle priorities.' ) ); ?></p>
			</div>
			<div class="card-grid">
				<article class="card">
					<h3>Canada</h3>
					<p>Flexible study pathways with strong academic and post-study opportunities.</p>
				</article>
				<article class="card">
					<h3>Australia</h3>
					<p>High-quality institutions and vibrant student communities.</p>
				</article>
				<article class="card">
					<h3>United Kingdom</h3>
					<p>Globally recognised universities with a strong tradition of excellence.</p>
				</article>
			</div>
		</div>
	</section>

	<section class="section section--alt" id="opportunities">
		<div class="section__inner">
			<div class="section__heading">
				<h2><?php echo esc_html( nvconsult_get_homepage_value( 'section_opportunities_title', 'Featured opportunities' ) ); ?></h2>
				<p><?php echo esc_html( nvconsult_get_homepage_value( 'opportunities_intro', 'Explore programs, services, and support that help you move forward with confidence.' ) ); ?></p>
			</div>
			<div class="card-grid">
				<article class="card">
					<h3>Programs</h3>
					<p>Browse academic pathways aligned to your short and long-term goals.</p>
				</article>
				<article class="card">
					<h3>Services</h3>
					<p>Access guidance on applications, documents, interviews, and preparation.</p>
				</article>
				<article class="card">
					<h3>Knowledge Centre</h3>
					<p>Find fresh insights through articles, FAQs, and practical resources.</p>
				</article>
			</div>
		</div>
	</section>

	<section class="section" id="consultation">
		<div class="section__inner about">
			<div>
				<h2><?php echo esc_html( nvconsult_get_homepage_value( 'section_consultation_title', 'Consultation plans' ) ); ?></h2>
				<p><?php echo esc_html( nvconsult_get_homepage_value( 'consultation_intro', 'Choose a consultation approach that fits your stage and your priorities.' ) ); ?></p>
			</div>
			<div class="card">
				<h3><?php echo esc_html( nvconsult_get_homepage_value( 'consultation_card_title', 'Start with a guided conversation' ) ); ?></h3>
				<p><?php echo esc_html( nvconsult_get_homepage_value( 'consultation_card_body', 'We help you understand your options, timeline, and next steps in a simple and structured way.' ) ); ?></p>
			</div>
		</div>
	</section>

	<section class="section cta" id="contact">
		<div class="cta__inner">
			<h2><?php echo esc_html( nvconsult_get_homepage_value( 'section_cta_title', 'Let’s plan your next move' ) ); ?></h2>
			<p><?php echo esc_html( nvconsult_get_homepage_value( 'cta_text', 'Start your study-abroad journey with expert support that keeps the process organised and focused.' ) ); ?></p>
			<a class="button button--primary" href="mailto:hello@nvconsult.com">Contact us</a>
		</div>
	</section>
</main>
<?php get_footer(); ?>
