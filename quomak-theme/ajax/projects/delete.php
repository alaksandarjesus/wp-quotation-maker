<?php

use Plugin\Validator\Validate;
use App\Models\Project;


if(!function_exists('wp_638124_quomak_projects_delete')){

    function wp_638124_quomak_projects_delete(){

        $validator = new Validate();

        $rules = [
            'action' => 'required',
            'nonce' => 'required|nonce',
            'uuid' => 'required|exists:quomak_projects,uuid'
        ];

        $errors = $validator->validate($_GET, $rules);

        if (!empty($errors)) {

             wp_send_json_error(['errors' => $errors]);
        }

        $project = new Project;

        $uuid = $_GET['uuid'];

        if(!$project->can_delete("uuid = '$uuid'")){

            wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

        }

        $project->delete(['uuid' => $uuid]);

        return wp_send_json_success([]);

    }
}

add_action('wp_ajax_projects/delete', 'wp_638124_quomak_projects_delete');