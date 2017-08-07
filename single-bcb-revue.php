<?php while(have_posts()) {
    the_post();
    $meta = get_post_meta(get_the_ID(), BCBRevuePlugin::REVUE_FIELD, true);
    Header('location:'.wp_get_attachment_url($meta));
    die();
} ?>
