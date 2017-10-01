<?php
require 'inc/constants.php';

/*
 * All hooks/actions are defined at the end of this file.
 */
class BCTheme {
    const COLOR_LABELS = [
        'text_color' => 'Text',
        'accent_color' => 'Akzent',
        'accent_hover_color' => 'Aktiver Akzent',
        'accent_alternate_color' => 'Alternativer Akzent',
        'accent_text_color' => 'Akzent Text',
        'link_color' => 'Links'
    ];

    /*
     * Declares theme support for
     *  - Thumbnails on pages and concerts
     *  - Custom Logo
     *  - Custom header background
     *  - HTML5
     *  - Title tag
     *  - Automatic feed links
     *  - Custom background
     * Adds multiple image sizes, sets the thumbnail size, registers the main nav
     * menu and editor styles.
     */
    function add_support() {
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
            'default-color' => substr(Constants::COLORS['background_color'], 1)
        ]);

        register_nav_menus([
            'primary' => 'Hauptnavigation'
        ]);

        add_editor_style(['content.css', 'editor.css']);
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
        foreach(self::COLOR_LABELS as $key => $label) {
            $this->add_color_setting($wp_customize, $key, Constants::COLORS[$key], $label);
        }
    }

    /*
     * Registers scripts and styles for the theme.
     */
    function scripts() {
        wp_enqueue_style('bc-style', get_stylesheet_uri(), []);
    }

    /*
     * Prints the custom CSS based on the Color settings.
     */
    function custom_css() {
        ?><style type="text/css">
            <?php include(dirname(__FILE__).'/inc/css-vars.php'); ?>
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

    function add_editor_style($mceInit) {
        ob_start();
        include(dirname(__FILE__).'/inc/css-vars.php');
        $styles = str_replace("\n", "", ob_get_clean());
        if(!isset($mceInit['content_style'])) {
            $mceInit['content_style'] = $styles . ' ';
        }
        else {
            $mceInit['content_style'] .= ' ' . $styles . ' ';
        }
        return $mceInit;
    }

    function __construct() {
        // Suddenly actions.
        add_action('after_setup_theme', [$this, 'add_support']);
        add_action('customize_register', [$this, 'customize_register']);
        add_action('wp_enqueue_scripts', [$this, 'scripts']);
        add_action('wp_head', [$this, 'custom_css']);
        add_action('widgets_init', [$this, 'add_sidebars']);
        add_filter('tiny_mce_before_init', [$this, 'add_editor_style']);
    }
}

new BCTheme();
