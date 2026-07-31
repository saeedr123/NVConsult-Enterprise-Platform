<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_University_Relationships {
    private const META_UNIVERSITY = '_nvconsult_university_id';
    private const SUPPORTED = ['nv_program', 'nv_scholarship', 'nv_internship'];

    public static function init(): void {
        add_action('init', [self::class, 'register_meta']);
        add_action('add_meta_boxes', [self::class, 'add_boxes']);
        add_action('save_post', [self::class, 'save'], 15, 2);
    }

    public static function register_meta(): void {
        foreach (self::SUPPORTED as $post_type) {
            register_post_meta($post_type, self::META_UNIVERSITY, [
                'type' => 'integer', 'single' => true, 'default' => 0, 'show_in_rest' => true,
                'sanitize_callback' => 'absint',
                'auth_callback' => static fn() => current_user_can('edit_posts'),
            ]);
        }
    }

    public static function add_boxes(): void {
        foreach (self::SUPPORTED as $post_type) {
            add_meta_box('nvconsult-university-relationship', __('University / Institution', 'nvconsult-core'), [self::class, 'render'], $post_type, 'side', 'default');
        }
    }

    public static function render(WP_Post $post): void {
        wp_nonce_field('nvconsult_save_university_relationship', 'nvconsult_university_nonce');
        $selected = absint(get_post_meta($post->ID, self::META_UNIVERSITY, true));
        $universities = get_posts(['post_type' => 'nv_university', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC']);
        echo '<select name="nvconsult_university_id" style="width:100%">';
        echo '<option value="0">' . esc_html__('Not linked to a university', 'nvconsult-core') . '</option>';
        foreach ($universities as $university) {
            printf('<option value="%1$d" %2$s>%3$s</option>', absint($university->ID), selected($selected, $university->ID, false), esc_html($university->post_title));
        }
        echo '</select>';
    }

    public static function save(int $post_id, WP_Post $post): void {
        if (!in_array($post->post_type, self::SUPPORTED, true)) { return; }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
        if (!isset($_POST['nvconsult_university_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nvconsult_university_nonce'])), 'nvconsult_save_university_relationship')) { return; }
        if (!current_user_can('edit_post', $post_id)) { return; }
        $university_id = isset($_POST['nvconsult_university_id']) ? absint($_POST['nvconsult_university_id']) : 0;
        if ($university_id && get_post_type($university_id) !== 'nv_university') { return; }
        if ($university_id) { update_post_meta($post_id, self::META_UNIVERSITY, $university_id); }
        else { delete_post_meta($post_id, self::META_UNIVERSITY); }
    }

    public static function university_id(int $post_id): int {
        return absint(get_post_meta($post_id, self::META_UNIVERSITY, true));
    }
}
