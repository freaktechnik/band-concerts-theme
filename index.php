<?php get_header(); ?>
<div>
<?php while(have_posts()) {
    the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header>
            <a href="<?php the_permalink() ?>"><?php the_title('<h1>', '</h1>'); ?></a>
        </header>
        <div class="content">
            <?php the_content(); ?>
        </div>
        <?php edit_post_link(); ?>
    </article><?php
}
the_posts_pagination([
    'prev_text' => 'Vorherige',
    'next_text' => 'Nächste',
    'screen_reader_text' => 'Posts navigation'
]); ?>
</div>
<?php get_footer(); ?>
