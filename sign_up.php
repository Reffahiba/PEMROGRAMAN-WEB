<?php
    include 'koneksi.php';

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["admin_username"]);
    $email = test_input($_POST["email"]);
    $number = test_input($_POST["number"]);
    $password = test_input($_POST["admin_password"]);

    // Validasi bahwa semua bidang telah diisi
    if (empty($username) || empty($email) || empty($number) || empty($password)) {
        echo "Semua bidang harus diisi.";
    } else {
        // Buat kueri SQL untuk memeriksa keberadaan username di dalam tabel pengguna
        $check_query = "SELECT * FROM admin WHERE nama_admin = '$username'";

        // Eksekusi kueri SQL
        $result = mysqli_query($conn, $check_query);

        // Periksa hasil kueri
        if (mysqli_num_rows($result) > 0) {
            // Jika username sudah ada, tampilkan pesan kesalahan
            echo "<script>alert('Username sudah digunakan. Silakan coba dengan username yang lain.');</script>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO admin (nama_admin, email, no_telepon, password) VALUES ('$username', '$email', '$number', '$hashed_password')";
            
            if (mysqli_query($conn, $sql)) {
                header("Location: login_admin.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
    // Tutup koneksi
    mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Management System</title>
     <link rel="stylesheet" href="style_admin.css" />
    <link rel="icon" href="gambar/WareHouse WSM.png">
    <style>
      .copyright-sign-up {
        background-color: white;
        text-align: center;
        color: #3c2bad;
        margin-top: 45px;
        padding: 2px;
        font-weight: bold;
      }
    </style>

</head>
<body>
    <div class="container">
      <h1 class="title">Warehouse Management System</h1>
      <img src="gambar/WareHouse WSM.png" alt="logo-WSM" class="logo-login" />
      <form action="sign_up.php" method="post">
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
          <img src="gambar/email.png" alt="user-icon" class="icon" />
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Email"
            class="login-bar"
            required
          />
        </div>
        <div class="input-container">
          <img src="gambar/nohp.png" alt="user-icon" class="icon" />
          <input
            type="tel"
            id="number"
            name="number"
            placeholder="No. Handphone"
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
        <div class="input-container">
          <img src="gambar/padlock.png" alt="user-icon" class="icon" />
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Confirm Password"
            class="login-bar"
            required
          />
        </div>
        <button type="submit" class="btn-login">Sign Up</button>
      </form>
    </div>

    <br>

    <footer class="copyright-sign-up">
      <p>Copyright &copy; F Production</p>
    </footer>
</body>
</html>