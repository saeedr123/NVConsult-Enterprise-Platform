<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function nvconsultv2_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 220, 'flex-height' => true, 'flex-width' => true ) );
    register_nav_menus( array(
        'primary'              => __( 'Primary Navigation', 'nvconsult-theme-v2' ),
        'footer_study_abroad'  => __( 'Footer: Study Abroad', 'nvconsult-theme-v2' ),
        'footer_work_abroad'   => __( 'Footer: Work Abroad', 'nvconsult-theme-v2' ),
        'footer_consultation'  => __( 'Footer: Consultation', 'nvconsult-theme-v2' ),
        'footer_company'       => __( 'Footer: Company', 'nvconsult-theme-v2' ),
    ) );
}
add_action( 'after_setup_theme', 'nvconsultv2_theme_setup' );

function nvconsultv2_theme_enqueue_assets() {
    wp_enqueue_style( 'nvconsult-theme-v2-style', get_stylesheet_uri(), array(), '2.0.0' );
    wp_enqueue_script( 'nvconsult-theme-v2-main', get_template_directory_uri() . '/assets/js/main.js', array(), '2.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'nvconsultv2_theme_enqueue_assets' );

function nvconsultv2_get_global_settings() {
    if ( function_exists( 'nvconsult_v2_get_global_settings' ) ) {
        return nvconsult_v2_get_global_settings();
    }

    return array(
        'brand' => array(),
        'footer' => array(
            'footer_blurb'   => __( 'Helping students and professionals unlock global opportunities.', 'nvconsult-theme-v2' ),
            'copyright_text' => __( '© 2026 NVConsult. All rights reserved.', 'nvconsult-theme-v2' ),
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
        'analytics' => array(),
    );
}

function nvconsultv2_get_homepage_sections() {
    if ( function_exists( 'nvconsult_v2_get_homepage_sections' ) ) {
        return nvconsult_v2_get_homepage_sections();
    }
    return array(
        array( 'id' => 'hero', 'enabled' => true, 'order' => 1 ),
        array( 'id' => 'journey-cards', 'enabled' => true, 'order' => 2 ),
        array( 'id' => 'featured-destinations', 'enabled' => true, 'order' => 3 ),
        array( 'id' => 'featured-jobs', 'enabled' => true, 'order' => 4 ),
        array( 'id' => 'why-nvconsult', 'enabled' => true, 'order' => 5 ),
        array( 'id' => 'consultation-plans', 'enabled' => true, 'order' => 6 ),
        array( 'id' => 'testimonials', 'enabled' => true, 'order' => 7 ),
        array( 'id' => 'knowledge-centre', 'enabled' => true, 'order' => 8 ),
        array( 'id' => 'cta', 'enabled' => true, 'order' => 9 ),
    );
}

function nvconsultv2_get_section_settings( $section_id ) {
    $sections = nvconsultv2_get_homepage_sections();
    foreach ( $sections as $section ) {
        if ( isset( $section['id'] ) && $section_id === $section['id'] ) {
            return $section;
        }
    }
    return array();
}

function nvconsultv2_button_class( $color ) {
    $map = array(
        'blue'   => 'btn-primary',
        'orange' => 'btn-secondary',
        'green'  => 'btn-green',
    );
    return isset( $map[ $color ] ) ? $map[ $color ] : 'btn-primary';
}

function nvconsultv2_render_section_heading( $section_id, $default_heading = '', $default_subheading = '' ) {
    $section = nvconsultv2_get_section_settings( $section_id );
    $heading = ! empty( $section['heading'] ) ? $section['heading'] : $default_heading;
    $subheading = ! empty( $section['subheading'] ) ? $section['subheading'] : $default_subheading;
    if ( empty( $heading ) && empty( $subheading ) ) {
        return;
    }
    echo '<div class="section-heading">';
    if ( ! empty( $heading ) ) {
        echo '<h2>' . esc_html( $heading ) . '</h2>';
    }
    if ( ! empty( $subheading ) ) {
        echo '<p>' . esc_html( $subheading ) . '</p>';
    }
    echo '</div>';
}
