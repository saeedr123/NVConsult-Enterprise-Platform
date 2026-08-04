<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_v2_get_default_consultation_plans() {
	return array(
		'plan_free' => array(
			'name'        => __( 'Free Consultation', 'nvconsult-core-v2' ),
			'description' => __( 'A quick strategy call to map your goals and next steps.', 'nvconsult-core-v2' ),
			'features'    => "Initial eligibility review\nGoal-setting conversation\nCountry recommendation\nNext-step checklist",
			'btn_label'   => __( 'Book Free Consultation', 'nvconsult-core-v2' ),
			'btn_link'    => '#',
			'icon_class'  => 'dashicons dashicons-yes-alt',
			'color'       => 'green',
			'visible'     => true,
		),
		'plan_full' => array(
			'name'        => __( 'Full Support ★', 'nvconsult-core-v2' ),
			'description' => __( 'Hands-on support from application to relocation readiness.', 'nvconsult-core-v2' ),
			'features'    => "Eligibility assessment\nInstitution or employer matching\nDocument preparation support\nVisa guidance\nInterview preparation\nPre-departure support",
			'btn_label'   => __( 'Get Full Support', 'nvconsult-core-v2' ),
			'btn_link'    => '#',
			'icon_class'  => 'dashicons dashicons-star-filled',
			'color'       => 'orange',
			'visible'     => true,
		),
	);
}

function nvconsult_v2_save_consultation_plans() {
	if ( ! isset( $_POST['nvconsult_v2_consultation_plans_submit'] ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	check_admin_referer( 'nvconsult_v2_save_consultation_plans', 'nvconsult_v2_consultation_plans_nonce' );
	$defaults = nvconsult_v2_get_default_consultation_plans();
	$input    = isset( $_POST['plans'] ) ? wp_unslash( $_POST['plans'] ) : array();
	$data     = array();
	foreach ( $defaults as $key => $plan ) {
		$row = isset( $input[ $key ] ) ? $input[ $key ] : array();
		$data[ $key ] = array(
			'name'        => isset( $row['name'] ) ? sanitize_text_field( $row['name'] ) : $plan['name'],
			'description' => isset( $row['description'] ) ? sanitize_textarea_field( $row['description'] ) : $plan['description'],
			'features'    => isset( $row['features'] ) ? sanitize_textarea_field( $row['features'] ) : $plan['features'],
			'btn_label'   => isset( $row['btn_label'] ) ? sanitize_text_field( $row['btn_label'] ) : $plan['btn_label'],
			'btn_link'    => isset( $row['btn_link'] ) ? esc_url_raw( $row['btn_link'] ) : $plan['btn_link'],
			'icon_class'  => isset( $row['icon_class'] ) ? sanitize_text_field( $row['icon_class'] ) : $plan['icon_class'],
			'color'       => isset( $row['color'] ) ? sanitize_text_field( $row['color'] ) : $plan['color'],
			'visible'     => ! empty( $row['visible'] ),
		);
	}
	update_option( 'nvconsult_v2_consultation_plans', $data );
	add_settings_error( 'nvconsult_v2_messages', 'nvconsult_v2_consultation_saved', __( 'Consultation plans updated.', 'nvconsult-core-v2' ), 'updated' );
}
add_action( 'admin_init', 'nvconsult_v2_save_consultation_plans' );

function nvconsult_v2_render_consultation_plans_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$plans = wp_parse_args( get_option( 'nvconsult_v2_consultation_plans', array() ), nvconsult_v2_get_default_consultation_plans() );
	settings_errors( 'nvconsult_v2_messages' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Consultation Plans', 'nvconsult-core-v2' ); ?></h1>
		<form method="post">
			<?php wp_nonce_field( 'nvconsult_v2_save_consultation_plans', 'nvconsult_v2_consultation_plans_nonce' ); ?>
			<div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:24px;max-width:1100px;">
				<?php foreach ( $plans as $key => $plan ) : ?>
					<div class="postbox" style="padding:20px;">
						<h2><?php echo esc_html( ucfirst( str_replace( '_', ' ', $key ) ) ); ?></h2>
						<p><label><?php esc_html_e( 'Name', 'nvconsult-core-v2' ); ?><br><input class="widefat" type="text" name="plans[<?php echo esc_attr( $key ); ?>][name]" value="<?php echo esc_attr( $plan['name'] ); ?>"></label></p>
						<p><label><?php esc_html_e( 'Description', 'nvconsult-core-v2' ); ?><br><textarea class="widefat" rows="3" name="plans[<?php echo esc_attr( $key ); ?>][description]"><?php echo esc_textarea( $plan['description'] ); ?></textarea></label></p>
						<p><label><?php esc_html_e( 'Features', 'nvconsult-core-v2' ); ?><br><textarea class="widefat" rows="6" name="plans[<?php echo esc_attr( $key ); ?>][features]"><?php echo esc_textarea( $plan['features'] ); ?></textarea></label></p>
						<p><label><?php esc_html_e( 'Button Label', 'nvconsult-core-v2' ); ?><br><input class="widefat" type="text" name="plans[<?php echo esc_attr( $key ); ?>][btn_label]" value="<?php echo esc_attr( $plan['btn_label'] ); ?>"></label></p>
						<p><label><?php esc_html_e( 'Button Link', 'nvconsult-core-v2' ); ?><br><input class="widefat" type="url" name="plans[<?php echo esc_attr( $key ); ?>][btn_link]" value="<?php echo esc_attr( $plan['btn_link'] ); ?>"></label></p>
						<p><label><?php esc_html_e( 'Icon Class', 'nvconsult-core-v2' ); ?><br><input class="widefat" type="text" name="plans[<?php echo esc_attr( $key ); ?>][icon_class]" value="<?php echo esc_attr( $plan['icon_class'] ); ?>"></label></p>
						<p><label><?php esc_html_e( 'Color', 'nvconsult-core-v2' ); ?><br><select name="plans[<?php echo esc_attr( $key ); ?>][color]"><option value="green" <?php selected( $plan['color'], 'green' ); ?>><?php esc_html_e( 'Green', 'nvconsult-core-v2' ); ?></option><option value="orange" <?php selected( $plan['color'], 'orange' ); ?>><?php esc_html_e( 'Orange', 'nvconsult-core-v2' ); ?></option></select></label></p>
						<p><label><input type="checkbox" name="plans[<?php echo esc_attr( $key ); ?>][visible]" value="1" <?php checked( ! empty( $plan['visible'] ) ); ?>> <?php esc_html_e( 'Visible', 'nvconsult-core-v2' ); ?></label></p>
					</div>
				<?php endforeach; ?>
			</div>
			<p class="submit"><button type="submit" name="nvconsult_v2_consultation_plans_submit" class="button button-primary"><?php esc_html_e( 'Save Consultation Plans', 'nvconsult-core-v2' ); ?></button></p>
		</form>
	</div>
	<?php
}
