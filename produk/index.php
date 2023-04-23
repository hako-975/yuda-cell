<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$produk_stok = mysqli_query($koneksi, "SELECT id_produk, nama_produk, harga_beli, harga_jual, stok FROM produk WHERE stok <= 0 || stok >= 0 ORDER BY nama_produk ASC");

$produk_jenis_saldo = mysqli_query($koneksi, "SELECT id_produk, nama_produk, harga_beli, harga_jual, produk.id_jenis_saldo, jenis_saldo, jumlah_saldo FROM produk INNER JOIN jenis_saldo ON produk.id_jenis_saldo = jenis_saldo.id_jenis_saldo ORDER BY produk.nama_produk ASC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Produk - Yuda Cell</title>
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
                    <nav>
					  <div class="nav nav-tabs" id="nav-tab" role="tablist">
					  	<form method="get" class="m-0 p-0">
						    <button class="nav-link <?= (isset($_GET['stok'])) ? 'active' : ''; ?>" type="submit" name="stok">Stok</button>
					  	</form>
					  	<form method="get" class="m-0 p-0">
						    <button class="nav-link <?= (isset($_GET['jenis_saldo'])) ? 'active' : '' ; ?>" type="submit" name="jenis_saldo">Jenis Saldo</button>
					  	</form>
					  </div>
					</nav>
					<div class="tab-content" id="nav-tabContent">
					  <div class="tab-pane fade show <?= (isset($_GET['stok'])) ? 'active' : ''; ?>" id="nav-stok" role="tabpanel" aria-labelledby="nav-stok-tab">
					  	<div class="card shadow mb-4">
	                        <div class="card-header py-3">
	                            <div class="row">
	                                <div class="col head-left">
	                                    <h5 class="my-auto font-weight-bold text-primary">Produk Stok</h5>
	                                </div>
	                                <div class="col head-right">
	                                    <a href="<?= BASE_URL; ?>produk/tambah_produk_stok.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah Produk Stok</a>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="card-body">
	                            <div class="table-responsive">
	                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
										<thead>
											<tr>
												<th>No.</th>
												<th>Nama Produk</th>
												<th>Harga Beli</th>
												<th>Harga Jual</th>
												<th>Stok</th>
												<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
													<th>Aksi</th>
												<?php endif ?>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1; ?>
											<?php foreach ($produk_stok as $dps): ?>
												<tr>
													<td><?= $i++; ?></td>
													<td><?= $dps['nama_produk']; ?></td>
													<td>Rp. <?= str_replace(",", ".", number_format($dps['harga_beli'])); ?></td>
													<td>Rp. <?= str_replace(",", ".", number_format($dps['harga_jual'])); ?></td>
													<td><?= $dps['stok']; ?></td>
													<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
														<td>
															<a class="btn btn-sm btn-success" href="ubah_produk_stok.php?id_produk=<?= $dps['id_produk']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
															<a class="btn btn-sm btn-danger btn-delete" data-nama="Produk <?= $dps['nama_produk']; ?> akan terhapus!" href="hapus_produk.php?id_produk=<?= $dps['id_produk']; ?>&type=stok"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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
					  <div class="tab-pane fade show <?= (isset($_GET['jenis_saldo'])) ? 'active' : '' ; ?>" id="nav-saldo" role="tabpanel" aria-labelledby="nav-saldo-tab">
					  	<div class="card shadow mb-4">
	                        <div class="card-header py-3">
	                            <div class="row">
	                                <div class="col head-left">
	                                    <h5 class="my-auto font-weight-bold text-primary">Produk Jenis Saldo</h5>
	                                </div>
	                                <div class="col head-right">
	                                    <a href="<?= BASE_URL; ?>produk/tambah_produk_jenis_saldo.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah Produk Jenis Saldo</a>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="card-body">
	                            <div class="table-responsive">
	                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
										<thead>
											<tr>
												<th>No.</th>
												<th>Nama Produk</th>
												<th>Harga Beli</th>
												<th>Harga Jual</th>
												<th>Jenis Saldo</th>
												<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
													<th>Aksi</th>
												<?php endif ?>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1; ?>
											<?php foreach ($produk_jenis_saldo as $dpjs): ?>
												<tr>
													<td><?= $i++; ?></td>
													<td><?= $dpjs['nama_produk']; ?></td>
													<td>Rp. <?= str_replace(",", ".", number_format($dpjs['harga_beli'])); ?></td>
													<td>Rp. <?= str_replace(",", ".", number_format($dpjs['harga_jual'])); ?></td>
													<td><?= $dpjs['jenis_saldo']; ?> (sisa saldo Rp. <?= str_replace(",", ".", number_format($dpjs['jumlah_saldo'])); ?>)</td>
													<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
														<td>
															<a class="btn btn-sm btn-success" href="ubah_produk_jenis_saldo.php?id_produk=<?= $dpjs['id_produk']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
															<a class="btn btn-sm btn-danger btn-delete" data-nama="Produk <?= $dpjs['nama_produk']; ?> akan terhapus!" href="hapus_produk.php?id_produk=<?= $dpjs['id_produk']; ?>&type=jenis_saldo"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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
					</div>
					<?php if (!isset($_GET['stok']) && !isset($_GET['jenis_saldo'])): ?>
						<h1 class="d-block mx-auto text-center mt-5 pt-5">Pilih tab menu di atas!</h1>
					<?php endif ?>
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