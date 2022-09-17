<?php

namespace App\Controllers;

class Customers
{

    private $wpdb;

    private $table;

    private $where;

    private $limit;

    private $offset;

    private $select = '*';

    private $orderByColumn = '';

    private $orderByDirection = '';

    public function __construct()
    {

        global $wpdb;

        $this->table = $wpdb->prefix . 'quomak_customers';

        $this->wpdb = $wpdb;

    }

    private function reset()
    {

        $this->where = null;

        $this->limit = null;

        $this->offset = null;

        $this->select = '*';

        $this->orderByColumn = null;

        $this->orderByDirection = null;

        return $this;
    }

    private function count()
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

    private function sql()
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

            $columns = ['business_name', 'first_name', 'email', 'last_name', 'mobile'];

            $where = '(' . implode(' LIKE "%' . $search . '%" OR ', $columns) . ' LIKE "%' . $search . '%")';

        }

        return [
            'total' => intval($this->reset()->count()),
            'filtered' => intval($this->reset()->where($where)->count()),
            'results' => $this->reset()->where($where)->orderBy($column, $dir)->limit($limit)->offset($offset)->get(),

        ];
    }
}
