<?php
/**
 * Plugin Name: NVConsult Core
 * Description: Unified NVConsult platform for opportunities, CRM, applications, documents, messaging, notifications, reporting, automation, AI and staff/applicant workflows.
 * Version: 0.40.0
 * Requires at least: 6.4
 * Requires PHP: 8.0
 * Text Domain: nvconsult-core
 */
if(!defined('ABSPATH')){exit;}
define('NVCONSULT_CORE_VERSION','0.40.0');define('NVCONSULT_CORE_FILE',__FILE__);define('NVCONSULT_CORE_DIR',plugin_dir_path(__FILE__));
foreach(['class-content-types.php','class-capabilities.php','class-relationships.php','class-university-relationships.php','class-editor-fields.php','class-job-importer.php','class-job-taxonomies.php','class-job-query.php','class-applications.php','class-documents.php','class-protected-downloads.php','class-applicant-portal.php','class-portal-shortcode.php','class-staff-workflow.php','class-messages.php','class-activity.php','class-document-requests.php','class-notifications.php','class-staff-dashboard.php','class-followups.php','class-staff-actions.php','class-staff-collaboration.php','class-crm.php','class-partner-crm.php','class-automation-rules.php','class-reporting.php','class-security.php','class-ai-assistant.php','class-health.php','class-installer.php','class-data-integrity.php']as$f)require_once NVCONSULT_CORE_DIR.'includes/'.$f;
register_activation_hook(__FILE__,['NVConsult_Core_Installer','activate']);register_deactivation_hook(__FILE__,['NVConsult_Core_Installer','deactivate']);
add_action('plugins_loaded',static function(){foreach(['NVConsult_Core_Content_Types','NVConsult_Core_Relationships','NVConsult_Core_University_Relationships','NVConsult_Core_Editor_Fields','NVConsult_Core_Job_Importer','NVConsult_Core_Job_Taxonomies','NVConsult_Core_Job_Query','NVConsult_Core_Applications','NVConsult_Core_Documents','NVConsult_Core_Protected_Downloads','NVConsult_Core_Applicant_Portal','NVConsult_Core_Portal_Shortcode','NVConsult_Core_Staff_Workflow','NVConsult_Core_Messages','NVConsult_Core_Activity','NVConsult_Core_Document_Requests','NVConsult_Core_Notifications','NVConsult_Core_Staff_Dashboard','NVConsult_Core_Followups','NVConsult_Core_Staff_Actions','NVConsult_Core_Staff_Collaboration','NVConsult_Core_CRM','NVConsult_Core_Partner_CRM','NVConsult_Core_Automation_Rules','NVConsult_Core_Reporting','NVConsult_Core_Security','NVConsult_Core_AI_Assistant','NVConsult_Core_Health','NVConsult_Core_Data_Integrity']as$c)$c::init();});
