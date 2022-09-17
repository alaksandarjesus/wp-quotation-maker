<?php

namespace App\Models;

use App\Models\Model;


class Project extends Model{

    private $tablename = 'quomak_projects';

    public $wpdb;

    public $search_columns =  ['name'];

    public $fillable = [
       "name" => "",
       "category_id" => "",
       "customer_id" => "",
       "notes"=> ""
    ];

    public function __construct(){

        global $wpdb;

        $this->table = $wpdb->prefix.$this->tablename;

        $this->wpdb = $wpdb;
       
    }

}