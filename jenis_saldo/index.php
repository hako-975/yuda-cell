<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$jenis_saldo = mysqli_query($koneksi, "SELECT * FROM jenis_saldo ORDER BY jenis_saldo ASC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Jenis Saldo - Yuda Cell</title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Jenis Saldo</h5>
                                </div>
                                <?php if ($data_profile['hak_akses'] == 'administrator'): ?>
                                    <div class="col head-right">
                                        <a href="<?= BASE_URL; ?>jenis_saldo/tambah_jenis_saldo.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah Jenis Saldo</a>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
										<tr>
											<th>No.</th>
                                            <th>Jenis Saldo</th>
											<th>Jumlah Saldo</th>
											<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
												<th>Aksi</th>
											<?php endif ?>
										</tr>
									</thead>
                                    <tbody>
										<?php $i = 1; ?>
										<?php foreach ($jenis_saldo as $djs): ?>
											<tr>
												<td><?= $i++; ?></td>
                                                <td><?= $djs['jenis_saldo']; ?></td>
												<td>Rp. <?= str_replace(",", ".", number_format($djs['jumlah_saldo'])); ?></td>
												<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
													<td>
														<a class="btn btn-sm btn-success" href="ubah_jenis_saldo.php?id_jenis_saldo=<?= $djs['id_jenis_saldo']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
														<a class="btn btn-sm btn-danger btn-delete" data-nama="Jenis Saldo <?= $djs['jenis_saldo']; ?> akan terhapus!" href="hapus_jenis_saldo.php?id_jenis_saldo=<?= $djs['id_jenis_saldo']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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