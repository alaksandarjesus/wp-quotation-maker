<?php

use Plugin\Validator\Validate;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Quotation;


if (!function_exists('wp_401694_quomak_quotations_list')) {

    function wp_401694_quomak_quotations_list()
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

        $quotation = new Quotation;

        $paginated = $quotation->datatable_paginate($_POST);

        $paginated['results'] = array_map(function($item){
            $project = new Project;
            $customer = new Customer;

            $item->project = $project->reset()->where("id = $item->project_id")->first();
            $project_row = $item->project;
            $item->customer = $customer->reset()->where("id = $project_row->customer_id")->first();
            return $item;
        }, $paginated['results']);


        wp_send_json_success($paginated);

    }

}

add_action('wp_ajax_quotations/list', 'wp_401694_quomak_quotations_list');
