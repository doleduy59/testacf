<?php
    $page_id = get_option('page_on_front'); 
    $hero_video = get_field('hero_video', $page_id);
    $title = '';
    $content = '';
    $field_key = get_field('field_key',$page_id);
    ///echo "key: " . $field_key;
    $fields = acf_get_fields( $field_key);
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
                <?php
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
                echo trim($title); 
                ?>
            </h1>
            <p>
                <?php
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
                echo trim($content); 
                ?>
            </p>
        </div>
        <div class="video">
            <?php echo $hero_video; ?>
        </div>
    </div>
</section>