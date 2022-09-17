<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo site_url(); ?>"><?php echo get_bloginfo(); ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (is_user_logged_in()) {?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                        href="<?php echo site_url() . '/dashboard'; ?>">Dashboard</a>
                </li>
                <?php } else {?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo site_url(); ?>">Home</a>
                </li>

                <?php }?>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url() . '/customers'; ?>">Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url() . '/vendors'; ?>">Vendors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url() . '/products'; ?>">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url() . '/projects'; ?>">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url() . '/quotations'; ?>">Quotations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url() . '/invoices'; ?>">Invoices</a>
                </li>
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link logout" href="javascript:void(0)">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>