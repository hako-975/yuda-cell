<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier ASC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Supplier - Yuda Cell</title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Supplier</h5>
                                </div>
                                <?php if ($data_profile['hak_akses'] == 'administrator'): ?>
                                    <div class="col head-right">
                                        <a href="<?= BASE_URL; ?>supplier/tambah_supplier.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah Supplier</a>
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
											<th>Nama Supplier</th>
											<th>Alamat Supplier</th>
											<th>No. Telp Supplier</th>
											<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
												<th>Aksi</th>
											<?php endif ?>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php foreach ($supplier as $ds): ?>
											<tr>
												<td><?= $i++; ?></td>
												<td><?= $ds['nama_supplier']; ?></td>
												<td><?= $ds['alamat_supplier']; ?></td>
                                                <?php 
                                                    $toNumber62 = $ds['no_telp_supplier'];
                                                    if (substr($toNumber62, 0, 2) != "62") {
                                                        $toNumber62 = substr_replace($toNumber62, "62", 0, 1);
                                                    }
                                                 ?>
												<td><a target="_blank" class="btn btn-sm btn-success" href="https://wa.me/<?= $toNumber62; ?>"><i class="fab fa-fw fa-whatsapp"></i> +<?= $toNumber62; ?></a></td>
												<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
													<td>
														<a class="btn btn-sm btn-success" href="ubah_supplier.php?id_supplier=<?= $ds['id_supplier']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
														<a class="btn btn-sm btn-danger btn-delete" data-nama="Supplier dengan nama <?= $ds['nama_supplier']; ?> akan terhapus!" href="hapus_supplier.php?id_supplier=<?= $ds['id_supplier']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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