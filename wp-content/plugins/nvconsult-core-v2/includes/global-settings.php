<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_v2_get_global_defaults() {
	return array(
		'brand' => array(
			'logo_url'        => '',
			'dark_logo_url'   => '',
			'favicon_url'     => '',
			'primary_color'   => '#2563eb',
			'secondary_color' => '#0f172a',
			'accent_color'    => '#f97316',
			'font_family'     => 'Inter, Arial, sans-serif',
		),
		'footer' => array(
			'footer_blurb'   => __( 'Helping students and professionals unlock global opportunities.', 'nvconsult-core-v2' ),
			'copyright_text' => __( '© 2026 NVConsult. All rights reserved.', 'nvconsult-core-v2' ),
			'privacy_url'    => '',
			'terms_url'      => '',
		),
		'social' => array(
			'facebook_url'    => '',
			'instagram_url'   => '',
			'linkedin_url'    => '',
			'youtube_url'     => '',
			'whatsapp_number' => '',
			'phone'           => '',
			'email'           => '',
			'login_url'       => wp_login_url(),
		),
		'analytics' => array(
			'ga_code'                  => '',
			'cookie_banner_enabled'    => false,
			'cookie_banner_text'       => __( 'We use cookies to improve your browsing experience.', 'nvconsult-core-v2' ),
			'announcement_bar_enabled' => false,
			'announcement_bar_text'    => '',
		),
	);
}

function nvconsult_v2_get_global_settings() {
	return wp_parse_args( get_option( 'nvconsult_v2_global', array() ), nvconsult_v2_get_global_defaults() );
}

function nvconsult_v2_save_global_settings() {
	if ( ! isset( $_POST['nvconsult_v2_global_submit'] ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	check_admin_referer( 'nvconsult_v2_save_global', 'nvconsult_v2_global_nonce' );
	$input = isset( $_POST['global'] ) ? wp_unslash( $_POST['global'] ) : array();
	$data  = array(
		'brand' => array(
			'logo_url'        => isset( $input['brand']['logo_url'] ) ? esc_url_raw( $input['brand']['logo_url'] ) : '',
			'dark_logo_url'   => isset( $input['brand']['dark_logo_url'] ) ? esc_url_raw( $input['brand']['dark_logo_url'] ) : '',
			'favicon_url'     => isset( $input['brand']['favicon_url'] ) ? esc_url_raw( $input['brand']['favicon_url'] ) : '',
			'primary_color'   => isset( $input['brand']['primary_color'] ) ? sanitize_text_field( $input['brand']['primary_color'] ) : '',
			'secondary_color' => isset( $input['brand']['secondary_color'] ) ? sanitize_text_field( $input['brand']['secondary_color'] ) : '',
			'accent_color'    => isset( $input['brand']['accent_color'] ) ? sanitize_text_field( $input['brand']['accent_color'] ) : '',
			'font_family'     => isset( $input['brand']['font_family'] ) ? sanitize_text_field( $input['brand']['font_family'] ) : '',
		),
		'footer' => array(
			'footer_blurb'   => isset( $input['footer']['footer_blurb'] ) ? sanitize_textarea_field( $input['footer']['footer_blurb'] ) : '',
			'copyright_text' => isset( $input['footer']['copyright_text'] ) ? sanitize_text_field( $input['footer']['copyright_text'] ) : '',
			'privacy_url'    => isset( $input['footer']['privacy_url'] ) ? esc_url_raw( $input['footer']['privacy_url'] ) : '',
			'terms_url'      => isset( $input['footer']['terms_url'] ) ? esc_url_raw( $input['footer']['terms_url'] ) : '',
		),
		'social' => array(
			'facebook_url'    => isset( $input['social']['facebook_url'] ) ? esc_url_raw( $input['social']['facebook_url'] ) : '',
			'instagram_url'   => isset( $input['social']['instagram_url'] ) ? esc_url_raw( $input['social']['instagram_url'] ) : '',
			'linkedin_url'    => isset( $input['social']['linkedin_url'] ) ? esc_url_raw( $input['social']['linkedin_url'] ) : '',
			'youtube_url'     => isset( $input['social']['youtube_url'] ) ? esc_url_raw( $input['social']['youtube_url'] ) : '',
			'whatsapp_number' => isset( $input['social']['whatsapp_number'] ) ? sanitize_text_field( $input['social']['whatsapp_number'] ) : '',
			'phone'           => isset( $input['social']['phone'] ) ? sanitize_text_field( $input['social']['phone'] ) : '',
			'email'           => isset( $input['social']['email'] ) ? sanitize_email( $input['social']['email'] ) : '',
			'login_url'       => isset( $input['social']['login_url'] ) ? esc_url_raw( $input['social']['login_url'] ) : wp_login_url(),
		),
		'analytics' => array(
			'ga_code'                  => isset( $input['analytics']['ga_code'] ) ? wp_kses_post( $input['analytics']['ga_code'] ) : '',
			'cookie_banner_enabled'    => ! empty( $input['analytics']['cookie_banner_enabled'] ),
			'cookie_banner_text'       => isset( $input['analytics']['cookie_banner_text'] ) ? sanitize_text_field( $input['analytics']['cookie_banner_text'] ) : '',
			'announcement_bar_enabled' => ! empty( $input['analytics']['announcement_bar_enabled'] ),
			'announcement_bar_text'    => isset( $input['analytics']['announcement_bar_text'] ) ? sanitize_text_field( $input['analytics']['announcement_bar_text'] ) : '',
		),
	);
	update_option( 'nvconsult_v2_global', $data );
	add_settings_error( 'nvconsult_v2_messages', 'nvconsult_v2_global_saved', __( 'Global settings updated.', 'nvconsult-core-v2' ), 'updated' );
}
add_action( 'admin_init', 'nvconsult_v2_save_global_settings' );

function nvconsult_v2_render_global_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$settings = nvconsult_v2_get_global_settings();
	settings_errors( 'nvconsult_v2_messages' );
	?>
	<div class="wrap nvconsult-v2-tabs-wrap">
		<h1><?php esc_html_e( 'Global Theme Settings', 'nvconsult-core-v2' ); ?></h1>
		<form method="post">
			<?php wp_nonce_field( 'nvconsult_v2_save_global', 'nvconsult_v2_global_nonce' ); ?>
			<h2 class="nav-tab-wrapper"><a href="#nv-brand" class="nav-tab nav-tab-active"><?php esc_html_e( 'Brand', 'nvconsult-core-v2' ); ?></a><a href="#nv-footer" class="nav-tab"><?php esc_html_e( 'Footer', 'nvconsult-core-v2' ); ?></a><a href="#nv-social" class="nav-tab"><?php esc_html_e( 'Social', 'nvconsult-core-v2' ); ?></a><a href="#nv-analytics" class="nav-tab"><?php esc_html_e( 'Analytics', 'nvconsult-core-v2' ); ?></a></h2>
			<div id="nv-brand" class="nv-tab-panel" style="display:block;"><table class="form-table"><tbody><tr><th><?php esc_html_e( 'Logo URL', 'nvconsult-core-v2' ); ?></th><td><input class="large-text" type="url" name="global[brand][logo_url]" value="<?php echo esc_attr( $settings['brand']['logo_url'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Dark Logo URL', 'nvconsult-core-v2' ); ?></th><td><input class="large-text" type="url" name="global[brand][dark_logo_url]" value="<?php echo esc_attr( $settings['brand']['dark_logo_url'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Favicon URL', 'nvconsult-core-v2' ); ?></th><td><input class="large-text" type="url" name="global[brand][favicon_url]" value="<?php echo esc_attr( $settings['brand']['favicon_url'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Primary Color', 'nvconsult-core-v2' ); ?></th><td><input class="regular-text" type="text" name="global[brand][primary_color]" value="<?php echo esc_attr( $settings['brand']['primary_color'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Secondary Color', 'nvconsult-core-v2' ); ?></th><td><input class="regular-text" type="text" name="global[brand][secondary_color]" value="<?php echo esc_attr( $settings['brand']['secondary_color'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Accent Color', 'nvconsult-core-v2' ); ?></th><td><input class="regular-text" type="text" name="global[brand][accent_color]" value="<?php echo esc_attr( $settings['brand']['accent_color'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Font Family', 'nvconsult-core-v2' ); ?></th><td><input class="regular-text" type="text" name="global[brand][font_family]" value="<?php echo esc_attr( $settings['brand']['font_family'] ); ?>"></td></tr></tbody></table></div>
			<div id="nv-footer" class="nv-tab-panel" style="display:none;"><table class="form-table"><tbody><tr><th><?php esc_html_e( 'Footer Blurb', 'nvconsult-core-v2' ); ?></th><td><textarea class="large-text" rows="3" name="global[footer][footer_blurb]"><?php echo esc_textarea( $settings['footer']['footer_blurb'] ); ?></textarea></td></tr><tr><th><?php esc_html_e( 'Copyright Text', 'nvconsult-core-v2' ); ?></th><td><input class="regular-text" type="text" name="global[footer][copyright_text]" value="<?php echo esc_attr( $settings['footer']['copyright_text'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Privacy URL', 'nvconsult-core-v2' ); ?></th><td><input class="large-text" type="url" name="global[footer][privacy_url]" value="<?php echo esc_attr( $settings['footer']['privacy_url'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Terms URL', 'nvconsult-core-v2' ); ?></th><td><input class="large-text" type="url" name="global[footer][terms_url]" value="<?php echo esc_attr( $settings['footer']['terms_url'] ); ?>"></td></tr></tbody></table></div>
			<div id="nv-social" class="nv-tab-panel" style="display:none;"><table class="form-table"><tbody><tr><th><?php esc_html_e( 'Facebook URL', 'nvconsult-core-v2' ); ?></th><td><input class="large-text" type="url" name="global[social][facebook_url]" value="<?php echo esc_attr( $settings['social']['facebook_url'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Instagram URL', 'nvconsult-core-v2' ); ?></th><td><input class="large-text" type="url" name="global[social][instagram_url]" value="<?php echo esc_attr( $settings['social']['instagram_url'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'LinkedIn URL', 'nvconsult-core-v2' ); ?></th><td><input class="large-text" type="url" name="global[social][linkedin_url]" value="<?php echo esc_attr( $settings['social']['linkedin_url'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'YouTube URL', 'nvconsult-core-v2' ); ?></th><td><input class="large-text" type="url" name="global[social][youtube_url]" value="<?php echo esc_attr( $settings['social']['youtube_url'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'WhatsApp Number', 'nvconsult-core-v2' ); ?></th><td><input class="regular-text" type="text" name="global[social][whatsapp_number]" value="<?php echo esc_attr( $settings['social']['whatsapp_number'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Phone', 'nvconsult-core-v2' ); ?></th><td><input class="regular-text" type="text" name="global[social][phone]" value="<?php echo esc_attr( $settings['social']['phone'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Email', 'nvconsult-core-v2' ); ?></th><td><input class="regular-text" type="email" name="global[social][email]" value="<?php echo esc_attr( $settings['social']['email'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Login URL', 'nvconsult-core-v2' ); ?></th><td><input class="large-text" type="url" name="global[social][login_url]" value="<?php echo esc_attr( $settings['social']['login_url'] ); ?>"></td></tr></tbody></table></div>
			<div id="nv-analytics" class="nv-tab-panel" style="display:none;"><table class="form-table"><tbody><tr><th><?php esc_html_e( 'GA Code', 'nvconsult-core-v2' ); ?></th><td><textarea class="large-text" rows="5" name="global[analytics][ga_code]"><?php echo esc_textarea( $settings['analytics']['ga_code'] ); ?></textarea></td></tr><tr><th><?php esc_html_e( 'Cookie Banner Enabled', 'nvconsult-core-v2' ); ?></th><td><label><input type="checkbox" name="global[analytics][cookie_banner_enabled]" value="1" <?php checked( ! empty( $settings['analytics']['cookie_banner_enabled'] ) ); ?>> <?php esc_html_e( 'Enable cookie banner', 'nvconsult-core-v2' ); ?></label></td></tr><tr><th><?php esc_html_e( 'Cookie Banner Text', 'nvconsult-core-v2' ); ?></th><td><input class="large-text" type="text" name="global[analytics][cookie_banner_text]" value="<?php echo esc_attr( $settings['analytics']['cookie_banner_text'] ); ?>"></td></tr><tr><th><?php esc_html_e( 'Announcement Bar Enabled', 'nvconsult-core-v2' ); ?></th><td><label><input type="checkbox" name="global[analytics][announcement_bar_enabled]" value="1" <?php checked( ! empty( $settings['analytics']['announcement_bar_enabled'] ) ); ?>> <?php esc_html_e( 'Enable announcement bar', 'nvconsult-core-v2' ); ?></label></td></tr><tr><th><?php esc_html_e( 'Announcement Bar Text', 'nvconsult-core-v2' ); ?></th><td><input class="large-text" type="text" name="global[analytics][announcement_bar_text]" value="<?php echo esc_attr( $settings['analytics']['announcement_bar_text'] ); ?>"></td></tr></tbody></table></div>
			<p class="submit"><button type="submit" name="nvconsult_v2_global_submit" class="button button-primary"><?php esc_html_e( 'Save Global Settings', 'nvconsult-core-v2' ); ?></button></p>
		</form>
	</div>
	<script>(function(){const tabs=document.querySelectorAll('.nav-tab-wrapper a');const panels=document.querySelectorAll('.nv-tab-panel');tabs.forEach(function(tab){tab.addEventListener('click',function(event){event.preventDefault();tabs.forEach(function(item){item.classList.remove('nav-tab-active');});panels.forEach(function(panel){panel.style.display='none';});tab.classList.add('nav-tab-active');const target=document.querySelector(tab.getAttribute('href'));if(target){target.style.display='block';}});});})();</script>
	<?php
}
