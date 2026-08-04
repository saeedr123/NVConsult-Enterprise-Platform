<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$grouped = array();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		$grouped[ get_post_type() ][] = get_post();
	}
	wp_reset_postdata();
}
?>
<main class="search-shell">
	<section class="search-hero"><h1><?php printf( esc_html__( 'Search results for “%s”', 'nvconsult-theme-v2' ), get_search_query() ); ?></h1></section>
	<?php if ( ! empty( $grouped ) ) : ?>
		<?php foreach ( $grouped as $post_type => $posts ) : $post_type_object = get_post_type_object( $post_type ); ?>
			<section class="section" style="padding-top:24px;"><h2><?php echo esc_html( $post_type_object ? $post_type_object->labels->name : ucfirst( $post_type ) ); ?></h2><div class="search-grid"><?php foreach ( $posts as $post ) : setup_postdata( $post ); ?><article class="search-card content-card"><span class="post-type-badge"><?php echo esc_html( $post_type_object ? $post_type_object->labels->singular_name : ucfirst( $post_type ) ); ?></span><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p class="search-meta"><?php echo esc_html( get_the_date() ); ?></p><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p></article><?php endforeach; wp_reset_postdata(); ?></div></section>
		<?php endforeach; ?>
	<?php else : ?>
		<div class="placeholder-message"><p><?php esc_html_e( 'No results matched your search. Try another keyword or browse our destinations, jobs, or articles.', 'nvconsult-theme-v2' ); ?></p></div>
	<?php endif; ?>
</main>
<?php get_footer(); ?>
