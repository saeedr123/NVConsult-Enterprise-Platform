<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_v2_get_related_posts( $post_type ) {
	return get_posts(
		array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);
}

function nvconsult_v2_get_meta_box_config() {
	return array(
		'nvconsult_country' => array(
			'title'  => __( 'Country Details', 'nvconsult-core-v2' ),
			'fields' => array(
				'_nvconsult_flag_image' => array( 'label' => __( 'Flag Image URL', 'nvconsult-core-v2' ), 'type' => 'url' ),
				'_nvconsult_hero_image' => array( 'label' => __( 'Hero Image URL', 'nvconsult-core-v2' ), 'type' => 'url' ),
				'_nvconsult_description' => array( 'label' => __( 'Description', 'nvconsult-core-v2' ), 'type' => 'textarea' ),
				'_nvconsult_visa_info' => array( 'label' => __( 'Visa Information', 'nvconsult-core-v2' ), 'type' => 'textarea' ),
				'_nvconsult_cost_of_living' => array( 'label' => __( 'Cost of Living', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_work_rights' => array( 'label' => __( 'Work Rights', 'nvconsult-core-v2' ), 'type' => 'textarea' ),
				'_nvconsult_education_info' => array( 'label' => __( 'Education Information', 'nvconsult-core-v2' ), 'type' => 'textarea' ),
				'_nvconsult_language' => array( 'label' => __( 'Language', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_currency' => array( 'label' => __( 'Currency', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_climate' => array( 'label' => __( 'Climate', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_featured' => array( 'label' => __( 'Featured', 'nvconsult-core-v2' ), 'type' => 'checkbox' ),
				'_nvconsult_order' => array( 'label' => __( 'Display Order', 'nvconsult-core-v2' ), 'type' => 'number' ),
				'_nvconsult_seo_title' => array( 'label' => __( 'SEO Title', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_seo_description' => array( 'label' => __( 'SEO Description', 'nvconsult-core-v2' ), 'type' => 'textarea' ),
			),
		),
		'nvconsult_institution' => array(
			'title'  => __( 'Institution Details', 'nvconsult-core-v2' ),
			'fields' => array(
				'_nvconsult_country_id' => array( 'label' => __( 'Country', 'nvconsult-core-v2' ), 'type' => 'select', 'options' => 'nvconsult_country' ),
				'_nvconsult_logo' => array( 'label' => __( 'Logo URL', 'nvconsult-core-v2' ), 'type' => 'url' ),
				'_nvconsult_featured' => array( 'label' => __( 'Featured', 'nvconsult-core-v2' ), 'type' => 'checkbox' ),
				'_nvconsult_hidden' => array( 'label' => __( 'Hidden', 'nvconsult-core-v2' ), 'type' => 'checkbox' ),
				'_nvconsult_order' => array( 'label' => __( 'Display Order', 'nvconsult-core-v2' ), 'type' => 'number' ),
			),
		),
		'nvconsult_program' => array(
			'title'  => __( 'Program Details', 'nvconsult-core-v2' ),
			'fields' => array(
				'_nvconsult_institution_id' => array( 'label' => __( 'Institution', 'nvconsult-core-v2' ), 'type' => 'select', 'options' => 'nvconsult_institution' ),
				'_nvconsult_country_id' => array( 'label' => __( 'Country', 'nvconsult-core-v2' ), 'type' => 'select', 'options' => 'nvconsult_country' ),
				'_nvconsult_level' => array( 'label' => __( 'Level', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_duration' => array( 'label' => __( 'Duration', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_fees' => array( 'label' => __( 'Fees', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_requirements' => array( 'label' => __( 'Requirements', 'nvconsult-core-v2' ), 'type' => 'textarea' ),
				'_nvconsult_intake' => array( 'label' => __( 'Intake', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_career_outcomes' => array( 'label' => __( 'Career Outcomes', 'nvconsult-core-v2' ), 'type' => 'textarea' ),
				'_nvconsult_featured' => array( 'label' => __( 'Featured', 'nvconsult-core-v2' ), 'type' => 'checkbox' ),
			),
		),
		'nvconsult_job' => array(
			'title'  => __( 'Job Details', 'nvconsult-core-v2' ),
			'fields' => array(
				'_nvconsult_country_id' => array( 'label' => __( 'Country', 'nvconsult-core-v2' ), 'type' => 'select', 'options' => 'nvconsult_country' ),
				'_nvconsult_salary_range' => array( 'label' => __( 'Salary Range', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_accommodation' => array( 'label' => __( 'Accommodation', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_benefits' => array( 'label' => __( 'Benefits', 'nvconsult-core-v2' ), 'type' => 'textarea' ),
				'_nvconsult_requirements' => array( 'label' => __( 'Requirements', 'nvconsult-core-v2' ), 'type' => 'textarea' ),
				'_nvconsult_visa_sponsored' => array( 'label' => __( 'Visa Sponsored', 'nvconsult-core-v2' ), 'type' => 'checkbox' ),
				'_nvconsult_employer' => array( 'label' => __( 'Employer', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_location' => array( 'label' => __( 'Location', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_apply_url' => array( 'label' => __( 'Apply URL', 'nvconsult-core-v2' ), 'type' => 'url' ),
				'_nvconsult_closing_date' => array( 'label' => __( 'Closing Date', 'nvconsult-core-v2' ), 'type' => 'date' ),
				'_nvconsult_featured' => array( 'label' => __( 'Featured', 'nvconsult-core-v2' ), 'type' => 'checkbox' ),
				'_nvconsult_order' => array( 'label' => __( 'Display Order', 'nvconsult-core-v2' ), 'type' => 'number' ),
			),
		),
		'nvconsult_scholarship' => array(
			'title'  => __( 'Scholarship Details', 'nvconsult-core-v2' ),
			'fields' => array(
				'_nvconsult_country_id' => array( 'label' => __( 'Country', 'nvconsult-core-v2' ), 'type' => 'select', 'options' => 'nvconsult_country' ),
				'_nvconsult_institution_id' => array( 'label' => __( 'Institution', 'nvconsult-core-v2' ), 'type' => 'select', 'options' => 'nvconsult_institution' ),
				'_nvconsult_amount' => array( 'label' => __( 'Amount', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_deadline' => array( 'label' => __( 'Deadline', 'nvconsult-core-v2' ), 'type' => 'date' ),
				'_nvconsult_featured' => array( 'label' => __( 'Featured', 'nvconsult-core-v2' ), 'type' => 'checkbox' ),
			),
		),
		'nvconsult_article' => array(
			'title'  => __( 'Article Details', 'nvconsult-core-v2' ),
			'fields' => array(
				'_nvconsult_country_id' => array( 'label' => __( 'Country', 'nvconsult-core-v2' ), 'type' => 'select', 'options' => 'nvconsult_country', 'allow_empty' => true ),
				'_nvconsult_related_program_id' => array( 'label' => __( 'Related Program', 'nvconsult-core-v2' ), 'type' => 'select', 'options' => 'nvconsult_program', 'allow_empty' => true ),
				'_nvconsult_related_job_id' => array( 'label' => __( 'Related Job', 'nvconsult-core-v2' ), 'type' => 'select', 'options' => 'nvconsult_job', 'allow_empty' => true ),
				'_nvconsult_featured' => array( 'label' => __( 'Featured', 'nvconsult-core-v2' ), 'type' => 'checkbox' ),
				'_nvconsult_seo_title' => array( 'label' => __( 'SEO Title', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_seo_description' => array( 'label' => __( 'SEO Description', 'nvconsult-core-v2' ), 'type' => 'textarea' ),
			),
		),
		'nvconsult_testimonial' => array(
			'title'  => __( 'Testimonial Details', 'nvconsult-core-v2' ),
			'fields' => array(
				'_nvconsult_country_id' => array( 'label' => __( 'Country', 'nvconsult-core-v2' ), 'type' => 'select', 'options' => 'nvconsult_country' ),
				'_nvconsult_rating' => array( 'label' => __( 'Rating (1-5)', 'nvconsult-core-v2' ), 'type' => 'number', 'min' => 1, 'max' => 5 ),
				'_nvconsult_video_url' => array( 'label' => __( 'Video URL', 'nvconsult-core-v2' ), 'type' => 'url' ),
				'_nvconsult_related_program_id' => array( 'label' => __( 'Related Program', 'nvconsult-core-v2' ), 'type' => 'select', 'options' => 'nvconsult_program', 'allow_empty' => true ),
				'_nvconsult_featured' => array( 'label' => __( 'Featured', 'nvconsult-core-v2' ), 'type' => 'checkbox' ),
				'_nvconsult_order' => array( 'label' => __( 'Display Order', 'nvconsult-core-v2' ), 'type' => 'number' ),
				'_nvconsult_person_role' => array( 'label' => __( 'Person Role', 'nvconsult-core-v2' ), 'type' => 'text' ),
			),
		),
		'nvconsult_faq' => array(
			'title'  => __( 'FAQ Details', 'nvconsult-core-v2' ),
			'fields' => array(
				'_nvconsult_answer' => array( 'label' => __( 'Answer', 'nvconsult-core-v2' ), 'type' => 'editor' ),
				'_nvconsult_related_country_id' => array( 'label' => __( 'Related Country', 'nvconsult-core-v2' ), 'type' => 'select', 'options' => 'nvconsult_country', 'allow_empty' => true ),
				'_nvconsult_order' => array( 'label' => __( 'Display Order', 'nvconsult-core-v2' ), 'type' => 'number' ),
			),
		),
		'nvconsult_banner' => array(
			'title'  => __( 'Banner Details', 'nvconsult-core-v2' ),
			'fields' => array(
				'_nvconsult_headline' => array( 'label' => __( 'Headline', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_subheadline' => array( 'label' => __( 'Subheadline', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_cta_text' => array( 'label' => __( 'CTA Text', 'nvconsult-core-v2' ), 'type' => 'text' ),
				'_nvconsult_cta_link' => array( 'label' => __( 'CTA Link', 'nvconsult-core-v2' ), 'type' => 'url' ),
				'_nvconsult_bg_image' => array( 'label' => __( 'Background Image URL', 'nvconsult-core-v2' ), 'type' => 'url' ),
				'_nvconsult_alignment' => array( 'label' => __( 'Alignment', 'nvconsult-core-v2' ), 'type' => 'choice', 'choices' => array( 'left' => __( 'Left', 'nvconsult-core-v2' ), 'center' => __( 'Center', 'nvconsult-core-v2' ), 'right' => __( 'Right', 'nvconsult-core-v2' ) ) ),
			),
		),
	);
}

function nvconsult_v2_register_meta_boxes() {
	foreach ( nvconsult_v2_get_meta_box_config() as $post_type => $config ) {
		add_meta_box(
			'nvconsult_v2_' . $post_type . '_details',
			$config['title'],
			'nvconsult_v2_render_meta_box',
			$post_type,
			'normal',
			'default',
			array(
				'post_type' => $post_type,
				'fields'    => $config['fields'],
			)
		);
	}
}
add_action( 'add_meta_boxes', 'nvconsult_v2_register_meta_boxes' );

function nvconsult_v2_render_meta_box( $post, $meta_box ) {
	$fields = isset( $meta_box['args']['fields'] ) ? $meta_box['args']['fields'] : array();
	wp_nonce_field( 'nvconsult_v2_save_meta_box', 'nvconsult_v2_meta_box_nonce' );
	echo '<table class="form-table"><tbody>';
	foreach ( $fields as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );
		echo '<tr><th scope="row"><label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] ) . '</label></th><td>';
		switch ( $field['type'] ) {
			case 'textarea':
				echo '<textarea class="large-text" rows="4" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '">' . esc_textarea( $value ) . '</textarea>';
				break;
			case 'editor':
				wp_editor( wp_kses_post( $value ), $key, array( 'textarea_name' => $key, 'textarea_rows' => 6 ) );
				break;
			case 'checkbox':
				echo '<label><input type="checkbox" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="1" ' . checked( $value, '1', false ) . '> ' . esc_html__( 'Enable', 'nvconsult-core-v2' ) . '</label>';
				break;
			case 'select':
				$options = nvconsult_v2_get_related_posts( $field['options'] );
				echo '<select id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '">';
				if ( ! empty( $field['allow_empty'] ) ) {
					echo '<option value="">' . esc_html__( 'Select an option', 'nvconsult-core-v2' ) . '</option>';
				}
				foreach ( $options as $option ) {
					echo '<option value="' . esc_attr( $option->ID ) . '" ' . selected( (string) $value, (string) $option->ID, false ) . '>' . esc_html( get_the_title( $option ) ) . '</option>';
				}
				echo '</select>';
				break;
			case 'choice':
				echo '<select id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '">';
				foreach ( $field['choices'] as $choice_value => $choice_label ) {
					echo '<option value="' . esc_attr( $choice_value ) . '" ' . selected( $value, $choice_value, false ) . '>' . esc_html( $choice_label ) . '</option>';
				}
				echo '</select>';
				break;
			default:
				$type = in_array( $field['type'], array( 'url', 'date', 'number', 'text' ), true ) ? $field['type'] : 'text';
				echo '<input class="regular-text" type="' . esc_attr( $type ) . '" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '"';
				if ( isset( $field['min'] ) ) {
					echo ' min="' . esc_attr( (string) $field['min'] ) . '"';
				}
				if ( isset( $field['max'] ) ) {
					echo ' max="' . esc_attr( (string) $field['max'] ) . '"';
				}
				echo ' />';
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

function nvconsult_v2_sanitize_meta_value( $value, $type ) {
	switch ( $type ) {
		case 'textarea':
			return sanitize_textarea_field( $value );
		case 'editor':
			return wp_kses_post( $value );
		case 'url':
			return esc_url_raw( $value );
		case 'number':
		case 'select':
			return '' === $value ? '' : absint( $value );
		case 'checkbox':
			return empty( $value ) ? '0' : '1';
		case 'date':
		case 'choice':
		case 'text':
		default:
			return sanitize_text_field( $value );
	}
}

function nvconsult_v2_save_meta_boxes( $post_id ) {
	if ( ! isset( $_POST['nvconsult_v2_meta_box_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nvconsult_v2_meta_box_nonce'] ) ), 'nvconsult_v2_save_meta_box' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$post_type = get_post_type( $post_id );
	$configs   = nvconsult_v2_get_meta_box_config();
	if ( empty( $configs[ $post_type ] ) ) {
		return;
	}
	foreach ( $configs[ $post_type ]['fields'] as $key => $field ) {
		$raw_value = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		$value     = nvconsult_v2_sanitize_meta_value( $raw_value, $field['type'] );
		if ( 'checkbox' === $field['type'] || '' !== $value ) {
			update_post_meta( $post_id, $key, $value );
		} else {
			delete_post_meta( $post_id, $key );
		}
	}
	if ( isset( $configs[ $post_type ]['fields']['_nvconsult_order'] ) ) {
		$menu_order = (int) get_post_meta( $post_id, '_nvconsult_order', true );
		remove_action( 'save_post', 'nvconsult_v2_save_meta_boxes' );
		wp_update_post(
			array(
				'ID'         => $post_id,
				'menu_order' => $menu_order,
			)
		);
		add_action( 'save_post', 'nvconsult_v2_save_meta_boxes' );
	}
}
add_action( 'save_post', 'nvconsult_v2_save_meta_boxes' );
