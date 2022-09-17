<?php

namespace App\Models;

use App\Models\Model;


class Customer extends Model{

    private $tablename = 'quomak_customers';

    public $wpdb;

    public $search_columns =  ['business_name', 'first_name', 'email', 'last_name', 'mobile'];

    public $fillable = [
        "address_line_1" => "",
        "address_line_2" => "",
        "business_name" => "",
        "city" => "",
        "country" => "",
        "email" => "",
        "first_name" => "",
        "gstin" => "",
        "last_name" => "",
        "mobile" => "",
        "notes" => "",
        "pincode" => "",
        "state" => ""];

    public function __construct(){

        global $wpdb;

        $this->table = $wpdb->prefix.$this->tablename;

        $this->wpdb = $wpdb;
       
    }

}