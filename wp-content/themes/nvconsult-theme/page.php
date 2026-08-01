<?php
/**
 * Page template.
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
		<?php while ( have_posts() ) : the_post(); ?>
			<article class="card">
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</article>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>
