<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_v2_get_hero_defaults() {
	return array(
		'headline'       => __( 'Study Abroad. Work Abroad.', 'nvconsult-core-v2' ),
		'subheadline'    => __( 'Expert guidance for your next international move.', 'nvconsult-core-v2' ),
		'tagline'        => __( 'Your Global Journey Starts Here.', 'nvconsult-core-v2' ),
		'btn1_label'     => __( 'Study Abroad', 'nvconsult-core-v2' ),
		'btn1_url'       => '#',
		'btn1_color'     => 'blue',
		'btn2_label'     => __( 'Work Abroad', 'nvconsult-core-v2' ),
		'btn2_url'       => '#',
		'btn2_color'     => 'orange',
		'bg_image_left'  => '',
		'bg_image_right' => '',
		'overlay_color'  => 'rgba(15, 23, 42, 0.55)',
	);
}

function nvconsult_v2_save_hero_settings() {
	if ( ! isset( $_POST['nvconsult_v2_hero_submit'] ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	check_admin_referer( 'nvconsult_v2_save_hero', 'nvconsult_v2_hero_nonce' );
	$input = isset( $_POST['hero'] ) ? wp_unslash( $_POST['hero'] ) : array();
	$data  = array(
		'headline'       => isset( $input['headline'] ) ? wp_kses_post( $input['headline'] ) : '',
		'subheadline'    => isset( $input['subheadline'] ) ? wp_kses_post( $input['subheadline'] ) : '',
		'tagline'        => isset( $input['tagline'] ) ? wp_kses_post( $input['tagline'] ) : '',
		'btn1_label'     => isset( $input['btn1_label'] ) ? sanitize_text_field( $input['btn1_label'] ) : '',
		'btn1_url'       => isset( $input['btn1_url'] ) ? esc_url_raw( $input['btn1_url'] ) : '',
		'btn1_color'     => isset( $input['btn1_color'] ) ? sanitize_text_field( $input['btn1_color'] ) : 'blue',
		'btn2_label'     => isset( $input['btn2_label'] ) ? sanitize_text_field( $input['btn2_label'] ) : '',
		'btn2_url'       => isset( $input['btn2_url'] ) ? esc_url_raw( $input['btn2_url'] ) : '',
		'btn2_color'     => isset( $input['btn2_color'] ) ? sanitize_text_field( $input['btn2_color'] ) : 'orange',
		'bg_image_left'  => isset( $input['bg_image_left'] ) ? esc_url_raw( $input['bg_image_left'] ) : '',
		'bg_image_right' => isset( $input['bg_image_right'] ) ? esc_url_raw( $input['bg_image_right'] ) : '',
		'overlay_color'  => isset( $input['overlay_color'] ) ? sanitize_text_field( $input['overlay_color'] ) : '',
	);
	update_option( 'nvconsult_v2_hero', $data );
	add_settings_error( 'nvconsult_v2_messages', 'nvconsult_v2_hero_saved', __( 'Hero settings updated.', 'nvconsult-core-v2' ), 'updated' );
}
add_action( 'admin_init', 'nvconsult_v2_save_hero_settings' );

function nvconsult_v2_render_hero_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$hero = wp_parse_args( get_option( 'nvconsult_v2_hero', array() ), nvconsult_v2_get_hero_defaults() );
	settings_errors( 'nvconsult_v2_messages' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Hero Settings', 'nvconsult-core-v2' ); ?></h1>
		<form method="post">
			<?php wp_nonce_field( 'nvconsult_v2_save_hero', 'nvconsult_v2_hero_nonce' ); ?>
			<table class="form-table"><tbody>
				<tr><th><label for="hero_headline"><?php esc_html_e( 'Headline', 'nvconsult-core-v2' ); ?></label></th><td><textarea class="large-text" rows="2" id="hero_headline" name="hero[headline]"><?php echo esc_textarea( $hero['headline'] ); ?></textarea></td></tr>
				<tr><th><label for="hero_subheadline"><?php esc_html_e( 'Subheadline', 'nvconsult-core-v2' ); ?></label></th><td><textarea class="large-text" rows="2" id="hero_subheadline" name="hero[subheadline]"><?php echo esc_textarea( $hero['subheadline'] ); ?></textarea></td></tr>
				<tr><th><label for="hero_tagline"><?php esc_html_e( 'Tagline', 'nvconsult-core-v2' ); ?></label></th><td><textarea class="large-text" rows="2" id="hero_tagline" name="hero[tagline]"><?php echo esc_textarea( $hero['tagline'] ); ?></textarea></td></tr>
				<tr><th><?php esc_html_e( 'Primary Button', 'nvconsult-core-v2' ); ?></th><td><input class="regular-text" type="text" name="hero[btn1_label]" value="<?php echo esc_attr( $hero['btn1_label'] ); ?>"> <input class="regular-text" type="url" name="hero[btn1_url]" value="<?php echo esc_attr( $hero['btn1_url'] ); ?>"> <select name="hero[btn1_color]"><option value="blue" <?php selected( $hero['btn1_color'], 'blue' ); ?>><?php esc_html_e( 'Blue', 'nvconsult-core-v2' ); ?></option><option value="orange" <?php selected( $hero['btn1_color'], 'orange' ); ?>><?php esc_html_e( 'Orange', 'nvconsult-core-v2' ); ?></option></select></td></tr>
				<tr><th><?php esc_html_e( 'Secondary Button', 'nvconsult-core-v2' ); ?></th><td><input class="regular-text" type="text" name="hero[btn2_label]" value="<?php echo esc_attr( $hero['btn2_label'] ); ?>"> <input class="regular-text" type="url" name="hero[btn2_url]" value="<?php echo esc_attr( $hero['btn2_url'] ); ?>"> <select name="hero[btn2_color]"><option value="blue" <?php selected( $hero['btn2_color'], 'blue' ); ?>><?php esc_html_e( 'Blue', 'nvconsult-core-v2' ); ?></option><option value="orange" <?php selected( $hero['btn2_color'], 'orange' ); ?>><?php esc_html_e( 'Orange', 'nvconsult-core-v2' ); ?></option></select></td></tr>
				<tr><th><label for="hero_bg_left"><?php esc_html_e( 'Left Background Image URL', 'nvconsult-core-v2' ); ?></label></th><td><input class="large-text" type="url" id="hero_bg_left" name="hero[bg_image_left]" value="<?php echo esc_attr( $hero['bg_image_left'] ); ?>"></td></tr>
				<tr><th><label for="hero_bg_right"><?php esc_html_e( 'Right Background Image URL', 'nvconsult-core-v2' ); ?></label></th><td><input class="large-text" type="url" id="hero_bg_right" name="hero[bg_image_right]" value="<?php echo esc_attr( $hero['bg_image_right'] ); ?>"></td></tr>
				<tr><th><label for="hero_overlay"><?php esc_html_e( 'Overlay Color', 'nvconsult-core-v2' ); ?></label></th><td><input class="regular-text" type="text" id="hero_overlay" name="hero[overlay_color]" value="<?php echo esc_attr( $hero['overlay_color'] ); ?>"></td></tr>
			</tbody></table>
			<p class="submit"><button type="submit" name="nvconsult_v2_hero_submit" class="button button-primary"><?php esc_html_e( 'Save Hero Settings', 'nvconsult-core-v2' ); ?></button></p>
		</form>
	</div>
	<?php
}
