<?php
namespace App\Models;

use Plugin\Core\Log;


class Model {

    private $where;

    private $limit;

    private $offset;

    private $select = '*';

    private $orderByColumn = '';

    private $orderByDirection = '';


    public function __construct(){

        

    }

    private function logger(){
        return  new Log('db.model');
    }

    public function table(){

        return $this->table;
    }


    public function reset()
    {

        $this->where = null;

        $this->limit = null;

        $this->offset = null;

        $this->select = '*';

        $this->orderByColumn = null;

        $this->orderByDirection = null;

        return $this;
    }

    public function count()
    {

        $sql = "SELECT count(*) FROM $this->table WHERE deleted_at IS NULL";

        if (!current_user_can('administrator')) {

            $user_id = get_current_user_id();

            $sql .= " AND created_by = $user_id";
        }

        if ($this->where) {

            $sql .= " AND " . $this->where . " ";
        }

        if ($this->orderByColumn) {

            $sql .= " ORDER BY $this->orderByColumn $this->orderByDirection ";
        }

        if ($this->limit) {

            $sql .= " LIMIT $this->limit ";
        }

        if ($this->offset) {

            $sql .= " OFFSET $this->offset ";
        }

        return $this->wpdb->get_var($sql);
    }

    public function sql()
    {

        $sql = "SELECT $this->select FROM $this->table WHERE deleted_at IS NULL";

        if (!current_user_can('administrator')) {

            $user_id = get_current_user_id();

            $sql .= " AND created_by = $user_id";
        }

        if ($this->where) {

            $sql .= " AND " . $this->where . " ";
        }

        if ($this->orderByColumn) {

            $sql .= " ORDER BY $this->orderByColumn $this->orderByDirection ";
        }

        if ($this->limit) {

            $sql .= " LIMIT $this->limit ";
        }

        if ($this->offset) {

            $sql .= " OFFSET $this->offset ";
        }

        return $sql;
    }

    public function where($condition = null)
    {

        $this->where = $condition;

        return $this;
    }

    public function orderBy($column = null, $direction = null)
    {

        $this->orderByColumn = $column;

        $this->orderByDirection = !empty($direction) ? strtoupper($direction) : 'ASC';

        return $this;
    }

    public function select($columns = '*')
    {

        $this->select = $columns;

        return $this;
    }

    public function limit($limit = null)
    {

        $this->limit = $limit;

        return $this;
    }

    public function offset($offset = null)
    {

        $this->offset = $offset;

        return $this;
    }

    public function first()
    {

        return $this->wpdb->get_row($this->sql());
    }

    public function get()
    {

        return $this->wpdb->get_results($this->sql());
    }

    public function sum($column){

        $sql = "SELECT SUM($column) FROM $this->table WHERE deleted_at IS NULL";

        if (!current_user_can('administrator')) {

            $user_id = get_current_user_id();

            $sql .= " AND created_by = $user_id";
        }

        if ($this->where) {

            $sql .= " AND " . $this->where . " ";
        }

        return $this->wpdb->get_var($sql);
    }

    public function prepare($args){
        $args = (array) $args;
        $fillable = (array) json_decode(json_encode($this->fillable));
        foreach($fillable as $key => &$value){
            if(!empty($args[$key])){
                $fillable[$key] = $args[$key];
            }
        }
        return $fillable;
    }


    public function create($args){
        $args = $this->prepare($args);
        $args['uuid'] = wp_generate_uuid4();
        $args['created_by'] = get_current_user_id();
        $args['created_at'] = current_time('mysql');
        $insert_id = $this->wpdb->insert($this->table, $args);
        return $this->wpdb->insert_id;
    }

    public function can_update($where){

        // $this->logger()->info("hllo world");

        $row = $this->reset()->where($where)->first();

        if(empty($row)){

            return false;
        }

        
        if(current_user_can('administrator')){

            return false;
        }

        return $row->created_by == get_current_user_id();
    }

    public function update($args, $where){
        $args = $this->prepare($args);
        $args['updated_by'] = get_current_user_id();
        $args['updated_at'] = current_time('mysql');
        $this->wpdb->update($this->table, $args, $where);
        return true;
    }

    public function can_delete($where){

        // $this->logger()->info("hllo world");

        $row = $this->reset()->where($where)->first();

        if(empty($row)){

            return false;
        }

        
        if(current_user_can('administrator')){

            return true;
        }

        return $row->created_by == get_current_user_id();
    }

    public function delete($where){
        $args = [];
        $args['deleted_by'] = get_current_user_id();
        $args['deleted_at'] = current_time('mysql');
        $this->wpdb->update($this->table, $args, $where);
        return true;
    }

    public function trash($where){
        $this->wpdb->delete($this->table, $where);
        return true;
    }
    public function datatable_paginate($args)
    {

        $offset = $args['start'];

        $limit = $args['length'];

        $search = trim($args['search']['value']);

        $column = null;

        $dir = null;

        $where = null;

        if (!empty($args['order'])) {

            $column = $args['columns'][$args['order'][0]['column']]['data'];

            $dir = $args['order'][0]['dir'];
        }

        if ($search) {

           

            $where = '(' . implode(' LIKE "%' . $search . '%" OR ', $this->search_columns) . ' LIKE "%' . $search . '%")';

        }

        return [
            'total' => intval($this->reset()->count()),
            'filtered' => intval($this->reset()->where($where)->count()),
            'results' => $this->reset()->where($where)->orderBy($column, $dir)->limit($limit)->offset($offset)->get(),

        ];
    }

}