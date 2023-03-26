<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);

$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Profile - <?= $data_profile['username']; ?></title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Profile</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
							<table cellpadding="10" cellspacing="0">
								<tr>
									<th>Username</th>
									<td>: <?= $data_profile['username']; ?></td>
								</tr>
								<tr>
									<th>Hak Akses</th>
									<td>: <?= ucwords($data_profile['hak_akses']); ?></td>
								</tr>
								<tr>
									<th>Nama Lengkap</th>
									<td>: <?= $data_profile['nama_lengkap']; ?></td>
								</tr>
								<tr>
									<th>No. Telp User</th>
									<td>: <?= $data_profile['no_telp_user']; ?></td>
								</tr>
							</table>
							<hr>
							<a class="btn btn-sm btn-success" href="<?= BASE_URL; ?>profile/ubah_profile.php">Ubah Profile</a>
							<a class="btn btn-sm btn-danger" href="<?= BASE_URL; ?>profile/ubah_password.php">Ubah Password</a>
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
</body>
</html>