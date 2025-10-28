<?php
/* * Template Name: Event
 * Template Post Type: post 
 */

use SimplePie\Parse\Date;

?>
<?php
get_header();
?>
<?php
    $thumbnail = get_field('thumbnail_event');
    $thumbnail_url = $thumbnail['url'];
    $title = get_field('title_event');
    $time_start_raw = get_field('time_start_event');
    $time_end_raw = get_field('time_end_event');
    $time_date_raw = get_field('time_date_event');
    $participants = get_field('participants_event');
    $location = get_field('location_event');
    $location_map = get_field('location_map_event');
    $author_img = get_field('author_img_event');
    $author_img_url = $author_img['url'];
    $author_name = get_field('author_name_event');
    $author_position = get_field('author_position_event');
    $content = get_field('content_event');

    // Xử lý dữ liệu thời gian
    $time_start = DateTime::createFromFormat('H:i:s', $time_start_raw);
    $time_end = DateTime::createFromFormat('H:i:s', $time_end_raw);
    $time_date = DateTime::createFromFormat('d/m/Y', $time_date_raw);
    

    if ($time_start) {
        $time_start_h = $time_start->format('H');
        $time_start_m = $time_start->format('i');
    }
    
    if ($time_end) {
        $time_end_h = $time_end->format('H');
        $time_end_m = $time_end->format('i');
    }

    $time_day_of_week_full = $time_date->format('l');
    // Chuyển sang Tiếng Việt
    $weekday_translation = array(
                'Monday'    => 'thứ 2',
                'Tuesday'   => 'thứ 3',
                'Wednesday' => 'thứ 4',
                'Thursday'  => 'thứ 5',
                'Friday'    => 'thứ 6',
                'Saturday'  => 'thứ 7',
                'Sunday'    => 'chủ nhật'
    );
    if ($time_start) {
        $time_start_h = $time_start->format('H');
        $time_start_m = $time_start->format('i');
        if ($time_end) {
            $time_end_h = $time_end->format('H');
            $time_end_m = $time_end->format('i');
            $time = 'Thời gian: '.$time_start_h.'h'.$time_start_m.' - '.$time_end_h.'h'.$time_end_m
            .', '.$weekday_translation[$time_day_of_week_full].' ngày '.$time_date->format('d/m/Y');

        }
        else {
            $time = 'Thời gian: Bắt đầu từ '.$time_start_h.'h'.$time_start_m
            .', '.$weekday_translation[$time_day_of_week_full].' ngày '.$time_date->format('d/m/Y');
        }
    }
    else {
        $time = 'Thời gian: Bắt đầu từ '.$weekday_translation[$time_day_of_week_full].' ngày '.$time_date->format('d/m/Y');
    }
    
    
    

    
    
    //$time = $time_date . ", " . $time_start . " - " . $time_end;
    

?>
<script>
console.log(<?php echo $participant ?>)
</script>
<section class='event-post'>
    <?php
        if($thumbnail){
            echo "<img class='thumbnail_event' src='$thumbnail_url'><img>";
        }
        else{
            echo "không có hình ảnh";
        }
    ?>
    <div class='title-container'>
        <?php echo"<h1 class='title'>$title</h1>" ?>
        <div>
            <button class='btn-chevron-right'>ĐĂNG KÝ THAM GIA <i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>
    <div class='location-container'>
        <?php echo "
        <p>$time</p>
        <p>Quy mô: $participants người</p>
        <p>$location | $location_map</p>"
        ?>
    </div>
    <h2>Diễn giả</h2>
    <div class='content-container'>
        <?php echo " 
        <div class='author-list'>
            <div class='author-item'>
                <div class='avt'>
                    <img src='$author_img_url' alt=''></img>
                </div>
                <div class='author-content'>
                    <h3>$author_name</h3>
                    <p>$author_position</p>
                </div>
            </div>
        </div>
        <div class='content'>";
        echo apply_filters('the_content', $content);
        echo "</div>";
        ?>
    </div>
</section>
<?php

$recruitment_qr_temp = locate_template( 'components/share-items/recruitment-qr.php' );
if ( $recruitment_qr_temp ) {
    load_template( $recruitment_qr_temp, false ); 
}
// 1. Tìm đường dẫn tuyệt đối đến file contact.php
$contact_temp = locate_template( 'components/share-items/contact.php' );
// 2. Kiểm tra xem file có tồn tại không và tải nó vào
if ( $contact_temp ) {
    load_template( $contact_temp, false ); // Tham số thứ 2 là $require_once, đặt là false để cho phép gọi nhiều lần
}
?>






<?php get_footer(); ?>