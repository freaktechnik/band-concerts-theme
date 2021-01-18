<?php get_header(); ?>
<div>
<?php
    $itemList = [
        '@context' => 'http://schema.org',
        '@type' => 'ItemList',
        'itemListElement' => []
    ];
    $itemPosition = 0;
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
            if(get_post()->post_type !== 'post') {
                $item = [
                    '@type' => 'ListItem',
                    'position' => ++$itemPosition,
                    'url' => get_permalink()
                ];
                $itemList['itemListElement'][] = $item;
            }
            $nonCancelledYears = [];
            foreach($concerts as $c) {
                $date = get_the_date('d.m.Y', $c['id']);
                $cancelled = $c['cancelled'];
                if(strtotime($date) > $now) {
                    $year = $date;
                }
                else {
                    $year = get_the_date('Y', $c['id']);
                }
                if(!in_array($year, $years)) {
                    $years[] = $year;
                }
                if(!$cancelled && !in_array($year, $nonCancelledYears)) {
                    $nonCancelledYears[] = $year;
                }
            }
            $dates = [];
            foreach($years as $year) {
                $date = '<date>';
                $cancelled = !in_array($year, $nonCancelledYears);
                if($cancelled) {
                    $date = '<date class="detail cancelled">';
                }
                $date .= $year.'</date>';
                $dates[] = $date;
            } ?>
            <p><?php echo \BandConcerts\Theme\Theme::get_icon('calendar').implode(', ', $dates); ?></p>
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
            <?php
            ob_start();
            the_post_thumbnail();
            the_content('(ganzer Beschrieb...)');
            $content = ob_get_flush();
            if(!strlen($content)) {
            ?><div class="concert-placeholder"><?php echo \BandConcerts\Theme\Theme::get_icon(\BandConcerts\ConcertSeries::isConcert(get_the_ID()) ? 'music' : 'calendar', 'solid', 'fa-placeholder') ?></div><?php
            }
            ?>
        </section>
    </article><?php
}
if(!empty($itemList['itemListElement'])) {
    echo '<script type="application/ld+json">';
    echo json_encode($itemList, JSON_UNESCAPED_SLASHES);
    echo '</script>';
}
the_posts_pagination([
    'prev_text' => 'Vorherige',
    'next_text' => 'Nächste',
    'screen_reader_text' => 'Posts navigation'
]);
?>
</div>
<?php get_footer(); ?>
