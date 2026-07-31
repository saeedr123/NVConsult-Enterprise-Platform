<?php
if(!defined('ABSPATH')){exit;}
final class NVConsult_Core_Audit_Export{
 public static function init():void{add_action('admin_post_nvc_export_case_audit',[self::class,'export']);}
 public static function export():void{if(!current_user_can('nvconsult_manage_applications'))wp_die(esc_html__('Access denied.','nvconsult-core'));$id=absint($_GET['application_id']??0);check_admin_referer('nvc_export_case_audit_'.$id);if(!$id||get_post_type($id)!=='nv_application')wp_die(esc_html__('Invalid application.','nvconsult-core'));$items=NVConsult_Core_Activity::items($id,true);$name='nvconsult-case-'.$id.'-audit-'.gmdate('Ymd-His').'.csv';nocache_headers();header('Content-Type: text/csv; charset=utf-8');header('Content-Disposition: attachment; filename="'.$name.'"');$out=fopen('php://output','w');fputcsv($out,['time','type','actor','event']);foreach($items as$i)fputcsv($out,[(string)($i['time']??''),(string)($i['type']??''),(string)($i['actor']??''),(string)($i['text']??'')]);fclose($out);exit;}
 public static function url(int$id):string{return wp_nonce_url(admin_url('admin-post.php?action=nvc_export_case_audit&application_id='.$id),'nvc_export_case_audit_'.$id);}
}
