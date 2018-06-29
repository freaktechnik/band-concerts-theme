<?php
/*
Template Name: Posts List
Template Post Type: page
 */
get_header(); ?>
<div>
<?php
$oldq = $wp_query;
$wp_query = new WP_Query([
    'post_type' => 'post',
    'paged' => get_query_var('paged') ?? 1,
]);
while($wp_query->have_posts()) {
        $wp_query->the_post(); ?>
    <article id="concert-<?php the_ID(); ?>" <?php post_class([
        'two-columns'
    ]); ?>>
        <aside>
            <a href="<?php the_permalink() ?>"><?php the_title('<h1>', '</h1>'); ?></a>
            <p><?php
                echo \BandConcerts\Theme\Theme::get_icon('calendar');
                the_date(NULL, '<time datetime="'.get_the_date(\DateTime::W3C).'">', '</time>');
                ?><br><?php
                echo \BandConcerts\Theme\Theme::get_icon('user');
                the_author();
            ?></p><?php
            edit_post_link(null, '<p>'.\BandConcerts\Theme\Theme::get_icon('edit'), '</p>'); ?>
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
]);
$wp_query = $oldq; ?>
</div>
<?php get_footer(); ?>
