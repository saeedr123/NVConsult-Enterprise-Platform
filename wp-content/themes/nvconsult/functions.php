<?php
if(!defined('ABSPATH')){exit;}
function nvconsult_theme_setup():void{add_theme_support('title-tag');add_theme_support('post-thumbnails');add_theme_support('html5',['search-form','gallery','caption','style','script']);register_nav_menus(['primary'=>__('Primary Navigation','nvconsult'),'footer'=>__('Footer Navigation','nvconsult')]);}
add_action('after_setup_theme','nvconsult_theme_setup');
add_action('wp_enqueue_scripts',static function(){wp_enqueue_style('nvconsult-theme',get_stylesheet_uri(),[],wp_get_theme()->get('Version'));});
function nvconsult_theme_url(string$slug):string{$page=get_page_by_path($slug);return$page?get_permalink($page):home_url('/'.$slug.'/');}
function nvconsult_platform_active():bool{return class_exists('NVConsult_Core_Applications');}
function nvconsult_opportunity_count(string$type):int{$q=new WP_Query(['post_type'=>$type,'post_status'=>'publish','posts_per_page'=>1,'fields'=>'ids','no_found_rows'=>false]);return(int)$q->found_posts;}
