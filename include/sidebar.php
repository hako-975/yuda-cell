<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= BASE_URL; ?>index.php">
        <img src="<?= BASE_URL; ?>img/logo.png" class="img-fluid" width="50" alt="Logo">
    </a>
    <a href="<?= BASE_URL; ?>index.php" class="text-decoration-none mx-auto text-white"><h5>Yuda Cell</h5></a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= BASE_URL; ?>index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider my-0">
    
    <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL; ?>transaksi/index.php">
            <i class="fas fa-fw fa-box"></i>
            <span>Transaksi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Kelola Produk
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    
    <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL; ?>pemasukan_produk/index.php">
            <i class="fas fa-fw fa-box"></i>
            <span>Pemasukan Produk</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL; ?>produk/index.php">
            <i class="fas fa-fw fa-box"></i>
            <span>Produk</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL; ?>jenis_saldo/index.php">
            <i class="fas fa-fw fa-box"></i>
            <span>Jenis Saldo</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Administrator</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= BASE_URL; ?>jenis_produk/index.php">Jenis Produk</a>
                <a class="collapse-item" href="<?= BASE_URL; ?>supplier/index.php">Supplier</a>
                <a class="collapse-item" href="<?= BASE_URL; ?>user/index.php">User</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL; ?>laporan/index.php">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>