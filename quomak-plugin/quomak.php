<?php

/*
Plugin Name: QuoMak

*/

define('QUOMAK_PLUGIN_DIR', __DIR__.'/.');

define('QUOMAK_PLUGIN_VERSION', '0.0.0');

define( 'WP_ENVIRONMENT_TYPE', 'development' );




require_once (QUOMAK_PLUGIN_DIR.'/vendor/autoload.php');

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();

use Plugin\Core\Config;

function wp_quomak_plugin_on_init(){

    $config = new Config();

    $config->init();

}

function wp_quomak_plugin_on_activate(){

    $config = new Config();

    $config->activate();

}


add_action('init', 'wp_quomak_plugin_on_init');

register_activation_hook( __FILE__, 'wp_quomak_plugin_on_activate' );