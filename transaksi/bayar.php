<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$id_transaksi = htmlspecialchars($_GET['id_transaksi']);

$data_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user WHERE transaksi.id_transaksi = '$id_transaksi'"));

$detail_transaksi = mysqli_query($koneksi, "SELECT * FROM detail_transaksi INNER JOIN transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi INNER JOIN produk ON detail_transaksi.id_produk = produk.id_produk WHERE detail_transaksi.id_transaksi = '$id_transaksi' ORDER BY produk.nama_produk ASC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

if (isset($_POST['btnBayar'])) {
	$bayar = htmlspecialchars($_POST['bayar']);
	$kembalian = htmlspecialchars($_POST['kembalian']);

	if ($bayar < $data_transaksi['total_harga']) {
		setAlert("Gagal!", "Uang yang dibayarkan kurang dari total harga!", "error");
		echo "
			<script>
				window.history.back();
			</script>
		";
		exit;
	}

	$update_transaksi = mysqli_query($koneksi, "UPDATE transaksi SET bayar = '$bayar', kembalian = '$kembalian' WHERE id_transaksi = '$id_transaksi'");

	if ($update_transaksi) {
		setAlert("Berhasil!", "Pembayaran Transaksi Produk dengan ID Transaksi $id_transaksi berhasil!", "success");
		header("Location:" . BASE_URL . "transaksi/detail_transaksi.php?id_transaksi=$id_transaksi");
		exit;
	} else {
		setAlert("Gagal!", "Pembayaran Transaksi Produk dengan ID Transaksi $id_transaksi gagal!", "error");
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
    <title>Pembayaran Transaksi Barang - ID Transaksi <?= $id_transaksi; ?></title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Pembayaran ID Transaksi - <?= $data_transaksi['id_transaksi']; ?></h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>transaksi/detail_transaksi.php?id_transaksi=<?= $id_transaksi; ?>" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            	<table class="table table-bordered" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>No.</th>
											<th>Nama Produk</th>
											<th>Jumlah</th>
											<th>Subtotal</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php foreach ($detail_transaksi as $ddt): ?>
											<tr>
												<td><?= $i++; ?></td>
												<td><?= $ddt['nama_produk']; ?></td>
												<td><?= $ddt['jumlah']; ?></td>
												<td>Rp. <?= str_replace(",", ".", number_format($ddt['subtotal'])); ?></td>
											</tr>
										<?php endforeach ?>
									</tbody>
								</table>
                            </div>
							<hr>
							<form method="post">
							  <div class="form-group">
							    <label for="total_harga">Total Harga</label>
							    <input type="text" disabled name="total_harga" id="total_harga" class="not-allowed form-control" value="Rp. <?= str_replace(",", ".", number_format($data_transaksi['total_harga'])); ?>">
							  </div>
							  <div class="form-group">
							    <label for="bayar">Bayar</label>
							    <input type="number" name="bayar" id="bayar" class="form-control" required>
							  </div>
							  <div class="form-group">
							    <label for="kembalian">Kembalian</label>
							    <input style="cursor: not-allowed;" type="number" name="kembalian" id="kembalian" class="form-control">
							  </div>
							  <div class="form-group text-right">
							    <button type="submit" name="btnBayar" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Bayar</button>
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
	<script>
	  // Get the "bayar" and "kembalian" input fields
	  const bayarInput = document.getElementById("bayar");
	  const kembalianInput = document.getElementById("kembalian");

	  // Calculate the kembalian and update the input field when the "bayar" value changes
	  bayarInput.addEventListener("input", function() {
	    const totalHarga = <?= $data_transaksi['total_harga'] ?>;
	    const bayar = bayarInput.value;
	    const kembalian = bayar - totalHarga;
	    kembalianInput.value = kembalian;
	  });

	</script>

</body>
</html>