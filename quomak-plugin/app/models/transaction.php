<?php

namespace App\Models;

use App\Models\Model;


class Transaction extends Model{

    private $tablename = 'quomak_transactions';

    public $wpdb;

    public $search_columns =  ['id'];

    public $fillable = [
        'invoice_item_id' => "",
        'amount' => "",
        'notes' => ""
    ];

    public function __construct(){

        global $wpdb;

        $this->table = $wpdb->prefix.$this->tablename;

        $this->wpdb = $wpdb;
       
    }

}