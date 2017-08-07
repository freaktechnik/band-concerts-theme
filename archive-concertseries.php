<?php get_header(); ?>
<div>
<?php
    while(have_posts()) {
    the_post(); ?>
    <article id="concert-<?php the_ID(); ?>" <?php post_class(); ?>>
        <a href="<?php the_permalink() ?>"><?php the_title('<h1>', '</h1>'); ?></a>
        <?php the_post_thumbnail();
        the_content('(ganzer Beschrieb...)');
        $review = get_post_meta(get_the_ID(), BC_ConcertSeries::REVIEW_FIELD, true);
        if(!empty($review)) { ?>
            <p><a href="<?php the_permalink() ?>#review">Bericht lesen</a>
        <?php
            edit_post_link();
        ?></p><?php
        }
        else {
            edit_post_link();
        }?>
    </article><?php
}
the_posts_pagination([
    'prev_text' => 'Vorherige',
    'next_text' => 'Nächste',
    'screen_reader_text' => 'Posts navigation'
]);
?>
</div>
<?php get_footer(); ?>
