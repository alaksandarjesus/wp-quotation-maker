<?php

use Plugin\Validator\Validate;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Customer;


if (!function_exists('wp_737694_quomak_projects_project')) {

    function wp_737694_quomak_projects_project()
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
            'project_category_uuid' => 'required|exists:quomak_project_categories,uuid',
            'project_customer_uuid' => 'required|exists:quomak_customers,uuid',
            'uuid' => 'nullable|exists:quomak_projects,uuid', 
            'name' => 'required|min:3|max:200',
            'notes' => 'nullable|max:200'
        ];

        $messages = [

        ];

        $errors = $validator->validate($_POST, $rules, $messages);

        if (!empty($errors)) {

            wp_send_json_error(['errors' => $errors]);
        }

        $project_category = new ProjectCategory;
        $project_category_uuid = $_POST['project_category_uuid'];
        $project_category_row = $project_category->reset()->where("uuid = '$project_category_uuid'")->first();
        $_POST['category_id'] = $project_category_row->id;

        $customer = new Customer;
        $customer_uuid = $_POST['project_customer_uuid'];
        $customer_row = $customer->reset()->where("uuid = '$customer_uuid'")->first();
        $_POST['customer_id'] = $customer_row->id;


        $project = new Project;

        $uuid = !empty($_POST['uuid'])?$_POST['uuid']:NULL;

        if(empty($uuid)){

            $project->create($_POST);

        }else{

            if(!$project->can_update("uuid = '$uuid'")){

                wp_send_json_error(['errors' => ['You are not authorized to perform this action']]);

            }

             $project->update($_POST, ['uuid' => $uuid]);
        }


    
        wp_send_json_success(['redirect' => site_url() . '/projects']);

    }

}

add_action('wp_ajax_projects/project', 'wp_737694_quomak_projects_project');
