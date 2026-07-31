<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Relationships {
    private const META_COUNTRY = '_nvconsult_country_id';
    private const SUPPORTED = ['nv_university', 'nv_program', 'nv_scholarship', 'nv_internship', 'nv_job'];

    public static function init(): void {
        add_action('add_meta_boxes', [self::class, 'add_meta_boxes']);
        add_action('save_post', [self::class, 'save'], 10, 2);
        add_action('init', [self::class, 'register_meta']);
    }

    public static function register_meta(): void {
        foreach (self::SUPPORTED as $post_type) {
            register_post_meta($post_type, self::META_COUNTRY, [
                'type' => 'integer',
                'single' => true,
                'default' => 0,
                'show_in_rest' => true,
                'sanitize_callback' => 'absint',
                'auth_callback' => static fn() => current_user_can('edit_posts'),
            ]);
        }
    }

    public static function add_meta_boxes(): void {
        foreach (self::SUPPORTED as $post_type) {
            add_meta_box(
                'nvconsult-country-relationship',
                __('Destination Country', 'nvconsult-core'),
                [self::class, 'render_country_box'],
                $post_type,
                'side',
                'default'
            );
        }
    }

    public static function render_country_box(WP_Post $post): void {
        wp_nonce_field('nvconsult_save_relationships', 'nvconsult_relationship_nonce');
        $selected = absint(get_post_meta($post->ID, self::META_COUNTRY, true));
        $countries = get_posts([
            'post_type' => 'nv_country',
            'post_status' => 'publish',
            'numberposts' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        ]);
        echo '<select name="nvconsult_country_id" style="width:100%">';
        echo '<option value="0">' . esc_html__('Select country', 'nvconsult-core') . '</option>';
        foreach ($countries as $country) {
            printf(
                '<option value="%1$d" %2$s>%3$s</option>',
                absint($country->ID),
                selected($selected, $country->ID, false),
                esc_html($country->post_title)
            );
        }
        echo '</select>';
    }

    public static function save(int $post_id, WP_Post $post): void {
        if (!in_array($post->post_type, self::SUPPORTED, true)) { return; }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
        if (!isset($_POST['nvconsult_relationship_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nvconsult_relationship_nonce'])), 'nvconsult_save_relationships')) { return; }
        if (!current_user_can('edit_post', $post_id)) { return; }

        $country_id = isset($_POST['nvconsult_country_id']) ? absint($_POST['nvconsult_country_id']) : 0;
        if ($country_id && get_post_type($country_id) !== 'nv_country') { return; }

        if ($country_id) {
            update_post_meta($post_id, self::META_COUNTRY, $country_id);
        } else {
            delete_post_meta($post_id, self::META_COUNTRY);
        }
    }

    public static function country_id(int $post_id): int {
        return absint(get_post_meta($post_id, self::META_COUNTRY, true));
    }
}
