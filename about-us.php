<?php
/* * Template Name: About Us
 * Template Post Type: page 
 */
wp_enqueue_style( 'about-us-css' );

?>
<?php get_header() ?>
<?php get_template_part('components/about-us/about-us-hero-section'); ?>
<?php get_template_part('components/about-us/about-us-demo-hardcode'); ?>
<?php get_footer() ?>