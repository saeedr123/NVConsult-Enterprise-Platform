<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Applications {
    private const STATUS = ['new','reviewing','documents','submitted','approved','rejected','closed'];

    public static function init(): void {
        add_action('init', [self::class, 'register']);
        add_action('rest_api_init', [self::class, 'routes']);
        add_action('add_meta_boxes_nv_application', [self::class, 'add_box']);
        add_action('save_post_nv_application', [self::class, 'save_admin'], 10, 2);
    }

    public static function register(): void {
        register_post_type('nv_application', [
            'labels' => ['name' => __('Applications','nvconsult-core'), 'singular_name' => __('Application','nvconsult-core')],
            'public' => false, 'show_ui' => true, 'show_in_menu' => true, 'show_in_rest' => false,
            'supports' => ['title'], 'menu_icon' => 'dashicons-clipboard',
            'capability_type' => 'post', 'map_meta_cap' => true,
        ]);
        foreach (['_nvconsult_applicant_name','_nvconsult_email','_nvconsult_phone','_nvconsult_application_type','_nvconsult_status'] as $key) {
            register_post_meta('nv_application', $key, ['type'=>'string','single'=>true,'show_in_rest'=>false,'sanitize_callback'=>'sanitize_text_field','auth_callback'=>static fn()=>current_user_can('nvconsult_manage_applications')]);
        }
        register_post_meta('nv_application','_nvconsult_target_id',['type'=>'integer','single'=>true,'show_in_rest'=>false,'sanitize_callback'=>'absint','auth_callback'=>static fn()=>current_user_can('nvconsult_manage_applications')]);
    }

    public static function routes(): void {
        register_rest_route('nvconsult/v1','/applications',[ 'methods'=>WP_REST_Server::CREATABLE, 'callback'=>[self::class,'create'], 'permission_callback'=>'__return_true' ]);
        register_rest_route('nvconsult/v1','/applications/(?P<id>\d+)',[ 'methods'=>WP_REST_Server::READABLE, 'callback'=>[self::class,'view'], 'permission_callback'=>[self::class,'can_view'] ]);
    }

    public static function create(WP_REST_Request $request) {
        $name=sanitize_text_field((string)$request['name']); $email=sanitize_email((string)$request['email']);
        if ($name==='' || !is_email($email)) return new WP_Error('invalid_application',__('Name and a valid email are required.','nvconsult-core'),['status'=>400]);
        $type=sanitize_key((string)$request['type']); if (!in_array($type,['job','program','scholarship','internship','consultation','general'],true)) $type='general';
        $target=absint($request['target_id']);
        $id=wp_insert_post(['post_type'=>'nv_application','post_status'=>'private','post_title'=>sprintf('%s — %s',$name,current_time('Y-m-d H:i'))],true);
        if (is_wp_error($id)) return $id;
        update_post_meta($id,'_nvconsult_applicant_name',$name); update_post_meta($id,'_nvconsult_email',$email);
        update_post_meta($id,'_nvconsult_phone',sanitize_text_field((string)$request['phone'])); update_post_meta($id,'_nvconsult_application_type',$type);
        update_post_meta($id,'_nvconsult_target_id',$target); update_post_meta($id,'_nvconsult_status','new');
        if (is_user_logged_in()) update_post_meta($id,'_nvconsult_user_id',get_current_user_id());
        $token=wp_generate_password(32,false,false); update_post_meta($id,'_nvconsult_tracking_hash',wp_hash_password($token));
        return new WP_REST_Response(['application_id'=>$id,'status'=>'new','tracking_token'=>$token],201);
    }

    public static function can_view(WP_REST_Request $request): bool {
        if (current_user_can('nvconsult_manage_applications')) return true;
        $id=absint($request['id']); if (!$id || get_post_type($id)!=='nv_application') return false;
        if (is_user_logged_in() && absint(get_post_meta($id,'_nvconsult_user_id',true))===get_current_user_id()) return true;
        $token=sanitize_text_field((string)$request->get_param('token')); $hash=(string)get_post_meta($id,'_nvconsult_tracking_hash',true);
        return $token!=='' && $hash!=='' && wp_check_password($token,$hash);
    }

    public static function view(WP_REST_Request $request): WP_REST_Response {
        $id=absint($request['id']);
        return new WP_REST_Response(['id'=>$id,'type'=>(string)get_post_meta($id,'_nvconsult_application_type',true),'target_id'=>absint(get_post_meta($id,'_nvconsult_target_id',true)),'status'=>(string)get_post_meta($id,'_nvconsult_status',true),'updated'=>get_post_modified_time(DATE_ATOM,true,$id)],200);
    }

    public static function add_box(): void { add_meta_box('nvconsult-application-status',__('Application Workflow','nvconsult-core'),[self::class,'render_box'],'nv_application','side','high'); }
    public static function render_box(WP_Post $post): void {
        wp_nonce_field('nvconsult_application_admin','nvconsult_application_nonce'); $current=(string)get_post_meta($post->ID,'_nvconsult_status',true);
        echo '<select name="nvconsult_application_status" style="width:100%">'; foreach(self::STATUS as $status) printf('<option value="%1$s" %2$s>%3$s</option>',esc_attr($status),selected($current,$status,false),esc_html(ucwords(str_replace('_',' ',$status)))); echo '</select>';
    }
    public static function save_admin(int $id, WP_Post $post): void {
        if (defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE) return; if (!current_user_can('nvconsult_manage_applications')) return;
        if (!isset($_POST['nvconsult_application_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nvconsult_application_nonce'])),'nvconsult_application_admin')) return;
        $status=sanitize_key($_POST['nvconsult_application_status']??''); if (in_array($status,self::STATUS,true)) update_post_meta($id,'_nvconsult_status',$status);
    }
}
