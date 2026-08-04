<?php
/**
 * Homepage content template.
 *
 * @package NVConsultTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = nvconsult_get_homepage_settings();
$destinations = array(
	array(
		'country' => 'Cyprus',
		'flag'    => '🇨🇾',
		'text'    => 'Study in one of Europe's most affordable English-speaking destinations.',
		'image'   => 'linear-gradient(135deg, #4ea0e8, #0d3f80)',
	),
	array(
		'country' => 'Germany',
		'flag'    => '🇩🇪',
		'text'    => 'World-class education and excellent career opportunities await you.',
		'image'   => 'linear-gradient(135deg, #846c3b, #d5b46c)',
	),
	array(
		'country' => 'Latvia',
		'flag'    => '🇱🇻',
		'text'    => 'High-quality education with affordable tuition and living costs.',
		'image'   => 'linear-gradient(135deg, #9e4d51, #d79b87)',
	),
	array(
		'country' => 'Romania',
		'flag'    => '🇷🇴',
		'text'    => 'European degrees with competitive tuition fees and vibrant student life.',
		'image'   => 'linear-gradient(135deg, #6fa7d8, #93c7ec)',
	),
);
$opportunities = array(
	array(
		'title'   => 'Warehouse Worker',
		'country' => 'Germany',
		'salary'  => '€2,200 - €2,600',
		'image'   => 'linear-gradient(135deg, #4e5b63, #222f3a)',
	),
	array(
		'title'   => 'Hotel Housekeeper',
		'country' => 'Croatia',
		'salary'  => '€1,400 - €1,700',
		'image'   => 'linear-gradient(135deg, #6d5948, #cab39f)',
	),
	array(
		'title'   => 'Welder',
		'country' => 'Romania',
		'salary'  => '€1,800 - €2,200',
		'image'   => 'linear-gradient(135deg, #111827, #6b4f40)',
	),
	array(
		'title'   => 'Forklift Operator',
		'country' => 'Lithuania',
		'salary'  => '€1,700 - €2,000',
		'image'   => 'linear-gradient(135deg, #777e8f, #2d3644)',
	),
);
$why_choose = array(
	array(
		'icon'  => '🧑‍🏫',
		'title' => 'Expert Guidance',
		'text'  => 'Professional advice from experienced consultants.',
	),
	array(
		'icon'  => '🎓',
		'title' => 'Study & Work Opportunities',
		'text'  => 'Access to top institutions and global employers.',
	),
	array(
		'icon'  => '📄',
		'title' => 'Visa Assistance',
		'text'  => 'End-to-end support for smooth visa processing.',
	),
	array(
		'icon'  => '🛡️',
		'title' => 'Transparent Process',
		'text'  => 'Clear information and honest guidance.',
	),
	array(
		'icon'  => '🤝',
		'title' => 'Personal Support',
		'text'  => 'We're with you at every step of your journey.',
	),
	array(
		'icon'  => '🌐',
		'title' => 'Global Network',
		'text'  => 'Strong connections worldwide.',
	),
);
$stories = array(
	array(
		'name' => 'Anjali Sharma',
		'role' => 'Student, Cyprus',
		'text' => '“NVConsult helped me get admission in my dream university in Cyprus.”',
	),
	array(
		'name' => 'Rohit Verma',
		'role' => 'Warehouse Worker, Germany',
		'text' => '“I got my dream job in Germany with the help of NVConsult.”',
	),
	array(
		'name' => 'Sneha Reddy',
		'role' => 'Student, Latvia',
		'text' => '“Excellent guidance and support throughout my student visa process.”',
	),
);
$resources = array(
	array(
		'tag'   => 'VISA GUIDE',
		'title' => 'Germany Work Visa Guide 2024',
		'date'  => 'May 10, 2024',
		'image' => 'linear-gradient(135deg, #486b9c, #a6bbd6)',
	),
	array(
		'tag'   => 'STUDY TIPS',
		'title' => 'How to Choose the Right University',
		'date'  => 'May 7, 2024',
		'image' => 'linear-gradient(135deg, #90a7ba, #d3e1eb)',
	),
	array(
		'tag'   => 'COUNTRY GUIDE',
		'title' => 'Living in Cyprus as an International Student',
		'date'  => 'May 5, 2024',
		'image' => 'linear-gradient(135deg, #3f74b2, #d5a970)',
	),
);
?>
<main id="main-content" class="homepage">
	<section class="hero" id="top">
		<div class="hero__frame">
			<span class="hero__plane" aria-hidden="true"></span>
			<span class="hero__plane--small" aria-hidden="true"></span>
			<div class="hero__content">
				<div class="hero__copy">
					<h1 class="hero__title"><?php echo esc_html( $settings['hero_title'] ); ?></h1>
					<p class="hero__subtitle"><?php echo esc_html( $settings['hero_study_label'] ); ?></p>
					<p class="hero__text"><?php echo esc_html( $settings['hero_intro'] ); ?></p>
					<div class="hero__actions">
						<a class="button button--primary" href="<?php echo esc_url( $settings['hero_primary_button_url'] ); ?>"><span class="button__icon">🎓</span><?php echo esc_html( $settings['hero_primary_button_label'] ); ?></a>
						<a class="button button--secondary" href="<?php echo esc_url( $settings['hero_secondary_button_url'] ); ?>"><span class="button__icon">💼</span><?php echo esc_html( $settings['hero_secondary_button_label'] ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section" id="study-abroad">
		<div class="section__inner">
			<h2 class="section-title section-title--with-accent"><?php echo esc_html( $settings['pathways_title'] ); ?></h2>
			<div class="pathways">
				<article class="path-card path-card--study">
					<div class="path-card__art path-card__art--study" aria-hidden="true"></div>
					<div class="path-card__content">
						<h3><?php echo esc_html( $settings['pathway_study_title'] ); ?></h3>
						<p><?php echo esc_html( $settings['pathway_study_text'] ); ?></p>
						<a class="path-card__arrow" href="#featured-destinations" aria-label="Explore study abroad options">→</a>
					</div>
				</article>
				<article class="path-card path-card--work" id="work-abroad">
					<div class="path-card__art path-card__art--work" aria-hidden="true"></div>
					<div class="path-card__content">
						<h3><?php echo esc_html( $settings['pathway_work_title'] ); ?></h3>
						<p><?php echo esc_html( $settings['pathway_work_text'] ); ?></p>
						<a class="path-card__arrow" href="#featured-opportunities" aria-label="Explore work abroad options">→</a>
					</div>
				</article>
			</div>
		</div>
	</section>

	<section class="section" id="featured-destinations">
		<div class="section__inner">
			<h2 class="section-title section-title--with-accent"><?php echo esc_html( $settings['study_destinations_title'] ); ?></h2>
			<div class="cards-grid cards-grid--four">
				<?php foreach ( $destinations as $destination ) : ?>
					<article class="destination-card">
						<div class="destination-card__media" style="background-image: <?php echo esc_attr( $destination['image'] ); ?>;"></div>
						<div class="destination-card__body">
							<span class="destination-card__flag"><?php echo esc_html( $destination['flag'] ); ?> <span><?php echo esc_html( $destination['country'] ); ?></span></span>
							<h3 class="destination-card__title"><?php echo esc_html( $destination['country'] ); ?></h3>
							<p class="destination-card__text"><?php echo esc_html( $destination['text'] ); ?></p>
							<a class="link-arrow" href="#consultation-plans">Explore →</a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="section" id="featured-opportunities">
		<div class="section__inner">
			<h2 class="section-title section-title--with-accent"><?php echo esc_html( $settings['opportunities_title'] ); ?></h2>
			<div class="cards-grid cards-grid--four">
				<?php foreach ( $opportunities as $opportunity ) : ?>
					<article class="opportunity-card">
						<div class="opportunity-card__media" style="background-image: <?php echo esc_attr( $opportunity['image'] ); ?>;"></div>
						<div class="opportunity-card__body">
							<h3 class="opportunity-card__title"><?php echo esc_html( $opportunity['title'] ); ?></h3>
							<div class="opportunity-card__meta">
								<span>📍 <?php echo esc_html( $opportunity['country'] ); ?></span>
								<span class="badge">Visa Sponsored</span>
							</div>
							<p class="opportunity-card__salary"><?php echo esc_html( $opportunity['salary'] ); ?></p>
							<a class="link-arrow" href="#consultation-plans">Apply Now →</a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<div class="section__footer-link">
				<a class="link-arrow" href="#consultation-plans">View All Opportunities →</a>
			</div>
		</div>
	</section>

	<section class="section" id="why-choose-us">
		<div class="section__inner">
			<h2 class="section-title section-title--with-accent"><?php echo esc_html( $settings['why_choose_title'] ); ?></h2>
			<div class="why-grid">
				<?php foreach ( $why_choose as $item ) : ?>
					<article class="why-card">
						<div class="why-card__icon"><?php echo esc_html( $item['icon'] ); ?></div>
						<h3 class="why-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
						<p class="why-card__text"><?php echo esc_html( $item['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="section" id="consultation-plans">
		<div class="section__inner">
			<h2 class="section-title section-title--with-accent"><?php echo esc_html( $settings['consultation_title'] ); ?></h2>
			<div class="consultation-grid">
				<article class="consultation-card consultation-card--free">
					<div>
						<h3 class="consultation-card__title">Free Consultation</h3>
						<p class="consultation-card__lead">Perfect if you’re exploring your options.</p>
						<ul class="consultation-card__list">
							<li>Initial Consultation</li>
							<li>Eligibility Assessment</li>
							<li>Study/Work Options</li>
							<li>Questions &amp; Answers</li>
						</ul>
						<a class="button button--primary consultation-card__button" href="#site-footer">Book Free Consultation</a>
					</div>
					<div class="consultation-card__visual" aria-hidden="true">🎧</div>
				</article>
				<article class="consultation-card consultation-card--full">
					<div>
						<h3 class="consultation-card__title">Full Support +</h3>
						<p class="consultation-card__lead">We guide you from application to arrival.</p>
						<ul class="consultation-card__list">
							<li>Dedicated Consultant</li>
							<li>Application Assistance</li>
							<li>Document Review</li>
							<li>Visa Guidance</li>
							<li>Pre-Departure Support</li>
							<li>Ongoing Assistance</li>
						</ul>
						<a class="button button--secondary consultation-card__button" href="#site-footer">Get Full Support</a>
					</div>
					<div class="consultation-card__visual" aria-hidden="true">👥</div>
				</article>
			</div>
		</div>
	</section>

	<section class="section" id="resources">
		<div class="section__inner content-grid">
			<div>
				<h2 class="section-title section-title--with-accent"><?php echo esc_html( $settings['stories_title'] ); ?></h2>
				<div class="story-slider">
					<button class="slider-arrow" type="button" aria-label="Previous story">‹</button>
					<div>
						<div class="story-track">
							<?php foreach ( $stories as $story ) : ?>
								<article class="story-card">
									<div class="story-card__top">
										<div class="story-card__avatar" aria-hidden="true"></div>
										<div>
											<h3 class="story-card__name"><?php echo esc_html( $story['name'] ); ?></h3>
											<div class="story-card__role"><?php echo esc_html( $story['role'] ); ?></div>
										</div>
									</div>
									<p class="story-card__text"><?php echo esc_html( $story['text'] ); ?></p>
								</article>
							<?php endforeach; ?>
						</div>
						<div class="story-dots" aria-hidden="true">
							<span class="is-active"></span><span></span><span></span>
						</div>
					</div>
					<button class="slider-arrow" type="button" aria-label="Next story">›</button>
				</div>
			</div>
			<div>
				<h2 class="section-title section-title--with-accent"><?php echo esc_html( $settings['resources_title'] ); ?></h2>
				<div class="resources-grid">
					<?php foreach ( $resources as $resource ) : ?>
						<article class="resource-card">
							<div class="resource-card__media" style="background-image: <?php echo esc_attr( $resource['image'] ); ?>;"></div>
							<div class="resource-card__body">
								<span class="resource-card__tag"><?php echo esc_html( $resource['tag'] ); ?></span>
								<h3 class="resource-card__title"><?php echo esc_html( $resource['title'] ); ?></h3>
								<p class="resource-card__meta"><?php echo esc_html( $resource['date'] ); ?></p>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
				<div class="section__footer-link">
					<a class="link-arrow" href="#site-footer">View All Articles →</a>
				</div>
			</div>
		</div>
	</section>
</main>
