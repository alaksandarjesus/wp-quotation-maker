<?php

namespace App\Models;

use App\Models\Model;


class ProductUnit extends Model{

    private $tablename = 'quomak_product_units';

    public $wpdb;

    public $search_columns =  ['name', 'notes'];

    public $fillable = [
        "name" => "",
        "notes" => "",
       ];

    public function __construct(){

        global $wpdb;

        $this->table = $wpdb->prefix.$this->tablename;

        $this->wpdb = $wpdb;
       
    }

}