<?php get_header(); ?>
    <section class="main">
        <h1>Unsere nächsten Konzerte</h1>
        <?php
            $concertseries = BandConcertPlugin::getCurrentConcerts();
            foreach($concertseries as $cs) {
                $post = $cs;
                $concerts = BC_ConcertSeries::getConcertsForSeries($cs->ID);
        ?>
        <article id="concert-<?php echo $cs->ID ?>" class="<?php post_class() ?>">
            <a href="<?php echo get_permalink($cs) ?>"><?php the_title('<h2>', '</h2>') ?></a>
            <?php the_post_thumbnail();
            echo $cs->post_content; ?>
            <h3>Auftritte</h3>
            <ul><?php foreach($concerts as $concert) {
                if(strtotime($concert['date']) > time()) { ?>
                <li><time datetime="<?php echo $concert['date'] ?>"><?php echo get_the_date('l j. F Y, H:i', $concert['id']) ?></time>, <?php echo $concert['location'] ?></li>
                <?php }
            } ?>
            </ul>
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
