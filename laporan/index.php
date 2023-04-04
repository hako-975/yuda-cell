<?php 
require_once '../koneksi.php';
if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$id_user = $_SESSION['id_user'];

if (isset($_GET['btnLaporan'])) {
    $dari_tanggal = htmlspecialchars($_GET['dari_tanggal']);
    $sampai_tanggal = htmlspecialchars($_GET['sampai_tanggal']);

    $dari_tanggal_baru =  $dari_tanggal . ' 00:00:00';
    $sampai_tanggal_baru =  $sampai_tanggal . ' 23:59:59';

    $transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user WHERE tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' ORDER BY tanggal_transaksi ASC");

	$omset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT sum(total_harga) as omset FROM transaksi WHERE tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
	$laba = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM((b.harga_jual - b.harga_beli) * dt.kuantitas) AS laba FROM detail_transaksi dt INNER JOIN barang b ON dt.id_barang = b.id_barang INNER JOIN transaksi t ON dt.id_transaksi = t.id_transaksi WHERE t.tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
	$barang_paling_laku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT barang.id_barang, barang.nama_barang, SUM(kuantitas) as laku FROM detail_transaksi dt INNER JOIN barang ON dt.id_barang = barang.id_barang INNER JOIN transaksi t ON dt.id_transaksi = t.id_transaksi WHERE t.tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' GROUP BY dt.id_barang ORDER BY laku DESC LIMIT 1"));
}

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
 ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Yuda Cell</title>
    <?php include_once '../include/head.php'; ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include_once '../include/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include_once '../include/topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                	<!-- Page Heading -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col head-left">
                                    <h5 class="my-auto font-weight-bold text-primary">Laporan</h5>
                                </div>
                                <div class="col head-right">
                                    <button type="button" onclick="return window.history.back()" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<form method="get">
				                <div class="row">
				                	<div class="col">
				                		<div class="form-group">
						                    <label for="dari_tanggal">Dari Tanggal</label>
						                    <input class="form-control" type="date" name="dari_tanggal" value="<?= isset($_GET['btnLaporan']) ? $dari_tanggal : date('Y-m-01'); ?>">
						                </div>
				                	</div>
				                	<div class="col">
				                		<div class="form-group">
						                    <label for="sampai_tanggal">Sampai Tanggal</label>
						                    <input class="form-control" type="date" name="sampai_tanggal" value="<?= isset($_GET['btnLaporan']) ? $sampai_tanggal : date('Y-m-d'); ?>">
						                </div>
				                	</div>
				                </div>
				                <div class="form-group">
				                    <button type="submit" name="btnLaporan" class="btn btn-primary"><i class="fas fa-fw fa-filter"></i> Filter</button>
				                </div>
				            </form>
						    <?php if (isset($_GET['btnLaporan'])): ?>
						    	<h4 style="text-align: center;">Laporan Yuda Cell - Dari Tanggal <?= $dari_tanggal; ?> Sampai Tanggal <?= $sampai_tanggal; ?></h4>
							    <h5>Omset: Rp. <?= str_replace(",", ".", number_format($omset['omset'])); ?></h5>
							    <h5>Laba: Rp. <?= str_replace(",", ".", number_format($laba['laba'])); ?></h5>
							    <?php if ($barang_paling_laku): ?>
							        <h5>Barang Terlaku: <?= ucwords($barang_paling_laku['nama_barang']); ?> (<?= $barang_paling_laku['laku']; ?>)</h5>
							    <?php endif ?>
        						<a target="_blank" href="<?= BASE_URL; ?>laporan/print_laporan.php?dari_tanggal=<?= $dari_tanggal; ?>&sampai_tanggal=<?= $sampai_tanggal; ?>" class="btn btn-success my-3"><i class="fas fa-fw fa-print"></i> Print</a>
						    	<div class="table-responsive">
						    		<table class="table table-bordered">
						                <thead>
						                    <tr>
						                        <th>No.</th>
						                        <th>Tanggal Transaksi</th>
						                        <th>Total Harga</th>
						                        <th>Bayar</th>
						                        <th>Kembalian</th>
						                        <th>Detail Transaksi</th>
						                        <th>User</th>
						                    </tr>
						                </thead>
						                <tbody>
						                    <?php $i = 1; ?>
						                    <?php foreach ($transaksi as $dt): ?>
						                        <?php 
						                            $id_transaksi = $dt['id_transaksi'];
						                            $detail_transaksi = mysqli_query($koneksi, "SELECT * FROM detail_transaksi INNER JOIN barang ON detail_transaksi.id_barang = barang.id_barang WHERE id_transaksi = '$id_transaksi'");
						                         ?>
						                        <tr>
						                            <td><?= $i++; ?></td>
						                            <td><?= $dt['tanggal_transaksi']; ?></td>
						                            <td>Rp. <?= str_replace(",", ".", number_format($dt['total_harga'])); ?></td>
						                            <td>Rp. <?= str_replace(",", ".", number_format($dt['bayar'])); ?></td>
						                            <td>Rp. <?= str_replace(",", ".", number_format($dt['kembalian'])); ?></td>
						                            <td>
						                                <ul>
						                                    <?php foreach ($detail_transaksi as $ddt): ?>
						                                        <li>
						                                            <?= $ddt['nama_barang']; ?> (<?= $ddt['kuantitas']; ?>)
						                                        </li>
						                                    <?php endforeach ?>
						                                </ul>
						                            </td>
						                            <td><?= $dt['username']; ?></td>
						                        </tr>
						                    <?php endforeach ?>
						                </tbody>
						            </table>
						    	</div>
						    <?php endif ?>
               			</div>
                    </div>

				</div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once '../include/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include_once '../include/script.php' ?>

</body>

</html>