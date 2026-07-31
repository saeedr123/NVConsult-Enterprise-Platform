<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Editor_Fields {
    private const SCHEMA = [
        'nv_university' => [
            '_nvconsult_website' => ['Website', 'url'],
            '_nvconsult_city' => ['City', 'text'],
            '_nvconsult_ranking' => ['Ranking / recognition', 'text'],
            '_nvconsult_application_url' => ['Application URL', 'url'],
        ],
        'nv_program' => [
            '_nvconsult_duration' => ['Duration', 'text'],
            '_nvconsult_tuition' => ['Tuition / fee', 'text'],
            '_nvconsult_intake' => ['Intake', 'text'],
            '_nvconsult_apply_url' => ['Apply URL', 'url'],
        ],
        'nv_scholarship' => [
            '_nvconsult_value' => ['Scholarship value', 'text'],
            '_nvconsult_deadline' => ['Deadline', 'text'],
            '_nvconsult_eligibility' => ['Eligibility summary', 'textarea'],
            '_nvconsult_apply_url' => ['Apply URL', 'url'],
        ],
        'nv_internship' => [
            '_nvconsult_company' => ['Company / host', 'text'],
            '_nvconsult_duration' => ['Duration', 'text'],
            '_nvconsult_deadline' => ['Deadline', 'text'],
            '_nvconsult_apply_url' => ['Apply URL', 'url'],
        ],
        'nv_job' => [
            '_nvconsult_company' => ['Employer', 'text'],
            '_nvconsult_location' => ['Location', 'text'],
            '_nvconsult_salary' => ['Salary / compensation', 'text'],
            '_nvconsult_contract' => ['Contract type', 'text'],
            '_nvconsult_apply_url' => ['Apply URL', 'url'],
        ],
    ];

    public static function init(): void {
        add_action('init', [self::class, 'register_meta']);
        add_action('add_meta_boxes', [self::class, 'add_boxes']);
        add_action('save_post', [self::class, 'save'], 20, 2);
    }

    public static function register_meta(): void {
        foreach (self::SCHEMA as $post_type => $fields) {
            foreach ($fields as $key => $definition) {
                register_post_meta($post_type, $key, [
                    'type' => 'string',
                    'single' => true,
                    'show_in_rest' => true,
                    'sanitize_callback' => $definition[1] === 'url' ? 'esc_url_raw' : 'sanitize_textarea_field',
                    'auth_callback' => static fn() => current_user_can('edit_posts'),
                ]);
            }
        }
    }

    public static function add_boxes(): void {
        foreach (array_keys(self::SCHEMA) as $post_type) {
            add_meta_box('nvconsult-details', __('NVConsult Details', 'nvconsult-core'), [self::class, 'render'], $post_type, 'normal', 'high');
        }
    }

    public static function render(WP_Post $post): void {
        wp_nonce_field('nvconsult_save_editor_fields', 'nvconsult_editor_fields_nonce');
        foreach (self::SCHEMA[$post->post_type] as $key => [$label, $type]) {
            $value = (string) get_post_meta($post->ID, $key, true);
            echo '<p><label><strong>' . esc_html($label) . '</strong></label><br>';
            if ($type === 'textarea') {
                printf('<textarea name="nvconsult_fields[%1$s]" rows="4" style="width:100%%">%2$s</textarea>', esc_attr($key), esc_textarea($value));
            } else {
                printf('<input type="%1$s" name="nvconsult_fields[%2$s]" value="%3$s" style="width:100%%">', $type === 'url' ? 'url' : 'text', esc_attr($key), esc_attr($value));
            }
            echo '</p>';
        }
    }

    public static function save(int $post_id, WP_Post $post): void {
        if (!isset(self::SCHEMA[$post->post_type])) { return; }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
        if (!isset($_POST['nvconsult_editor_fields_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nvconsult_editor_fields_nonce'])), 'nvconsult_save_editor_fields')) { return; }
        if (!current_user_can('edit_post', $post_id)) { return; }

        $submitted = isset($_POST['nvconsult_fields']) && is_array($_POST['nvconsult_fields']) ? wp_unslash($_POST['nvconsult_fields']) : [];
        foreach (self::SCHEMA[$post->post_type] as $key => $definition) {
            $raw = isset($submitted[$key]) ? $submitted[$key] : '';
            $value = $definition[1] === 'url' ? esc_url_raw($raw) : ($definition[1] === 'textarea' ? sanitize_textarea_field($raw) : sanitize_text_field($raw));
            if ($value !== '') { update_post_meta($post_id, $key, $value); } else { delete_post_meta($post_id, $key); }
        }
    }
}
