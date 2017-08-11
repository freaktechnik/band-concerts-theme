<?php get_header(); ?>
<div>
<?php while(have_posts()) {
    the_post();
    include(dirname(__FILE__).'/inc/simple-page.php');
}
the_posts_pagination([
    'prev_text' => 'Vorherige',
    'next_text' => 'Nächste',
    'screen_reader_text' => 'Posts navigation'
]); ?>
</div>
<?php get_footer(); ?>
