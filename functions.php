<?php
/*
 * All hooks/actions are defined at the end of this file.
 */
class BCBTheme {
    /*
     * Declares theme support for
     *  - Thumbnails on rooms
     *  - Custom Logo
     *  - HTML5
     *  - Title tag
     *  - Automatic feed links
     *  - Custom background
     * Adds multiple image sizes, sets the thumbnail size, registers the main nav
     * menu and editor styles.
     */
    function add_support() {
        global $content_width;
        add_theme_support('post-thumbnails', [ 'concertseries', 'page' ]);
        add_theme_support('custom-logo', [
            'height' => 140,
            'width' => 560,
            'flex-width' => true,
            'flex-height' => false
        ]);
        add_theme_support('custom-header', [
            'width' => '1920',
            'height' => '200',
            'flex-width' => true,
            'flex-height' => true,
            'uploads' => true,
            'header-text' => false,
            'video' => true
        ]);
        // Bigger sizes so it scales on hidpi displays
        add_image_size('header-logo-2x', 1120, 280);
        //TODO no srcset?

        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ]);
        add_theme_support('title-tag');
        add_theme_support('automatic-feed-links');
        add_theme_support('custom-background', [
            'default-color' => 'ffffff'
        ]);
    /*
        $crop = [ 'center', 'center' ];
        add_image_size('post-thumbnail_xl', 3900, 1080, $crop);
        add_image_size('post-thumbnail_l', 1920, 576, $crop);
        add_image_size('post-thubmnail_xm', 1280, 384, $crop);
        add_image_size('post-thumbnail_m', 720, 216, $crop);
        set_post_thumbnail_size(480, 144, $crop);

        add_image_size('gallery-2x', 300, 300, $crop);
        add_image_size('gallery-3x', 450, 450, $crop);
        add_image_size('gallery-4x', 600, 600, $crop);
    */
        register_nav_menus([
            'primary' => 'Hauptnavigation'
        ]);

        //add_editor_style(['content.css']);

        if(!isset($content_width)) {
            $content_width = 678;
        }
    }

    /*
     * Helper function that adds a color setting and control to the Customizer.
     */
    function add_color_setting($wp_customize, $name, $default, $label) {
        $wp_customize->add_setting($name, [
            'default' => $default,
            'sanitize_callback' => 'sanitize_hex_color'
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            $name,
            [
                'section' => 'colors',
                'label' => $label
            ])
        );
    }

    /*
     * Adds custom theme settings. Mainly a select for the room on the custom front
     * page and color options.
     */
    function customize_register($wp_customize) {
        $this->add_color_setting($wp_customize, 'text_color', '#291610', 'Text');
        $this->add_color_setting($wp_customize, 'accent_color', '#d5d0c4', 'Akzent');
        $this->add_color_setting($wp_customize, 'accent_hover_color', '#dfdbd2', 'Aktiver akzent');
        $this->add_color_setting($wp_customize, 'accent_alternate_color', '#b27100', 'Alternativer Akzent');
        $this->add_color_setting($wp_customize, 'accent_text_color', '#605036', 'Akzent Text');
        $this->add_color_setting($wp_customize, 'link_color', '#605036', 'Links');
    }

    /*
     * Registers scripts and styles for the theme.
     */
    function scripts() {
        wp_enqueue_style('bcb-style', get_stylesheet_uri(), []);
        //wp_enqueue_style('bcb.style-admin', get_stylesheet_directory_uri().'/content.css');

        if(is_user_logged_in()) {
            //wp_enqueue_style('bcb-style-admin', get_stylesheet_directory_uri().'/admin.css');
        }
    }

    /*
     * Prints the custom CSS based on the Color settings.
     */
    function custom_css() {
        ?><style type="text/css">
            body {
                --font-color: <?php echo get_theme_mod('text_color', '#291610'); ?>;
                --background-color: #<?php echo get_background_color(); ?>;
                --accent-color: <?php echo get_theme_mod('accent_color', '#d5d0c4') ?>;
                --accent-hover-color: <?php echo get_theme_mod('accent_hover_color', '#dfdbd2') ?>;
                --accent-alternate-color: <?php echo get_theme_mod('accent_alternate_color', '#b27100') ?>;
                --accent-font-color: <?php echo get_theme_mod('accent_text_color', '#605036') ?>;
                --link-color: <?php echo get_theme_mod('link_color', '#605036') ?>;
            }
        </style><?php
    }

    /*
     * Registers the widget areas in the footer and the aside for rooms.
     */
    function add_sidebars() {
    	register_sidebar([
    		'name' => __('Fusszeile'),
    		'id' => 'footer',
    		'before_widget' => '<section>',
    		'after_widget' => '</section>',
    		'before_title' => '<h4>',
    		'after_title' => '</h4>',
    	]);
        register_sidebar([
    		'name' => __('Seitenleiste'),
    		'id' => 'aside',
    		'before_widget' => '<section>',
    		'after_widget' => '</section>',
    		'before_title' => '<h2>',
    		'after_title' => '</h2>',
    	]);
    }

    function __construct() {
        // Suddenly actions.
        add_action('after_setup_theme', [$this, 'add_support']);
        add_action('customize_register', [$this, 'customize_register']);
        add_action('wp_enqueue_scripts', [$this, 'scripts']);
        add_action('wp_head', [$this, 'custom_css']);
        add_action('widgets_init', [$this, 'add_sidebars']);
    }
}

new BCBTheme();
