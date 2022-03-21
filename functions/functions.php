<?php

function mv_slider_options()
{
    $show_slider_nav = MV_Slider_Settings::$options['mv_slider_bullets'];

    wp_enqueue_script(
        'mv-slider-options-js',
        MV_SLIDER_URL . 'vendor/flexslider/flexslider.js',
        ['jquery'],
        MV_SLIDER_VERSION,
        true
    );

    wp_localize_script('mv-slider-options-js', 'SLIDER_OPTIONS', ['controlNav' => $show_slider_nav]);
}