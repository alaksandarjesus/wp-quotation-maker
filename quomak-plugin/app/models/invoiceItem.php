<?php

namespace App\Models;

use App\Models\Model;


class InvoiceItem extends Model{

    private $tablename = 'quomak_invoice_items';

    public $wpdb;

    public $search_columns =  [];

    public $fillable = [
       "invoice_id" => "",
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