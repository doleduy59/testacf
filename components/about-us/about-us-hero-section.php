<?php
    $page_id = get_the_ID(); 
    //echo "page_id: " . $page_id;
    $hero_video = get_field('hero_video', $page_id);
    $title = '';
    $content = '';
    $key_field = get_field('key_field',$page_id);
    //echo "key: " . $key_field;
    $fields = acf_get_fields( $key_field);
    if ( $fields ) {
    $field_count = count($fields);
    } else {
        echo "Không Field Group hoặc không có Field nào.";
    }
?>
<section class="hero">
    <div class="hero-content">
        <div class="small-box"></div>
    </div>
    <div class="hero-video">
        <div class="small-box"></div>
    </div>
    <div class="content">
        <div class="hero-text">
            <h1>
                <?php /* 
                    for($i = 1; $i <= $field_count; $i++){
                        $part_field_name = "hero_title_{$i}";
                        $highlight_field_name = "hero_title_highlight_{$i}";

                        $part = get_field($part_field_name, $page_id);
                        $highlight = get_field($highlight_field_name, $page_id);
                        if($part){
                            $title .=  esc_html($part) . ' ';
                        }
                        if($highlight){
                            $title .=  '<span class="highlight">' . esc_html($highlight) . ' ' . '</span>';
                        }
                    }
                echo trim($title); */
                ?>
                <?php  
                    $hero_title = get_field('hero_title', $page_id);
                    echo $hero_title;
                ?>
            </h1>
            <p>
                <?php /*
                    for($i = 1; $i <= $field_count; $i++){
                        $part_field_name = "hero_content_{$i}";
                        $highlight_field_name = "hero_content_highlight_{$i}";

                        $part = get_field($part_field_name, $page_id);
                        $highlight = get_field($highlight_field_name, $page_id);
                        if($part){
                            $content .=  esc_html($part) . ' ';
                        }
                        if($highlight){
                            $content .=  '<span class="highlight">' . esc_html($highlight) . ' ' . '</span>';
                        }
                    }
                echo trim($content); */
                ?>
                <?php  
                    $hero_content = get_field('hero_content', $page_id);
                    echo $hero_content;
                ?>
            </p>
        </div>
        <div class="video">
            <?php echo $hero_video; ?>
        </div>
    </div>
</section>