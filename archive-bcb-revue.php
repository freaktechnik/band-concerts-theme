<?php get_header(); ?>
<div>
<?php
    while(have_posts()) {
    the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class([
        'two-columns'
    ]); ?>>
        <aside>
            <a href="<?php the_permalink() ?>">
                <?php $content = get_post_meta(get_the_ID(), BCBRevuePlugin::REVUE_FIELD, true);
                $contentSrc = wp_get_attachment_image_src($content, 'thumbnail'); ?>
                <img src="<?php echo esc_url($contentSrc[0]) ?>">
            </a>
        </aside>
        <section>
            <a href="<?php the_permalink() ?>">
                <h2>Revue <?php echo get_the_title(); ?> - <?php echo get_the_date('F Y') ?></h2>
            </a>
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
