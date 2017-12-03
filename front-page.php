<?php get_header(); ?>
    <section class="main">
        <h1>Nächste Termine</h1>
        <?php
            $concertseries = BandConcertPlugin::getCurrentConcerts();
            $printedConcert = false;
            $bc_css = [];
            foreach($concertseries as $cs) {
                $concerts = BC_ConcertSeries::getConcertsForSeries($cs->ID);
                $concerts = array_filter($concerts, function($i) {
                    $date = strtotime($i['date']);
                    $i['time'] = $date;
                    return $date > time();
                });
                if(!count($concerts)) {
                    continue;
                }

                $earliestConcertDate = NULL;
                foreach($concerts as $c) {
                    if(empty($earliestConcertDate) || $c['time'] < $earliestConcertDate) {
                        $earliestConcertDate = $c['time'];
                    }
                }

                $cs->concerts = $concerts;
                $cs->earliestTime = $earliestConcertDate;
                $bc_css[] = $cs;
            }
            usort($bc_css, function($a, $b) {
                return $a->earliestTime - $b->earliestTime;
            });
            $itemCount = 5;
            $bc_css = array_slice($bc_css, 0, $itemCount);

            $postQuery = new WP_Query([
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 1
            ]);
            if($postQuery->have_posts()) {
                $index = min(count($bc_css), $itemCount - 1);
                $bc_css[$index] = $postQuery->next_post();
            }

            $firstConcert = true;
            foreach($bc_css as $cs) {
                $printedConcert = true;
                if($firstConcert) {
                    $firstConcert = false; ?>
        <article id="concert-<?php echo $cs->ID ?>" <?php post_class('bc_first', $cs->ID) ?>>
            <a href="<?php echo get_permalink($cs) ?>"><h2><?php echo get_the_title($cs) ?></h2></a>
            <?php echo get_the_post_thumbnail($cs);
            ?><section><?php
                echo $cs->post_content;
            ?></section><?php
            if(BC_ConcertSeries::isConcert($cs->ID)) { ?>
            <h3>Auftritte</h3>
            <?php }
            $concerts = $cs->concerts;
            include(dirname(__FILE__).'/inc/concert-dates.php') ?>
        </article>
        <div class="bc_extras">
        <?php }
                else { ?>
        <article id="concert-<?php echo $cs->ID ?>" <?php post_class('bc_extra', $cs->ID) ?>>
            <a href="<?php echo get_permalink($cs) ?>"><h2><?php echo get_the_title($cs) ?></h2></a>
            <?php
            if($cs->post_type === 'post') { ?>
                <p><time datetime="<?php echo get_the_date(DateTime::W3C, $cs); ?>"><?php echo get_the_date(NULL, $cs); ?></time></p>
                <p><?php
                echo get_the_author_meta('display_name', $cs->post_author); ?>
                </p><?php
            }
            else {
                $concerts = $cs->concerts;
                include(dirname(__FILE__).'/inc/short-concert-dates.php');
            }?>
        </article>
                <?php }
            } ?></div><?php
            if(!$printedConcert) { ?>
        <p>Aktuell sind keine Aktivitäten bekannt.</p>
        <p><a href="index.php/concert/">Vergangene Aktivitäten</a></p>
        <?php }
        else { ?>
        <p><a href="index.php/concert/">Alle Aktivitäten</a></p>
        <?php } ?>
    </section>
    <?php if(is_active_sidebar('aside')) { ?>
    <aside>
        <?php dynamic_sidebar('aside'); ?>
    </aside>
    <?php }
get_footer(); ?>
