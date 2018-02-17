<?php
require_once __DIR__.'/../includes/Constants.php';

use \BandConcerts\Theme\Constants;

$ignoredKeys = [
    'background_color'
];
$shadow = 'box-shadow: 0 0 .5rem';
$variableSelectors = [
    'text_color' => [
        '.skip-link:focus' => 'color',
    ],
    'background_color' => [
        '.skip-link:focus' => 'background-color',
        'main' => 'background-color',
        '.wpcf7 button, .wpcf7 input[type="submit"], .wpcf7 input[type="button"], a.button, a.button:link, a.next.page-numbers, a.prev.page-numbers' => 'background-color',
        '.wpcf7 input[type="checkbox"],.wpcf7 input[type="radio"]' => 'background-color',
        'body' => 'background-color',
    ],
    'text_color' => [
        '.wpcf7 button, .wpcf7 input[type="submit"], .wpcf7 input[type="button"], a.button, a.button:link, a.next.page-numbers, a.prev.page-numbers' => 'color',
        'svg.fa-font' => 'fill',
        'body' => 'color',
    ],
    'link_color' => [
        'a, a:link, a:visited' => 'color',
        'a:not(.image):hover, a:not(.image):active, a:not(.image):focus' => 'color',
        'a:not(.image):hover, a:not(.image):active, a:not(.image):focus' => 'border-bottom: 1px solid',
    ],
    'accent_color' => [
        '.logotitle' => 'color',
        '#menubutton' => 'background-color',
        'header .spanner' => 'background-color',
        'header .sub-menu li:hover, header .sub-menu li:active, header .sub-menu li.current-menu-item, header .children li:hover, header .children li:active, header .children li.current_page_item' => 'background-color',
        '.wpcf7-form-control:not(.wpcf7-mailpoetsignup):not(.wpcf7-radio), a.button, a.button:link, a.next.page-numbers, a.prev.page-numbers' => 'border: 1px solid',
        '.wpcf7 input[type="submit"]:hover, .wpcf7 input[type="submit"]:active, .wpcf7 input[type="button"]:hover, .wpcf7 input[type="button"]:active, .wpcf7 button:hover, .wpcf7 button:active, a.button:hover, a.button:active, a.next.page-numbers:hover, a.next.page-numbers:active, a.prev.page-numbers:hover, a.prev.page-numbers:active' => 'background-color',
        '.wpcf7 input[type="checkbox"],.wpcf7 input[type="radio"]' => 'border: 1px solid',
        '.wpcf7 input[type="checkbox"]:checked,.wpcf7 input[type="radio"]:checked' => 'background-color',
    ],
    'accent_hover_color' => [
        '#menubutton:hover, #menubutton:active' => 'background-color',
        'header .sub-menu, header .children' => 'background-color',
        '.menu li:hover, .menu li:active, .menu li.current-menu-item, .menu li.current-menu-ancestor' => 'background-color',
    ],
    'accent_text_color' => [
        '#menubutton' => 'color',
        'header .spanner' => 'color',
        '.menu li:not(:last-child)' => 'boder-bottom: 1px solid',
        '.menu > li a, .menu li > a:link, .menu li > a:visited' => 'color',
        '.wpcf7 input[type="submit"]:hover, .wpcf7 input[type="submit"]:active, .wpcf7 input[type="button"]:hover, .wpcf7 input[type="button"]:active, .wpcf7 button:hover, .wpcf7 button:active, a.button:hover, a.button:active, a.next.page-numbers:hover, a.next.page-numbers:active, a.prev.page-numbers:hover, a.prev.page-numbers:active' => 'color',
        '.wpcf7 input[type="checkbox"]:checked::after,.wpcf7 input[type="radio"]:checked::after' => 'color',
        '.menu li:not(:last-child)' => 'border-bottom: 1px solid',
    ],
    'accent_alternate_color' => [
        'main aside' => 'background-color',
        'blockquote' => 'border-left: 0.5rem solid',
    ],
    'accent_alternate_hover_color' => [
        'main .menu li:hover' => 'background-color',
    ],
    'accent_alternate_text_color' => [
        'main aside' => 'color',
        'main .menu li:not(:last-child)' => 'border-bottom: 1px solid',
        'main .menu li > a, main .menu li > a:link, main .menu li > a:visited' => 'color',
    ],
    'shadow_color' => [
        '#menubutton' => $shadow,
        'header .spanner' => $shadow,
    ],
    'footer_color' => [
        'footer' => 'background-color',
        'footer button, footer input[type="submit"], footer input[type="button"]' => 'background-color',
        'footer button:hover, footer button:active, footer input[type="submit"]:hover, footer input[type="submit"]:active, footer input[type="button"]:hover, footer input[type="button"]:active' => 'color',
    ],
    'footer_text_color' => [
        'footer' => 'color',
        'footer a:not(.image), footer a:not(.image):link' => 'color',
        'footer button, footer input' => 'border: 1px solid',
        'footer button, footer input[type="submit"], footer input[type="button"]' => 'color',
        'svg.fa-footer' => 'fill',
        'footer .menu li:not(:last-child)' => 'border-bottom: 1px solid',
    ],
    'footer_text_hover_color' => [
        'footer a:not(.image):hover, footer a:not(.image):active, footer a:not(.image):focus' => 'border-bottom: 1px solid',
        'footer a:not(.image):hover, footer a:not(.image):active, footer a:not(.image):focus' => 'color',
        'footer button:hover, footer button:active, footer input[type="submit"]:hover, footer input[type="submit"]:active, footer input[type="button"]:hover, footer input[type="button"]:active' => 'background-color',
        'footer button:hover, footer button:active, footer input[type="submit"]:hover, footer input[type="submit"]:active, footer input[type="button"]:hover, footer input[type="button"]:active' => 'border-color',
        'svg.fa-footer:hover' => 'fill',
    ],
];

$resolvedColors = [];
foreach(Constants::COLORS as $var => $val) {
    $resolvedColors[$var] = get_theme_mod($var, $val);
}

$css = [];
foreach($variableSelectors as $var => $selectors) {
    foreach($selectors as $selector => $prop) {
        if(strpos($prop, ':') === false) {
            $line = $prop.': '.$resolvedColors[$var];
        }
        else {
            $line = $prop.' '.$resolvedColors[$var];
        }
        $css[$selector][] = $line;
    }
}
foreach($css as $selector => $lines) {
    echo $selector;
    echo "{";
    foreach($lines as $line) {
        echo $line.";";
    }
    echo "}\n";
}
?>

@supports (--css: variables) {
    :root {
        --background-color: #<?php background_color(); ?>;
    <?php foreach(Constants::COLORS as $key => $color) {
        if(in_array($key, $ignoredKeys)) {
            continue;
        }
        $cssColor = Constants::key_to_cssvar($key);
        echo '--'.$cssColor.': '.$resolvedColors[$key].';';
    } ?>
    }
}
