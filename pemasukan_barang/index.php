<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$pemasukan_barang = mysqli_query($koneksi, "SELECT * FROM pemasukan_barang INNER JOIN barang ON pemasukan_barang.id_barang = barang.id_barang INNER JOIN supplier ON pemasukan_barang.id_supplier = supplier.id_supplier ORDER BY tanggal_pemasukan DESC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pemasukan Barang - Yuda Cell</title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Pemasukan Barang</h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>pemasukan_barang/tambah_pemasukan_barang.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah Pemasukan Barang</a>
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
											<th>Nama Supplier</th>
											<th>Tanggal Pemasukan</th>
											<th>Jumlah Pemasukan</th>
											<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
												<th>Aksi</th>
											<?php endif ?>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php foreach ($pemasukan_barang as $dpb): ?>
											<tr>
												<td><?= $i++; ?></td>
												<td><?= $dpb['nama_barang']; ?></td>
												<td><?= $dpb['nama_supplier']; ?></td>
												<td><?= $dpb['tanggal_pemasukan']; ?></td>
												<td><?= $dpb['jumlah_pemasukan']; ?></td>
												<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
													<td>
														<a class="btn btn-sm btn-success" href="ubah_pemasukan_barang.php?id_pemasukan_barang=<?= $dpb['id_pemasukan_barang']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
														<a class="btn btn-sm btn-danger btn-delete" data-nama="Pemasukan Barang <?= $dpb['nama_barang']; ?> akan terhapus!"href="hapus_pemasukan_barang.php?id_pemasukan_barang=<?= $dpb['id_pemasukan_barang']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
													</td>
												<?php endif ?>
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