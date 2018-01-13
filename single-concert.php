<?php
while(have_posts()) {
    the_post();
    $post = BC_ConcertSeries::getSeriesForConcert(get_the_ID());
    $concerts = BC_Concert::FormatPost(get_post(), $post->ID);
    $cal = BC_EventICal::MakeSingleEvent($concerts);
    $cal->emit();
    return;
}
