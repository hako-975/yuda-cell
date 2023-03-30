<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
<<<<<<< HEAD
	header("Location: login.php");
	exit;
}


=======
	header("Location: ".BASE_URL."login.php");
	exit;
}

>>>>>>> 7282410724e69b75a027036b2b0f3a084e11b25a
$id_transaksi = htmlspecialchars($_GET['id_transaksi']);


$data_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user WHERE transaksi.id_transaksi = '$id_transaksi'"));

if ($data_transaksi == null) {
<<<<<<< HEAD
	echo "
		<script>
			window.location.href='transaksi.php';
=======
	setAlert("Perhatian!", "Data Transaksi tidak ditemukan!", "error");
	header("Location:" . BASE_URL . "transaksi/index.php");
	echo "
		<script>
			window.history.back();
>>>>>>> 7282410724e69b75a027036b2b0f3a084e11b25a
		</script>
	";
	exit;
}

$detail_transaksi = mysqli_query($koneksi, "SELECT * FROM detail_transaksi INNER JOIN transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi INNER JOIN barang ON detail_transaksi.id_barang = barang.id_barang WHERE detail_transaksi.id_transaksi = '$id_transaksi' ORDER BY barang.nama_barang ASC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<<<<<<< HEAD
<html>
<head>
	<title>Transaksi</title>
</head>
<body>
	<a href="transaksi.php">Kembali</a>
	<h4>Id Transaksi: <?= $data_transaksi['id_transaksi']; ?></h4>
	<h4>Total Harga: Rp. <?= str_replace(",", ".", number_format($data_transaksi['total_harga'])); ?></h4>
	<h4>Bayar: Rp. <?= str_replace(",", ".", number_format($data_transaksi['bayar'])); ?></h4>
	<h4>Kembalian: Rp. <?= str_replace(",", ".", number_format($data_transaksi['kembalian'])); ?></h4>
	<?php if ($data_transaksi['bayar'] == '0'): ?>
		<a href="bayar.php?id_transaksi=<?= $data_transaksi['id_transaksi']; ?>">Bayar</a><br><br>
	<?php endif ?>
	<a href="tambah_detail_transaksi.php?id_transaksi=<?= $data_transaksi['id_transaksi']; ?>">Tambah Transaksi Barang</a>
	<table border="1" cellpadding="10" cellspacing="0">
		<thead>
			<tr>
				<th>No.</th>
				<th>Nama Barang</th>
				<th>Kuantitas</th>
				<th>Subtotal</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			<?php foreach ($detail_transaksi as $ddt): ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= $ddt['nama_barang']; ?></td>
					<td><?= $ddt['kuantitas']; ?></td>
					<td>Rp. <?= str_replace(",", ".", number_format($ddt['subtotal'])); ?></td>
					<td>
						<a href="ubah_detail_transaksi.php?id_detail_transaksi=<?= $ddt['id_detail_transaksi']; ?>&id_transaksi=<?= $id_transaksi; ?>">Ubah</a>
						<a onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi <?= $ddt['nama_barang']; ?>?')" href="hapus_detail_transaksi.php?id_detail_transaksi=<?= $ddt['id_detail_transaksi']; ?>&id_transaksi=<?= $id_transaksi; ?>">Hapus</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
=======

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Detail Transaksi - <?= $data_transaksi['id_transaksi']; ?> - Yuda Cell</title>
    <?php include_once '../include/head.php'; ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include_once '../include/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include_once '../include/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                	<!-- Page Heading -->
                	<div class="row">
                		<div class="col">
                			<h4>Id Transaksi: <?= $data_transaksi['id_transaksi']; ?></h4>
							<h4>Total Harga: Rp. <?= str_replace(",", ".", number_format($data_transaksi['total_harga'])); ?></h4>
							<h4>Bayar: Rp. <?= str_replace(",", ".", number_format($data_transaksi['bayar'])); ?></h4>
							<h4>Kembalian: Rp. <?= str_replace(",", ".", number_format($data_transaksi['kembalian'])); ?></h4>
							<?php if ($data_transaksi['bayar'] == '0'): ?>
								<a class="btn btn-danger" href="bayar.php?id_transaksi=<?= $data_transaksi['id_transaksi']; ?>"><i class="fas fa-fw fa-exclamation"></i> Bayar</a>
							<?php endif ?>
                		</div>
                	</div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col head-left">
                                    <h5 class="my-auto font-weight-bold text-primary">ID Transaksi - <?= $data_transaksi['id_transaksi']; ?></h5>
                                </div>
                                <div class="col head-right">
									<a href="<?= BASE_URL; ?>tambah_detail_transaksi.php?id_transaksi=<?= $data_transaksi['id_transaksi']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah Transaksi Barang</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
	                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>No.</th>
											<th>Nama Barang</th>
											<th>Kuantitas</th>
											<th>Subtotal</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php foreach ($detail_transaksi as $ddt): ?>
											<tr>
												<td><?= $i++; ?></td>
												<td><?= $ddt['nama_barang']; ?></td>
												<td><?= $ddt['kuantitas']; ?></td>
												<td>Rp. <?= str_replace(",", ".", number_format($ddt['subtotal'])); ?></td>
												<td>
													<a class="btn btn-sm btn-success" href="ubah_detail_transaksi.php?id_detail_transaksi=<?= $ddt['id_detail_transaksi']; ?>&id_transaksi=<?= $id_transaksi; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
													<a class="btn btn-sm btn-danger btn-delete" data-nama="Data Transaksi Barang <?= $ddt['nama_barang']; ?> akan terhapus!" href="hapus_detail_transaksi.php?id_detail_transaksi=<?= $ddt['id_detail_transaksi']; ?>&id_transaksi=<?= $id_transaksi; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
												</td>
											</tr>
										<?php endforeach ?>
									</tbody>
								</table>
							</div>
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

>>>>>>> 7282410724e69b75a027036b2b0f3a084e11b25a
</html>