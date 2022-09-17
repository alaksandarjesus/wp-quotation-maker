<?php

use Plugin\Validator\Validate;
use App\Models\ProjectCategory;


if(!function_exists('wp_068534_quomak_projects_categories_delete')){

    function wp_068534_quomak_projects_categories_delete(){

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
            'uuid' => 'required|exists:quomak_project_categories,uuid'
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

             wp_send_json_error(['errors' => $errors]);
        }

        $category = new ProjectCategory;

        $uuid = $_GET['uuid'];

        if(!$category->can_delete("uuid = '$uuid'")){

            wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

        }

        $category->delete(['uuid' => $uuid]);

        return wp_send_json_success([]);

    }
}

add_action('wp_ajax_projects/categories/delete', 'wp_068534_quomak_projects_categories_delete');