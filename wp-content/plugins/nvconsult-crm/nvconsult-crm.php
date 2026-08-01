<?php
/**
 * Plugin Name: NVConsult CRM
 * Description: Lightweight CRM integration plugin for contacts and opportunities.
 * Version: 1.0.0
 * Author: NVConsult
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NVConsult_CRM {
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_types' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_lead_meta_boxes' ) );
		add_action( 'save_post_nvconsult_lead', array( __CLASS__, 'save_lead_meta' ) );
		add_filter( 'manage_nvconsult_lead_posts_columns', array( __CLASS__, 'register_lead_columns' ) );
		add_action( 'manage_nvconsult_lead_posts_custom_column', array( __CLASS__, 'render_lead_columns' ), 10, 2 );
	}

	public static function register_post_types() {
		register_post_type(
			'nvconsult_lead',
			array(
				'labels' => array(
					'name'          => __( 'Leads', 'nvconsult-crm' ),
					'singular_name' => __( 'Lead', 'nvconsult-crm' ),
				),
				'public'       => false,
				'show_ui'      => true,
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor' ),
				'menu_icon'    => 'dashicons-groups',
			)
		);
	}

	public static function register_lead_meta_boxes() {
		add_meta_box( 'nvconsult_lead_details', 'Lead Details', array( __CLASS__, 'render_lead_meta_box' ), 'nvconsult_lead', 'normal', 'default' );
	}

	public static function render_lead_meta_box( $post ) {
		wp_nonce_field( 'nvconsult_lead_meta', 'nvconsult_lead_meta_nonce' );
		$email = get_post_meta( $post->ID, '_nvconsult_lead_email', true );
		$company = get_post_meta( $post->ID, '_nvconsult_lead_company', true );
		$status = get_post_meta( $post->ID, '_nvconsult_lead_status', true );
		?>
		<p>
			<label for="nvconsult_lead_email">Email</label><br />
			<input type="email" id="nvconsult_lead_email" name="nvconsult_lead_email" value="<?php echo esc_attr( $email ); ?>" class="widefat" />
		</p>
		<p>
			<label for="nvconsult_lead_company">Company</label><br />
			<input type="text" id="nvconsult_lead_company" name="nvconsult_lead_company" value="<?php echo esc_attr( $company ); ?>" class="widefat" />
		</p>
		<p>
			<label for="nvconsult_lead_status">Status</label><br />
			<select id="nvconsult_lead_status" name="nvconsult_lead_status">
				<option value="new" <?php selected( $status, 'new' ); ?>>New</option>
				<option value="contacted" <?php selected( $status, 'contacted' ); ?>>Contacted</option>
				<option value="qualified" <?php selected( $status, 'qualified' ); ?>>Qualified</option>
			</select>
		</p>
		<?php
	}

	public static function save_lead_meta( $post_id ) {
		if ( ! isset( $_POST['nvconsult_lead_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nvconsult_lead_meta_nonce'] ) ), 'nvconsult_lead_meta' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$email = isset( $_POST['nvconsult_lead_email'] ) ? sanitize_email( wp_unslash( $_POST['nvconsult_lead_email'] ) ) : '';
		$company = isset( $_POST['nvconsult_lead_company'] ) ? sanitize_text_field( wp_unslash( $_POST['nvconsult_lead_company'] ) ) : '';
		$status = isset( $_POST['nvconsult_lead_status'] ) ? sanitize_text_field( wp_unslash( $_POST['nvconsult_lead_status'] ) ) : 'new';

		update_post_meta( $post_id, '_nvconsult_lead_email', $email );
		update_post_meta( $post_id, '_nvconsult_lead_company', $company );
		update_post_meta( $post_id, '_nvconsult_lead_status', $status );
	}

	public static function register_lead_columns( $columns ) {
		$columns['email'] = __( 'Email', 'nvconsult-crm' );
		$columns['company'] = __( 'Company', 'nvconsult-crm' );
		$columns['status'] = __( 'Status', 'nvconsult-crm' );

		return $columns;
	}

	public static function render_lead_columns( $column, $post_id ) {
		if ( 'email' === $column ) {
			echo esc_html( get_post_meta( $post_id, '_nvconsult_lead_email', true ) );
		} elseif ( 'company' === $column ) {
			echo esc_html( get_post_meta( $post_id, '_nvconsult_lead_company', true ) );
		} elseif ( 'status' === $column ) {
			echo esc_html( get_post_meta( $post_id, '_nvconsult_lead_status', true ) );
		}
	}
}

NVConsult_CRM::init();
