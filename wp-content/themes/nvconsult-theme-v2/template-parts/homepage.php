<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$sections = nvconsultv2_get_homepage_sections();
usort(
	$sections,
	static function ( $a, $b ) {
		return (int) $a['order'] <=> (int) $b['order'];
	}
);
?>
<main id="primary" class="site-main">
	<?php foreach ( $sections as $section ) : ?>
		<?php if ( ! empty( $section['enabled'] ) ) : ?>
			<?php get_template_part( 'template-parts/sections/' . sanitize_file_name( $section['id'] ) ); ?>
		<?php endif; ?>
	<?php endforeach; ?>
</main>
