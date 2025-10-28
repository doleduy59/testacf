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
    wp_enqueue_style( 'about-us-css', get_template_directory_uri() . '/assets/css/about-us.css', array(), '1.0', 'all');
    wp_enqueue_style( 'button-css', get_template_directory_uri() . '/assets/css/button.css', array(), '1.0', 'all');
    wp_enqueue_style( 'event-post-css', get_template_directory_uri() . '/assets/css/event-post.css', array(), '1.0', 'all');
    wp_enqueue_style( 'demo-hardcode-css', get_template_directory_uri() . '/assets/css/home-demo-hardcode.css', array(), '1.0', 'all');


    wp_enqueue_style( 'inter-tight-font', 'https://fonts.googleapis.com/css2?family=Inter+Tight:wght@100;200;300;400;500;600;700&display=swap', array(), '1.0', 'all' );
    wp_enqueue_style('font-awesome','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',array(),'6.0.0');

}
add_action( 'wp_enqueue_scripts', 'theme_script' );


//swiper js and css
function my_enqueue_swiper() {
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0', 'all' );
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array('jquery'), '11.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_swiper' );
function my_custom_swiper_init() {
    wp_enqueue_script( 'custom-swiper-init', get_template_directory_uri() . '/js/custom-swiper.js', array('swiper-js'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'my_custom_swiper_init' );



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




// Thêm Khóa API cho Google Maps (Sử dụng Filter acf/fields/google_map/api)
function my_acf_google_map_api( $api ) {
    
    // ĐIỀN KHÓA API CỦA BẠN VÀO DÒNG DƯỚI ĐÂY
    $api['key'] = 'ĐIỀN_KHOÁ_API_CỦA_BẠN_VÀO_ĐÂY'; 
    
    // Đảm bảo bạn đã bật các dịch vụ cần thiết (Maps JavaScript API, Geocoding API, Places API) trên Google Cloud Platform
    
    return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

