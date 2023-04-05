<?php 
require_once 'koneksi.php';

if (!isset($_SESSION['id_user'])) 
{
    setAlert("Akses ditolak!", "Login terlebih dahulu!", "error");
    header("Location: ".BASE_URL."login.php");
    exit;
} 


$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

$omset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT sum(total_harga) as omset FROM transaksi"));
$laba = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM((b.harga_jual - b.harga_beli) * dt.kuantitas) AS laba FROM detail_transaksi dt INNER JOIN barang b ON dt.id_barang = b.id_barang"));

$jumlah_transaksi = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM transaksi"));

$barang_paling_laku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT barang.id_barang, barang.nama_barang, SUM(kuantitas) as laku FROM detail_transaksi INNER JOIN barang ON detail_transaksi.id_barang = barang.id_barang GROUP BY detail_transaksi.id_barang ORDER BY laku DESC LIMIT 1"));

$transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user ORDER BY tanggal_transaksi DESC");


if (isset($_GET['btnFilter'])) {
    $dari_tanggal = htmlspecialchars($_GET['dari_tanggal']);
    $sampai_tanggal = htmlspecialchars($_GET['sampai_tanggal']);

    $dari_tanggal_baru =  $dari_tanggal . ' 00:00:00';
    $sampai_tanggal_baru =  $sampai_tanggal . ' 23:59:59';

    $omset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT sum(total_harga) as omset FROM transaksi WHERE tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
    $laba = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM((b.harga_jual - b.harga_beli) * dt.kuantitas) AS laba FROM detail_transaksi dt INNER JOIN barang b ON dt.id_barang = b.id_barang INNER JOIN transaksi t ON dt.id_transaksi = t.id_transaksi WHERE tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));

    $jumlah_transaksi = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM transaksi WHERE tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));

    $transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user WHERE tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' ORDER BY tanggal_transaksi DESC");

    $barang_paling_laku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT barang.id_barang, barang.nama_barang, SUM(kuantitas) as laku FROM detail_transaksi dt INNER JOIN barang ON dt.id_barang = barang.id_barang INNER JOIN transaksi t ON dt.id_transaksi = t.id_transaksi WHERE tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' GROUP BY dt.id_barang ORDER BY laku DESC LIMIT 1"));

}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard - Yuda Cell</title>
    <?php include_once 'include/head.php'; ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include_once 'include/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include_once 'include/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid bg-white rounded p-3">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->

                    <form method="get">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="dari_tanggal">Dari Tanggal</label>
                                    <input class="form-control" type="date" name="dari_tanggal" value="<?= isset($_GET['btnFilter']) ? $dari_tanggal : date('Y-m-01'); ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="sampai_tanggal">Sampai Tanggal</label>
                                    <input class="form-control" type="date" name="sampai_tanggal" value="<?= isset($_GET['btnFilter']) ? $sampai_tanggal : date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="btnFilter" class="btn btn-primary"><i class="fas fa-fw fa-filter"></i> Filter</button>
                            <a href="<?= BASE_URL; ?>index.php" class="btn btn-primary"><i class="fas fa-fw fa-redo"></i> Reset</a>
                        </div>
                    </form>    
                    <hr>
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Omset <?= isset($_GET['btnFilter']) ? "(Filter)" : "(Semua)"; ?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= str_replace(",", ".", number_format($omset['omset'])); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Laba <?= isset($_GET['btnFilter']) ? "(Filter)" : "(Semua)"; ?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= str_replace(",", ".", number_format($laba['laba'])); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Jumlah Transaksi <?= isset($_GET['btnFilter']) ? "(Filter)" : "(Semua)"; ?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_transaksi; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Barang Paling Laku <?= isset($_GET['btnFilter']) ? "(Filter)" : "(Semua)"; ?></div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                <?php if ($barang_paling_laku): ?>
                                                    <?= $barang_paling_laku['nama_barang']; ?> (<?= $barang_paling_laku['laku']; ?>)
                                                <?php else: ?>
                                                    Tidak Ada
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <div class="row my-3">
                                <div class="col head-left">
                                    <h5 class="my-auto font-weight-bold text-primary">Transaksi Terbaru</h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>transaksi/tambah_transaksi.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah Transaksi</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Id Transaksi</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Total Harga</th>
                                            <th>Bayar</th>
                                            <th>Kembalian</th>
                                            <th>User</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($transaksi as $dt): ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $dt['id_transaksi']; ?></td>
                                                <td><?= $dt['tanggal_transaksi']; ?></td>
                                                <td>Rp. <?= str_replace(",", ".", number_format($dt['total_harga'])); ?></td>
                                                <td>Rp. <?= str_replace(",", ".", number_format($dt['bayar'])); ?></td>
                                                <td>Rp. <?= str_replace(",", ".", number_format($dt['kembalian'])); ?></td>
                                                <td><?= $dt['username']; ?></td>
                                                <td>
                                                    <?php if ($dt['bayar'] == 0): ?>
                                                        <a class="btn btn-sm btn-info m-1" href="<?= BASE_URL; ?>transaksi/detail_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>"><i class="fas fa-fw fa-exclamation"></i> Bayar</a>
                                                    <?php else: ?>
                                                        <a class="btn btn-sm btn-info m-1" href="<?= BASE_URL; ?>transaksi/detail_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>"><i class="fas fa-fw fa-info"></i> Detail</a>
                                                    <?php endif ?>
                                                    <a class="btn btn-sm btn-success m-1" href="<?= BASE_URL; ?>transaksi/ubah_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
                                                    <a class="btn btn-sm btn-danger m-1 btn-delete" data-nama="Transaksi dengan ID Transaksi <?= $dt['id_transaksi']; ?> akan terhapus!" href="hapus_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once 'include/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <?php include_once 'include/script.php' ?>

    <!-- Page level custom scripts -->
</body>

</html>