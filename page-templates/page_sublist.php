<?php
/*
Template Name: Page List
Template Post Type: page, post
 */
get_header(); ?>
<div>
<?php if(have_posts()) {
    the_post();
    include __DIR__.'/../inc/simple-page.php';
    $children = get_children([
        'post_type' => 'page',
        'post_parent' => get_the_ID(),
        'orderby' => 'menu_order'
    ]);
    foreach($children as $child) {
        setup_postdata($child);
        $post = $child;
        include __DIR__.'/../inc/simple-page.php';
    }
} ?>
</div>
<?php get_footer(); ?>
