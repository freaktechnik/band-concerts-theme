<?php get_header(); ?>
    <section class="main">
        <h1>Unsere nächsten Konzerte</h1>
        <?php
            $concertseries = BandConcertPlugin::getCurrentConcerts();
            foreach($concertseries as $cs) {
                $post = $cs;
                $concerts = BC_ConcertSeries::getConcertsForSeries($cs->ID);
                $concerts = array_filter($concerts, function($i) {
                    $date = strtotime($i['date']);
                    return $date > time();
                });
        ?>
        <article id="concert-<?php echo $cs->ID ?>" class="<?php post_class() ?>">
            <a href="<?php echo get_permalink($cs) ?>"><?php the_title('<h2>', '</h2>') ?></a>
            <?php the_post_thumbnail();
            echo $cs->post_content; ?>
            <h3>Auftritte</h3>
            <?php include(dirname(__FILE__).'/inc/concert-dates.php') ?>
        </article>
        <?php } ?>
        <p><a href="index.php/concert/">Zu den Konzertberichten</a></p>
    </section>
    <?php if(is_active_sidebar('aside')) { ?>
    <aside>
        <?php dynamic_sidebar('aside'); ?>
    </aside>
    <?php }
get_footer(); ?>
