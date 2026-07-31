<?php
if(!defined('ABSPATH')){exit;}
function nvconsult_theme_setup():void{add_theme_support('title-tag');add_theme_support('post-thumbnails');add_theme_support('html5',['search-form','gallery','caption','style','script']);register_nav_menus(['primary'=>__('Primary Navigation','nvconsult'),'footer'=>__('Footer Navigation','nvconsult')]);}
add_action('after_setup_theme','nvconsult_theme_setup');
add_action('wp_enqueue_scripts',static function(){wp_enqueue_style('nvconsult-theme',get_stylesheet_uri(),[],wp_get_theme()->get('Version'));});
function nvconsult_theme_url(string$slug):string{$page=get_page_by_path($slug);return$page?get_permalink($page):home_url('/'.$slug.'/');}
function nvconsult_platform_active():bool{return class_exists('NVConsult_Core_Applications');}
function nvconsult_opportunity_count(string$type):int{$q=new WP_Query(['post_type'=>$type,'post_status'=>'publish','posts_per_page'=>1,'fields'=>'ids','no_found_rows'=>false]);return(int)$q->found_posts;}
function nvconsult_archive_url(string$type):string{$url=get_post_type_archive_link($type);return$url?:home_url('/');}
add_action('pre_get_posts',static function(WP_Query$q):void{if(is_admin()||!$q->is_main_query()||!$q->is_post_type_archive())return;$types=(array)$q->get('post_type');if(!array_intersect($types,['nv_program','nv_scholarship','nv_internship','nv_job','nv_university','nv_country','nv_service']))return;$dest=isset($_GET['destination'])?sanitize_title(wp_unslash($_GET['destination'])):'';if($dest)$q->set('tax_query',[['taxonomy'=>'nv_destination','field'=>'slug','terms'=>$dest]]);$q->set('posts_per_page',12);});
