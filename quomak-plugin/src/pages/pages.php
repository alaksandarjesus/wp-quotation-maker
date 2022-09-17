<?php

namespace Plugin\Pages;

use Plugin\Core\Log;

class Pages
{
    private $tablename = 'quomak_countries';

    public function __construct()
    {
        $this->log = new Log('pages.create');
        $this->create_page();
    }


    public function create_page(){
        $pages = [
    
            [
                'title' => 'Home',
                'content' => '<!-- wp:shortcode -->
                [quomak-page page=guest]
                <!-- /wp:shortcode -->',
            ],
            [
                'title' => 'Dashboard',
                'content' => '<!-- wp:shortcode -->
                [quomak-page page=dashboard]
                <!-- /wp:shortcode -->',
            ],
            [
                'title' => 'Customers',
                'content' => '<!-- wp:shortcode -->
                [quomak-page page=customers]
                <!-- /wp:shortcode -->',
            ],
            [
                'title' => 'Vendors',
                'content' => '<!-- wp:shortcode -->
                [quomak-page page=vendors]
                <!-- /wp:shortcode -->',
            ],
            [
                'title' => 'Products',
                'content' => '<!-- wp:shortcode -->
                [quomak-page page=products]
                <!-- /wp:shortcode -->',
            ],
            [
                'title' => 'Projects',
                'content' => '<!-- wp:shortcode -->
                [quomak-page page=projects]
                <!-- /wp:shortcode -->',
            ],[
                'title' => 'Quotations',
                'content' => '<!-- wp:shortcode -->
                [quomak-page page=quotations]
                <!-- /wp:shortcode -->',
            ],[
                'title' => 'Invoices',
                'content' => '<!-- wp:shortcode -->
                [quomak-page page=invoices]
                <!-- /wp:shortcode -->',
            ],
        ];
        foreach ($pages as $page) {
        if (post_exists($page['title']) !== 0) {
            $existing_page = get_page_by_title($page['title']);
            $page_id = $existing_page->ID;
            $status = 'publish';
            $content = $page['content'];
            $post = array('ID' => $page_id,'post_content' => $content, 'post_status' => $status);
            wp_update_post($post);
            continue;
        }
        // Create post object
        $my_post = array(
            'post_type' => 'page',
            'post_title' => $page['title'],
            'post_content' => $page['content'],
            'post_status' => 'publish',
            'post_author' => 1,
        );
    
        // Insert the post into the database
        wp_insert_post($my_post);
    }
    }
}
