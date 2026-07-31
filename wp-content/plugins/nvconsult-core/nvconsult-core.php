<?php
/**
 * Plugin Name: NVConsult Core
 * Description: Durable content models, relationships, editorial fields, job ingestion, capabilities and shared platform services for NVConsult.
 * Version: 0.6.0
 * Requires at least: 6.4
 * Requires PHP: 8.0
 * Text Domain: nvconsult-core
 */
if (!defined('ABSPATH')) { exit; }

define('NVCONSULT_CORE_VERSION', '0.6.0');
define('NVCONSULT_CORE_FILE', __FILE__);
define('NVCONSULT_CORE_DIR', plugin_dir_path(__FILE__));

require_once NVCONSULT_CORE_DIR . 'includes/class-content-types.php';
require_once NVCONSULT_CORE_DIR . 'includes/class-capabilities.php';
require_once NVCONSULT_CORE_DIR . 'includes/class-relationships.php';
require_once NVCONSULT_CORE_DIR . 'includes/class-university-relationships.php';
require_once NVCONSULT_CORE_DIR . 'includes/class-editor-fields.php';
require_once NVCONSULT_CORE_DIR . 'includes/class-job-importer.php';

register_activation_hook(__FILE__, ['NVConsult_Core_Capabilities', 'activate']);
register_deactivation_hook(__FILE__, ['NVConsult_Core_Capabilities', 'deactivate']);

add_action('plugins_loaded', static function () {
    NVConsult_Core_Content_Types::init();
    NVConsult_Core_Relationships::init();
    NVConsult_Core_University_Relationships::init();
    NVConsult_Core_Editor_Fields::init();
    NVConsult_Core_Job_Importer::init();
});
