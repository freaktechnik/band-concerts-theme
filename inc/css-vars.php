<?php
require_once 'constants.php';

$ignoredKeys = [
    'background_color'
];
function key_to_cssvar($key) {
    return str_replace('_', '-', str_replace('text', 'font', $key));
} ?>
body {
    --background-color: #<?php background_color(); ?>;
<?php foreach(Constants::COLORS as $key => $color) {
    if(in_array($key, $ignoredKeys)) {
        continue;
    }
    $cssColor = key_to_cssvar($key);
    echo '--'.$cssColor.': '.get_theme_mod($key, $color).';';
} ?>
}
