<?php
if(!defined('ABSPATH')){exit;}
final class NVConsult_Core_Installer{
 public static function activate():void{NVConsult_Core_Capabilities::activate();NVConsult_Core_Content_Types::register();NVConsult_Core_Applications::register();NVConsult_Core_CRM::register();NVConsult_Core_Partner_CRM::register();flush_rewrite_rules();if(!wp_next_scheduled('nvconsult_daily_followups'))wp_schedule_event(time()+HOUR_IN_SECONDS,'daily','nvconsult_daily_followups');update_option('nvconsult_core_version',NVCONSULT_CORE_VERSION,false);}
 public static function deactivate():void{$ts=wp_next_scheduled('nvconsult_daily_followups');if($ts)wp_unschedule_event($ts,'nvconsult_daily_followups');flush_rewrite_rules();}
}
