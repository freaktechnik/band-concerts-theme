<?php
while(have_posts()) {
    the_post();
    $concert = get_post();
    $post = \BandConcerts\ConcertSeries::getSeriesForConcert(get_the_ID());
    $concerts = \BandConcerts\Concert::FormatPost($concert, $post->ID);
    $cal = \BandConcerts\EventICal::MakeSingleEvent($concerts);
    $cal->emit($post->post_title.'.ics');
    return;
}
