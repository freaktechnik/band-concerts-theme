<?php
class Constants {
    const COLORS = [
        'text_color' => '#291610',
        'accent_color' => '#047983',
        'accent_hover_color' => '#285F63',
        'accent_text_color' => '#FFFFFF',
        'accent_alternate_color' => '#CCCCCC',
        'accent_alternate_hover_color' => '#EEEEEE',
        'accent_alternate_text_color' => '#291610',
        'link_color' => '#047983',
        'background_color' => '#FFFFFF',
        'shadow_color' => '#291610',
        'footer_color' => '#303232',
        'footer_text_color' => '#E8E8DE',
        'footer_text_hover_color' => '#EEB100'
    ];
}

function key_to_cssvar($key) {
    return str_replace('_', '-', str_replace('text', 'font', $key));
}
