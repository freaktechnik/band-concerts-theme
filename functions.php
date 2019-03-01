<?php
namespace BandConcerts\Theme;

require_once __DIR__.'/includes/Constants.php';
require_once __DIR__.'/includes/LinksWidget.php';

global $post;

/*
 * All hooks/actions are defined at the end of this file.
 */
class Theme {
    const COLOR_LABELS = [
        'text_color' => 'Text',
        'accent_color' => 'Akzent',
        'accent_hover_color' => 'Aktiver Akzent',
        'accent_text_color' => 'Akzent Text',
        'accent_alternate_color' => 'Alternativer Akzent',
        'accent_alternate_hover_color' => 'Alternative aktiver Akzent',
        'accent_alternate_text_color' => 'Alternativer Akzent Text',
        'link_color' => 'Links',
        'footer_color' => 'Footer',
        'footer_text_color' => 'Footer Text',
        'footer_text_hover_color' => 'Footer aktiver Text'
    ];

    const NO_ACTIVITIES_MESSAGE = 'Aktuell sind keine Aktivitäten bekannt.';
    const PAST_ACTIVITIES_BUTTON = 'Vergangene Aktivitäten';
    const ALL_ACTIVITIES_BUTTON = 'Alle Aktivitäten';

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
    function add_support()
    {
        add_theme_support('post-thumbnails', [ 'concertseries', 'post', 'page' ]);
        add_theme_support('custom-logo', [
            'height' => 140,
            'width' => 560,
            'flex-width' => true,
            'flex-height' => false,
            'header-text' => [ 'site-title' ]
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
        update_option('large_size_w', 664);

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
    function add_color_setting($wp_customize, $name, $default, $label)
    {
        $wp_customize->add_setting($name, [
            'default' => $default,
            'sanitize_callback' => 'sanitize_hex_color'
        ]);

        $wp_customize->add_control(new \WP_Customize_Color_Control(
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
    function customize_register($wp_customize)
    {
        foreach(self::COLOR_LABELS as $key => $label) {
            $this->add_color_setting($wp_customize, $key, Constants::COLORS[$key], $label);
        }

        // Header text toggle
        $wp_customize->add_setting('show_header_title', [
            'default' => true,
            'theme_supports' => 'custom-logo'
        ]);

        $wp_customize->add_control(new \WP_Customize_Control(
            $wp_customize,
            'show_header_title',
            [
                'section' => 'header_image',
                'label' => 'Titel anzeigen',
                'type' => 'checkbox'
            ])
        );

        // No concerts message
        $wp_customize->add_setting('no_concerts_message', [
            'default' => self::NO_ACTIVITIES_MESSAGE
        ]);

        $wp_customize->add_control(new \WP_Customize_Control(
            $wp_customize,
            'no_concerts_message',
            [
                'section' => 'static_front_page',
                'label' => 'Keine Aktivitäten Info',
                'description' => 'Nachricht wenn keine Aktivitäten anstehen'
            ])
        );

        // Past activities message
        $wp_customize->add_setting('past_concerts_message', [
            'default' => self::PAST_ACTIVITIES_BUTTON
        ]);

        $wp_customize->add_control(new \WP_Customize_Control(
            $wp_customize,
            'past_concerts_message',
            [
                'section' => 'static_front_page',
                'label' => 'Vergangene Aktivitäten Knopf'
            ])
        );

        // All activities message
        $wp_customize->add_setting('all_concerts_message', [
            'default' => self::ALL_ACTIVITIES_BUTTON
        ]);

        $wp_customize->add_control(new \WP_Customize_Control(
            $wp_customize,
            'all_concerts_message',
            [
                'section' => 'static_front_page',
                'label' => 'Alle Aktivitäten Knopf'
            ])
        );
    }

    /*
     * Registers scripts and styles for the theme.
     */
    function scripts()
    {
        wp_enqueue_style('bc-style-content', get_template_directory_uri().'/content.css', []);
        wp_enqueue_style('bc-style', get_template_directory_uri().'/style.css', [ 'bc-style-content' ]);
        // modified to call `svg4everybody();`
        wp_enqueue_script('svg4everybody', get_template_directory_uri().'/js/svg4everybody.min.js', [], '2.1.9', false);
    }

    /*
     * Prints the custom CSS based on the Color settings.
     */
    function custom_css()
    {
        ?><style type="text/css">
            <?php include __DIR__.'/inc/css-vars.php'; ?>
        </style><?php
    }

    /*
     * Registers the widget areas in the footer and the aside for rooms.
     */
    function add_sidebars()
    {
        register_sidebar([
            'name' => __('Fusszeile').' 1',
            'id' => 'footer',
            'before_widget' => '<section>',
            'after_widget' => '</section>',
            'before_title' => '<h4>',
            'after_title' => '</h4>',
        ]);
        register_sidebar([
            'name' => __('Fusszeile').' 2',
            'id' => 'footer2',
            'before_widget' => '<section>',
            'after_widget' => '</section>',
            'before_title' => '<h4>',
            'after_title' => '</h4>',
        ]);
        register_sidebar([
            'name' => __('Fusszeile').' 3',
            'id' => 'footer3',
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

    function add_editor_style(array $mceInit)
    {
        ob_start();
        include __DIR__.'/inc/css-vars.php';
        $styles = str_replace([ "\n", "\"" ], [ "", "\\\"" ], ob_get_clean());
        if(!isset($mceInit['content_style'])) {
            $mceInit['content_style'] = $styles . ' ';
        }
        else {
            $mceInit['content_style'] .= ' ' . $styles . ' ';
        }
        return $mceInit;
    }

    static function get_icon(string $icon, string $set = 'solid', string $class = 'fa-font'): string
    {
        $dir = get_template_directory_uri();
        return <<<HTML
<svg class="$class">
  <use xlink:href="$dir/images/fa-$set.svg#$icon"></use>
</svg>
HTML;
    }

    static function format_concerts(array $concerts, string $dateFormat = 'l j. F Y, H:i', bool $share = true)
    {
        if(count($concerts) == 1) {
            $concert = array_pop($concerts);
            ?><section id="event<?php echo $concert['id'] ?>"><?php
            self::format_details($concert, $dateFormat, $share);
            ?></section><?php
        }
        else { ?>
        <ul><?php foreach($concerts as $concert) { ?>
            <li id="event<?php echo $concert['id'] ?>"><?php self::format_details($concert, $dateFormat, $share); ?></li>
        <?php } ?>
        </ul>
        <?php
        }
    }

    static function format_details(array $concert, string $dateFormat = 'l j. F Y, H:i', bool $share = true)
    {
        $entry = '';
        if($concert['unco'] == 'unconfirmed' && strpos($dateFormat, 'H:i') !== FALSE) {
            $dateFormat = 'l j. F Y';
        }
        if($concert['fee'] != '-1') {
            $icon = self::get_icon('ticket-alt');
            $entry = '<section class="detail">'.$icon.'<span>Eintritt: '.(empty($concert['fee']) ? 'frei, Kollekte' : $concert['fee'].' CHF').'</span></section>';
        }
        ?><section class="detail"><?php echo self::get_icon('calendar'); ?><span><time datetime="<?php echo $concert['date'] ?>"><?php echo get_the_date($dateFormat, $concert['id']) ?></time><?php if($dateFormat == 'l j. F Y, H:i') { ?> Uhr<?php } ?></span></section>
        <?php
        if(!empty($concert['location'])) {
            ?><section class="detail"><?php echo self::get_icon('location-arrow'); ?><span><?php echo $concert['location']; ?></span></section><?php echo $entry;
        }
        if($share) {
            $inFuture = strtotime($concert[$concert['dateend'] ? 'dateend' : 'date']) > time();
            ?><section><?php
            if($inFuture || $concert['fbevent']) {
                echo self::get_icon('share');
            }
            if($inFuture) {
            ?><a href="<?php echo get_permalink($concert['id']) ?>" title="In Kalender Exportieren"><?php
            echo self::get_icon('calendar-plus');
            ?>Termin exportieren</a><?php
            }
            if($concert['fbevent']) {
                ?> <a href="<?php echo $concert['fbevent'] ?>" rel="external noopener" title="Facebook Event"><?php
                echo self::get_icon('facebook', 'brands');
                ?>Event</a><?php
            }
            ?></section><?php
        }
    }

    public static function alwaysShowName() {
        return !empty(get_theme_mod('show_header_title', '1'));
    }

    public static function noActivitiesMessage() {
        return get_theme_mod('no_concerts_message', self::NO_ACTIVITIES_MESSAGE);
    }

    public static function pastActivitiesButton() {
        return get_theme_mod('past_concerts_message', self::PAST_ACTIVITIES_BUTTON);
    }

    public static function allActivitiesButton() {
        return get_theme_mod('all_concerts_message', self::ALL_ACTIVITIES_BUTTON);
    }

    public function make_schema_events(\WP_Post $post, array $concerts = null): array
    {
        $schema = [
            'performer' => [
                '@type' => 'PerformingGroup',
                'name' => \BandConcerts\EventIcal::$organizerName
            ]
        ];
        if(has_custom_logo()) {
            $custom_logo_id = get_theme_mod('custom_logo');
            $schema['performer']['logo'] = wp_get_attachment_image_src($custom_logo_id , 'full')[0];
        }
        $schema['name'] = get_the_title($post);
        $schema['url'] = get_permalink($post);

        setup_postdata($post);
        $schema['description'] = strip_tags(apply_filters('the_content', get_the_content()));
        wp_reset_postdata();

        if($thumbnail = get_the_post_thumbnail_url($post)) {
            $schema['image'] = [ $thumbnail ];
        }

        if($concerts === null) {
            $concerts = \BandConcerts\ConcertSeries::getConcertsForSeries($post->ID);
        }

        $tz = new \DateTimeZone(\BandConcerts\EventICal::$timezone);
        $duration = new \DateInterval(\BandConcerts\EventICal::$eventDuration);;

        $out = [];
        foreach($concerts as $concert) {
            $eventType = 'Event';
            if(\BandConcerts\ConcertSeries::isConcert(get_the_ID())) {
                $eventType = 'MusicEvent';
            }
            $date = new \DateTime($concert['date'], $tz);
            $event = [
                '@context' => 'http://schema.org',
                '@type' => $eventType,
                'performer' => $schema['performer'],
                'url' => $schema['url'].'#event'.$concert['id'],
                'name' => $schema['name'],
                'startDate' => $date->format(\DateTime::W3C),
                'location' => [
                    '@type' => 'Place',
                    'name' => explode(',', $concert['location'])[0],
                    'address' => $concert['location']
                    //TODO needs address
                ],
                'image' => $schema['image'],
                'description' => $schema['description'],
            ];

            if(!empty($concert['dateend'])) {
                $dateend = new \DateTime($concert['dateend'], $tz);
                $event['endDate'] = $dateend->format(\DateTime::W3C);
            }
            else {
                if(!$concert['unco']) {
                    $date->add($duration);
                }
                else {
                    $date->add(new \DateInterval('PT23H59M59S'));
                }
                $event['endDate'] = $date->format(\DateTime::W3C);
            }

            if($concert['fee'] != '-1') {
                $event['offers'] = [
                    '@type' => 'Offer',
                    'price' => $concert['fee'],
                    'priceCurrency' => 'CHF'
                ];
                if(!empty($concert['fbevent'])) {
                    $event['offers']['url'] = $concert['fbevent'];
                }
            }
            $out[] = $event;
        }
        return $out;
    }

    /**
     * Adds the widget for the current edition.
     */
    public function onWidgets() {
        register_widget('\BandConcerts\Theme\LinksWidget');
        $this->add_sidebars();
    }

    public function onAdmin() {
        if(!class_exists('\BandConcerts\Plugin')) {
            echo '<div class="error"><p>'.__('Error: The theme needs the BandConcerts Plugin to function', 'my-theme' ).'</p></div>';
        }
    }

    function __construct() {
        // Suddenly actions.
        add_action('after_setup_theme', [$this, 'add_support']);
        add_action('customize_register', [$this, 'customize_register']);
        add_action('wp_enqueue_scripts', [$this, 'scripts']);
        add_action('wp_head', [$this, 'custom_css']);
        add_action('widgets_init', [$this, 'onWidgets']);
        add_action('admin_notices', [$this, 'onAdmin']);
        add_filter('tiny_mce_before_init', [$this, 'add_editor_style']);
    }
}

new Theme();
