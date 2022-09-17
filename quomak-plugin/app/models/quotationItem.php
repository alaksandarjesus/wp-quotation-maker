<?php

namespace App\Models;

use App\Models\Model;


class QuotationItem extends Model{

    private $tablename = 'quomak_quotation_items';

    public $wpdb;

    public $search_columns =  [];

    public $fillable = [
       "quotation_id" => "",
       "product_id" => "",
       "qty" => "",
       "price" => "",
       "tax" => "",
       "total" => "",
    ];

    public function __construct(){

        global $wpdb;

        $this->table = $wpdb->prefix.$this->tablename;

        $this->wpdb = $wpdb;
       
    }

}