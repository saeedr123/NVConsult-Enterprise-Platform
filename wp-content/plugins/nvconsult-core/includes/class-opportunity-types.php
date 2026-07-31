<?php
if(!defined('ABSPATH')){exit;}
final class NVConsult_Core_Opportunity_Types{
 public static function init():void{add_action('init',[self::class,'meta'],20);}
 public static function meta():void{foreach(['nv_scholarship','nv_internship']as$type){register_post_meta($type,'_nvconsult_deadline',['type'=>'string','single'=>true,'show_in_rest'=>true,'sanitize_callback'=>'sanitize_text_field']);register_post_meta($type,'_nvconsult_provider',['type'=>'string','single'=>true,'show_in_rest'=>true,'sanitize_callback'=>'sanitize_text_field']);register_post_meta($type,'_nvconsult_eligibility',['type'=>'string','single'=>true,'show_in_rest'=>true,'sanitize_callback'=>'sanitize_textarea_field']);}}
 public static function kinds():array{return['job'=>'Job','program'=>'University / Study','scholarship'=>'Scholarship','internship'=>'Internship','consultation'=>'Consultation','general'=>'General'];}
}
