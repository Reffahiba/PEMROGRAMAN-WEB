<?php
    include 'koneksi.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil nilai username dan password yang dimasukkan oleh pengguna dari formulir
        $username = $_POST["user_username"];
        $password = $_POST["user_password"];

        $check_query = "SELECT * FROM pengguna WHERE nama_user = '$username'";

        $result = mysqli_query($conn, $check_query);
        $row = mysqli_fetch_assoc($result);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                $user_role = $user_data['role'];
                password_verify($password, $row['password']);

                session_start();
                $_SESSION['user_username'] = $username;
                $_SESSION['user_role'] = $user_role;

                if($user_role == 'Kepala Gudang'){
                  header('Location: dashboard_kepala_gudang.php');
                }
                else{
                  header("Location: dashboard_staff_gudang.php");
                }
                exit();
            } else {
                // Jika tidak ada baris yang cocok, berikan pesan kesalahan
                echo "<script>alert('Username dan password tidak ada.');</script>";
            }
        } else {
            // Jika query tidak berhasil dieksekusi, tampilkan pesan kesalahan
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
        margin-top: 172px;
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
      <form action="login_user.php" method="post">
        <div class="input-container">
          <img src="gambar/user.png" alt="user-icon" class="icon" />
          <input
            type="text"
            id="username"
            name="user_username"
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
            name="user_password"
            placeholder="Password"
            class="login-bar"
            required
          />
        </div>
        <button type="submit" class="btn-login">Login</button>
      </form>
    </div>

    <br>

    <footer class="copyright-login">
      <p>Copyright &copy; F Production</p>
    </footer>
  </body>
</html>
