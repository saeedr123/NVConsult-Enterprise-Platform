<?php
/**
 * Plugin Name: NVConsult Core
 * Description: Foundation plugin for the NVConsult Enterprise Platform.
 * Version: 1.0.0
 * Author: NVConsult
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NVConsult_Core {
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'register_settings_page' ) );
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	public static function activate() {
		if ( ! get_option( 'nvconsult_core_settings' ) ) {
			update_option( 'nvconsult_core_settings', array( 'site_status' => 'foundation_ready' ) );
		}
	}

	public static function register_settings_page() {
		add_menu_page(
			'NVConsult Core Settings',
			'NVConsult Core',
			'manage_options',
			'nvconsult-core-settings',
			array( __CLASS__, 'render_settings_page' ),
			'dashicons-admin-generic',
			20
		);
	}

	public static function register_settings() {
		register_setting( 'nvconsult_core_settings_group', 'nvconsult_core_settings' );
	}

	public static function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$settings = get_option( 'nvconsult_core_settings', array() );
		?>
		<div class="wrap">
			<h1>NVConsult Core Settings</h1>
			<p>Foundation-only settings for the approved architecture.</p>
			<form method="post" action="options.php">
				<?php settings_fields( 'nvconsult_core_settings_group' ); ?>
				<?php do_settings_sections( 'nvconsult_core_settings_group' ); ?>
				<table class="form-table">
					<tr>
						<th scope="row"><label for="nvconsult_core_settings[site_status]">Site status</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_core_settings[site_status]" name="nvconsult_core_settings[site_status]" value="<?php echo esc_attr( $settings['site_status'] ?? '' ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button( 'Save settings' ); ?>
			</form>
		</div>
		<?php
	}
}

register_activation_hook( __FILE__, array( 'NVConsult_Core', 'activate' ) );
NVConsult_Core::init();
