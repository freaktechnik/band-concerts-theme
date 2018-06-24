<?php get_header(); ?>
<div>
<?php
    while(have_posts()) {
    the_post(); ?>
    <article id="concert-<?php the_ID(); ?>" <?php post_class([
        'two-columns'
    ]); ?>>
        <aside>
            <a href="<?php the_permalink() ?>"><?php the_title('<h1>', '</h1>'); ?></a>
            <?php $concerts = \BandConcerts\ConcertSeries::getConcertsForSeries(get_the_ID());
            $years = [];
            $now = time();
            foreach($concerts as $c) {
                $date = get_the_date('d.m.Y', $c['id']);
                if(strtotime($date) > $now) {
                    $year = $date;
                }
                else {
                    $year = get_the_date('Y', $c['id']);
                }
                if(!in_array($year, $years)) {
                    $years[] = $year;
                }
            } ?>
            <p><time><?php echo \BandConcerts\Theme\Theme::get_icon('calendar').implode(', ', $years); ?></time></p>
            <?php
            $review = get_post_meta(get_the_ID(), \BandConcerts\ConcertSeries::REVIEW_FIELD, true);
            if(!empty($review)) { ?>
                <p><a href="<?php the_permalink() ?>#review"><?php echo \BandConcerts\Theme\Theme::get_icon('newspaper'); ?>Bericht lesen</a></p>
            <?php
            }
            edit_post_link(null, '<p>'.\BandConcerts\Theme\Theme::get_icon('edit'), '</p>');
            ?>
        </aside>
        <section>
            <?php the_post_thumbnail();
            the_content('(ganzer Beschrieb...)');
            ?>
        </section>
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
