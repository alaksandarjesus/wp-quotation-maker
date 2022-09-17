<?php
namespace Plugin\Validator;

use Rakit\Validation\Rule;

class ExistsRule extends Rule{


    protected $message = "The :attribute is does not exist";

    protected $fillableParams = ['table', 'column'];

    public function check($value): bool
    {
        $this->requireParameters(['table', 'column']);

        $table = $this->parameter('table');

        $column = $this->parameter('column');

        global $wpdb;

        $wptable = $wpdb->prefix.$table;

        $count = $wpdb->get_var("SELECT COUNT(*) FROM $wptable WHERE $column = '$value'");

        return !!$count;

    }

}
