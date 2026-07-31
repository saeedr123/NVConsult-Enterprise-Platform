<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Portal_Shortcode {
    public static function init(): void {
        add_shortcode('nvconsult_applicant_portal',[self::class,'render']);
        add_action('wp_enqueue_scripts',[self::class,'register_assets']);
    }

    public static function register_assets(): void {
        wp_register_style('nvconsult-portal',plugins_url('../assets/portal.css',__FILE__),[],NVCONSULT_CORE_VERSION);
    }

    public static function render(): string {
        if (!is_user_logged_in()) {
            return '<section class="nvc-portal nvc-portal-login"><h2>'.esc_html__('Applicant Portal','nvconsult-core').'</h2><p>'.esc_html__('Please sign in to view your applications and documents.','nvconsult-core').'</p><a class="nvc-portal-button" href="'.esc_url(wp_login_url(get_permalink())).'">'.esc_html__('Sign in','nvconsult-core').'</a></section>';
        }
        wp_enqueue_style('nvconsult-portal');
        $user=wp_get_current_user();
        $applications=get_posts(['post_type'=>'nv_application','post_status'=>'private','numberposts'=>50,'meta_key'=>'_nvconsult_user_id','meta_value'=>$user->ID,'orderby'=>'modified','order'=>'DESC']);
        ob_start(); ?>
        <section class="nvc-portal">
            <header class="nvc-portal-head"><div><span class="nvc-eyebrow"><?php esc_html_e('NVConsult Portal','nvconsult-core'); ?></span><h2><?php echo esc_html(sprintf(__('Welcome, %s','nvconsult-core'),$user->display_name)); ?></h2></div><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>"><?php esc_html_e('Sign out','nvconsult-core'); ?></a></header>
            <div class="nvc-stats"><div><strong><?php echo count($applications); ?></strong><span><?php esc_html_e('Applications','nvconsult-core'); ?></span></div><div><strong><?php echo esc_html(self::count_status($applications,'approved')); ?></strong><span><?php esc_html_e('Approved','nvconsult-core'); ?></span></div><div><strong><?php echo esc_html(self::count_status($applications,'documents')); ?></strong><span><?php esc_html_e('Need documents','nvconsult-core'); ?></span></div></div>
            <div class="nvc-application-list">
            <?php if (!$applications): ?><div class="nvc-empty"><h3><?php esc_html_e('No applications yet','nvconsult-core'); ?></h3><p><?php esc_html_e('Your submitted study, job, scholarship, internship and consultation applications will appear here.','nvconsult-core'); ?></p></div>
            <?php else: foreach($applications as $application): self::card($application); endforeach; endif; ?>
            </div>
        </section><?php
        return (string)ob_get_clean();
    }

    private static function count_status(array $applications,string $status): int { $n=0; foreach($applications as $app){ if(get_post_meta($app->ID,'_nvconsult_status',true)===$status)$n++; } return $n; }
    private static function card(WP_Post $app): void {
        $status=(string)get_post_meta($app->ID,'_nvconsult_status',true); $type=(string)get_post_meta($app->ID,'_nvconsult_application_type',true); $target=absint(get_post_meta($app->ID,'_nvconsult_target_id',true));
        $docs=get_posts(['post_type'=>'nv_document','post_status'=>'private','numberposts'=>-1,'fields'=>'ids','meta_key'=>'_nvconsult_application_id','meta_value'=>$app->ID]); ?>
        <article class="nvc-application"><div class="nvc-application-top"><div><span class="nvc-type"><?php echo esc_html(ucfirst($type)); ?></span><h3><?php echo esc_html($target?get_the_title($target):sprintf(__('Application #%d','nvconsult-core'),$app->ID)); ?></h3></div><span class="nvc-status nvc-status-<?php echo esc_attr($status); ?>"><?php echo esc_html(ucwords(str_replace('_',' ',$status))); ?></span></div><div class="nvc-application-meta"><span><?php echo esc_html(sprintf(__('%d documents','nvconsult-core'),count($docs))); ?></span><span><?php echo esc_html(sprintf(__('Updated %s','nvconsult-core'),get_post_modified_time(get_option('date_format'),false,$app->ID))); ?></span></div>
        <?php if($docs): ?><div class="nvc-documents"><?php foreach($docs as $doc): ?><div><span><?php echo esc_html(ucfirst((string)get_post_meta($doc,'_nvconsult_document_type',true))); ?></span><small><?php echo esc_html(ucwords(str_replace('_',' ',(string)get_post_meta($doc,'_nvconsult_document_status',true)))); ?></small><a href="<?php echo esc_url(rest_url('nvconsult/v1/documents/'.$doc.'/download')); ?>"><?php esc_html_e('Download','nvconsult-core'); ?></a></div><?php endforeach; ?></div><?php endif; ?>
        </article><?php
    }
}
