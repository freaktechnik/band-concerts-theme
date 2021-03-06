<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php esc_attr(bloginfo('charset')); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <link rel="profile" href="http://gmpg.org/xfn/11">

        <meta name="msapplication-TileColor" content="#FFFFFF"/>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class() ?>>
        <a href="#maincontent" class="skip-link"><?php _e('Skip to main content') ?></a>
        <header class="main-head" id="top">
            <div class="upper-head">
                <?php if(is_page() && has_post_thumbnail()) { ?>
                <div id="wp-custom-header" class="wp-custom-header"><?php
                    the_post_thumbnail('full');
                ?></div>
                <?php }
                else {
                    the_custom_header_markup();
                } ?>
                <div class="wrapper">
                    <?php if(has_custom_logo()) {
                        the_custom_logo();
                        ?><h1 class="logotitle<?php echo \BandConcerts\Theme\Theme::alwaysShowName() ? '' : ' hidden'; ?>"><a href="<?php echo esc_attr(get_home_url()) ?>" rel="home"><?php
                        bloginfo('name');
                        ?></a></h1><?php
                    }
                    else {
                        ?><h1><a href="<?php echo esc_attr(get_home_url()) ?>" rel="home"><?php
                        bloginfo('name');
                        ?></a></h1><?php
                    } ?>
                </div>
            </div>
            <nav>
                <label id="menubutton" class="mobile-only" title="Menu" for="menu-toggle" aria-controls="menu">&#9776;</label>
                <input type="checkbox" id="menu-toggle">
                <div class="spanner">
                    <div class="wrapper">
                        <?php wp_nav_menu([
                            'container' => 'nav',
                            'theme_location' => 'primary'
                        ]); ?>
                    </div>
                </div>
            </nav>
        </header>
        <main id="maincontent">
            <div class="wrapper">
