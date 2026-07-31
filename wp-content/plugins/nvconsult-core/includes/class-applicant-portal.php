<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Applicant_Portal {
    public static function init(): void {
        add_action('rest_api_init', [self::class, 'routes']);
    }

    public static function routes(): void {
        register_rest_route('nvconsult/v1','/portal/me',[
            'methods'=>WP_REST_Server::READABLE,
            'callback'=>[self::class,'dashboard'],
            'permission_callback'=>static fn()=>is_user_logged_in(),
        ]);
    }

    public static function dashboard(): WP_REST_Response {
        $user=wp_get_current_user();
        $applications=get_posts([
            'post_type'=>'nv_application','post_status'=>'private','numberposts'=>50,
            'meta_key'=>'_nvconsult_user_id','meta_value'=>$user->ID,'orderby'=>'modified','order'=>'DESC',
        ]);
        $items=array_map([self::class,'application_item'],$applications);
        return new WP_REST_Response([
            'user'=>['id'=>$user->ID,'display_name'=>$user->display_name,'email'=>$user->user_email],
            'applications'=>$items,
            'counts'=>self::counts($items),
        ],200);
    }

    private static function application_item(WP_Post $application): array {
        $id=$application->ID;
        $document_ids=get_posts([
            'post_type'=>'nv_document','post_status'=>'private','numberposts'=>-1,'fields'=>'ids',
            'meta_key'=>'_nvconsult_application_id','meta_value'=>$id,
        ]);
        $documents=array_map(static fn($doc_id)=>[
            'id'=>$doc_id,
            'type'=>(string)get_post_meta($doc_id,'_nvconsult_document_type',true),
            'status'=>(string)get_post_meta($doc_id,'_nvconsult_document_status',true),
            'filename'=>(string)get_post_meta($doc_id,'_nvconsult_original_name',true),
            'download'=>rest_url('nvconsult/v1/documents/'.$doc_id.'/download'),
        ],$document_ids);
        $target_id=absint(get_post_meta($id,'_nvconsult_target_id',true));
        return [
            'id'=>$id,
            'type'=>(string)get_post_meta($id,'_nvconsult_application_type',true),
            'status'=>(string)get_post_meta($id,'_nvconsult_status',true),
            'target_id'=>$target_id,
            'target_title'=>$target_id ? get_the_title($target_id) : '',
            'target_url'=>$target_id ? get_permalink($target_id) : '',
            'documents'=>$documents,
            'updated'=>get_post_modified_time(DATE_ATOM,true,$id),
        ];
    }

    private static function counts(array $items): array {
        $counts=['total'=>count($items),'active'=>0,'approved'=>0,'documents_needed'=>0];
        foreach($items as $item){
            if (!in_array($item['status'],['approved','rejected','closed'],true)) $counts['active']++;
            if ($item['status']==='approved') $counts['approved']++;
            if ($item['status']==='documents') $counts['documents_needed']++;
        }
        return $counts;
    }
}
