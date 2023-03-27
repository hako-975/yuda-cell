<?php 
require_once 'koneksi.php';

// check login
if (isset($_SESSION['id_user'])) {
    setAlert("Anda telah Login!", "Selamat Datang!", "success");
	header("Location: ".BASE_URL."index.php");
    exit;
}

if (isset($_COOKIE['username'])) {
   // Automatically fill in the username field in the login form
   $username = $_COOKIE['username'];
}

if (isset($_POST['btnLogin'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $remember_me = htmlspecialchars($_POST['remember_me']);

    // check username
    $check_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
    if ($data_user = mysqli_fetch_assoc($check_username)) {
        if (password_verify($password, $data_user['password'])) {
            if ($remember_me == 'on') {
                setcookie('username', $username, time() + (86400 * 30), "/");
            }
            else
            {
                setcookie('username', '', time() - 3600, '/');
            }

            $_SESSION['id_user'] = $data_user['id_user'];
            $_SESSION['hak_akses'] = $data_user['hak_akses'];
            header("Location: index.php");
            exit;
        }
        else
        {
            setAlert("Gagal Login!", "Username atau password yang Anda masukkan salah!", "error");
            header("Location: ".BASE_URL."login.php");
            exit;
        }
    }
    else
    {
        setAlert("Gagal Login!", "Username atau password yang Anda masukkan salah!", "error");
        header("Location: ".BASE_URL."login.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Login - Yuda Cell</title>
    <?php include 'include/head.php'; ?>

</head>

<body>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="img/logo.png" class="m-auto" width="100" alt="Logo">
                                        <h1 class="h4 text-gray-900">Yuda Cell</h1>
                                        <h2 class="h4 text-gray-900 mb-4">Silahkan Masuk</h2>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control form-control-user"
                                                id="username" name="username" required value="<?= (isset($_COOKIE['username']) ? $_COOKIE['username'] : ''); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="remember_me" name="remember_me">
                                                <label class="custom-control-label" for="remember_me">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" name="btnLogin" class="btn btn-primary btn-user btn-block">Login</button>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <?php include_once 'include/script.php' ?>

</body>

</html>