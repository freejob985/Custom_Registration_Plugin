<?php
/*
Plugin Name: Custom_Registration_Plugin
Description: Plugin to add custom user registration.
Version: 1.1
Author: Your Name
*/
if (!session_id()) {
    session_start();
}
/*
 */
// Enqueue your CSS file
function enqueue_custom_css()
{
    wp_enqueue_style('custom-style', plugins_url('Custom_Registration_Plugin/css/cs.css'));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_css');
function my_custom_shortcode_with_html()
{
    $html_content = include 'new_user.php';
    return $html_content;
}
add_shortcode('new_user', 'my_custom_shortcode_with_html');
/*
 */
function process_registration_form()
{
    if (isset($_POST['submit_registration']) && !is_admin()) {
        if (!isset($_POST['my_nonce']) || !wp_verify_nonce($_POST['my_nonce'], 'my_action')) {
            die('خطأ في التحقق');
        }
        $username = sanitize_user($_POST['username']);
        $email_to_retrieve = isset($_SESSION['email']) ? sanitize_email($_SESSION['email']) : '';

        $password = sanitize_text_field($_POST['password']);
        $confirm_password = sanitize_text_field($_POST['confirm_password']);
        if ($password !== $confirm_password) {
            $_SESSION['new_user'] = "كلمة المرور غير متطابقة.";
            wp_redirect($_SERVER['HTTP_REFERER']);
            wp_die('');
        }
        // قم بفحص صحة البريد الإلكتروني وفحص توفر اسم المستخدم
        if (!is_email($email_to_retrieve) || username_exists($username) || email_exists($email_to_retrieve)) {
            $_SESSION['new_user'] = "البريد الإلكتروني أو اسم المستخدم غير صالح أو مأخوذ بالفعل.";
            wp_redirect($_SERVER['HTTP_REFERER']);
            wp_die('');
        }
        // إنشاء المستخدم وحفظ بياناته في قاعدة البيانات
        $user_id = wp_create_user($username, $password, $email_to_retrieve);
        if (!is_wp_error($user_id)) {
echo "2";
         wp_redirect(home_url());
        } else {
            $_SESSION['new_user'] = "'حدثت مشكلة أثناء تسجيل المستخدم.'";
            wp_redirect($_SERVER['HTTP_REFERER']);
            wp_die('');
        }
    }
}
add_action('init', 'process_registration_form');
function registration()
{
    $page_title = 'registration';
    $page_content = '
    <div class="container">
    [new_user]
    </div>
';
    $new_page = array(
        'post_title' => $page_title,
        'post_content' => $page_content,
        'post_status' => 'publish',
        'post_type' => 'page',
    );
    $page_id = wp_insert_post($new_page); 
}
register_activation_hook(__FILE__, 'registration');
// ======================================================================================
/*
*/
register_deactivation_hook(__FILE__, 'delete_plugin_registration');
function delete_plugin_registration()
{
    $page_title = 'registration'; 
    $page = get_page_by_title($page_title);
    if ($page) {
        wp_delete_post($page->ID, true);
    }
}
// =======================================================================================

