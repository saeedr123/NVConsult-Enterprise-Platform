<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Portal_Shortcode {
    private const STEPS = [
        'new' => 'Received',
        'reviewing' => 'Review',
        'documents' => 'Documents',
        'submitted' => 'Submitted',
        'approved' => 'Decision',
    ];

    public static function init(): void {
        add_shortcode('nvconsult_applicant_portal', [self::class, 'render']);
        add_action('wp_enqueue_scripts', [self::class, 'register_assets']);
    }

    public static function register_assets(): void {
        wp_register_style('nvconsult-portal', plugins_url('../assets/portal.css', __FILE__), [], NVCONSULT_CORE_VERSION);
        wp_register_script('nvconsult-portal', plugins_url('../assets/portal.js', __FILE__), [], NVCONSULT_CORE_VERSION, true);
    }

    public static function render(): string {
        if (!is_user_logged_in()) {
            return '<section class="nvc-portal nvc-portal-login"><h2>' . esc_html__('Applicant Portal', 'nvconsult-core') . '</h2><p>' . esc_html__('Please sign in to view your applications and documents.', 'nvconsult-core') . '</p><a class="nvc-portal-button" href="' . esc_url(wp_login_url(get_permalink())) . '">' . esc_html__('Sign in', 'nvconsult-core') . '</a></section>';
        }

        wp_enqueue_style('nvconsult-portal');
        wp_enqueue_script('nvconsult-portal');
        $user = wp_get_current_user();
        $seen = (array) get_user_meta($user->ID, '_nvconsult_seen_notifications', true);
        wp_localize_script('nvconsult-portal', 'NVConsultPortal', [
            'nonce' => wp_create_nonce('wp_rest'),
            'notifications' => rest_url('nvconsult/v1/notifications'),
            'seen' => array_values($seen),
        ]);

        $apps = get_posts([
            'post_type' => 'nv_application',
            'post_status' => 'private',
            'numberposts' => 50,
            'meta_key' => '_nvconsult_user_id',
            'meta_value' => $user->ID,
            'orderby' => 'modified',
            'order' => 'DESC',
        ]);
        $tasks = 0;
        foreach ($apps as $app) {
            foreach (NVConsult_Core_Document_Requests::items($app->ID) as $request) {
                if ($request['status'] === 'required') { $tasks++; }
            }
        }
        $unread = NVConsult_Core_Notifications::unread_count($user->ID);

        ob_start();
        ?>
        <section class="nvc-portal">
            <header class="nvc-portal-head">
                <div><span class="nvc-eyebrow"><?php esc_html_e('NVConsult Portal', 'nvconsult-core'); ?></span><h2><?php echo esc_html(sprintf(__('Welcome, %s', 'nvconsult-core'), $user->display_name)); ?></h2></div>
                <div class="nvc-portal-actions"><button type="button" class="nvc-notification-toggle" aria-label="<?php esc_attr_e('Notifications', 'nvconsult-core'); ?>">&#128276;<span class="nvc-notification-count" <?php echo $unread ? '' : 'hidden'; ?>><?php echo absint($unread); ?></span></button><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>"><?php esc_html_e('Sign out', 'nvconsult-core'); ?></a></div>
            </header>
            <aside class="nvc-notification-panel" hidden><div class="nvc-notification-head"><h3><?php esc_html_e('Notifications', 'nvconsult-core'); ?></h3><button type="button" class="nvc-mark-all-read"><?php esc_html_e('Mark all read', 'nvconsult-core'); ?></button></div><div class="nvc-notification-list"><p><?php esc_html_e('Loading…', 'nvconsult-core'); ?></p></div></aside>
            <div class="nvc-stats"><div><strong><?php echo count($apps); ?></strong><span><?php esc_html_e('Applications', 'nvconsult-core'); ?></span></div><div><strong><?php echo self::count_status($apps, 'approved'); ?></strong><span><?php esc_html_e('Approved', 'nvconsult-core'); ?></span></div><div class="<?php echo $tasks ? 'nvc-stat-alert' : ''; ?>"><strong><?php echo absint($tasks); ?></strong><span><?php esc_html_e('Action required', 'nvconsult-core'); ?></span></div></div>
            <div class="nvc-application-list">
                <?php if (!$apps) : ?><div class="nvc-empty"><h3><?php esc_html_e('No applications yet', 'nvconsult-core'); ?></h3></div>
                <?php else : foreach ($apps as $app) { self::card($app); } endif; ?>
            </div>
        </section>
        <?php
        return (string) ob_get_clean();
    }

    private static function count_status(array $apps, string $status): int {
        $count = 0;
        foreach ($apps as $app) {
            if (get_post_meta($app->ID, '_nvconsult_status', true) === $status) { $count++; }
        }
        return $count;
    }

    private static function card(WP_Post $app): void {
        $status = (string) get_post_meta($app->ID, '_nvconsult_status', true);
        $type = (string) get_post_meta($app->ID, '_nvconsult_application_type', true);
        $target = absint(get_post_meta($app->ID, '_nvconsult_target_id', true));
        $docs = get_posts(['post_type'=>'nv_document','post_status'=>'private','numberposts'=>-1,'fields'=>'ids','meta_key'=>'_nvconsult_application_id','meta_value'=>$app->ID]);
        $requests = NVConsult_Core_Document_Requests::items($app->ID);
        ?>
        <article class="nvc-application" id="nvc-application-<?php echo absint($app->ID); ?>">
            <div class="nvc-application-top"><div><span class="nvc-type"><?php echo esc_html(ucfirst($type)); ?></span><h3><?php echo esc_html($target ? get_the_title($target) : sprintf(__('Application #%d', 'nvconsult-core'), $app->ID)); ?></h3></div><span class="nvc-status nvc-status-<?php echo esc_attr($status); ?>"><?php echo esc_html(ucwords(str_replace('_', ' ', $status))); ?></span></div>
            <?php self::timeline($status); if ($requests) { self::tasks($requests); } ?>
            <div class="nvc-application-meta"><span><?php echo esc_html(sprintf(__('%d documents', 'nvconsult-core'), count($docs))); ?></span><span><?php echo esc_html(sprintf(__('Updated %s', 'nvconsult-core'), get_post_modified_time(get_option('date_format'), false, $app->ID))); ?></span></div>
            <?php if ($docs) : ?><div class="nvc-documents"><?php foreach ($docs as $doc) : ?><div><span><?php echo esc_html(ucfirst((string) get_post_meta($doc, '_nvconsult_document_type', true))); ?></span><small><?php echo esc_html(ucwords(str_replace('_', ' ', (string) get_post_meta($doc, '_nvconsult_document_status', true)))); ?></small><a href="<?php echo esc_url(rest_url('nvconsult/v1/documents/' . $doc . '/download')); ?>"><?php esc_html_e('Download', 'nvconsult-core'); ?></a></div><?php endforeach; ?></div><?php endif; ?>
            <?php self::upload($app->ID); ?>
            <button type="button" class="nvc-message-toggle"><?php esc_html_e('Messages', 'nvconsult-core'); ?></button>
            <section class="nvc-messages" data-endpoint="<?php echo esc_url(rest_url('nvconsult/v1/applications/' . $app->ID . '/messages')); ?>" hidden><div class="nvc-message-list"></div><form class="nvc-message-form" data-endpoint="<?php echo esc_url(rest_url('nvconsult/v1/applications/' . $app->ID . '/messages')); ?>"><textarea required maxlength="5000" placeholder="<?php echo esc_attr__('Write a message to your consultant…', 'nvconsult-core'); ?>"></textarea><button type="submit"><?php esc_html_e('Send message', 'nvconsult-core'); ?></button><span class="nvc-message-feedback" aria-live="polite"></span></form></section>
        </article>
        <?php
    }

    private static function tasks(array $requests): void {
        echo '<section class="nvc-tasks"><h4>' . esc_html__('Tasks / Action Required', 'nvconsult-core') . '</h4>';
        foreach ($requests as $item) {
            $required = $item['status'] === 'required';
            printf('<div class="nvc-task %s"><div><strong>%s</strong><p>%s</p></div><span>%s</span></div>', $required ? 'is-required' : 'is-done', esc_html(ucfirst($item['type'])), esc_html($item['note'] ?: __('Please upload this document.', 'nvconsult-core')), esc_html($required ? __('Required', 'nvconsult-core') : __('Uploaded', 'nvconsult-core')));
        }
        echo '</section>';
    }

    private static function upload(int $id): void {
        ?>
        <form class="nvc-upload-form" data-endpoint="<?php echo esc_url(rest_url('nvconsult/v1/applications/' . $id . '/documents')); ?>"><select name="type" required><option value=""><?php esc_html_e('Document type', 'nvconsult-core'); ?></option><?php foreach (['passport'=>'Passport','cv'=>'CV','photo'=>'Photo','academic'=>'Academic','experience'=>'Experience','language'=>'Language','financial'=>'Financial','offer'=>'Offer','visa'=>'Visa','other'=>'Other'] as $value => $label) { printf('<option value="%s">%s</option>', esc_attr($value), esc_html($label)); } ?></select><input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required><button type="submit"><?php esc_html_e('Upload document', 'nvconsult-core'); ?></button><span class="nvc-upload-message" aria-live="polite"></span></form>
        <?php
    }

    private static function timeline(string $status): void {
        $keys = array_keys(self::STEPS);
        $current = array_search($status, $keys, true);
        if ($status === 'rejected' || $status === 'closed') { $current = 3; }
        if ($current === false) { $current = 0; }
        echo '<ol class="nvc-timeline">';
        foreach (self::STEPS as $key => $label) {
            $index = array_search($key, $keys, true);
            printf('<li class="%s"><span></span><small>%s</small></li>', esc_attr($index <= $current ? 'is-active' : ''), esc_html($label));
        }
        echo '</ol>';
    }
}
