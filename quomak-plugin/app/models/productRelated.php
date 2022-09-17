<?php

namespace App\Models;

use App\Models\Model;


class ProductRelated extends Model{

    private $tablename = 'quomak_product_related';

    public $wpdb;

    public $search_columns =  [];

    public $fillable = [
        "related_product_id" => "",
        "product_id" => "",
       ];

    public function __construct(){

        global $wpdb;

        $this->table = $wpdb->prefix.$this->tablename;

        $this->wpdb = $wpdb;
       
    }

}