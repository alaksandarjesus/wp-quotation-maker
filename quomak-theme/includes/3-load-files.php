<?php

foreach ( glob( TEMPLATE_DIR . "/functions/*.php" ) as $file ) {
    include_once $file;
}

foreach ( glob( TEMPLATE_DIR . "/filters/*.php" ) as $file ) {
    include_once $file;
}

foreach ( glob( TEMPLATE_DIR . "/actions/*.php" ) as $file ) {
    include_once $file;
}

foreach ( glob( TEMPLATE_DIR . "/shortcodes/*.php" ) as $file ) {
    include_once $file;
}

foreach ( glob( TEMPLATE_DIR . "/widgets/*.php" ) as $file ) {
    include_once $file;
}

if(wp_doing_ajax()){
    foreach ( glob( TEMPLATE_DIR . "/ajax/**/*.php" ) as $file ) {
        include_once $file;
    }
}

// add_action( 'widgets_init', 'quomak_register_sidebars' );
// if(!function_exists('quomak_register_sidebars')){

//     function quomak_register_sidebars() {
//         /* Register the 'primary' sidebar. */
//         register_sidebar(
//             array(
//                 'id'            => 'primary',
//                 'name'          => __( 'Primary Sidebar' ),
//                 'description'   => __( 'A short description of the sidebar.' ),
//                 'before_widget' => '<div id="%1$s" class="widget %2$s">',
//                 'after_widget'  => '</div>',
//                 'before_title'  => '<h3 class="widget-title">',
//                 'after_title'   => '</h3>',
//             )
//         );
//         /* Repeat register_sidebar() code for additional sidebars. */
//     }
// }
