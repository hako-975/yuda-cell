<?php 
	require_once 'koneksi.php';
	session_destroy();
	setAlert("Anda telah Logout!", "Logout Berhasil!", "success");
	header("Location: login.php");
	exit;
?>