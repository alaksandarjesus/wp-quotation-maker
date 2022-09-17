<?php

namespace App\Models;

use App\Models\Model;


class Invoice extends Model{

    private $tablename = 'quomak_invoices';

    public $wpdb;

    public $search_columns =  ["quotation_number" ];

    public $fillable = [
       "quotation_number" => "",
       "quotation_date" => "",
       "project_id" => "",
       "subtotal" => "",
       "taxtotal" => "",
       "discount" => "",
       "total" => "",
       "notes"=> ""
    ];

    public function __construct(){

        global $wpdb;

        $this->table = $wpdb->prefix.$this->tablename;

        $this->wpdb = $wpdb;
       
    }

}