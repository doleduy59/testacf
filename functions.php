<?php
function theme_setup(){
    add_theme_support( 'post-thumbnails' );

    register_nav_menus( array(
        'navbar_desktop' => esc_html__( 'Menu Header'),
        'footer_desktop'  => esc_html__( 'Menu Footer'),
    ) );
    
    add_theme_support( 'title-tag' );
    
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );
}
add_action( 'after_setup_theme', 'theme_setup' );


function theme_script() {
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), '1.0');
    wp_enqueue_style( 'main-css', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0', 'all');
    wp_enqueue_style( 'hero-css', get_template_directory_uri() . '/assets/css/hero.css', array(), '1.0', 'all');
    wp_enqueue_style( 'button-css', get_template_directory_uri() . '/assets/css/button.css', array(), '1.0', 'all');
    wp_enqueue_style( 'event-post-css', get_template_directory_uri() . '/assets/css/event-post.css', array(), '1.0', 'all');
    wp_enqueue_style( 'demo-hardcode-css', get_template_directory_uri() . '/assets/css/home-demo-hardcode.css', array(), '1.0', 'all');


    wp_enqueue_style( 'inter-tight-font', 'https://fonts.googleapis.com/css2?family=Inter+Tight:wght@100;200;300;400;500;600;700&display=swap', array(), '1.0', 'all' );
    wp_enqueue_style('font-awesome','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',array(),'6.0.0');

}
add_action( 'wp_enqueue_scripts', 'theme_script' );




// khai báo AJAX
function add_ajax_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('filter-cat', get_template_directory_uri() . '/assets/script/filter-cat.js', array('jquery'), '1.0', true); //cho script filter-cat
    
    wp_localize_script('filter-cat', 'my_ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'add_ajax_scripts');

// Xử lý AJAX
function load_category_posts() {
    check_ajax_referer('ajax_nonce', 'nonce');
    
    $cat_id = intval($_POST['cat_id']);
    
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    if ($cat_id !== 0) {
        $args['cat'] = $cat_id;
    }
    
    $query = new WP_Query($args);
    $html = '';
    
    if ($query->have_posts()) {
        $html .= "<div class='posts-list'>";
        while ($query->have_posts()) {
            $query->the_post();
            $post_link = get_permalink();
            $title = get_the_title();
            $html .= "<a href='{$post_link}'><h2>{$title}</h2></a>";
        }
        $html .= "</div>";
        wp_reset_postdata();
    } else {
        $html = 'Không tìm thấy bài viết nào.';
    }
    
    wp_send_json_success($html);
}
add_action('wp_ajax_load_category_posts', 'load_category_posts');
add_action('wp_ajax_nopriv_load_category_posts', 'load_category_posts');


















// Code này được kích hoạt khi WP Webhooks nhận dữ liệu từ Jotform
add_action('wph_action_main_4220', 'debug_jotform_webhook_data_final', 1); 
function debug_jotform_webhook_data_final($data) {
    error_log('--- JOTFORM WEBHOOK DATA START ---');
    error_log(print_r($data, true)); // Ghi vào wp-content/debug.log
    error_log('--- JOTFORM WEBHOOK DATA END ---');
}
add_action('wph_action_main_4220', 'handle_jotform_to_fluentcrm_final');


/* function handle_jotform_to_fluentcrm_ajax() {
    // --- 0. Kiểm tra API FluentCRM ---
    if (!function_exists('FluentCrmApi')) {
        error_log('FluentCRM API không tìm thấy. Lỗi.');
        wp_die();
    }

    // Dữ liệu đến từ Webhook được lưu trong $_REQUEST khi dùng AJAX GET/POST
    $data = $_REQUEST; 

    // === 1. Bật Debug Log (Kiểm tra dữ liệu đến) ===
    error_log('--- JOTFORM AJAX DATA START ---');
    error_log(print_r($data, true)); // Ghi vào wp-content/debug.log
    error_log('--- JOTFORM AJAX DATA END ---');

    // --- 2. Lấy dữ liệu từ Jotform (6 trường) ---
    // !!! BẮT BUỘC THAY THẾ KHÓA JOTFORM (key bên phải) bằng key THỰC TẾ từ debug.log !!!
    $contact_email = isset($data['user_email']) ? sanitize_email($data['user_email']) : ''; // Key tốt nhất cho Email
    $contact_name  = isset($data['full_name_user']) ? sanitize_text_field($data['full_name_user']) : ''; // Key tốt nhất cho Tên
    $contact_phone = isset($data['user_phone']) ? sanitize_text_field($data['user_phone']) : ''; // Key tốt nhất cho SĐT
    
    // 3 trường tùy chỉnh (Custom Fields)
    $company_name  = isset($data['company_name']) ? sanitize_text_field($data['company_name']) : ''; // Key tốt nhất cho Công ty
    $appointment   = isset($data['appointment_time']) ? sanitize_text_field($data['appointment_time']) : ''; // Key tốt nhất cho Thời gian hẹn
    $extra_note    = isset($data['extra_note']) ? sanitize_text_field($data['extra_note']) : ''; // Key tốt nhất cho Ghi chú

    if (empty($contact_email) || !is_email($contact_email)) {
        error_log('Jotform Webhook không có Email hợp lệ.');
        wp_die();
    }

    // --- 3. Chuẩn bị dữ liệu cho FluentCRM ---
    $contact_data = [
        // Trường Mặc định FluentCRM
        'email'      => $contact_email,
        'full_name'  => $contact_name, 
        'phone'      => $contact_phone, 
        'status'     => 'subscribed',
        'source'     => 'Jotform AJAX Endpoint',
        
        // Trường Tùy chỉnh (Phải khớp với SLUG bạn đã tạo)
        'company'    => $company_name, // Slug: 'company'
        'date_time'  => $appointment, // Slug: 'date_time'
        'note'       => $extra_note, // Slug: 'note'
    ];
    
    // --- 4. Cấu hình List/Tag (Sử dụng ID thực tế của bạn) ---
    $list_ids = [3]; // Thay ID List thực tế của bạn
    $tag_ids  = [8]; // Thay ID Tag thực tế của bạn

    // --- 5. Thực hiện tạo/cập nhật Contact ---
    try {
        FluentCrmApi('contacts')->updateOrCreate($contact_data, [
            'tags' => $tag_ids,
            'lists' => $list_ids,
        ]);
        error_log('Tạo/Cập nhật Contact FluentCRM thành công qua Custom AJAX.');
    } catch (\Exception $e) {
        error_log('Lỗi FluentCRM API: ' . $e->getMessage());
    }

    // Bắt buộc phải thoát để kết thúc yêu cầu Webhook
    wp_die();
}

// Lắng nghe yêu cầu từ bên ngoài (không đăng nhập) bằng Action Hook:
add_action('wp_ajax_nopriv_jotform_to_fluentcrm', 'handle_jotform_to_fluentcrm_ajax');*/







/*
// 1. Đăng ký Webhook Endpoint (Endpoint URL)
add_action('init', 'register_jotform_webhook_endpoint');
function register_jotform_webhook_endpoint() {
    // URL sẽ là: https://[domain]/api/jotform-lead/
    add_rewrite_rule(
        '^api/jotform-lead/?$',
        'index.php?jotform_webhook_listener=1',
        'top'
    );
}

// 2. Kích hoạt tham số Query (Query Var)
add_filter('query_vars', 'add_jotform_webhook_query_var');
function add_jotform_webhook_query_var($vars) {
    $vars[] = 'jotform_webhook_listener';
    return $vars;
}

// 3. Xử lý Dữ liệu Webhook (Lắng nghe Query Var)
add_action('template_redirect', 'handle_jotform_webhook_request');
function handle_jotform_webhook_request() {
    if (get_query_var('jotform_webhook_listener') == 1) {
        
        // Dữ liệu Webhook POST được lấy từ $_POST. 
        // Dùng $_REQUEST bao gồm cả GET và POST.
        $data = $_REQUEST; 

        // === DEBUG CODE (Phần này sẽ tạo file debug.log) ===
        error_log('--- JOTFORM CUSTOM ENDPOINT DATA START ---');
        error_log(print_r($data, true)); // Ghi vào wp-content/debug.log
        error_log('--- JOTFORM CUSTOM ENDPOINT DATA END ---');
        
        // === LOGIC TÍCH HỢP FLUENTCRM (Sử dụng 6 Keys đã xác nhận) ===
        $company_name  = isset($data['company_name']) ? sanitize_text_field($data['company_name']) : ''; 
        $contact_email = isset($data['contact_email']) ? sanitize_email($data['contact_email']) : ''; 
        $contact_name  = isset($data['contact_name']) ? sanitize_text_field($data['contact_name']) : ''; 
        $contact_phone = isset($data['contact_phone']) ? sanitize_text_field($data['contact_phone']) : ''; 
        $appointment   = isset($data['appointment']) ? sanitize_text_field($data['appointment']) : ''; 
        $extra_note    = isset($data['extra_note']) ? sanitize_text_field($data['extra_note']) : ''; 

        if ( function_exists( 'FluentCrmApi' ) && is_email($contact_email)) {
            $contact_data = [
                'email'      => $contact_email,
                'full_name'  => $contact_name, 
                'phone'      => $contact_phone, 
                'status'     => 'subscribed',
                'source'     => 'Jotform Custom API',
                
                // SLUGS CỦA CUSTOM FIELDS
                'company'    => $company_name, // Slug: 'company'
                'date_time'  => $appointment, // Slug: 'date_time'
                'note'       => $extra_note, // Slug: 'note'
            ];
            
            // Thay ID List/Tag của bạn vào đây
            $list_ids = [3]; // List ID
            $tag_ids  = [8]; // Tag ID

            FluentCrmApi('contacts')->updateOrCreate($contact_data, ['tags' => $tag_ids, 'lists' => $list_ids,]);
            error_log('Tạo/Cập nhật Contact FluentCRM thành công qua Custom Endpoint.');
        }

        // Bắt buộc phải exit để kết thúc yêu cầu.
        exit; 
    }
}
    */


/*
// Đăng ký custom webhook endpoint
add_action('rest_api_init', function () {
    register_rest_route('webhook/v1', '/receive', array(
        'methods' => 'POST',
        'callback' => 'handle_webhook_receive',
        'permission_callback' => 'verify_webhook_signature'
    ));
});

// Xử lý dữ liệu webhook nhận được
function handle_webhook_receive($request) {
    $payload = $request->get_body();
    $data = json_decode($payload, true);
    
    // Xử lý dữ liệu ở đây
    // Ví dụ: tạo post, cập nhật user, etc.
    
    return new WP_REST_Response(['status' => 'success'], 200);
}

// Xác thực webhook (tuỳ chọn)
function verify_webhook_signature($request) {
    $signature = $request->get_header('x-webhook-signature');
    
    // Thêm logic xác thực của bạn ở đây
    // return true; // Bỏ qua xác thực cho development
    
    // Ví dụ xác thực với secret key
    $secret = 'your-secret-key';
    $payload = $request->get_body();
    $expected_signature = hash_hmac('sha256', $payload, $secret);
    
    return hash_equals($expected_signature, $signature);
}
*/






// ==================== 
// CUSTOM POST TYPE FOR CONSULTATION REGISTRATION
// ====================

add_action('init', 'register_consultation_post_type');
function register_consultation_post_type() {
    $labels = array(
        'name'               => 'Đăng ký tư vấn',
        'singular_name'      => 'Đăng ký tư vấn',
        'menu_name'          => 'Đăng ký tư vấn',
        'name_admin_bar'     => 'Đăng ký tư vấn',
        'add_new'            => 'Thêm mới',
        'add_new_item'       => 'Thêm đăng ký mới',
        'new_item'           => 'Đăng ký mới',
        'edit_item'          => 'Sửa đăng ký',
        'view_item'          => 'Xem đăng ký',
        'all_items'          => 'Tất cả đăng ký',
        'search_items'       => 'Tìm đăng ký',
        'not_found'          => 'Không tìm thấy đăng ký nào',
        'not_found_in_trash' => 'Không có đăng ký trong thùng rác'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-format-chat',
        'supports'           => array('title'),
        'show_in_rest'       => false
    );

    register_post_type('consultation_registration', $args);
}

// ==================== 
// CUSTOM COLUMNS FOR ADMIN
// ====================

add_filter('manage_consultation_registration_posts_columns', 'set_custom_consultation_columns');
function set_custom_consultation_columns($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'title' => 'Tiêu đề',
        'contact_name' => 'Người liên hệ',
        'company' => 'Công ty',
        'email' => 'Email',
        'phone' => 'Số điện thoại',
        'preferred_time' => 'Thời gian mong muốn',
        'date' => 'Ngày đăng ký'
    );
    return $new_;
}





/*
// ==================== 
// CUSTOM POST TYPE FOR CONSULTATION REGISTRATION
// ====================

add_action('init', 'register_consultation_post_type');
function register_consultation_post_type() {
    register_post_type('consultation_registration',
        array(
            'labels' => array(
                'name' => 'Đăng ký tư vấn',
                'singular_name' => 'Đăng ký tư vấn'
            ),
            'public' => false, // Ẩn khỏi frontend
            'show_ui' => true, // Hiện trong admin
            'has_archive' => false,
            'supports' => array('title'),
            'menu_icon' => 'dashicons-format-chat'
        )
    );
}

// ==================== 
// CUSTOM COLUMNS FOR ADMIN
// ====================

add_filter('manage_consultation_registration_posts_columns', 'set_custom_consultation_columns');
function set_custom_consultation_columns($columns) {
    unset($columns['date']);
    $columns['contact_name'] = 'Người liên hệ';
    $columns['company'] = 'Công ty';
    $columns['email'] = 'Email';
    $columns['phone'] = 'Số điện thoại';
    $columns['preferred_time'] = 'Thời gian mong muốn';
    $columns['date'] = 'Ngày đăng ký';
    return $columns;
}

add_action('manage_consultation_registration_posts_custom_column', 'custom_consultation_column', 10, 2);
function custom_consultation_column($column, $post_id) {
    switch ($column) {
        case 'contact_name':
            echo get_post_meta($post_id, 'contact_name', true);
            break;
        case 'company':
            echo get_post_meta($post_id, 'company_name', true);
            break;
        case 'email':
            echo get_post_meta($post_id, 'email', true);
            break;
        case 'phone':
            echo get_post_meta($post_id, 'phone', true);
            break;
        case 'preferred_time':
            echo get_post_meta($post_id, 'preferred_time', true);
            break;
    }
}*/

// ==================== 
// WEBHOOK ENDPOINT FOR JOTFORM CHATBOT
// ====================

// Đăng ký webhook endpoint cho Jotform chatbot
add_action('rest_api_init', function () {
    register_rest_route('jotform/v1', '/register-consult', array(
        'methods' => 'POST',
        'callback' => 'handle_consultation_registration',
        'permission_callback' => '__return_true'
    ));
});

// Xử lý đăng ký tư vấn từ chatbot
function handle_consultation_registration($request) {
    // 1. Lấy dữ liệu từ Jotform chatbot
    $payload = $request->get_body();
    $data = json_decode($payload, true);
    
    // 2. Log dữ liệu nhận được để debug
    error_log('Jotform Chatbot Data: ' . print_r($data, true));
    
    // 3. Validate dữ liệu
    if (empty($data)) {
        return new WP_REST_Response([
            'status' => 'error',
            'message' => 'No data received'
        ], 400);
    }
    
    // 4. Trích xuất thông tin từ chatbot
    $company_name = sanitize_text_field($data['company_name'] ?? '');
    $contact_name = sanitize_text_field($data['contact_name'] ?? '');
    $email = sanitize_email($data['email'] ?? '');
    $phone = sanitize_text_field($data['phone'] ?? '');
    $preferred_time = sanitize_text_field($data['preferred_time'] ?? '');
    $notes = sanitize_textarea_field($data['notes'] ?? '');
    
    // 5. VALIDATE CÁC TRƯỜNG BẮT BUỘC
    if (empty($contact_name) || empty($email) || empty($phone)) {
        return new WP_REST_Response([
            'status' => 'error',
            'message' => 'Thiếu thông tin bắt buộc (tên, email, số điện thoại)'
        ], 400);
    }
    
    // 6. LƯU VÀO DATABASE - TẠO CUSTOM POST TYPE
    $result = save_consultation_registration(array(
        'company_name' => $company_name,
        'contact_name' => $contact_name,
        'email' => $email,
        'phone' => $phone,
        'preferred_time' => $preferred_time,
        'notes' => $notes
    ));
    
    // 7. GỬI EMAIL THÔNG BÁO (tuỳ chọn)
    send_consultation_notification_email(array(
        'company_name' => $company_name,
        'contact_name' => $contact_name,
        'email' => $email,
        'phone' => $phone,
        'preferred_time' => $preferred_time,
        'notes' => $notes
    ));
    
    // 8. Trả response thành công
    return new WP_REST_Response([
        'status' => 'success',
        'message' => 'Đăng ký tư vấn thành công! Chúng tôi sẽ liên hệ lại sớm.',
        'registration_id' => $result['post_id'] ?? null
    ], 200);
}

// Hàm lưu thông tin đăng ký
function save_consultation_registration($data) {
    // Tạo post mới trong WordPress
    $post_id = wp_insert_post(array(
        'post_title' => 'Đăng ký tư vấn - ' . $data['contact_name'] . ' - ' . date('d/m/Y H:i'),
        'post_content' => $data['notes'],
        'post_status' => 'publish',
        'post_type' => 'consultation_registration' // Sẽ tạo custom post type
    ));
    
    if ($post_id && !is_wp_error($post_id)) {
        // Lưu meta data
        update_post_meta($post_id, 'company_name', $data['company_name']);
        update_post_meta($post_id, 'contact_name', $data['contact_name']);
        update_post_meta($post_id, 'email', $data['email']);
        update_post_meta($post_id, 'phone', $data['phone']);
        update_post_meta($post_id, 'preferred_time', $data['preferred_time']);
        update_post_meta($post_id, 'registration_date', current_time('mysql'));
        
        return ['success' => true, 'post_id' => $post_id];
    }
    
    return ['success' => false, 'error' => 'Failed to save registration'];
}

// Hàm gửi email thông báo
function send_consultation_notification_email($data) {
    $to = get_option('admin_email'); // Email admin
    $subject = 'Có đăng ký tư vấn mới từ Chatbot';
    
    $message = "
    <h2>ĐĂNG KÝ TƯ VẤN MỚI</h2>
    <p><strong>Công ty:</strong> {$data['company_name']}</p>
    <p><strong>Người liên hệ:</strong> {$data['contact_name']}</p>
    <p><strong>Email:</strong> {$data['email']}</p>
    <p><strong>Số điện thoại:</strong> {$data['phone']}</p>
    <p><strong>Thời gian mong muốn:</strong> {$data['preferred_time']}</p>
    <p><strong>Ghi chú:</strong> {$data['notes']}</p>
    <p><strong>Thời gian đăng ký:</strong> " . date('d/m/Y H:i') . "</p>
    ";
    
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    wp_mail($to, $subject, $message, $headers);
}