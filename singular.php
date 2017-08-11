<?php get_header();
while(have_posts()) {
    the_post();
    include(dirname(__FILE__).'/inc/simple-page.php');
}
get_footer(); ?>
