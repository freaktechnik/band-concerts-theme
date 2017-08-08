<?php get_header();
while(have_posts()) {
the_post(); ?>
<article id="concert-<?php the_ID() ?>" <?php post_class([
    'two-columns'
    ]) ?>>
    <aside>
        <?php the_title('<h1>', '</h1>');
        $concerts = BC_ConcertSeries::getConcertsForSeries(get_the_ID());
        if(!empty($concerts)) { ?>
        <h2>Auftritte</h2>
        <ul><?php foreach($concerts as $concert) { ?>
            <li><time datetime="<?php echo $concert['date'] ?>"><?php echo get_the_date('l j. F Y, H:i', $concert['id']) ?></time>, <?php echo $concert['location'] ?></li>
        <?php } ?>
        </ul>
        <?php } ?>
    </aside>
    <section>
        <?php
        the_post_thumbnail();
        the_content();
        $review = get_post_meta(get_the_ID(), BC_ConcertSeries::REVIEW_FIELD, true);
        if(!empty($review)) { ?>
        <h2 id="review">Konzertbericht</h2>
        <p><?php echo $review; ?></p>
        <?php } ?>
    </section>
</article>
<? } ?>
<?php get_footer(); ?>
