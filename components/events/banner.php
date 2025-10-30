<?php 
// Sử dụng tên handle đã đăng ký: 'my-swiper-init'
wp_enqueue_style( 'swiper-css' );
wp_enqueue_script( 'my-swiper-init' ); 
wp_enqueue_style( 'events-css' );
//$image_ids = rwmb_get_value( 'image_slider' );

$page_id = get_the_ID();
//echo "page_id: " . $page_id;
$field_key = get_field('banner_event_key', $page_id);
$fields = acf_get_fields( $field_key);
$field_count = count($fields);
//echo "field count: " . $field_count;

?>
<div class="events-banner">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <?php
            if ( $fields ) {
                foreach( $fields as $field) {
                    if ( in_array( $field['type'], array('repeater', 'flexible_content', 'group') ) ) {
                        continue;
                    }
                    $image = get_field($field['name'], $page_id);
                    if ( !empty($image) && is_array($image) ) {
                        if ( $field['name'] != "banner_event_key" ) {
                        ?>
                        <div class="swiper-slide">
                            <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <?php
                        }
                    }
                }
            } else {
                echo '<p>Không tìm thấy Field Group hoặc không có field nào trong nhóm.</p>';
            }
            ?>
        </div>
        <div class="swiper-button-next"><img src="<?php echo get_template_directory_uri() . '/assets/svgs/navigationBannerR.svg' ?>" alt=""></div>
        <div class="swiper-button-prev"><img src="<?php echo get_template_directory_uri() . '/assets/svgs/navigationBannerL.svg' ?>" alt=""></div>
    </div> 

</div>



<?php
/*
                foreach ( $image_ids as $image_id ) {
                    // Lấy URL ảnh với kích thước 'full' (hoặc 'large' để tối ưu)
                    $image_url = wp_get_attachment_image_url( $image_id, 'full' ); 
                    // Lấy thẻ <img> hoàn chỉnh (tùy chọn)
                    // $image_html = wp_get_attachment_image( $image_id, 'full', false ); 
                    if ( $image_url ) {
                        // Tạo một swiper-slide cho mỗi ảnh
                        ?>
                        <div class="swiper-slide">
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <?php
                    }
                }
                */
?>