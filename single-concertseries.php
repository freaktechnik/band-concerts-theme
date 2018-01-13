<?php get_header();
while(have_posts()) {
the_post(); ?>
<article id="concert-<?php the_ID() ?>" <?php post_class([
    'two-columns'
    ]) ?>>
    <aside>
        <?php the_title('<h1>', '</h1>');
        $concerts = \BandConcerts\ConcertSeries::getConcertsForSeries(get_the_ID());
        if(!empty($concerts)) { ?>
            <?php if(\BandConcerts\ConcertSeries::isConcert(get_the_ID())) { ?>
                <h2>Auftritte</h2>
            <?php }
            include __DIR__.'/inc/concert-dates.php';
        }
        $flyer = get_post_meta(get_the_ID(), \BandConcerts\ConcertSeries::FLYER_FIELD, true);
        $flyerUrl = wp_get_attachment_url($flyer);
        if(!empty($flyerUrl)) {
            ?><a href="<?php echo $flyerUrl; ?>" target="_blank"><?php echo \BandConcerts\Theme\Theme::get_icon('file-pdf'); ?>Flyer</a><?php
        }
        edit_post_link(null, '<p>'.\BandConcerts\Theme\Theme::get_icon('edit'), '</p>'); ?>
    </aside>
    <section>
        <?php
        the_post_thumbnail();
        the_content();
        $review = apply_filters( 'the_content', get_post_meta(get_the_ID(), \BandConcerts\ConcertSeries::REVIEW_FIELD, true));
        if(!empty($review)) { ?>
        <h2 id="review"><?php echo \BandConcerts\ConcertSeries::IsConcert(get_the_ID()) ? 'Konzertbericht' : 'Rückblick'; ?></h2>
        <p><?php echo $review; ?></p>
        <?php } ?>
    </section>
</article>
<?php }
get_footer();
