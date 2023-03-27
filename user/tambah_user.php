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

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

if (isset($_POST['btnTambahUser'])) {
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);
	$verifikasi_password = htmlspecialchars($_POST['verifikasi_password']);
	$nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
	$no_telp_user = htmlspecialchars($_POST['no_telp_user']);

	// check username 
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

	// check password with verify
	if ($password != $verifikasi_password) {
		setAlert("Gagal!", "Password harus sama dengan verifikasi password!", "error");
		echo "
			<script>
				window.history.back();
			</script>
		";
		exit;
	}

	$password = password_hash($password, PASSWORD_DEFAULT);

	$tambah_user = mysqli_query($koneksi, "INSERT INTO user VALUES('', '$username', '$password', 'operator', '$nama_lengkap', '$no_telp_user')");

	if ($tambah_user) {
		setAlert("Berhasil!", "User ".$username." berhasil ditambahkan!", "success");
		header("Location:" . BASE_URL . "user/index.php");
		exit;
	} else {
		setAlert("Gagal!", "User gagal ditambahkan!", "error");
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
    <title>Tambah User - Yuda Cell</title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Tambah User</h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>user/index.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<form method="post">
								<div class="form-group">
									<label for="username">Username</label>
									<input class="form-control" type="text" name="username" id="username" required>
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input class="form-control" type="password" name="password" id="password" required>
								</div>
								<div class="form-group">
									<label for="verifikasi_password">Verifikasi Password</label>
									<input class="form-control" type="password" name="verifikasi_password" id="verifikasi_password" required>
								</div>
								<div class="form-group">
									<label for="nama_lengkap">Nama Lengkap</label>
									<input class="form-control" type="text" name="nama_lengkap" id="nama_lengkap" required>
								</div>
								<div class="form-group">
									<label for="no_telp_user">No. Telp User</label>
									<input class="form-control" type="number" name="no_telp_user" id="no_telp_user" required>
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnTambahUser" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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