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

		if ( ! get_option( 'nvconsult_homepage_settings' ) ) {
			update_option( 'nvconsult_homepage_settings', array(
				'hero_title' => 'Study abroad with clarity and confidence',
				'hero_intro' => 'Explore opportunities, plan your journey, and connect with trusted guidance for your next move.',
				'hero_card_title' => 'Designed for the full study-abroad journey',
				'hero_card_copy' => 'From choosing a destination to preparing your application, the experience stays clear and practical at every step.',
				'section_destinations_title' => 'Featured study destinations',
				'destinations_intro' => 'Choose from a curated list of destinations that support both academic goals and lifestyle priorities.',
				'section_opportunities_title' => 'Featured opportunities',
				'opportunities_intro' => 'Explore programs, services, and support that help you move forward with confidence.',
				'section_consultation_title' => 'Consultation plans',
				'consultation_intro' => 'Choose a consultation approach that fits your stage and your priorities.',
				'consultation_card_title' => 'Start with a guided conversation',
				'consultation_card_body' => 'We help you understand your options, timeline, and next steps in a simple and structured way.',
				'section_cta_title' => 'Let’s plan your next move',
				'cta_text' => 'Start your study-abroad journey with expert support that keeps the process organised and focused.',
				'footer_text' => '© 2026 NVConsult. Built for modern operators.',
			) );
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
		register_setting( 'nvconsult_homepage_settings_group', 'nvconsult_homepage_settings' );
	}

	public static function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$core_settings = get_option( 'nvconsult_core_settings', array() );
		$homepage_settings = get_option( 'nvconsult_homepage_settings', array() );
		?>
		<div class="wrap">
			<h1>NVConsult Core Settings</h1>
			<p>Foundation-only settings for the approved architecture and public homepage.</p>
			<form method="post" action="options.php">
				<?php settings_fields( 'nvconsult_core_settings_group' ); ?>
				<?php do_settings_sections( 'nvconsult_core_settings_group' ); ?>
				<table class="form-table">
					<tr>
						<th scope="row"><label for="nvconsult_core_settings[site_status]">Site status</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_core_settings[site_status]" name="nvconsult_core_settings[site_status]" value="<?php echo esc_attr( $core_settings['site_status'] ?? '' ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button( 'Save core settings' ); ?>
			</form>

			<form method="post" action="options.php">
				<?php settings_fields( 'nvconsult_homepage_settings_group' ); ?>
				<?php do_settings_sections( 'nvconsult_homepage_settings_group' ); ?>
				<h2>Homepage Content</h2>
				<table class="form-table">
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[hero_title]">Hero title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[hero_title]" name="nvconsult_homepage_settings[hero_title]" value="<?php echo esc_attr( $homepage_settings['hero_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[hero_intro]">Hero intro</label></th>
						<td><textarea class="large-text" rows="3" id="nvconsult_homepage_settings[hero_intro]" name="nvconsult_homepage_settings[hero_intro]"><?php echo esc_textarea( $homepage_settings['hero_intro'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[hero_card_title]">Hero card title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[hero_card_title]" name="nvconsult_homepage_settings[hero_card_title]" value="<?php echo esc_attr( $homepage_settings['hero_card_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[hero_card_copy]">Hero card copy</label></th>
						<td><textarea class="large-text" rows="3" id="nvconsult_homepage_settings[hero_card_copy]" name="nvconsult_homepage_settings[hero_card_copy]"><?php echo esc_textarea( $homepage_settings['hero_card_copy'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[section_destinations_title]">Destinations title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[section_destinations_title]" name="nvconsult_homepage_settings[section_destinations_title]" value="<?php echo esc_attr( $homepage_settings['section_destinations_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[destinations_intro]">Destinations intro</label></th>
						<td><textarea class="large-text" rows="2" id="nvconsult_homepage_settings[destinations_intro]" name="nvconsult_homepage_settings[destinations_intro]"><?php echo esc_textarea( $homepage_settings['destinations_intro'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[section_opportunities_title]">Opportunities title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[section_opportunities_title]" name="nvconsult_homepage_settings[section_opportunities_title]" value="<?php echo esc_attr( $homepage_settings['section_opportunities_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[opportunities_intro]">Opportunities intro</label></th>
						<td><textarea class="large-text" rows="2" id="nvconsult_homepage_settings[opportunities_intro]" name="nvconsult_homepage_settings[opportunities_intro]"><?php echo esc_textarea( $homepage_settings['opportunities_intro'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[section_consultation_title]">Consultation title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[section_consultation_title]" name="nvconsult_homepage_settings[section_consultation_title]" value="<?php echo esc_attr( $homepage_settings['section_consultation_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[consultation_intro]">Consultation intro</label></th>
						<td><textarea class="large-text" rows="2" id="nvconsult_homepage_settings[consultation_intro]" name="nvconsult_homepage_settings[consultation_intro]"><?php echo esc_textarea( $homepage_settings['consultation_intro'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[consultation_card_title]">Consultation card title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[consultation_card_title]" name="nvconsult_homepage_settings[consultation_card_title]" value="<?php echo esc_attr( $homepage_settings['consultation_card_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[consultation_card_body]">Consultation card body</label></th>
						<td><textarea class="large-text" rows="3" id="nvconsult_homepage_settings[consultation_card_body]" name="nvconsult_homepage_settings[consultation_card_body]"><?php echo esc_textarea( $homepage_settings['consultation_card_body'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[section_cta_title]">CTA title</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[section_cta_title]" name="nvconsult_homepage_settings[section_cta_title]" value="<?php echo esc_attr( $homepage_settings['section_cta_title'] ?? '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[cta_text]">CTA text</label></th>
						<td><textarea class="large-text" rows="2" id="nvconsult_homepage_settings[cta_text]" name="nvconsult_homepage_settings[cta_text]"><?php echo esc_textarea( $homepage_settings['cta_text'] ?? '' ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="nvconsult_homepage_settings[footer_text]">Footer text</label></th>
						<td><input type="text" class="regular-text" id="nvconsult_homepage_settings[footer_text]" name="nvconsult_homepage_settings[footer_text]" value="<?php echo esc_attr( $homepage_settings['footer_text'] ?? '' ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button( 'Save homepage settings' ); ?>
			</form>
		</div>
		<?php
	}
}

register_activation_hook( __FILE__, array( 'NVConsult_Core', 'activate' ) );
NVConsult_Core::init();
