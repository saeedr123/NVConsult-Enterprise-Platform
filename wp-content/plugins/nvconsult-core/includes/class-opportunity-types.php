<?php
if(!defined('ABSPATH')){exit;}
final class NVConsult_Core_Opportunity_Types{
 public static function init():void{add_action('init',[self::class,'register']);}
 public static function register():void{foreach(['nv_scholarship'=>['Scholarships','Scholarship'],'nv_internship'=>['Internships','Internship']]as$type=>$labels)register_post_type($type,['labels'=>['name'=>__($labels[0],'nvconsult-core'),'singular_name'=>__($labels[1],'nvconsult-core')],'public'=>true,'show_ui'=>true,'show_in_rest'=>true,'has_archive'=>true,'rewrite'=>['slug'=>$type==='nv_scholarship'?'scholarships':'internships'],'supports'=>['title','editor','excerpt','thumbnail','custom-fields'],'taxonomies'=>['category','post_tag']]);}
 public static function kinds():array{return['job'=>'Job','university'=>'University / Study','scholarship'=>'Scholarship','internship'=>'Internship'];}
}
