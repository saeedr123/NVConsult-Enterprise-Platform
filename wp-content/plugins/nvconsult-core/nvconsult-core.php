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
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( __CLASS__, 'add_action_links' ) );
		add_action( 'wp_dashboard_setup', array( __CLASS__, 'register_dashboard_widget' ) );
	}

	public static function activate() {
		$defaults = array(
			'hero_title' => 'Operational clarity for growth-ready teams',
			'hero_intro' => 'NVConsult helps founders and operators modernize delivery with strategy, execution, and CRM alignment under one roof.',
			'hero_primary_button_label' => 'Book a discovery call',
			'hero_primary_button_url' => '#contact',
			'hero_secondary_button_label' => 'View the roadmap',
			'hero_secondary_button_url' => '#services',
			'hero_card_title' => 'Sprints delivered with measurable momentum',
			'hero_card_copy' => 'From foundational design to launch-ready workflows, our team ships clear milestones and keeps your stakeholders informed.',
			'section_services_title' => 'What we deliver',
			'services_intro' => 'A focused set of services that cover brand, technology, CRM, and delivery operations.',
			'service_1_title' => 'Platform Strategy',
			'service_1_text' => 'Future-ready operating models tailored to the pace of your team.',
			'service_2_title' => 'Website Systems',
			'service_2_text' => 'Custom WordPress architecture designed for speed, extensibility, and editability.',
			'service_3_title' => 'Revenue Enablement',
			'service_3_text' => 'CRM flows that align technology, people, and customer experience.',
			'section_about_title' => 'Designed to feel calm, clear, and credible',
			'about_intro' => 'We combine strategy, product thinking, and execution to create premium digital experiences that support real growth.',
			'about_points' => 'Editable content blocks that remain consistent across the site.\nFlexible modules that can be adapted in future sprints.\nA strong foundation for performance and maintainability.',
			'stats_1_value' => '12+',
			'stats_1_label' => 'Years of advisory delivery',
			'stats_2_value' => '30%',
			'stats_2_label' => 'Typical workflow efficiency lift',
			'stats_3_value' => '100%',
			'stats_3_label' => 'Editable content framework',
			'stats_4_value' => '4',
			'stats_4_label' => 'Focused platform sprints',
			'about_card_title' => 'Platform blueprint',
			'about_card_body' => 'The homepage remains intentionally frozen in structure while each message, CTA, and service card can be updated through settings.',
			'section_cta_title' => 'Ready to move faster?',
			'cta_text' => 'Let us help you connect your brand, your operations, and your growth engine.',
			'cta_button_label' => 'Start a conversation',
			'cta_button_url' => '#contact',
			'footer_text' => '© 2026 NVConsult. Built for modern operators.',
		);

		if ( ! get_option( 'nvconsult_homepage_settings' ) ) {
			update_option( 'nvconsult_homepage_settings', $defaults );
		}
	}

	public static function add_action_links( $links ) {
		$settings_link = '<a href="admin.php?page=nvconsult-settings">Settings</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}

	public static function register_dashboard_widget() {
		wp_add_dashboard_widget( 'nvconsult_dashboard_widget', 'NVConsult Platform Status', array( __CLASS__, 'render_dashboard_widget' ) );
	}

	public static function render_dashboard_widget() {
		$settings = get_option( 'nvconsult_homepage_settings', array() );
		$lead_count = wp_count_posts( 'nvconsult_lead' )->publish ?? 0;
		$theme_name = wp_get_theme()->get( 'Name' );
		?>
		<p><strong>Theme:</strong> <?php echo esc_html( $theme_name ); ?></p>
		<p><strong>Homepage status:</strong> <?php echo esc_html( ! empty( $settings['hero_title'] ) ? 'Configured' : 'Needs setup' ); ?></p>
		<p><strong>Leads in CRM:</strong> <?php echo esc_html( $lead_count ); ?></p>
		<p>Use the settings page to refine homepage messaging and monitor the new CRM workflow.</p>
		<?php
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

register_activation_hook( __FILE__, array( 'NVConsult_Core', 'activate' ) );
NVConsult_Core::init();
