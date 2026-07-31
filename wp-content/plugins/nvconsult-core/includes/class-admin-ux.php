<?php
if(!defined('ABSPATH')){exit;}
final class NVConsult_Core_Admin_UX{
 public static function init():void{add_action('post_submitbox_misc_actions',[self::class,'case_actions']);add_action('admin_notices',[self::class,'notices']);}
 public static function case_actions(WP_Post$p):void{if($p->post_type!=='nv_application'||!current_user_can('nvconsult_manage_applications'))return;$portal=rest_url('nvconsult/v1/applications/'.$p->ID);echo'<div class="misc-pub-section"><strong>'.esc_html__('Case tools','nvconsult-core').'</strong><br><a class="button button-small" href="'.esc_url(NVConsult_Core_Audit_Export::url($p->ID)).'">'.esc_html__('Export audit CSV','nvconsult-core').'</a> <a class="button button-small" href="'.esc_url($portal).'" target="_blank" rel="noopener">'.esc_html__('REST record','nvconsult-core').'</a></div>';}
 public static function notices():void{if(!current_user_can('manage_options'))return;if(!is_ssl())echo'<div class="notice notice-error"><p>'.esc_html__('NVConsult: HTTPS is not active. Do not use real applicant data until HTTPS is enabled.','nvconsult-core').'</p></div>';if(!getenv('OPENAI_API_KEY'))echo'<div class="notice notice-info is-dismissible"><p>'.esc_html__('NVConsult AI is disabled until OPENAI_API_KEY is configured server-side. Core platform features continue to work.','nvconsult-core').'</p></div>';}
}
