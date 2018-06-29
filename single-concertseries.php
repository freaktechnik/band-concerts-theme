<?php get_header();
$schema = [
    '@context' => 'http://schema.org',
    '@type' => 'EventSeries',
    'subEvent' => [],
    'performer' => [
        '@type' => 'PerformingGroup',
        'name' => \BandConcerts\EventIcal::$organizerName
    ]
];
if(has_custom_logo()) {
    $custom_logo_id = get_theme_mod('custom_logo');
    $schema['performer']['logo'] = wp_get_attachment_image_src($custom_logo_id , 'full')[0];
}
while(have_posts()) {
the_post();
$schema['subEvents'] = [];
$schema['name'] = get_the_title();
$schema['description'] = strip_tags(apply_filters('the_content', get_the_content()));
if($thumbnail = get_the_post_thumbnail_url()) {
    $schema['image'] = [ $thumbnail ];
}
?>
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
        ob_start();
        the_post_thumbnail();
        the_content();
        $review = apply_filters( 'the_content', get_post_meta(get_the_ID(), \BandConcerts\ConcertSeries::REVIEW_FIELD, true));
        $content = ob_get_flush();
        if(!empty($review)) { ?>
        <h2 id="review"><?php echo \BandConcerts\ConcertSeries::IsConcert(get_the_ID()) ? 'Konzertbericht' : 'Rückblick'; ?></h2>
        <p><?php echo $review; ?></p>
        <?php }
        else if(!strlen($content)) {
        ?><div class="concert-placeholder"><?php echo \BandConcerts\Theme\Theme::get_icon(\BandConcerts\ConcertSeries::isConcert(get_the_ID()) ? 'music' : 'calendar', 'solid', 'fa-placeholder') ?></div><?php
        } ?>
    </section>
</article>
<script type="application/ld+json">
<?php
foreach($concerts as $concert) {
    $eventType = 'Event';
    if(\BandConcerts\ConcertSeries::isConcert(get_the_ID())) {
        $eventType = 'MusicEvent';
    }
    $event = [
        '@type' => $eventType,
        'performer' => $schema['performer'],
        'name' => $schema['name'],
        'startDate' => date(\DateTime::W3C, $concert['date']),
        'location' => [
            '@type' => 'Place',
            'name' => explode(',', $concert['location'])[0],
            'address' => $concert['location']
            //TODO needs address
        ],
        'image' => $schema['image'],
        'description' => $schema['description'],
    ];

    if(!empty($concert['dateend'])) {
        $event['endDate'] = date(\DateTime::W3C, $concert['dateend']);
    }

    if($concert['fee'] != '-1') {
        $event['offers'] = [
            '@type' => 'Offer',
            'price' => $concert['fee'],
            'priceCurrency' => 'CHF'
        ];
    }
    $schema['subEvents'][] = $event;
}
echo json_encode($schema, JSON_UNESCAPED_SLASHES);
?>
</script>
<?php }
get_footer();
