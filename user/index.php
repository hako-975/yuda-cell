<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$user = mysqli_query($koneksi, "SELECT * FROM user ORDER BY hak_akses ASC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User - Yuda Cell</title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">User</h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>user/tambah_user.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah User</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Username</th>
                                            <th>Hak Akses</th>
                                            <th>Nama Lengkap</th>
                                            <th>No. Telp User</th>
                                            <?php if ($data_profile['hak_akses'] == 'administrator'): ?>
                                                <th>Aksi</th>
                                            <?php endif ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($user as $du): ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $du['username']; ?></td>
                                                <td><?= ucwords($du['hak_akses']); ?></td>
                                                <td><?= $du['nama_lengkap']; ?></td>
                                                <td><?= $du['no_telp_user']; ?></td>
                                                <td>
                                                    <?php if ($data_profile['hak_akses'] == 'administrator'): ?>
                                                        <?php if ($du['hak_akses'] != 'administrator'): ?>
                                                                <a class="btn btn-sm btn-success" href="ubah_user.php?id_user=<?= $du['id_user']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
                                                                <a class="btn btn-sm btn-danger btn-delete" data-nama="User dengan username <?= $du['username']; ?> akan terhapus!" href="hapus_user.php?id_user=<?= $du['id_user']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                                        <?php endif ?>
                                                    <?php endif ?>
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