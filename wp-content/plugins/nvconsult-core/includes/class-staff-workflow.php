<?php
if (!defined('ABSPATH')) { exit; }

final class NVConsult_Core_Staff_Workflow {
    private const APP_STATUSES=['new','reviewing','documents','submitted','approved','rejected','closed'];
    private const DOC_STATUSES=['uploaded','reviewing','accepted','rejected','replacement_required'];

    public static function init():void{
        add_action('add_meta_boxes_nv_application',[self::class,'application_box']);
        add_action('add_meta_boxes_nv_document',[self::class,'document_box']);
        add_action('save_post_nv_document',[self::class,'save_document'],20,2);
        add_filter('manage_nv_application_posts_columns',[self::class,'columns']);
        add_action('manage_nv_application_posts_custom_column',[self::class,'column'],10,2);
    }
    public static function application_box():void{ add_meta_box('nvc-applicant-details',__('Applicant Details','nvconsult-core'),[self::class,'render_application'],'nv_application','normal','high'); }
    public static function render_application(WP_Post $post):void{
        $fields=['Applicant'=>'_nvconsult_applicant_name','Email'=>'_nvconsult_email','Phone'=>'_nvconsult_phone','Type'=>'_nvconsult_application_type'];
        echo '<table class="widefat striped"><tbody>';foreach($fields as $label=>$key)printf('<tr><th style="width:160px">%s</th><td>%s</td></tr>',esc_html($label),esc_html((string)get_post_meta($post->ID,$key,true)));echo '</tbody></table>';
        $target=absint(get_post_meta($post->ID,'_nvconsult_target_id',true));if($target)printf('<p><strong>%s:</strong> <a href="%s">%s</a></p>',esc_html__('Related opportunity','nvconsult-core'),esc_url(get_edit_post_link($target)),esc_html(get_the_title($target)));
    }
    public static function document_box():void{ add_meta_box('nvc-document-review',__('Document Review','nvconsult-core'),[self::class,'render_document'],'nv_document','normal','high'); }
    public static function render_document(WP_Post $post):void{
        wp_nonce_field('nvc_document_review','nvc_document_nonce');$status=(string)get_post_meta($post->ID,'_nvconsult_document_status',true);$app=absint(get_post_meta($post->ID,'_nvconsult_application_id',true));$attachment=absint(get_post_meta($post->ID,'_nvconsult_attachment_id',true));
        echo '<p><strong>'.esc_html__('Application','nvconsult-core').':</strong> '.esc_html('#'.$app).'</p><p><strong>'.esc_html__('File','nvconsult-core').':</strong> '.esc_html((string)get_post_meta($post->ID,'_nvconsult_original_name',true)).'</p>';
        if($attachment)printf('<p><a class="button" href="%s">%s</a></p>',esc_url(rest_url('nvconsult/v1/documents/'.$post->ID.'/download')),esc_html__('Download securely','nvconsult-core'));
        echo '<p><label><strong>'.esc_html__('Review status','nvconsult-core').'</strong></label><br><select name="nvc_document_status">';foreach(self::DOC_STATUSES as $value)printf('<option value="%1$s" %2$s>%3$s</option>',esc_attr($value),selected($status,$value,false),esc_html(ucwords(str_replace('_',' ',$value))));echo '</select></p>';
        echo '<p><label><strong>'.esc_html__('Reviewer note','nvconsult-core').'</strong></label><br><textarea name="nvc_document_note" rows="4" style="width:100%">'.esc_textarea((string)get_post_meta($post->ID,'_nvconsult_reviewer_note',true)).'</textarea></p>';
    }
    public static function save_document(int $id,WP_Post $post):void{
        if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE)return;if(!current_user_can('nvconsult_manage_applications'))return;if(!isset($_POST['nvc_document_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nvc_document_nonce'])),'nvc_document_review'))return;
        $old=(string)get_post_meta($id,'_nvconsult_document_status',true);$new=sanitize_key($_POST['nvc_document_status']??'');if(in_array($new,self::DOC_STATUSES,true))update_post_meta($id,'_nvconsult_document_status',$new);update_post_meta($id,'_nvconsult_reviewer_note',sanitize_textarea_field(wp_unslash($_POST['nvc_document_note']??'')));
        if($new!==$old&&in_array($new,self::DOC_STATUSES,true))self::notify_document($id,$new);
    }
    private static function notify_document(int $doc_id,string $status):void{
        $app=absint(get_post_meta($doc_id,'_nvconsult_application_id',true));$email=sanitize_email((string)get_post_meta($app,'_nvconsult_email',true));if(!$email)return;$name=(string)get_post_meta($doc_id,'_nvconsult_original_name',true);$subject=sprintf(__('NVConsult document update: %s','nvconsult-core'),$name);$body=sprintf(__('Your document "%1$s" is now marked as %2$s. Please sign in to your NVConsult portal for details.','nvconsult-core'),$name,ucwords(str_replace('_',' ',$status)));wp_mail($email,$subject,$body);
    }
    public static function columns(array $columns):array{$columns['nvc_type']=__('Type','nvconsult-core');$columns['nvc_status']=__('Status','nvconsult-core');$columns['nvc_applicant']=__('Applicant','nvconsult-core');return $columns;}
    public static function column(string $column,int $id):void{if($column==='nvc_type')echo esc_html(ucfirst((string)get_post_meta($id,'_nvconsult_application_type',true)));if($column==='nvc_status')echo esc_html(ucwords(str_replace('_',' ',(string)get_post_meta($id,'_nvconsult_status',true))));if($column==='nvc_applicant')echo esc_html((string)get_post_meta($id,'_nvconsult_applicant_name',true));}
}
