<?php
use GuzzleHttp\Psr7\Query;
wp_enqueue_style( 'swiper-css' );
wp_enqueue_script( 'my-swiper-init' ); 
wp_enqueue_style( 'events-css' );
// Lấy thời gian hiện tại
$current_time_gmt = current_time('timestamp');
$current_date_ymd = date('Ymd', $current_time_gmt);
$current_time_hi = date('H:i', $current_time_gmt);
$soon = [];
$still = [];
$end = [];
$args_all = array(
    'post_type'      => 'post',    // Thay bằng slug CPT của bạn nếu khác 'event'
    'posts_per_page' => -1,         // Lấy TẤT CẢ bài viết
    'post_status'    => 'publish',  // Chỉ lấy bài đã xuất bản
    'orderby'        => 'date',     // Sắp xếp theo ngày tạo
    'order'          => 'DESC',     // Mới nhất lên trước
    'category_name'  => 'event',
);
$query_all = new WP_Query( $args_all );
echo '<h2>Danh sách TẤT CẢ Bài viết Event</h2>';
echo '<p>Tổng số bài viết được tìm thấy: ' . $query_all->found_posts . '</p>';
echo '<ul>';
// Kiểm tra xem có bài viết nào không
if ( $query_all->have_posts() ) {
    while ( $query_all->have_posts() ) {
        $query_all->the_post();

        $title = get_the_title();
        $link = get_permalink();
        $thumbnail = get_field('thumbnail_event');
        $thumbnail_url = is_array($thumbnail) ? $thumbnail['url'] : 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fcommons.wikimedia.org%2Fwiki%2FFile%3ANo_Image_Available.jpg&psig=AOvVaw0BCt-4J8aBJnXZlbGVYTuR&ust=1761808411728000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCOifwvXtyJADFQAAAAAdAAAAABAE';
        $participants = get_field('participants_event');
        $location_map = get_field('location_map_event');


        /*
        echo '<li>';
        echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
        echo ' (ID: ' . get_the_ID() . ')';
        
        // Hiển thị ảnh
        if (!empty($thumbnail_url) && $thumbnail_url != 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fcommons.wikimedia.org%2Fwiki%2FFile%3ANo_Image_Available.jpg&psig=AOvVaw0BCt-4J8aBJnXZlbGVYTuR&ust=1761808411728000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCOifwvXtyJADFQAAAAAdAAAAABAE') {
            echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . get_the_title() . '" style="max-width: 100px;">';
        }
        
        // Hiển thị các trường khác
        echo '<p><strong>Số người tham gia:</strong> ' . (empty($participants) ? 'Chưa rõ' : esc_html($participants)) . '</p>';
        
        // Hiển thị Bản đồ (Giả định trả về chuỗi hoặc link)
        if (!empty($location_map)) {
             echo '<p><strong>Link Map:</strong> <a href="' . esc_url($location_map) . '" target="_blank">Xem Bản đồ</a></p>';
        }
        
        echo '</li>';
        echo '<hr>';
            */


    }
} else {
    echo '<li>Không tìm thấy bài viết Event nào.</li>';
}
echo '</ul>';
wp_reset_postdata();
?>



<div class="event_list">
    <div class="soon">
        <h2>Sự kiện sắp diễn ra</h2>
        <div class="swiper mySwiperGridSoon">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="http://companywebsitedemo.local/wp-content/uploads/2025/10/New-Bitmap-image.png" alt="">
                    <div class="container">
                        <div class="content">
                            <div class="tax">
                                <p><img src="<?php echo get_template_directory_uri() . '/assets/svgs/tag.svg' ?>" alt=""> Event</p>
                                <p><img src="<?php echo get_template_directory_uri() . '/assets/svgs/tag.svg' ?>" alt=""> Event</p>
                            </div>
                            <h3>Recap Sự kiện: “Chuyển đổi số: Tư Duy Hay Công Cụ?” Sự kiện dành cho cấp CEO và quản lý</h3>
                            <div class="location">
                                <p>Ngày 20/11/2023</p>
                                <p>Số 02 Kim Giang, Q. Thanh Xuân, TP. HN</p>
                                <p>Quy mô: 100 người</p>
                            </div>
                        </div>
                        <div class="btn">
                            <button class='btn-chevron-right' style="height: 2.25rem;">XEM CHI TIẾT<i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">Slide 2</div>
                <div class="swiper-slide">Slide 3</div>
                <div class="swiper-slide">Slide 4</div>
                <div class="swiper-slide">Slide 5</div>
                <div class="swiper-slide">Slide 6</div>
                <div class="swiper-slide">Slide 7</div>
                <div class="swiper-slide">Slide 8</div>
                <div class="swiper-slide">Slide 9</div>
            </div>
        </div>
    </div>




    <div class="end">
        <h2>Sự kiện đã kết thúc</h2>
        <div class="swiper mySwiperGrid">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="http://companywebsitedemo.local/wp-content/uploads/2025/10/New-Bitmap-image.png" alt="">
                    <div class="container">
                        <div class="content">
                            <div class="tax">
                                <p><img src="<?php echo get_template_directory_uri() . '/assets/svgs/tag.svg' ?>" alt=""> Event</p>
                                <p><img src="<?php echo get_template_directory_uri() . '/assets/svgs/tag.svg' ?>" alt=""> Event</p>
                            </div>
                            <h3>Recap Sự kiện: “Chuyển đổi số: Tư Duy Hay Công Cụ?” Sự kiện dành cho cấp CEO và quản lý</h3>
                            <div class="location">
                                <p>Ngày 20/11/2023</p>
                                <p>Số 02 Kim Giang, Q. Thanh Xuân, TP. HN</p>
                                <p>Quy mô: 100 người</p>
                            </div>
                        </div>
                        <div class="btn">
                            <button class='btn-chevron-right' style="height: 2.25rem;">XEM CHI TIẾT<i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">Slide 2</div>
                <div class="swiper-slide">Slide 3</div>
                <div class="swiper-slide">Slide 4</div>
                <div class="swiper-slide">
                    <img src="http://companywebsitedemo.local/wp-content/uploads/2025/10/New-Bitmap-image.png" alt="">
                    <div class="container">
                        <div class="content">
                            <div class="tax">
                                <p><img src="<?php echo get_template_directory_uri() . '/assets/svgs/tag.svg' ?>" alt=""> Event</p>
                                <p><img src="<?php echo get_template_directory_uri() . '/assets/svgs/tag.svg' ?>" alt=""> Event</p>
                            </div>
                            <h3>Recap Sự kiện: “Chuyển đổi số: Tư Duy Hay Công Cụ?” Sự kiện dành cho cấp CEO và quản lý</h3>
                            <div class="location">
                                <p>Ngày 20/11/2023</p>
                                <p>Số 02 Kim Giang, Q. Thanh Xuân, TP. HN</p>
                                <p>Quy mô: 100 người</p>
                            </div>
                        </div>
                        <div class="btn">
                            <button class='btn-chevron-right' style="height: 2.25rem;">XEM CHI TIẾT<i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">Slide 6</div>
                <div class="swiper-slide">Slide 7</div>
                <div class="swiper-slide">Slide 8</div>
                <div class="swiper-slide">Slide 9</div>
            </div>
        </div>
    </div>
</div>