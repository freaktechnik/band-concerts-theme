<?php
require_once 'constants.php';

$ignoredKeys = [
    'background_color'
];
?>


@supports(--css: variables) {
    :root {
        --background-color: #<?php background_color(); ?>;
    <?php foreach(Constants::COLORS as $key => $color) {
        if(in_array($key, $ignoredKeys)) {
            continue;
        }
        $cssColor = key_to_cssvar($key);
        echo '--'.$cssColor.': '.get_theme_mod($key, $color).';';
    } ?>
    }
}
