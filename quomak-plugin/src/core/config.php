<?php

namespace Plugin\Core;

use Plugin\DB\Customers;
use Plugin\DB\ProductCategories;
use Plugin\DB\ProductRelated;
use Plugin\DB\Products;
use Plugin\DB\ProductUnits;
use Plugin\DB\ProductVendors;
use Plugin\DB\Vendors;
use Plugin\DB\Projects;
use Plugin\DB\ProjectCategories;
use Plugin\DB\QuotationItems;
use Plugin\DB\Quotations;
use Plugin\DB\InvoiceItems;
use Plugin\DB\Invoices;
use Plugin\DB\Transactions;
use Plugin\Pages\Pages;



class Config
{

    public function __construct()
    {

    }

    public function activate()
    {

        if (get_option('quomak_plugin') == QUOMAK_PLUGIN_VERSION) {

            return;

        }

        new Pages;
        new Customers;
        new Vendors;
        new ProductCategories;
        new ProductUnits;
        new Products;
        new ProductRelated;
        new ProductVendors;
        new Projects;
        new ProjectCategories;
        new Quotations;
        new QuotationItems;
        new Invoices;
        new InvoiceItems;
        new Transactions;
        return;

    }

    public function init()
    {

    }

}
