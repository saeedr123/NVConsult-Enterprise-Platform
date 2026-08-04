<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_v2_get_default_homepage_sections() {
	return array(
		array( 'id' => 'hero', 'label' => __( 'Hero', 'nvconsult-core-v2' ), 'enabled' => true, 'order' => 1, 'heading' => '', 'subheading' => '', 'cta_text' => '', 'cta_link' => '', 'bg_image' => '', 'bg_color' => '' ),
		array( 'id' => 'journey-cards', 'label' => __( 'Journey Cards', 'nvconsult-core-v2' ), 'enabled' => true, 'order' => 2, 'heading' => __( 'What brings you here today?', 'nvconsult-core-v2' ), 'subheading' => '', 'cta_text' => '', 'cta_link' => '', 'bg_image' => '', 'bg_color' => '' ),
		array( 'id' => 'featured-destinations', 'label' => __( 'Featured Destinations', 'nvconsult-core-v2' ), 'enabled' => true, 'order' => 3, 'heading' => __( 'Featured Destinations', 'nvconsult-core-v2' ), 'subheading' => __( 'Explore top countries for study and work abroad.', 'nvconsult-core-v2' ), 'cta_text' => '', 'cta_link' => '', 'bg_image' => '', 'bg_color' => '' ),
		array( 'id' => 'featured-jobs', 'label' => __( 'Featured Jobs', 'nvconsult-core-v2' ), 'enabled' => true, 'order' => 4, 'heading' => __( 'Featured Jobs', 'nvconsult-core-v2' ), 'subheading' => __( 'Discover visa-friendly job opportunities.', 'nvconsult-core-v2' ), 'cta_text' => '', 'cta_link' => '', 'bg_image' => '', 'bg_color' => '' ),
		array( 'id' => 'why-nvconsult', 'label' => __( 'Why NVConsult', 'nvconsult-core-v2' ), 'enabled' => true, 'order' => 5, 'heading' => __( 'Why NVConsult', 'nvconsult-core-v2' ), 'subheading' => __( 'Trusted guidance across your global journey.', 'nvconsult-core-v2' ), 'cta_text' => '', 'cta_link' => '', 'bg_image' => '', 'bg_color' => '' ),
		array( 'id' => 'consultation-plans', 'label' => __( 'Consultation Plans', 'nvconsult-core-v2' ), 'enabled' => true, 'order' => 6, 'heading' => __( 'Consultation Plans', 'nvconsult-core-v2' ), 'subheading' => __( 'Choose the support level that fits your goals.', 'nvconsult-core-v2' ), 'cta_text' => '', 'cta_link' => '', 'bg_image' => '', 'bg_color' => '' ),
		array( 'id' => 'testimonials', 'label' => __( 'Testimonials', 'nvconsult-core-v2' ), 'enabled' => true, 'order' => 7, 'heading' => __( 'Success Stories', 'nvconsult-core-v2' ), 'subheading' => __( 'Hear from students and professionals we have helped.', 'nvconsult-core-v2' ), 'cta_text' => '', 'cta_link' => '', 'bg_image' => '', 'bg_color' => '' ),
		array( 'id' => 'knowledge-centre', 'label' => __( 'Knowledge Centre', 'nvconsult-core-v2' ), 'enabled' => true, 'order' => 8, 'heading' => __( 'Knowledge Centre', 'nvconsult-core-v2' ), 'subheading' => __( 'Latest guides, insights, and updates.', 'nvconsult-core-v2' ), 'cta_text' => '', 'cta_link' => '', 'bg_image' => '', 'bg_color' => '' ),
		array( 'id' => 'faq', 'label' => __( 'FAQ', 'nvconsult-core-v2' ), 'enabled' => true, 'order' => 9, 'heading' => __( 'Frequently Asked Questions', 'nvconsult-core-v2' ), 'subheading' => __( 'Answers to common questions.', 'nvconsult-core-v2' ), 'cta_text' => '', 'cta_link' => '', 'bg_image' => '', 'bg_color' => '' ),
		array( 'id' => 'cta', 'label' => __( 'Call To Action', 'nvconsult-core-v2' ), 'enabled' => true, 'order' => 10, 'heading' => __( 'Ready to begin your journey?', 'nvconsult-core-v2' ), 'subheading' => __( 'Talk to our team today.', 'nvconsult-core-v2' ), 'cta_text' => __( 'Book a Consultation', 'nvconsult-core-v2' ), 'cta_link' => '#', 'bg_image' => '', 'bg_color' => '' ),
	);
}

function nvconsult_v2_get_homepage_sections() {
	$saved    = get_option( 'nvconsult_v2_homepage_sections', array() );
	$defaults = nvconsult_v2_get_default_homepage_sections();
	if ( empty( $saved ) || ! is_array( $saved ) ) {
		return $defaults;
	}
	$indexed = array();
	foreach ( $defaults as $default ) {
		$indexed[ $default['id'] ] = $default;
	}
	foreach ( $saved as $section ) {
		if ( ! empty( $section['id'] ) && isset( $indexed[ $section['id'] ] ) ) {
			$indexed[ $section['id'] ] = wp_parse_args( $section, $indexed[ $section['id'] ] );
		}
	}
	return array_values( $indexed );
}

function nvconsult_v2_save_homepage_sections() {
	if ( ! isset( $_POST['nvconsult_v2_homepage_builder_submit'] ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	check_admin_referer( 'nvconsult_v2_save_homepage_sections', 'nvconsult_v2_homepage_builder_nonce' );
	$defaults = nvconsult_v2_get_default_homepage_sections();
	$input    = isset( $_POST['sections'] ) ? wp_unslash( $_POST['sections'] ) : array();
	$sanitized = array();
	foreach ( $defaults as $section ) {
		$id  = $section['id'];
		$row = isset( $input[ $id ] ) ? $input[ $id ] : array();
		$sanitized[] = array(
			'id'         => $id,
			'label'      => $section['label'],
			'enabled'    => ! empty( $row['enabled'] ),
			'order'      => isset( $row['order'] ) ? absint( $row['order'] ) : $section['order'],
			'heading'    => isset( $row['heading'] ) ? sanitize_text_field( $row['heading'] ) : '',
			'subheading' => isset( $row['subheading'] ) ? sanitize_text_field( $row['subheading'] ) : '',
			'cta_text'   => isset( $row['cta_text'] ) ? sanitize_text_field( $row['cta_text'] ) : '',
			'cta_link'   => isset( $row['cta_link'] ) ? esc_url_raw( $row['cta_link'] ) : '',
			'bg_image'   => isset( $row['bg_image'] ) ? esc_url_raw( $row['bg_image'] ) : '',
			'bg_color'   => isset( $row['bg_color'] ) ? sanitize_text_field( $row['bg_color'] ) : '',
		);
	}
	update_option( 'nvconsult_v2_homepage_sections', $sanitized );
	add_settings_error( 'nvconsult_v2_messages', 'nvconsult_v2_homepage_saved', __( 'Homepage sections updated.', 'nvconsult-core-v2' ), 'updated' );
}
add_action( 'admin_init', 'nvconsult_v2_save_homepage_sections' );

function nvconsult_v2_render_homepage_builder_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$sections = nvconsult_v2_get_homepage_sections();
	settings_errors( 'nvconsult_v2_messages' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Homepage Builder', 'nvconsult-core-v2' ); ?></h1>
		<form method="post">
			<?php wp_nonce_field( 'nvconsult_v2_save_homepage_sections', 'nvconsult_v2_homepage_builder_nonce' ); ?>
			<table class="widefat striped">
				<thead><tr><th><?php esc_html_e( 'Enable', 'nvconsult-core-v2' ); ?></th><th><?php esc_html_e( 'Section', 'nvconsult-core-v2' ); ?></th><th><?php esc_html_e( 'Order', 'nvconsult-core-v2' ); ?></th><th><?php esc_html_e( 'Heading', 'nvconsult-core-v2' ); ?></th><th><?php esc_html_e( 'Subheading', 'nvconsult-core-v2' ); ?></th><th><?php esc_html_e( 'CTA Text', 'nvconsult-core-v2' ); ?></th><th><?php esc_html_e( 'CTA Link', 'nvconsult-core-v2' ); ?></th></tr></thead>
				<tbody>
				<?php foreach ( $sections as $section ) : ?>
					<tr>
						<td><input type="checkbox" name="sections[<?php echo esc_attr( $section['id'] ); ?>][enabled]" value="1" <?php checked( ! empty( $section['enabled'] ) ); ?>></td>
						<td><?php echo esc_html( $section['label'] ); ?></td>
						<td><input class="small-text" type="number" name="sections[<?php echo esc_attr( $section['id'] ); ?>][order]" value="<?php echo esc_attr( (string) $section['order'] ); ?>"></td>
						<td><input class="regular-text" type="text" name="sections[<?php echo esc_attr( $section['id'] ); ?>][heading]" value="<?php echo esc_attr( $section['heading'] ); ?>"></td>
						<td><input class="regular-text" type="text" name="sections[<?php echo esc_attr( $section['id'] ); ?>][subheading]" value="<?php echo esc_attr( $section['subheading'] ); ?>"></td>
						<td><input class="regular-text" type="text" name="sections[<?php echo esc_attr( $section['id'] ); ?>][cta_text]" value="<?php echo esc_attr( $section['cta_text'] ); ?>"></td>
						<td><input class="regular-text" type="url" name="sections[<?php echo esc_attr( $section['id'] ); ?>][cta_link]" value="<?php echo esc_attr( $section['cta_link'] ); ?>"></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p class="submit"><button type="submit" name="nvconsult_v2_homepage_builder_submit" class="button button-primary"><?php esc_html_e( 'Save Sections', 'nvconsult-core-v2' ); ?></button></p>
		</form>
	</div>
	<?php
}
