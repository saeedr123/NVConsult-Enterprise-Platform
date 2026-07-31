<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Protected_Downloads {
    public static function init(): void {
        add_action('rest_api_init', [self::class, 'routes']);
    }

    public static function routes(): void {
        register_rest_route('nvconsult/v1','/documents/(?P<id>\d+)/download',[
            'methods'=>WP_REST_Server::READABLE,
            'callback'=>[self::class,'download'],
            'permission_callback'=>[self::class,'can_download'],
        ]);
    }

    public static function can_download(WP_REST_Request $request): bool {
        $doc_id=absint($request['id']);
        if (!$doc_id || get_post_type($doc_id)!=='nv_document') return false;
        if (current_user_can('nvconsult_manage_applications')) return true;
        $application_id=absint(get_post_meta($doc_id,'_nvconsult_application_id',true));
        return is_user_logged_in() && $application_id && absint(get_post_meta($application_id,'_nvconsult_user_id',true))===get_current_user_id();
    }

    public static function download(WP_REST_Request $request) {
        $doc_id=absint($request['id']);
        $attachment_id=absint(get_post_meta($doc_id,'_nvconsult_attachment_id',true));
        $path=$attachment_id ? get_attached_file($attachment_id) : '';
        if (!$path || !is_file($path) || !is_readable($path)) return new WP_Error('document_missing',__('Document file is unavailable.','nvconsult-core'),['status'=>404]);
        $mime=get_post_mime_type($attachment_id) ?: 'application/octet-stream';
        $name=sanitize_file_name((string)get_post_meta($doc_id,'_nvconsult_original_name',true));
        if ($name==='') $name=basename($path);
        while (ob_get_level()) { ob_end_clean(); }
        nocache_headers();
        header('X-Content-Type-Options: nosniff');
        header('Content-Type: '.sanitize_mime_type($mime));
        header('Content-Disposition: attachment; filename="'.str_replace('"','',$name).'"');
        header('Content-Length: '.filesize($path));
        readfile($path);
        exit;
    }
}
