<?php

use Plugin\Validator\Validate;
use App\Models\ProjectCategory;


if (!function_exists('wp_345566_quomak_projects_categories_category')) {

    function wp_345566_quomak_projects_categories_category()
    {
        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $rules = [
            'uuid' => 'nullable|exists:quomak_project_categories,uuid'
        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $category = new ProjectCategory;

        $uuid = !empty($_POST['uuid'])?$_POST['uuid']:NULL;

        if(empty($uuid)){

            $category->create($_POST);

        }else{

            if(!$category->can_update("uuid = '$uuid'")){

                wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

            }

             $category->update($_POST, ['uuid' => $uuid]);
        }


    
        wp_send_json_success(['reload' => true]);

    }

}

add_action('wp_ajax_projects/categories/category', 'wp_345566_quomak_projects_categories_category');
