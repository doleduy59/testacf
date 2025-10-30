

<?php
use GuzzleHttp\Psr7\Query;
wp_enqueue_style( 'swiper-css' );
wp_enqueue_script( 'my-swiper-init' ); 
wp_enqueue_style( 'events-css' );


$args_all = array(
    'post_type'      => 'post',    
    'posts_per_page' => -1,         // Lấy TẤT CẢ bài viết
    'post_status'    => 'publish',  
    'orderby'        => 'date',     
    'order'          => 'DESC',     
    'category_name'  => 'event',
);

$current_time = date( 'YmdHis' );
$upcomming_event = [];
$ended_event = [];

$query_all = new WP_Query( $args_all );
if ( $query_all->have_posts() ) {
    while ( $query_all->have_posts() ) {
        $query_all->the_post();

        $post_link = get_permalink();

        $title = get_the_title();
        $link = get_permalink();
        $thumbnail = get_field('thumbnail_event');
        $thumbnail_url = is_array($thumbnail) ? $thumbnail['url'] : 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fcommons.wikimedia.org%2Fwiki%2FFile%3ANo_Image_Available.jpg&psig=AOvVaw0BCt-4J8aBJnXZlbGVYTuR&ust=1761808411728000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCOifwvXtyJADFQAAAAAdAAAAABAE';
        $participants = get_field('participants_event');
        $location_map = get_field('location_map_event');

        $time_start = get_field('time_start_event');
        $time_date = get_field('time_date_event');
        $datetime_YmdHi = '';
        if ( $time_start && $time_date ) 
        {
            $time_clean = str_replace( ':', '', $time_start);
            $datetime_YmdHi = $time_date . $time_clean;
        } else {
            $datetime_YmdHi = '0';
        }

        if ( $datetime_YmdHi > $current_time ) {
            $upcomming_event[] = array(
                'title' => $title,
                'link' => $link,
                'thumbnail_url' => $thumbnail_url,
                'participants' => $participants,
                'location_map' => $location_map,
                'time_start' => $time_start,
                'time_date' => $time_date,
            );
        } else {
            $ended_event[] = array(
                'title' => $title,
                'link' => $link,
                'thumbnail_url' => $thumbnail_url,
                'participants' => $participants,
                'location_map' => $location_map,
                'time_start' => $time_start,
                'time_date' => $time_date,
            );
        } 
    }
} else {
    echo '<p>Không tìm thấy bài viết Event nào.</p>';
}
wp_reset_postdata();
?>

<div class="event_list">
    <div class="list">
        <div class="swiper mySwiperGridSoon">
            <h2>Sự kiện sắp diễn ra</h2>
            <div class="swiper-wrapper">


                <?php 
                if ( empty( $upcomming_event ) ) {
                    echo "<p>Không có sự kiện sắp diễn ra nào.</p>";
                } else {
                foreach ( $upcomming_event as $event ) { 
                ?>
                    <div class="swiper-slide">
                        <img src="<?php echo $event['thumbnail_url'] ?>" alt="">
                        <div class="container">
                            <div class="content">
                                <div class="tax">
                                    <p><img src="<?php echo get_template_directory_uri() . '/assets/svgs/tag.svg' ?>" alt=""> <?php echo 'Event' ?></p>
                                </div>
                                <h3><?php echo $event['title'] ?></h3>
                                <div class="location">
                                    <p>Ngày <?php $date = DateTime::createFromFormat('Ymd',$event['time_date'])->format('d/m/Y'); echo  date_i18n($date) ?></p>
                                    <p><?php echo $event['location_map'] ?></p>
                                    <p>Quy mô: <?php echo $event['participants'] ?> người</p>
                                    
                                </div>
                            </div>
                            <div class="btn">
                                <a href="<?php echo $post_link ?>" class='btn-chevron-right' style="height: 2.25rem;">XEM CHI TIẾT<i class="fa-solid fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php }}?>


            </div>
            <div class="navigation_bnt">
                <div class="swiper-button-next"><img src="<?php echo get_template_directory_uri() . '/assets/svgs/navigationPostR.svg' ?>" alt=""></div>
                <div class="swiper-button-prev"><img src="<?php echo get_template_directory_uri() . '/assets/svgs/navigationPostL.svg' ?>" alt=""></div>
            </div> 

        </div>
    </div>
    

    <div class="list">    
        <div class="swiper mySwiperGridEnded">
            <h2>Sự kiện đã kết thúc</h2>
            <div class="swiper-wrapper">


                <?php 
                if ( empty( $ended_event ) ) {
                    echo "<p>Không có sự kiện đã kết thúc nào.</p>";
                } else {
                foreach ( $ended_event as $event ) { 
                ?>
                    <div class="swiper-slide">
                        <img src="<?php echo $event['thumbnail_url'] ?>" alt="">
                        <div class="container">
                            <div class="content">
                                <div class="tax">
                                    <p><img src="<?php echo get_template_directory_uri() . '/assets/svgs/tag.svg' ?>" alt=""> <?php echo 'Event' ?></p>
                                </div>
                                <h3><?php echo $event['title'] ?></h3>
                                <div class="location">
                                    <p>Ngày <?php $date = DateTime::createFromFormat('Ymd',$event['time_date'])->format('d/m/Y'); echo  date_i18n($date) ?></p>
                                    <p><?php echo $event['location_map'] ?></p>
                                    <p>Quy mô: <?php echo $event['participants'] ?> người</p>
                                    
                                </div>
                            </div>
                            <div class="btn">
                                <a class='grey_btn' href="<?php echo $post_link ?>" class='btn-chevron-right' style="height: 2.25rem;">ĐÃ DIỄN RA</a>
                            </div>
                        </div>
                    </div>
                <?php }}?>

                
            </div>
            <div class="navigation_bnt">
                <div class="swiper-button-next"><img src="<?php echo get_template_directory_uri() . '/assets/svgs/navigationPostR.svg' ?>" alt=""></div>
                <div class="swiper-button-prev"><img src="<?php echo get_template_directory_uri() . '/assets/svgs/navigationPostL.svg' ?>" alt=""></div>
            </div> 
        </div>
    </div>
</div>






