<!--sidebar start-->
<?php 
    session_start(); 
    $id = $_SESSION['admin']['id_member'];
    $role_id = $_SESSION['admin']['role_id']; // Pastikan role_id disimpan di sesi saat login
    $hasil_profil = $lihat->member_edit($id);
?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa fa-users"></i>
        </div>
        <div class="sidebar-brand-text mx-3">RameninAjah<sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <?php if ($role_id == 1) { // admin ?>
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Waiter -->
    <?php if ($role_id == 1 || $role_id == 2) { // admin, waiter ?>
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fa fa-tablet"></i>
            <span>Waiter</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="index.php?page=order">Order</a>
                <a class="collapse-item" href="index.php?page=meja">Cek Meja</a>
                <a class="collapse-item" href="index.php?page=reservasi">Cek Reservasi</a>
                <a class="collapse-item" href="index.php?page=pesanan2">Cek Pesanan</a>
            </div>
        </div>
    </li>
    <?php } ?>

    <!-- Nav Item - Cashier -->
    <?php if ($role_id == 1 || $role_id == 3) { // admin, cashier ?>
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse3" aria-expanded="true"
            aria-controls="collapse3">
            <i class="fas fa-fw fa-desktop"></i>
            <span>Cashier</span>
        </a>
        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="index.php?page=jual">Transaksi Jual</a>
                <a class="collapse-item" href="index.php?page=laporan">Laporan Penjualan</a>
                <a class="collapse-item" href="index.php?page=selesai">Pesanan Selesai</a>
            </div>
        </div>
    </li>
    <?php } ?>

    <!-- Nav Item - Chef -->
    <?php if ($role_id == 1 || $role_id == 4) { // admin, chef ?>
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse4" aria-expanded="true"
            aria-controls="collapse4">
            <i class="fa fa-shopping-basket"></i>
            <span>Chef</span>
        </a>
        <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="index.php?page=barang">Menu</a>
                <a class="collapse-item" href="index.php?page=pesanan">Pesanan</a>
                <a class="collapse-item" href="index.php?page=kategori">Kategori</a>
            </div>
        </div>
    </li>
    <?php } ?>

    <!-- Nav Item - Feedback Pelanggan -->
    <?php if (in_array($role_id, [1, 2, 3, 4])) { // admin, cashier, chef, waiter ?>
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" href="index.php?page=feedback">
            <i class="fa fa-comments"></i>
            <span>Feedback Pelanggan</span></a>
    </li>
    <?php } ?>

    <!-- Nav Item - Admin Only -->
    <?php if ($role_id == 1) { // admin ?>
    <li class="nav-item active">
        <a class="nav-link" href="index.php?page=pengaturan">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Pengaturan Toko</span></a>
    </li>
    <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <h5 class="d-lg-block d-none mt-2"><b><?php echo $toko['nama_toko'];?>, <?php echo $toko['alamat_toko'];?></b></h5>
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img class="img-profile rounded-circle"
                            src="assets/img/user/<?php echo $hasil_profil['gambar'];?>">
                        <span
                            class="mr-2 d-none d-lg-inline text-gray-600 small ml-2"><?php echo $hasil_profil['nm_member'];?></span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="index.php?page=user">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
