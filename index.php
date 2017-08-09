<?php get_header(); ?>
<div>
<?php while(have_posts()) {
    the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class([
        'two-columns'
    ]); ?>>
        <aside>
            <a href="<?php the_permalink() ?>"><?php the_title('<h1>', '</h1>'); ?></a>
            <p><?php edit_post_link(); ?></p>
        </aside>
        <section>
            <?php the_content(); ?>
        </section>
    </article><?php
}
the_posts_pagination([
    'prev_text' => 'Vorherige',
    'next_text' => 'Nächste',
    'screen_reader_text' => 'Posts navigation'
]); ?>
</div>
<?php get_footer(); ?>
