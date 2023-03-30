<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user ORDER BY tanggal_transaksi DESC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Transaksi - Yuda Cell</title>
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
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col head-left">
                                    <h5 class="my-auto font-weight-bold text-primary">Transaksi</h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>transaksi/tambah_transaksi.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah Transaksi</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
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
													<a class="btn btn-sm btn-info" href="detail_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>"><i class="fas fa-fw fa-info"></i> Detail</a>
													<a class="btn btn-sm btn-success" href="ubah_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
													<a class="btn btn-sm btn-danger btn-delete" data-nama="Transaksi dengan ID Transaksi <?= $dt['id_transaksi']; ?> akan terhapus!" href="hapus_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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

</html>