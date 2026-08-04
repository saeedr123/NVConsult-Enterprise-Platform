<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nvconsult_v2_get_default_journey_cards() {
	return array(
		array(
			'title'       => __( 'I Want to Study Abroad', 'nvconsult-core-v2' ),
			'subtitle'    => __( 'Academic pathways', 'nvconsult-core-v2' ),
			'description' => __( 'Find countries, institutions, and programs that align with your goals.', 'nvconsult-core-v2' ),
			'image_url'   => '',
			'btn_label'   => __( 'Explore Study Options', 'nvconsult-core-v2' ),
			'btn_link'    => '#',
			'color'       => 'blue',
			'enabled'     => true,
			'order'       => 1,
		),
		array(
			'title'       => __( 'I Want to Work Abroad', 'nvconsult-core-v2' ),
			'subtitle'    => __( 'Career pathways', 'nvconsult-core-v2' ),
			'description' => __( 'Browse visa-friendly jobs and practical relocation support.', 'nvconsult-core-v2' ),
			'image_url'   => '',
			'btn_label'   => __( 'View Work Opportunities', 'nvconsult-core-v2' ),
			'btn_link'    => '#',
			'color'       => 'orange',
			'enabled'     => true,
			'order'       => 2,
		),
	);
}

function nvconsult_v2_save_journey_cards() {
	if ( ! isset( $_POST['nvconsult_v2_journey_cards_submit'] ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	check_admin_referer( 'nvconsult_v2_save_journey_cards', 'nvconsult_v2_journey_cards_nonce' );
	$cards_input = isset( $_POST['cards'] ) ? wp_unslash( $_POST['cards'] ) : array();
	$cards       = array();
	foreach ( $cards_input as $card ) {
		if ( empty( $card['title'] ) && empty( $card['description'] ) ) {
			continue;
		}
		$cards[] = array(
			'title'       => isset( $card['title'] ) ? sanitize_text_field( $card['title'] ) : '',
			'subtitle'    => isset( $card['subtitle'] ) ? sanitize_text_field( $card['subtitle'] ) : '',
			'description' => isset( $card['description'] ) ? sanitize_textarea_field( $card['description'] ) : '',
			'image_url'   => isset( $card['image_url'] ) ? esc_url_raw( $card['image_url'] ) : '',
			'btn_label'   => isset( $card['btn_label'] ) ? sanitize_text_field( $card['btn_label'] ) : '',
			'btn_link'    => isset( $card['btn_link'] ) ? esc_url_raw( $card['btn_link'] ) : '',
			'color'       => isset( $card['color'] ) ? sanitize_text_field( $card['color'] ) : 'blue',
			'enabled'     => ! empty( $card['enabled'] ),
			'order'       => isset( $card['order'] ) ? absint( $card['order'] ) : 0,
		);
	}
	update_option( 'nvconsult_v2_journey_cards', $cards );
	add_settings_error( 'nvconsult_v2_messages', 'nvconsult_v2_journey_cards_saved', __( 'Journey cards updated.', 'nvconsult-core-v2' ), 'updated' );
}
add_action( 'admin_init', 'nvconsult_v2_save_journey_cards' );

function nvconsult_v2_render_journey_cards_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$cards = get_option( 'nvconsult_v2_journey_cards', nvconsult_v2_get_default_journey_cards() );
	settings_errors( 'nvconsult_v2_messages' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Journey Cards', 'nvconsult-core-v2' ); ?></h1>
		<form method="post">
			<?php wp_nonce_field( 'nvconsult_v2_save_journey_cards', 'nvconsult_v2_journey_cards_nonce' ); ?>
			<div id="nvconsult-v2-journey-cards-admin">
				<?php foreach ( $cards as $index => $card ) : ?>
					<div class="postbox" style="padding:16px;margin-bottom:16px;">
						<p><label><?php esc_html_e( 'Title', 'nvconsult-core-v2' ); ?><br><input class="widefat" type="text" name="cards[<?php echo esc_attr( (string) $index ); ?>][title]" value="<?php echo esc_attr( $card['title'] ); ?>"></label></p>
						<p><label><?php esc_html_e( 'Subtitle', 'nvconsult-core-v2' ); ?><br><input class="widefat" type="text" name="cards[<?php echo esc_attr( (string) $index ); ?>][subtitle]" value="<?php echo esc_attr( $card['subtitle'] ); ?>"></label></p>
						<p><label><?php esc_html_e( 'Description', 'nvconsult-core-v2' ); ?><br><textarea class="widefat" rows="4" name="cards[<?php echo esc_attr( (string) $index ); ?>][description]"><?php echo esc_textarea( $card['description'] ); ?></textarea></label></p>
						<p><label><?php esc_html_e( 'Image URL', 'nvconsult-core-v2' ); ?><br><input class="widefat" type="url" name="cards[<?php echo esc_attr( (string) $index ); ?>][image_url]" value="<?php echo esc_attr( $card['image_url'] ); ?>"></label></p>
						<p><label><?php esc_html_e( 'Button Label', 'nvconsult-core-v2' ); ?><br><input class="widefat" type="text" name="cards[<?php echo esc_attr( (string) $index ); ?>][btn_label]" value="<?php echo esc_attr( $card['btn_label'] ); ?>"></label></p>
						<p><label><?php esc_html_e( 'Button Link', 'nvconsult-core-v2' ); ?><br><input class="widefat" type="url" name="cards[<?php echo esc_attr( (string) $index ); ?>][btn_link]" value="<?php echo esc_attr( $card['btn_link'] ); ?>"></label></p>
						<p><label><?php esc_html_e( 'Color', 'nvconsult-core-v2' ); ?><br><select name="cards[<?php echo esc_attr( (string) $index ); ?>][color]"><option value="blue" <?php selected( $card['color'], 'blue' ); ?>><?php esc_html_e( 'Blue', 'nvconsult-core-v2' ); ?></option><option value="orange" <?php selected( $card['color'], 'orange' ); ?>><?php esc_html_e( 'Orange', 'nvconsult-core-v2' ); ?></option></select></label></p>
						<p><label><?php esc_html_e( 'Order', 'nvconsult-core-v2' ); ?><br><input class="small-text" type="number" name="cards[<?php echo esc_attr( (string) $index ); ?>][order]" value="<?php echo esc_attr( (string) $card['order'] ); ?>"></label></p>
						<p><label><input type="checkbox" name="cards[<?php echo esc_attr( (string) $index ); ?>][enabled]" value="1" <?php checked( ! empty( $card['enabled'] ) ); ?>> <?php esc_html_e( 'Enabled', 'nvconsult-core-v2' ); ?></label></p>
						<p><button type="button" class="button nvconsult-v2-delete-card"><?php esc_html_e( 'Delete Card', 'nvconsult-core-v2' ); ?></button></p>
					</div>
				<?php endforeach; ?>
			</div>
			<p><button type="button" class="button" id="nvconsult-v2-add-card"><?php esc_html_e( 'Add New Card', 'nvconsult-core-v2' ); ?></button></p>
			<p class="submit"><button type="submit" name="nvconsult_v2_journey_cards_submit" class="button button-primary"><?php esc_html_e( 'Save Journey Cards', 'nvconsult-core-v2' ); ?></button></p>
		</form>
	</div>
	<script>
	(function(){const container=document.getElementById('nvconsult-v2-journey-cards-admin');const addButton=document.getElementById('nvconsult-v2-add-card');if(!container||!addButton){return;}container.addEventListener('click',function(event){if(event.target.classList.contains('nvconsult-v2-delete-card')){event.preventDefault();const box=event.target.closest('.postbox');if(box){box.remove();}}});addButton.addEventListener('click',function(){const index=container.children.length;const wrapper=document.createElement('div');wrapper.className='postbox';wrapper.style.cssText='padding:16px;margin-bottom:16px;';wrapper.innerHTML='<p><label><?php echo esc_js( __( 'Title', 'nvconsult-core-v2' ) ); ?><br><input class="widefat" type="text" name="cards['+index+'][title]"></label></p><p><label><?php echo esc_js( __( 'Subtitle', 'nvconsult-core-v2' ) ); ?><br><input class="widefat" type="text" name="cards['+index+'][subtitle]"></label></p><p><label><?php echo esc_js( __( 'Description', 'nvconsult-core-v2' ) ); ?><br><textarea class="widefat" rows="4" name="cards['+index+'][description]"></textarea></label></p><p><label><?php echo esc_js( __( 'Image URL', 'nvconsult-core-v2' ) ); ?><br><input class="widefat" type="url" name="cards['+index+'][image_url]"></label></p><p><label><?php echo esc_js( __( 'Button Label', 'nvconsult-core-v2' ) ); ?><br><input class="widefat" type="text" name="cards['+index+'][btn_label]"></label></p><p><label><?php echo esc_js( __( 'Button Link', 'nvconsult-core-v2' ) ); ?><br><input class="widefat" type="url" name="cards['+index+'][btn_link]"></label></p><p><label><?php echo esc_js( __( 'Color', 'nvconsult-core-v2' ) ); ?><br><select name="cards['+index+'][color]"><option value="blue"><?php echo esc_js( __( 'Blue', 'nvconsult-core-v2' ) ); ?></option><option value="orange"><?php echo esc_js( __( 'Orange', 'nvconsult-core-v2' ) ); ?></option></select></label></p><p><label><?php echo esc_js( __( 'Order', 'nvconsult-core-v2' ) ); ?><br><input class="small-text" type="number" name="cards['+index+'][order]" value="'+(index+1)+'"></label></p><p><label><input type="checkbox" name="cards['+index+'][enabled]" value="1" checked> <?php echo esc_js( __( 'Enabled', 'nvconsult-core-v2' ) ); ?></label></p><p><button type="button" class="button nvconsult-v2-delete-card"><?php echo esc_js( __( 'Delete Card', 'nvconsult-core-v2' ) ); ?></button></p>';container.appendChild(wrapper);});})();
	</script>
	<?php
}
