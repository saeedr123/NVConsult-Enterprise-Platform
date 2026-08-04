<?php
/**
 * Homepage content template.
 *
 * @package NVConsultThemeV2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = nvconsultv2_get_homepage_settings();
$services = array(
	array(
		'title' => $settings['service_1_title'],
		'text'  => $settings['service_1_text'],
	),
	array(
		'title' => $settings['service_2_title'],
		'text'  => $settings['service_2_text'],
	),
	array(
		'title' => $settings['service_3_title'],
		'text'  => $settings['service_3_text'],
	),
);
$about_points = explode( "\n", $settings['about_points'] );
?>
<main id="main-content">
	<section class="hero" id="top">
		<div class="hero__inner">
			<div class="hero__content">
				<div>
					<h1><?php echo esc_html( $settings['hero_title'] ); ?></h1>
					<p><?php echo esc_html( $settings['hero_intro'] ); ?></p>
					<div class="hero__actions">
						<a class="button button--primary" href="<?php echo esc_url( $settings['hero_primary_button_url'] ); ?>"><?php echo esc_html( $settings['hero_primary_button_label'] ); ?></a>
						<a class="button button--secondary" href="<?php echo esc_url( $settings['hero_secondary_button_url'] ); ?>"><?php echo esc_html( $settings['hero_secondary_button_label'] ); ?></a>
					</div>
				</div>
				<div class="hero__card">
					<h3><?php echo esc_html( $settings['hero_card_title'] ); ?></h3>
					<p><?php echo esc_html( $settings['hero_card_copy'] ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="section" id="services">
		<div class="section__inner">
			<div class="section__heading">
				<h2><?php echo esc_html( $settings['section_services_title'] ); ?></h2>
				<p><?php echo esc_html( $settings['services_intro'] ); ?></p>
			</div>
			<div class="card-grid">
				<?php foreach ( $services as $service ) : ?>
					<article class="card">
						<h3><?php echo esc_html( $service['title'] ); ?></h3>
						<p><?php echo esc_html( $service['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
			<div class="stats">
				<div class="stat"><strong>12+</strong><span>Years of advisory delivery</span></div>
				<div class="stat"><strong>30%</strong><span>Typical workflow efficiency lift</span></div>
				<div class="stat"><strong>100%</strong><span>Editable content framework</span></div>
				<div class="stat"><strong>4</strong><span>Focused platform sprints</span></div>
			</div>
		</div>
	</section>

	<section class="section section--alt" id="about">
		<div class="section__inner about">
			<div>
				<h2><?php echo esc_html( $settings['section_about_title'] ); ?></h2>
				<p><?php echo esc_html( $settings['about_intro'] ); ?></p>
				<ul>
					<?php foreach ( $about_points as $point ) : ?>
						<?php if ( ! empty( trim( $point ) ) ) : ?>
							<li><?php echo esc_html( trim( $point ) ); ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="card">
				<h3>Platform blueprint</h3>
				<p>The homepage remains intentionally frozen in structure while each message, CTA, and service card can be updated through settings.</p>
			</div>
		</div>
	</section>

	<section class="section cta" id="contact">
		<div class="cta__inner">
			<h2><?php echo esc_html( $settings['section_cta_title'] ); ?></h2>
			<p><?php echo esc_html( $settings['cta_text'] ); ?></p>
			<a class="button button--primary" href="<?php echo esc_url( $settings['cta_button_url'] ); ?>"><?php echo esc_html( $settings['cta_button_label'] ); ?></a>
		</div>
	</section>
</main>
