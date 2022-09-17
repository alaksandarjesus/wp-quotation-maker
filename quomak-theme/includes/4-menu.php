<?php

if (!function_exists('wp_533625_quomak_register_nav_menus')) {

    function wp_533625_quomak_register_nav_menus()
    {
        register_nav_menus(array(
            'primary-menu' => __('Primary Menu', 'text_domain'),
            'footer-menu-1' => __('Footer Menu 1', 'text_domain'),
            'footer-menu-2' => __('Footer Menu 2', 'text_domain'),
            'footer-menu-3' => __('Footer Menu 3', 'text_domain'),
            'footer-menu-4' => __('Footer Menu 4', 'text_domain'),
        ));
    }
}
add_action('after_setup_theme', 'wp_533625_quomak_register_nav_menus', 0);
