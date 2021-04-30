<?php
function dblimgs_add_shortcodes() {
    add_shortcode('dblimgs_images', 'dblimgs_render');

}

function dblimgs_render($atts) {
    $html = '';

    $html .= '<div class="dblimgs_main">';
    foreach ($atts as $key => $value) {
        if (substr($key, 0, 4) == 'img_' && !empty($value)) {
            $i = substr($key, 4);
            $alt = isset($atts['alt_' . $i]) ? $atts['alt_' . $i] : '';
            $class = isset($atts['class_' . $i]) ? $atts['class_' . $i] : '';
            $ratio = isset($atts['ratio_' . $i]) ? $atts['ratio_' . $i] : '';
            $html .='<div style="flex: ' . $ratio . '">';
            $html .= '<img src="' . $value . '" class="' . $class . '" alt="' . $alt . '" title="' . $alt . '"/>';
            $html .='</div>';
        }
    }
    $html .= '</div>';

    return $html;
}