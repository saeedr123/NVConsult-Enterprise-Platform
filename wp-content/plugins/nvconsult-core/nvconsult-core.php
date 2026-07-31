<?php
/**
 * Plugin Name: NVConsult Core
 * Description: Durable content models and shared platform services for NVConsult.
 * Version: 0.1.0
 * Requires at least: 6.4
 * Requires PHP: 8.0
 * Text Domain: nvconsult-core
 */
if (!defined('ABSPATH')) { exit; }

define('NVCONSULT_CORE_VERSION', '0.1.0');
define('NVCONSULT_CORE_FILE', __FILE__);
define('NVCONSULT_CORE_DIR', plugin_dir_path(__FILE__));

require_once NVCONSULT_CORE_DIR . 'includes/class-content-types.php';

add_action('plugins_loaded', static function () {
    NVConsult_Core_Content_Types::init();
});
