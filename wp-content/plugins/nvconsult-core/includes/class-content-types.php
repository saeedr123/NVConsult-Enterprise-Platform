<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Content_Types {
    public static function init(): void {
        add_action('init', [self::class, 'register']);
    }

    public static function register(): void {
        $types = [
            'nv_service' => ['Services', 'Service'],
            'nv_country' => ['Countries', 'Country'],
            'nv_university' => ['Universities', 'University'],
            'nv_program' => ['Study Programs', 'Study Program'],
            'nv_scholarship' => ['Scholarships', 'Scholarship'],
            'nv_internship' => ['Internships', 'Internship'],
            'nv_job' => ['Jobs', 'Job'],
            'nv_testimonial' => ['Testimonials', 'Testimonial'],
            'nv_faq' => ['FAQs', 'FAQ'],
            'nv_article' => ['Knowledge Centre', 'Article'],
        ];

        foreach ($types as $slug => [$plural, $singular]) {
            register_post_type($slug, [
                'labels' => ['name' => $plural, 'singular_name' => $singular],
                'public' => true,
                'show_in_rest' => true,
                'has_archive' => !in_array($slug, ['nv_testimonial', 'nv_faq'], true),
                'rewrite' => ['slug' => sanitize_title($plural)],
                'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'],
                'menu_position' => 25,
            ]);
        }

        register_taxonomy('nv_destination', ['nv_university','nv_program','nv_scholarship','nv_internship','nv_job'], [
            'labels' => ['name' => 'Destinations', 'singular_name' => 'Destination'],
            'public' => true,
            'hierarchical' => true,
            'show_in_rest' => true,
        ]);
    }
}
