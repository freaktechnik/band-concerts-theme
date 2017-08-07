<?php get_header();
    while(have_posts()) {
    the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class([
        'two-columns'
    ]); ?>>
        <aside>
            <?php the_title('<h1>', '</h1>');
            edit_post_link();
            if(is_page(get_the_ID())) { ?>
                <ul class="menu big-only">
                <?php wp_list_pages([
                    'child_of' => get_the_ID(),
                    'title_li' => null
                ]); ?>
                </ul>
            <?php } ?>
        </aside>
        <section>
            <?php the_content(); ?>
        </section>
    </article><?php
}
get_footer(); ?>
