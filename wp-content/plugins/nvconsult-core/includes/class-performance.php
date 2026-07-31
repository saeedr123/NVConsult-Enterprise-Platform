<?php
if(!defined('ABSPATH')){exit;}
final class NVConsult_Core_Performance{
 public static function init():void{add_action('save_post_nv_application',[self::class,'invalidate']);add_action('save_post_nv_contact',[self::class,'invalidate']);add_action('save_post_nv_partner',[self::class,'invalidate']);add_action('deleted_post',[self::class,'invalidate']);}
 public static function invalidate():void{delete_transient('nvc_dashboard_counts');delete_transient('nvc_report_counts');}
 public static function count(string$type,array$args=[]):int{$q=new WP_Query(array_merge(['post_type'=>$type,'post_status'=>'any','posts_per_page'=>1,'fields'=>'ids','no_found_rows'=>false],$args));return(int)$q->found_posts;}
 public static function recent(string$type,int$limit=50,array$args=[]):array{return get_posts(array_merge(['post_type'=>$type,'post_status'=>'any','numberposts'=>max(1,min(200,$limit)),'orderby'=>'modified','order'=>'DESC'], $args));}
}
