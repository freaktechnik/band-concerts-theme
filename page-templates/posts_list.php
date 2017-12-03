<?php
/*
Template Name: Posts List
Template Post Type: page
 */
get_header(); ?>
<div>
<?php
$q = new WP_Query([
    'post_type' => 'post'
]);
while($q->have_posts()) {
        $q->the_post(); ?>
    <article id="concert-<?php the_ID(); ?>" <?php post_class([
        'two-columns'
    ]); ?>>
        <aside>
            <a href="<?php the_permalink() ?>"><?php the_title('<h1>', '</h1>'); ?></a>
            <p><?php
                the_date(NULL, '<time datetime="'.get_the_date(DateTime::W3C).'">', '</time>');
                ?><br><?php
                the_author();
            ?></p><?php
            edit_post_link(); ?>
        </aside>
        <section>
            <?php the_post_thumbnail();
            the_content('(weiterlesen...)');
            ?>
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
