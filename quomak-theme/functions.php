<?php

define('TEMPLATE_DIR_URI', get_template_directory_uri( ));

define('TEMPLATE_DIR', get_template_directory( __FILE__ ));

foreach ( glob( TEMPLATE_DIR . "/includes/*.php" ) as $file ) {
    include_once $file;
}
