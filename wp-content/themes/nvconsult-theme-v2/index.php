<?php
/**
 * Main fallback template.
 *
 * Required by WordPress as the default template for the theme.
 * The homepage uses front-page.php; this file covers all other
 * default contexts (single posts, pages, archives, search, 404).
 *
 * @package NVConsultThemeV2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content">
	<section class="section">
		<div class="section__inner">
			<?php if ( have_posts() ) : ?>
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'card' ); ?> id="post-<?php the_ID(); ?>">
						<h2><?php the_title(); ?></h2>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</article>
					<?php
				endwhile;
				?>
			<?php else : ?>
				<div class="card">
					<h2><?php esc_html_e( 'Nothing found', 'nvconsult-theme-v2' ); ?></h2>
					<p><?php esc_html_e( 'No content is available here yet.', 'nvconsult-theme-v2' ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
