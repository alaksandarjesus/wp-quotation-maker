<?php

namespace App\Models;

use App\Models\Model;


class ProductVendor extends Model{

    private $tablename = 'quomak_product_vendors';

    public $wpdb;

    public $search_columns =  [];

    public $fillable = [
        "product_id" => "",
        "vendor_id" => "",
        "price" => "",
       ];

    public function __construct(){

        global $wpdb;

        $this->table = $wpdb->prefix.$this->tablename;

        $this->wpdb = $wpdb;
       
    }

}