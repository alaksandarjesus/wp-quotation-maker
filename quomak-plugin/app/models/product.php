<?php

namespace App\Models;

use App\Models\Model;


class Product extends Model{

    private $tablename = 'quomak_products';

    public $wpdb;

    public $search_columns =  ['name', 'code'];

    public $fillable = [
       "name" => "",
       "code" => "",
       "category_id" => "",
       "unit_id" => "",
       "notes"=> ""
    ];

    public function __construct(){

        global $wpdb;

        $this->table = $wpdb->prefix.$this->tablename;

        $this->wpdb = $wpdb;
       
    }

}