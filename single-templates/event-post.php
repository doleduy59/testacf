<?php
/* * Template Name: Event
 * Template Post Type: post 
 */
?>
<?php
get_header();
?>
<?php
    $thumbnail = get_field('thumbnail_event');
    $title = get_field('title_event');
    $time = get_field('time_event');
    $participants = get_field('participants');
    $location = get_field('location_event');
    $author_img = get_field('author_img');
    $author_name = get_field('author_name');
    $author_position = get_field('author_position');
    $content = get_field('content_event');
    

?>
<script>
console.log(<?php echo $participant ?>)
</script>
<section class='event-post'>
    <?php
        if($thumbnail){
            echo "<img class='thumbnail_event' src='$thumbnail'><img>";
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
        <p>$location</p>"
        ?>
    </div>
    <h2>Diễn giả</h2>
    <div class='content-container'>
        <?php echo " 
        <div class='author-list'>
            <div class='author-item'>
                <div class='avt'>
                    <img src='$author_img' alt=''></img>
                </div>
                <div class='author-content'>
                    <h3>$author_name</h3>
                    <p>$author_position</p>
                </div>
            </div>
        </div>
        <div class='content'>
            $content
        </div>";
        ?>
    </div>
</section>
<?php
// 1. Tìm đường dẫn tuyệt đối đến file contact.php
$template_file = locate_template( 'components/share-items/contact.php' );

// 2. Kiểm tra xem file có tồn tại không và tải nó vào
if ( $template_file ) {
    load_template( $template_file, false ); // Tham số thứ 2 là $require_once, đặt là false để cho phép gọi nhiều lần
}
?>






<?php get_footer(); ?>