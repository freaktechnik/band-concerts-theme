<?php
require_once __DIR__.'/../includes/Constants.php';

use \BandConcerts\Theme\Constants;

$ignoredKeys = [
    'background_color'
];
?>


@supports (--css: variables) {
    :root {
        --background-color: #<?php background_color(); ?>;
    <?php foreach(Constants::COLORS as $key => $color) {
        if(in_array($key, $ignoredKeys)) {
            continue;
        }
        $cssColor = Constants::key_to_cssvar($key);
        echo '--'.$cssColor.': '.get_theme_mod($key, $color).';';
    } ?>
    }
}
