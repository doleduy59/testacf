<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <meta name="description" content="<?php bloginfo( 'description' ); ?>">
    <?php wp_head() ?>

</head>

<body>
    <header>
        <nav>
            <div class="navbar">
                <div class="logo_container">
                    <img class="logo" src="<?php echo (get_template_directory_uri(  ).'/assets/images/1office.webp') ?>"
                        alt="">
                </div>
                <div class="nav-links">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'navbar_desktop', 
                        'container' => false, 
                        'menu_class' => 'desktop_navbar', 
                        'menu_id' => 'desktop_navbar',
                        'depth' => 1, 
                    ) )
                    ?>

                    <div class="nav-buttons">
                        <button class="phone"><i class="fa-solid fa-phone-volume"></i> 083.483.8888</button>
                        <button class="btn-chevron-right">ĐĂNG KÝ <i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </nav>
    </header>