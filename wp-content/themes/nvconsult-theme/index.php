<?php
/**
 * Main template fallback.
 *
 * @package NVConsultTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main class="section">
	<div class="section__inner">
		<h1><?php single_post_title(); ?></h1>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article class="card" style="margin-bottom: 1rem;">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<p><?php the_excerpt(); ?></p>
			</article>
		<?php endwhile; else : ?>
			<p>No posts found.</p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
