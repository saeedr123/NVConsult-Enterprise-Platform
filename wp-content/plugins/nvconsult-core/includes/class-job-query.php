<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Job_Query {
    public static function init(): void {
        add_action('rest_api_init', [self::class, 'routes']);
    }

    public static function routes(): void {
        register_rest_route('nvconsult/v1', '/jobs', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [self::class, 'search'],
            'permission_callback' => '__return_true',
            'args' => [
                'search' => ['sanitize_callback' => 'sanitize_text_field'],
                'country_id' => ['sanitize_callback' => 'absint'],
                'category' => ['sanitize_callback' => 'sanitize_title'],
                'sector' => ['sanitize_callback' => 'sanitize_title'],
                'contract' => ['sanitize_callback' => 'sanitize_title'],
                'page' => ['default' => 1, 'sanitize_callback' => 'absint'],
                'per_page' => ['default' => 12, 'sanitize_callback' => 'absint'],
            ],
        ]);
    }

    public static function search(WP_REST_Request $request): WP_REST_Response {
        $per_page = min(50, max(1, absint($request['per_page'])));
        $args = [
            'post_type' => 'nv_job', 'post_status' => 'publish',
            's' => sanitize_text_field((string) $request['search']),
            'paged' => max(1, absint($request['page'])), 'posts_per_page' => $per_page,
        ];
        $meta_query = [];
        if (absint($request['country_id'])) { $meta_query[] = ['key' => '_nvconsult_country_id', 'value' => absint($request['country_id']), 'compare' => '=']; }
        if ($meta_query) { $args['meta_query'] = $meta_query; }
        $tax_query = [];
        foreach (['category' => 'nv_job_category', 'sector' => 'nv_job_sector', 'contract' => 'nv_job_contract'] as $param => $taxonomy) {
            if ($request[$param]) { $tax_query[] = ['taxonomy' => $taxonomy, 'field' => 'slug', 'terms' => sanitize_title((string) $request[$param])]; }
        }
        if ($tax_query) { $args['tax_query'] = array_merge(['relation' => 'AND'], $tax_query); }
        $query = new WP_Query($args);
        $items = array_map(static function(WP_Post $job): array {
            return [
                'id' => $job->ID, 'title' => get_the_title($job), 'url' => get_permalink($job),
                'excerpt' => get_the_excerpt($job), 'company' => (string) get_post_meta($job->ID, '_nvconsult_company', true),
                'location' => (string) get_post_meta($job->ID, '_nvconsult_location', true), 'salary' => (string) get_post_meta($job->ID, '_nvconsult_salary', true),
                'country_id' => absint(get_post_meta($job->ID, '_nvconsult_country_id', true)),
            ];
        }, $query->posts);
        return new WP_REST_Response(['items' => $items, 'page' => max(1, absint($request['page'])), 'pages' => (int) $query->max_num_pages, 'total' => (int) $query->found_posts]);
    }
}
