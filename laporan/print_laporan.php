<?php 
require_once '../koneksi.php';
if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$id_user = $_SESSION['id_user'];

if (!isset($_GET['dari_tanggal'])) {
    header("Location: laporan.php");
    exit;
}

$dari_tanggal = htmlspecialchars($_GET['dari_tanggal']);
$sampai_tanggal = htmlspecialchars($_GET['sampai_tanggal']);

$dari_tanggal_baru =  $dari_tanggal . ' 00:00:00';
$sampai_tanggal_baru =  $sampai_tanggal . ' 23:59:59';

$transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user WHERE tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' ORDER BY tanggal_transaksi ASC");

$omset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT sum(total_harga) as omset FROM transaksi WHERE tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
$laba = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM((p.harga_jual - p.harga_beli) * dt.jumlah) AS laba FROM detail_transaksi dt INNER JOIN produk p ON dt.id_produk = p.id_produk INNER JOIN transaksi t ON dt.id_transaksi = t.id_transaksi WHERE t.tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
$produk_paling_laku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT produk.id_produk, produk.nama_produk, SUM(jumlah) as laku FROM detail_transaksi dt INNER JOIN produk ON dt.id_produk = produk.id_produk INNER JOIN transaksi t ON dt.id_transaksi = t.id_transaksi WHERE t.tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' GROUP BY dt.id_produk ORDER BY laku DESC LIMIT 1"));

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
 ?>


 <!DOCTYPE html>
 <html lang="en">
 <head>
     <title>Laporan Yuda Cell Dari Tanggal <?= $dari_tanggal; ?> Sampai Tanggal <?= $sampai_tanggal; ?></title>
    <link rel="icon" href="<?= BASE_URL; ?>img/logo.png">
 </head>
 <body>
    <img style="display: block; text-align: center; margin: 0 auto;" src="<?= BASE_URL; ?>img/logo.png" alt="Logo" width="100">
    <h3 style="text-align: center;">Laporan Yuda Cell - Dari Tanggal <?= date("d-m-Y", strtotime($dari_tanggal)); ?> Sampai Tanggal <?= date("d-m-Y", strtotime($sampai_tanggal)); ?></h3>
    <h4>Omset: Rp. <?= str_replace(",", ".", number_format($omset['omset'])); ?>, Laba: Rp. <?= str_replace(",", ".", number_format($laba['laba'])); ?>, <?php if ($produk_paling_laku): ?>Produk Terlaku: <?= ucwords($produk_paling_laku['nama_produk']); ?> (<?= $produk_paling_laku['laku']; ?>)<?php endif ?></h4>
     <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal Transaksi</th>
                <th>Total Harga</th>
                <th>Bayar</th>
                <th>Kembalian</th>
                <th>Detail Transaksi</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($transaksi as $dt): ?>
                <?php 
                    $id_transaksi = $dt['id_transaksi'];
                    $detail_transaksi = mysqli_query($koneksi, "SELECT * FROM detail_transaksi INNER JOIN produk ON detail_transaksi.id_produk = produk.id_produk WHERE id_transaksi = '$id_transaksi'");
                 ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= date("d-m-Y, H:i", strtotime($dt['tanggal_transaksi'])); ?></td>
                    <td>Rp. <?= str_replace(",", ".", number_format($dt['total_harga'])); ?></td>
                    <td>Rp. <?= str_replace(",", ".", number_format($dt['bayar'])); ?></td>
                    <td>Rp. <?= str_replace(",", ".", number_format($dt['kembalian'])); ?></td>
                    <td style="min-width: 6rem">
                        <div>
                            <?php foreach ($detail_transaksi as $ddt): ?>
                                <div>
                                    • <?= $ddt['nama_produk']; ?> (<?= $ddt['jumlah']; ?>)
                                </div>
                            <?php endforeach ?>
                        </div>
                    </td>
                    <td><?= $dt['username']; ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
     <script>
         window.print();
     </script>
 </body>
 </html>