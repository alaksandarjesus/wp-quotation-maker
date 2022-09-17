<?php

if (!function_exists('wp_3575e7_quomak_page_shortcode')) {

    function wp_3575e7_quomak_page_shortcode($atts, $content = null)
    {

        $attributes = shortcode_atts(array(
            'page' => ''
        ), $atts);

        
        ob_start();

        get_template_part('pages/'.$attributes['page'].'/index', null, $attributes);

        return ob_get_clean();
    }
}

add_shortcode('quomak-page', 'wp_3575e7_quomak_page_shortcode');
