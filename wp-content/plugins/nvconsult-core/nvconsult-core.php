<?php
/**
 * Plugin Name: NVConsult Core
 * Description: Shared functionality for the NVConsult Enterprise Platform.
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

	public static function register_settings_page() {
		add_menu_page(
			'NVConsult Settings',
			'NVConsult',
			'manage_options',
			'nvconsult-settings',
			array( __CLASS__, 'render_settings_page' ),
			'dashicons-admin-generic',
			20
		);
	}

	public static function register_settings() {
		register_setting( 'nvconsult_homepage_settings_group', 'nvconsult_homepage_settings' );
	}

	public static function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$settings = get_option( 'nvconsult_homepage_settings', array() );
		?>
		<div class="wrap">
			<h1>NVConsult Homepage Settings</h1>
			<p>Update the homepage copy and call-to-action content without changing the frozen layout.</p>
			<form method="post" action="options.php">
				<?php settings_fields( 'nvconsult_homepage_settings_group' ); ?>
				<?php do_settings_sections( 'nvconsult_homepage_settings_group' ); ?>
				<table class="form-table">
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[hero_title]">Hero title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[hero_title]" name="nvconsult_homepage_settings[hero_title]" value="<?php echo esc_attr( $settings['hero_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[hero_intro]">Hero intro</label></th>
						<td><textarea class="large-text" rows="3" id="nvconsult_homepage_settings[hero_intro]" name="nvconsult_homepage_settings[hero_intro]"><?php echo esc_textarea( $settings['hero_intro'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[hero_card_title]">Hero card title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[hero_card_title]" name="nvconsult_homepage_settings[hero_card_title]" value="<?php echo esc_attr( $settings['hero_card_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[hero_card_copy]">Hero card copy</label></th>
						<td><textarea class="large-text" rows="3" id="nvconsult_homepage_settings[hero_card_copy]" name="nvconsult_homepage_settings[hero_card_copy]"><?php echo esc_textarea( $settings['hero_card_copy'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[section_services_title]">Services section title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[section_services_title]" name="nvconsult_homepage_settings[section_services_title]" value="<?php echo esc_attr( $settings['section_services_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[services_intro]">Services intro</label></th>
						<td><textarea class="large-text" rows="2" id="nvconsult_homepage_settings[services_intro]" name="nvconsult_homepage_settings[services_intro]"><?php echo esc_textarea( $settings['services_intro'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[service_1_title]">Service 1 title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[service_1_title]" name="nvconsult_homepage_settings[service_1_title]" value="<?php echo esc_attr( $settings['service_1_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[service_1_text]">Service 1 text</label></th>
						<td><textarea class="large-text" rows="2" id="nvconsult_homepage_settings[service_1_text]" name="nvconsult_homepage_settings[service_1_text]"><?php echo esc_textarea( $settings['service_1_text'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[service_2_title]">Service 2 title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[service_2_title]" name="nvconsult_homepage_settings[service_2_title]" value="<?php echo esc_attr( $settings['service_2_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[service_2_text]">Service 2 text</label></th>
						<td><textarea class="large-text" rows="2" id="nvconsult_homepage_settings[service_2_text]" name="nvconsult_homepage_settings[service_2_text]"><?php echo esc_textarea( $settings['service_2_text'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[service_3_title]">Service 3 title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[service_3_title]" name="nvconsult_homepage_settings[service_3_title]" value="<?php echo esc_attr( $settings['service_3_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[service_3_text]">Service 3 text</label></th>
						<td><textarea class="large-text" rows="2" id="nvconsult_homepage_settings[service_3_text]" name="nvconsult_homepage_settings[service_3_text]"><?php echo esc_textarea( $settings['service_3_text'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[section_about_title]">About title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[section_about_title]" name="nvconsult_homepage_settings[section_about_title]" value="<?php echo esc_attr( $settings['section_about_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[about_intro]">About intro</label></th>
						<td><textarea class="large-text" rows="2" id="nvconsult_homepage_settings[about_intro]" name="nvconsult_homepage_settings[about_intro]"><?php echo esc_textarea( $settings['about_intro'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[about_points]">About points</label></th>
						<td><textarea class="large-text" rows="4" id="nvconsult_homepage_settings[about_points]" name="nvconsult_homepage_settings[about_points]"><?php echo esc_textarea( $settings['about_points'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[stats_1_value]">Stat 1 value</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[stats_1_value]" name="nvconsult_homepage_settings[stats_1_value]" value="<?php echo esc_attr( $settings['stats_1_value'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[stats_1_label]">Stat 1 label</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[stats_1_label]" name="nvconsult_homepage_settings[stats_1_label]" value="<?php echo esc_attr( $settings['stats_1_label'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[stats_2_value]">Stat 2 value</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[stats_2_value]" name="nvconsult_homepage_settings[stats_2_value]" value="<?php echo esc_attr( $settings['stats_2_value'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[stats_2_label]">Stat 2 label</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[stats_2_label]" name="nvconsult_homepage_settings[stats_2_label]" value="<?php echo esc_attr( $settings['stats_2_label'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[stats_3_value]">Stat 3 value</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[stats_3_value]" name="nvconsult_homepage_settings[stats_3_value]" value="<?php echo esc_attr( $settings['stats_3_value'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[stats_3_label]">Stat 3 label</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[stats_3_label]" name="nvconsult_homepage_settings[stats_3_label]" value="<?php echo esc_attr( $settings['stats_3_label'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[stats_4_value]">Stat 4 value</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[stats_4_value]" name="nvconsult_homepage_settings[stats_4_value]" value="<?php echo esc_attr( $settings['stats_4_value'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[stats_4_label]">Stat 4 label</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[stats_4_label]" name="nvconsult_homepage_settings[stats_4_label]" value="<?php echo esc_attr( $settings['stats_4_label'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[about_card_title]">About card title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[about_card_title]" name="nvconsult_homepage_settings[about_card_title]" value="<?php echo esc_attr( $settings['about_card_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[about_card_body]">About card body</label></th>
						<td><textarea class="large-text" rows="3" id="nvconsult_homepage_settings[about_card_body]" name="nvconsult_homepage_settings[about_card_body]"><?php echo esc_textarea( $settings['about_card_body'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[section_cta_title]">CTA title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[section_cta_title]" name="nvconsult_homepage_settings[section_cta_title]" value="<?php echo esc_attr( $settings['section_cta_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[cta_text]">CTA text</label></th>
						<td><textarea class="large-text" rows="2" id="nvconsult_homepage_settings[cta_text]" name="nvconsult_homepage_settings[cta_text]"><?php echo esc_textarea( $settings['cta_text'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[cta_button_label]">CTA button label</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[cta_button_label]" name="nvconsult_homepage_settings[cta_button_label]" value="<?php echo esc_attr( $settings['cta_button_label'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[cta_button_url]">CTA button URL</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[cta_button_url]" name="nvconsult_homepage_settings[cta_button_url]" value="<?php echo esc_attr( $settings['cta_button_url'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[footer_text]">Footer text</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[footer_text]" name="nvconsult_homepage_settings[footer_text]" value="<?php echo esc_attr( $settings['footer_text'] ?? '' ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button( 'Save homepage settings' ); ?>
			</form>
		</div>
		<?php
	}
}

NVConsult_Core::init();
