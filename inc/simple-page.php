<article id="post-<?php the_ID(); ?>" <?php post_class([
    'two-columns'
]); ?>>
    <aside>
        <?php if(!is_singular()) { ?><a href="<?php the_permalink() ?>"><?php }
        the_title('<h1>', '</h1>');

        if(!is_page()) { ?>
        <p><?php
            the_date('F j, Y', '<time>', '</time>');
            the_author();
        ?></p><?php
        }

        if(!is_singular()) { ?></a><?php }
        edit_post_link(null, '<p>', '</p>');
        if(is_page(get_the_ID()) && is_singular() && basename(get_page_template()) !== 'page_sublist.php') {
            $children = get_children([
                'post_parent' => get_the_ID(),
                'post_type' => 'page'
            ]);
            if(count($children) > 0) { ?>
            <ul class="menu big-only">
            <?php wp_list_pages([
                'child_of' => get_the_ID(),
                'title_li' => null
            ]); ?>
            </ul>
        <?php }
        } ?>
    </aside>
    <section>
        <?php the_content(); ?>
    </section>
</article>