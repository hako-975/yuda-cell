<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

if ($_SESSION['hak_akses'] != 'administrator') {
	setAlert("Perhatian!", "Tidak dapat melakukan perubahan selain Administrator!", "error");
	echo "
		<script>
			window.history.back();
		</script>
	";
	exit;
}

$id_barang = htmlspecialchars($_GET['id_barang']);
$data_barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN jenis_barang ON barang.id_jenis_barang = jenis_barang.id_jenis_barang WHERE id_barang = '$id_barang'"));

$jenis_barang = mysqli_query($koneksi, "SELECT * FROM jenis_barang ORDER BY jenis_barang ASC");

if (isset($_POST['btnUbahBarang'])) {
	$nama_barang = htmlspecialchars(ucwords($_POST['nama_barang']));
	$harga_beli = htmlspecialchars($_POST['harga_beli']);
	$harga_jual = htmlspecialchars($_POST['harga_jual']);
	$stok_barang = htmlspecialchars($_POST['stok_barang']);
	$id_jenis_barang = htmlspecialchars($_POST['id_jenis_barang']);

	if ($id_jenis_barang == 0) {
		setAlert("Gagal!", "Pilih Jenis Barang terlebih dahulu!", "error");
		echo "
			<script>
				window.history.back();
			</script>
		";
		exit;
	}

	$ubah_barang = mysqli_query($koneksi, "UPDATE barang SET nama_barang = '$nama_barang', harga_beli = '$harga_beli', harga_jual = '$harga_jual', stok_barang = '$stok_barang', id_jenis_barang = '$id_jenis_barang' WHERE id_barang = '$id_barang'");

	if ($ubah_barang) {
		setAlert("Berhasil!", "Barang berhasil diubah!", "success");
		header("Location:" . BASE_URL . "barang/index.php");
		exit;
	} else {
		setAlert("Gagal!", "Barang gagal diubah!", "error");
		echo "
			<script>
				window.history.back();
			</script>
		";
		exit;
	}
}

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title>Ubah Barang - <?= $data_barang['nama_barang']; ?></title>
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
                	<div class="card shadow mb-4">
                		<div class="card-header py-3">
                            <div class="row">
                                <div class="col head-left">
                                    <h5 class="my-auto font-weight-bold text-primary">Ubah Barang - <?= $data_barang['nama_barang']; ?></h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>barang/index.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<form method="post">
								<div class="form-group">
									<label for="nama_barang">Nama Barang</label>
									<input class="form-control" type="text" name="nama_barang" id="nama_barang" value="<?= $data_barang['nama_barang']; ?>" required>
								</div>
								<div class="form-group">
									<label for="harga_beli">Harga Beli</label>
									<input class="form-control" type="number" name="harga_beli" id="harga_beli" value="<?= $data_barang['harga_beli']; ?>" required>
								</div>
								<div class="form-group">
									<label for="harga_jual">Harga Jual</label>
									<input class="form-control" type="number" name="harga_jual" id="harga_jual" value="<?= $data_barang['harga_jual']; ?>" required>
								</div>
								<div class="form-group">
									<label for="stok_barang">Stok Barang</label>
									<input class="form-control" type="number" name="stok_barang" id="stok_barang" value="<?= $data_barang['stok_barang']; ?>" required>
								</div>
								<div class="form-group">
									<label for="id_jenis_barang">Jenis Barang</label>
									<select name="id_jenis_barang" id="id_jenis_barang" class="custom-select">
										<option value="<?= $data_barang['id_jenis_barang']; ?>"><?= $data_barang['jenis_barang']; ?></option>
										<?php foreach ($jenis_barang as $djb): ?>
											<?php if ($data_barang['id_jenis_barang'] != $djb['id_jenis_barang']): ?>
												<option value="<?= $djb['id_jenis_barang']; ?>"><?= $djb['jenis_barang']; ?></option>
											<?php endif ?>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnUbahBarang" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
								</div>
							</form>
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