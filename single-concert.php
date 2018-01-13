<?php
while(have_posts()) {
    the_post();
    $post = \BandConcerts\ConcertSeries::getSeriesForConcert(get_the_ID());
    $concerts = \BandConcerts\Concert::FormatPost(get_post(), $post->ID);
    $cal = \BandConcerts\EventICal::MakeSingleEvent($concerts);
    $cal->emit($post->post_title.'.ics');
    return;
}
