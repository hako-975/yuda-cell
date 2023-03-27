<?php 
	require_once 'koneksi.php';
	session_destroy();
	setAlert("Anda telah Logout!", "Logout Berhasil!", "success");
	header("Location: ".BASE_URL."login.php");
	exit;
?>