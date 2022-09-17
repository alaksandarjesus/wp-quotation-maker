<?php

namespace Plugin\DB;

use Plugin\Core\Log;

class InvoiceItems
{
    private $tablename = 'quomak_invoice_items';

    public function __construct()
    {
        $this->log = new Log('db.invoice-items');
        $this->create_table();
        $this->alter_table();
    }

    public function create_table()
    {
        $this->log->info('Creating new invoice items if table not exists');
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        global $wpdb;
        $create_table_query = "
                CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}{$this->tablename}` (
                  `id` bigint(20) NOT NULL AUTO_INCREMENT primary key,
                  `uuid` VARCHAR(36) NOT NULL,
                  `invoice_id` INTEGER(10) NULL,
                  `product_id` INTEGER(10) NULL,
                  `qty` FLOAT(10,2) NULL,
                  `price` FLOAT(10,2) NULL,
                  `tax` FLOAT(10,2) NULL,
                  `total` FLOAT(10,2) NULL,
                  `created_by` INTEGER(10) NOT NULL,
                  `created_at` DATETIME NOT NULL,
                  `updated_by` INTEGER(10) NULL,
                  `updated_at` DATETIME NULL,
                  `deleted_by` INTEGER(10) NULL,
                  `deleted_at` DATETIME NULL
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
        ";
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($create_table_query);
        $this->log->error(!empty($wpdb->last_error) ? $wpdb->last_error : '');

    }

    public function alter_table()
    {
        return;

        $this->log->info('Altering table quotations table');

        global $wpdb;

        $tablename = $wpdb->prefix . $this->tablename;

        $column_name = 'profile_count';

        $row = $wpdb->get_results("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
            WHERE table_name = `{$tablename}` AND column_name = `{$column_name}`");

        if (empty($row)) {
            $wpdb->query("ALTER TABLE `{$tablename}` ADD `{$column_name}` INT(1) NOT NULL DEFAULT 1");
        }

        $this->log->error(!empty($wpdb->last_error) ? $wpdb->last_error : '');

    }
}
