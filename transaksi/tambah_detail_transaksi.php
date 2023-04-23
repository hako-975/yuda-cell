<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$id_transaksi = htmlspecialchars($_GET['id_transaksi']);

$produk = mysqli_query($koneksi, "SELECT * FROM produk LEFT OUTER JOIN jenis_saldo ON produk.id_jenis_saldo = jenis_saldo.id_jenis_saldo ORDER BY nama_produk ASC");

// Convert the result set to an array
$produk_arr = array();
while ($row = mysqli_fetch_assoc($produk)) {
    $produk_arr[] = $row;
}

// Convert the array to a JSON string
$produkJson = json_encode($produk_arr);

if (isset($_POST['btnTambahDetailTransaksi'])) {
	$id_produk = htmlspecialchars($_POST['id_produk']);
	$jumlah = htmlspecialchars($_POST['jumlah']);
	$subtotal = htmlspecialchars($_POST['subtotal']);

	if ($id_produk == 0) {
		setAlert("Gagal!", "Pilih Produk terlebih dahulu!", "error");
		echo "
			<script>
				window.history.back();
			</script>
		";
		exit;
	}

	$tambah_detail_transaksi = mysqli_query($koneksi, "INSERT INTO detail_transaksi VALUES('', '$id_transaksi', '$id_produk', '$jumlah', '$subtotal')");

	$get_total_harga = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(subtotal) as total_harga FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'"));
	$total_harga = $get_total_harga['total_harga'];
	$update_total_harga = mysqli_query($koneksi, "UPDATE transaksi SET total_harga = '$total_harga' WHERE id_transaksi = '$id_transaksi'");

	// $update_stok = mysqli_query($koneksi, "UPDATE produk SET stok = stok - '$jumlah' WHERE id_produk = '$id_produk'");


	if ($tambah_detail_transaksi) {
		setAlert("Berhasil!", "Transaksi Produk berhasil ditambahkan!", "success");
		header("Location:" . BASE_URL . "transaksi/detail_transaksi.php?id_transaksi=$id_transaksi");
		exit;
	} else {
		setAlert("Gagal!", "Transaksi Produk gagal ditambahkan!", "error");
		echo "
			<script>
				window.history.back();
			</script>
		";
	}
}


$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tambah Transaksi Produk - ID Transaksi <?= $id_transaksi; ?></title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Tambah Transaksi Produk</h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>transaksi/detail_transaksi.php?id_transaksi=<?= $id_transaksi; ?>" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
							<form method="post">
								<div class="form-group">
									<label for="id_produk">Nama Produk</label>
									<select name="id_produk" id="id_produk" class="custom-select">
										<option value="0">--- Pilih Nama Produk ---</option>
										<?php foreach ($produk as $dp): ?>
											<option value="<?= $dp['id_produk']; ?>"><?= $dp['nama_produk']; ?> <?= ($dp['jenis_saldo']) ? '('.$dp['jenis_saldo'].')' : ''; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="jumlah">Jumlah</label>
									<input type="number" name="jumlah" id="jumlah" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="subtotal">Subtotal</label>
									<input style="cursor: not-allowed;" type="number" name="subtotal" id="subtotal" class="form-control">
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnTambahDetailTransaksi" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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
	  // Initialize the produk variable with the PHP-generated $produk array
	  const produk = <?= $produkJson; ?>;

	  const idProdukSelect = document.getElementById('id_produk');
	  const jumlahInput = document.getElementById('jumlah');
	  const subtotalInput = document.getElementById('subtotal');

	  // Calculate subtotal when either "Nama Produk" or "Jumlah" changes
	  idProdukSelect.addEventListener('change', () => {
	    const selectedProduk = idProdukSelect.options[idProdukSelect.selectedIndex];
	    updateSubtotal(selectedProduk);
	  });

	  jumlahInput.addEventListener('input', () => {
	    const selectedProduk = idProdukSelect.options[idProdukSelect.selectedIndex];
	    updateSubtotal(selectedProduk);
	  });

	  // Function to calculate subtotal
	  function updateSubtotal(selectedProduk) {
		  const idProduk = selectedProduk.value;
		  const jumlah = jumlahInput.value;

		  // Find the selected produk object from the produk array
		  const selectedProdukObj = produk.find((b) => b.id_produk == idProduk);

		  // Get the harga_jual property of the selected produk object
		  const hargaProduk = selectedProdukObj.harga_jual;

		  // Calculate the new subtotal value and update the input field
		  const subtotal = hargaProduk * jumlah;
		  subtotalInput.value = subtotal;
		}
	</script>
	
</body>
</html>