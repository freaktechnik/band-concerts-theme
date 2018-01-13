<?php get_header(); ?>
    <section class="main">
        <h1>Nächste Termine</h1>
        <?php
            $concertseries = \BandConcerts\Plugin::getCurrentConcerts();
            $printedConcert = false;
            $bc_css = [];
            foreach($concertseries as $cs) {
                $concerts = \BandConcerts\ConcertSeries::getConcertsForSeries($cs->ID);
                $earliestConcertDate = NULL;
                $concerts = array_filter($concerts, function($i) use(&$earliestConcertDate) {
                    $date = strtotime($i['date']);
                    if($date > time()) {
                        if(empty($earliestConcertDate) || $date < $earliestConcertDate) {
                            $earliestConcertDate = $date;
                        }
                        return true;
                    }
                    return false;
                });
                if(!count($concerts)) {
                    continue;
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

            if(count($bc_css) > 1 && count($bc_css) < $itemCount) {
                $postQuery = new WP_Query([
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => 1
                ]);
                if($postQuery->have_posts()) {
                    $index = min(count($bc_css), $itemCount - 1);
                    $bc_css[$index] = $postQuery->next_post();
                }
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
            if(\BandConcerts\ConcertSeries::isConcert($cs->ID)) { ?>
            <h3>Auftritte</h3>
            <?php }
            $concerts = $cs->concerts;
            ?><div class="cf-two-columns"><?php
            \BandConcerts\Theme\Theme::format_concerts($concerts, 'l j. F Y, H:i', false); ?></div>
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
                include __DIR__.'/inc/short-concert-dates.php';
            }?>
        </article>
                <?php }
            }
            if(!$printedConcert) { ?>
        <p>Aktuell sind keine Aktivitäten bekannt.</p>
        <p><a href="index.php/concert/" class="button">Vergangene Aktivitäten</a></p>
        <?php }
        else { ?>
        </div><p><a href="index.php/concert/" class="button">Alle Aktivitäten</a></p>
        <?php } ?>
    </section>
    <?php if(is_active_sidebar('aside')) { ?>
    <aside>
        <?php dynamic_sidebar('aside'); ?>
    </aside>
    <?php }
get_footer(); ?>
