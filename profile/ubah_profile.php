<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);

$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));


if (isset($_POST['btnUbahProfile'])) {
	$username = htmlspecialchars($_POST['username']);
	$nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
	$no_telp_user = htmlspecialchars($_POST['no_telp_user']);

	// check username 
	$old_username = $data_profile['username'];
	if ($username != $old_username) {
		$check_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
		if (mysqli_num_rows($check_username)) {
			setAlert("Gagal!", "Username telah digunakan!", "error");
			echo "
				<script>
					window.history.back();
				</script>
			";
			exit;
		}
	}

	$ubah_profile = mysqli_query($koneksi, "UPDATE user SET username = '$username', nama_lengkap = '$nama_lengkap', no_telp_user = '$no_telp_user' WHERE id_user = '$id_user'");

	if ($ubah_profile) {
		setAlert("Berhasil!", "Profile berhasil diubah!", "success");
		header("Location:" . BASE_URL . "profile/index.php");
		exit;
	} else {
		setAlert("Gagal!", "Profile gagal diubah!", "error");
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
	<title>Ubah Profile - <?= $data_profile['username']; ?></title>
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
	                                <h5 class="my-auto font-weight-bold text-primary">Ubah Profile - <?= $data_profile['username']; ?></h5>
	                            </div>
	                            <div class="col head-right">
	                                <a href="<?= BASE_URL; ?>profile/index.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
	                            </div>
	                        </div>
	                    </div>
		                <div class="card-body">
		                	<form method="post">
								<div class="form-group">
									<label for="username">Username</label>
									<input class="form-control" type="text" name="username" id="username" value="<?= $data_profile['username']; ?>" required>
								</div>
								<div class="form-group">
									<label for="nama_lengkap">Nama Lengkap</label>
									<input class="form-control" type="text" name="nama_lengkap" id="nama_lengkap" value="<?= $data_profile['nama_lengkap']; ?>" required>
								</div>
								<div class="form-group">
									<label for="no_telp_user">No. Telp User</label>
									<input class="form-control" type="number" name="no_telp_user" id="no_telp_user" value="<?= $data_profile['no_telp_user']; ?>" required>
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnUbahProfile" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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