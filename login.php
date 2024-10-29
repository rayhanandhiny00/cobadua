<?php 

session_start();

include 'config/app.php';

//cek tombol login ditekan
if (isset($_POST['login'])) {
    //ambil username dan password
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    
    //cek 
    $result = mysqli_query($db, "SELECT * FROM akun WHERE username = '$username'");

    //cek password
    if (mysqli_num_rows($result) == 1) {
        $hasil = mysqli_fetch_assoc($result);
        if (password_verify($password, $hasil['password'])) {
            //set session
            $_SESSION['login'] = true;
            $_SESSION['id_akun'] = $hasil['id_akun'];
            $_SESSION['no_a'] = $hasil['no_a'];
            $_SESSION['nama_a'] = $hasil['nama_a'];
            $_SESSION['jk'] = $hasil['jk'];
            $_SESSION['alamat'] = $hasil['alamat'];
            $_SESSION['tlp'] = $hasil['tlp'];
            $_SESSION['username'] = $hasil['username'];
            $_SESSION['role'] = $hasil['role'];

            //login benar lgsg ke index(file tujuan)
            header("location: index.php");
            exit;
        }
    }
    //jika tidak ada user ato pw salah
    $error = true;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Sign In GPS</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

<!-- Bootstrap core CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<!-- Favicons -->
    <link rel="icon" href="assets/img/logoGPS.png">
    <meta name="theme-color" content="#7952b3">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    
<main class="form-signin">
  <form action="" method="POST">
    <img class="mb-4" src="assets/img/logoGPS.png" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Sign In</h1>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger text-center">
            <b>Username atau Password SALAH</b>
        </div>
    <?php endif; ?>

    <div class="form-floating">
      <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Username" required>
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
      <label for="floatingPassword">Password</label>
    </div>

    <!--<div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>-->
    <button class="w-100 btn btn-lg btn-dark" style="background-color: #194569" type="submit" name="login">Login</button>
    <p class="mt-5 mb-3 text-muted">Copyright &copy; Globalindo Prisha Sentosa <?= date('Y')?></p>
  </form>
</main>
 
  </body>
</html>