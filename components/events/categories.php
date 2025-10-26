<div id="categoryButtons" class="catBtn">
    <?php
    $categories = get_categories( array(
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => true 
    ) );

    if ( ! empty( $categories ) ) :
        echo '<div id="category-filter-buttons">';
        echo '<button class="category-btn-filter active" data-cat-id="0">Tất Cả</button>';

        foreach ( $categories as $category ) {
            printf(
                '<button class="category-btn-filter" data-cat-id="%d">%s</button>',
                absint( $category->term_id ), 
                esc_html( $category->name ) 
            );
        }
        echo '</div>';
    endif;  
    ?>
</div>


<div id="categoryListPosts" class="catList">
    <?php
    //load lần đầu
    $args = array(
        'post_type'      => 'post', 
        'posts_per_page' => 6,     
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $query = new WP_Query($args);
    if ($query->have_posts()){
        echo "<div class='posts-list'>";
        while($query->have_posts()){
            $query->the_post();
            $post_link = get_permalink();
            $title = get_the_title();
            echo "<a href='{$post_link}'><h2>{$title}</h2></a>";
        };
        echo "</div>";
        wp_reset_postdata();
    } else {
        echo 'Không tìm thấy bài viết nào.';
    } 
    ?>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/script/filter-cat.js"></script>