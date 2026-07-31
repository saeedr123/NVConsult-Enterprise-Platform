<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Job_Taxonomies {
    public static function init(): void {
        add_action('init', [self::class, 'register']);
    }

    public static function register(): void {
        self::taxonomy('nv_job_category', __('Job Categories', 'nvconsult-core'), __('Job Category', 'nvconsult-core'), 'job-category');
        self::taxonomy('nv_job_contract', __('Contract Types', 'nvconsult-core'), __('Contract Type', 'nvconsult-core'), 'contract-type');
        self::taxonomy('nv_job_sector', __('Job Sectors', 'nvconsult-core'), __('Job Sector', 'nvconsult-core'), 'job-sector');
    }

    private static function taxonomy(string $key, string $plural, string $singular, string $slug): void {
        register_taxonomy($key, ['nv_job'], [
            'labels' => ['name' => $plural, 'singular_name' => $singular, 'search_items' => sprintf(__('Search %s', 'nvconsult-core'), $plural)],
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'hierarchical' => true,
            'rewrite' => ['slug' => $slug, 'with_front' => false],
        ]);
    }
}
