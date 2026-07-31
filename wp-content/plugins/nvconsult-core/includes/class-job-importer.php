<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Job_Importer {
    public static function init(): void {
        add_action('admin_menu', [self::class, 'menu']);
        add_action('admin_post_nvconsult_import_jobs', [self::class, 'handle']);
    }

    public static function menu(): void {
        add_submenu_page('edit.php?post_type=nv_job', __('Import Jobs', 'nvconsult-core'), __('Import Jobs', 'nvconsult-core'), 'nvconsult_manage_recruitment', 'nvconsult-job-import', [self::class, 'render']);
    }

    public static function render(): void {
        if (!current_user_can('nvconsult_manage_recruitment')) { wp_die(esc_html__('You do not have permission to import jobs.', 'nvconsult-core')); }
        echo '<div class="wrap"><h1>' . esc_html__('Import Jobs', 'nvconsult-core') . '</h1>';
        if (isset($_GET['imported'])) { printf('<div class="notice notice-success"><p>%s</p></div>', esc_html(sprintf(__('%d jobs imported/updated.', 'nvconsult-core'), absint($_GET['imported'])))); }
        echo '<p>' . esc_html__('Upload UTF-8 CSV with headers: external_id,title,description,company,location,salary,contract,apply_url,country.', 'nvconsult-core') . '</p>';
        echo '<form method="post" enctype="multipart/form-data" action="' . esc_url(admin_url('admin-post.php')) . '">';
        wp_nonce_field('nvconsult_import_jobs', 'nvconsult_import_nonce');
        echo '<input type="hidden" name="action" value="nvconsult_import_jobs">';
        echo '<input type="file" name="jobs_csv" accept=".csv,text/csv" required> ';
        submit_button(__('Import CSV', 'nvconsult-core'), 'primary', 'submit', false);
        echo '</form></div>';
    }

    public static function handle(): void {
        if (!current_user_can('nvconsult_manage_recruitment')) { wp_die(esc_html__('Permission denied.', 'nvconsult-core')); }
        check_admin_referer('nvconsult_import_jobs', 'nvconsult_import_nonce');
        if (empty($_FILES['jobs_csv']['tmp_name']) || !is_uploaded_file($_FILES['jobs_csv']['tmp_name'])) { wp_die(esc_html__('No valid CSV uploaded.', 'nvconsult-core')); }
        if (!empty($_FILES['jobs_csv']['size']) && (int) $_FILES['jobs_csv']['size'] > 5 * MB_IN_BYTES) { wp_die(esc_html__('CSV is too large.', 'nvconsult-core')); }

        $handle = fopen($_FILES['jobs_csv']['tmp_name'], 'r');
        if (!$handle) { wp_die(esc_html__('Could not read CSV.', 'nvconsult-core')); }
        $headers = fgetcsv($handle);
        $allowed = ['external_id','title','description','company','location','salary','contract','apply_url','country'];
        if (!$headers) { fclose($handle); wp_die(esc_html__('CSV has no header row.', 'nvconsult-core')); }
        $headers = array_map(static fn($h) => sanitize_key(trim((string) $h)), $headers);
        if (array_diff($headers, $allowed) || !in_array('title', $headers, true)) { fclose($handle); wp_die(esc_html__('CSV headers are invalid or title is missing.', 'nvconsult-core')); }

        $count = 0;
        while (($values = fgetcsv($handle)) !== false) {
            if (count($values) !== count($headers)) { continue; }
            $row = array_combine($headers, $values);
            if (empty(trim((string) $row['title']))) { continue; }
            if (self::upsert($row)) { $count++; }
        }
        fclose($handle);
        wp_safe_redirect(add_query_arg('imported', $count, admin_url('edit.php?post_type=nv_job&page=nvconsult-job-import')));
        exit;
    }

    private static function upsert(array $row): int {
        $external_id = sanitize_text_field($row['external_id'] ?? '');
        $existing = [];
        if ($external_id !== '') {
            $existing = get_posts(['post_type' => 'nv_job', 'post_status' => 'any', 'meta_key' => '_nvconsult_external_id', 'meta_value' => $external_id, 'numberposts' => 1, 'fields' => 'ids']);
        }
        $postarr = [
            'post_type' => 'nv_job', 'post_status' => 'draft',
            'post_title' => sanitize_text_field($row['title'] ?? ''),
            'post_content' => wp_kses_post($row['description'] ?? ''),
        ];
        if ($existing) { $postarr['ID'] = (int) $existing[0]; unset($postarr['post_status']); }
        $post_id = wp_insert_post($postarr, true);
        if (is_wp_error($post_id)) { return 0; }
        $map = ['company' => '_nvconsult_company', 'location' => '_nvconsult_location', 'salary' => '_nvconsult_salary', 'contract' => '_nvconsult_contract'];
        foreach ($map as $source => $meta) { if (isset($row[$source])) { update_post_meta($post_id, $meta, sanitize_text_field($row[$source])); } }
        if (!empty($row['apply_url'])) { update_post_meta($post_id, '_nvconsult_apply_url', esc_url_raw($row['apply_url'])); }
        if ($external_id !== '') { update_post_meta($post_id, '_nvconsult_external_id', $external_id); }
        if (!empty($row['country'])) {
            $country = get_page_by_title(sanitize_text_field($row['country']), OBJECT, 'nv_country');
            if ($country) { update_post_meta($post_id, '_nvconsult_country_id', (int) $country->ID); }
        }
        update_post_meta($post_id, '_nvconsult_import_source', 'csv');
        return (int) $post_id;
    }
}
