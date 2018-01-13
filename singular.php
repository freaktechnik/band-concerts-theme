<?php get_header();
while(have_posts()) {
    the_post();
    include __DIR__.'/inc/simple-page.php';
}
get_footer(); ?>
