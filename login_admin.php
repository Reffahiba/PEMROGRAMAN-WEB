<?php
    include 'koneksi.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil nilai username dan password yang dimasukkan oleh pengguna dari formulir
        $username = $_POST["admin_username"];
        $password = $_POST["admin_password"];

        // Buat kueri SQL untuk memeriksa keberadaan username dan password di dalam tabel pengguna
        $check_query = "SELECT * FROM admin WHERE nama_admin = '$username'";

        // Eksekusi kueri SQL
        $result = mysqli_query($conn, $check_query);

        $row = mysqli_fetch_assoc($result);
        // Periksa hasil kueri
        if ($result) {
            // Jika baris yang dikembalikan lebih dari 0
            if (mysqli_num_rows($result) > 0) {
              password_verify($password, $row["password"] );
              session_start();
              $_SESSION['admin_username'] = $username;
              header("Location: dashboard_admin.php");
              exit();
            } else {
                echo "<script>alert('Username dan password tidak ada.');</script>";
            }
        } else {
            echo "<script>alert('Terjadi kesalahan dalam eksekusi query.');</script>";
        }

        // Tutup koneksi
        mysqli_close($conn);
    }
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Warehouse Management System</title>
    <link rel="stylesheet" href="style_admin.css" />
    <link rel="icon" href="gambar/WareHouse WSM.png" />
    <style>
      .copyright-login {
        background-color: white;
        text-align: center;
        margin-top: 153px;
        color: #3c2bad;
        padding: 2px;
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h1 class="title">Warehouse Management System</h1>
      <img src="gambar/WareHouse WSM.png" alt="logo-WSM" class="logo-login" />
      <form action="login_admin.php" method="post">
        <div class="input-container">
          <img src="gambar/user.png" alt="user-icon" class="icon" />
          <input
            type="text"
            id="username"
            name="admin_username"
            placeholder="Username"
            class="login-bar"
            required
          />
        </div>
        <div class="input-container">
          <img src="gambar/padlock.png" alt="user-icon" class="icon" />
          <input
            type="password"
            id="password"
            name="admin_password"
            placeholder="Password"
            class="login-bar"
            required
          />
        </div>
        <button type="submit" class="btn-login">Login</button>
      </form>
      <a href="sign_up.php" class="to-sign-up">Belum punya akun</a>
    </div>

    <br>

    <footer class="copyright-login">
      <p>Copyright &copy; F Production</p>
    </footer>
  </body>
</html>
