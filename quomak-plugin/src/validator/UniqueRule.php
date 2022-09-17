<?php

namespace Plugin\Validator;

use Rakit\Validation\Rule;


class UniqueRule extends Rule{


    protected $message = "The :attribute is already taken";

    protected $fillableParams = ['table', 'column'];

    public function check($value): bool
    {
        $this->requireParameters(['table', 'column']);

        $table = $this->parameter('table');

        $column = $this->parameter('column');

        global $wpdb;

        $wptable = $wpdb->prefix.$table;

        $count = $wpdb->get_var("SELECT COUNT(*) FROM $wptable WHERE $column = '$value'");

        return !!!$count;

    }

}
