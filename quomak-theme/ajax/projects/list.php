<?php

use Plugin\Validator\Validate;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Customer;


if (!function_exists('wp_100377_quomak_projects_list')) {

    function wp_100377_quomak_projects_list()
    {

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

             wp_send_json_error(['errors' => $errors, $_GET]);
        }

        $rules = [

        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $project = new Project;

        $paginated = $project->datatable_paginate($_POST);

        $paginated['results'] = array_map(function($item){
            $project_category = new ProjectCategory;
            $customer = new Customer;
            $item->category = $project_category->reset()->where("id = $item->category_id")->first();
            $item->customer = $customer->reset()->where("id = $item->customer_id")->first();
            return $item;
        }, $paginated['results']);


        wp_send_json_success($paginated);

    }

}

add_action('wp_ajax_projects/list', 'wp_100377_quomak_projects_list');
