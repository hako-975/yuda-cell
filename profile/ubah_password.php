<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);

$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

if (isset($_POST['btnUbahPassword'])) {
	$password_lama = htmlspecialchars($_POST['password_lama']);
	$password_baru = htmlspecialchars($_POST['password_baru']);
	$verifikasi_password_baru = htmlspecialchars($_POST['verifikasi_password_baru']);

	// check password with verify
	if ($password_baru != $verifikasi_password_baru) {
		setAlert("Gagal!", "Password baru harus sama dengan verifikasi password baru!", "error");
		echo "
			<script>
				window.history.back();
			</script>
		";
		exit;
	}

	// check password lama
	if (!password_verify($password_lama, $data_profile['password'])) {
		setAlert("Gagal!", "Password lama tidak sesuai!", "error");
		echo "
			<script>
				window.history.back();
			</script>
		";
		exit;
	}

	$password_baru = password_hash($password_baru, PASSWORD_DEFAULT);

	$ubah_password = mysqli_query($koneksi, "UPDATE user SET password = '$password_baru' WHERE id_user = '$id_user'");

	if ($ubah_password) {
		setAlert("Berhasil!", "Password berhasil diubah!", "success");
		header("Location:" . BASE_URL . "profile/index.php");
		exit;
	} else {
		echo "
			<script>
				window.history.back();
			</script>
		";
		exit;
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Ubah Password - <?= $data_profile['username']; ?></title>
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
	                                <h5 class="my-auto font-weight-bold text-primary">Ubah Password - <?= $data_profile['username']; ?></h5>
	                            </div>
	                            <div class="col head-right">
	                                <a href="<?= BASE_URL; ?>profile/index.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
	                            </div>
	                        </div>
	                    </div>
		                <div class="card-body">
			                <form method="post">
								<div class="form-group">
									<label for="password_lama">Password Lama</label>
									<input class="form-control" type="password" name="password_lama" id="password_lama" required>
								</div>
								<div class="form-group">
									<label for="password_baru">Password Baru</label>
									<input class="form-control" type="password" name="password_baru" id="password_baru" required>
								</div>
								<div class="form-group">
									<label for="verifikasi_password_baru">Verifikasi Password Baru</label>
									<input class="form-control" type="password" name="verifikasi_password_baru" id="verifikasi_password_baru" required>
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnUbahPassword" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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