<?php
  include 'koneksi.php';

    session_start(); // Mulai sesi
    if(isset($_SESSION['admin_username'])) { // Periksa apakah pengguna telah login
        $nama_pengguna = $_SESSION['admin_username'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_user = $_POST["id_user"];
        $username = $_POST["nama_user"];
        $role = $_POST["role"];
        $number = $_POST["nomor"];
        $password = $_POST["pass"];

        // Validasi bahwa semua bidang telah diisi
        if (empty($id_user) || empty($username) || empty($role) || empty($number) || empty($password)) {
            echo "Semua bidang harus diisi.";
        } else {
            // Buat kueri SQL untuk memeriksa keberadaan username di dalam tabel pengguna
            $check_query = "SELECT * FROM pengguna WHERE nama_user = '$username'";

            // Eksekusi kueri SQL
            $result = mysqli_query($conn, $check_query);

            // Periksa hasil kueri
            if (mysqli_num_rows($result) > 0) {
                echo "<script>alert('Username sudah digunakan. Silakan coba dengan username yang lain.');</script>";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO pengguna (id_user, nama_user, role, no_telepon, password) VALUES ('$id_user', '$username', '$role', '$number', '$hashed_password')";
                
                if (mysqli_query($conn, $sql)) {
                    header("Location: kelola_user.php");
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Warehouse Management System</title>
    <link rel="stylesheet" href="style_admin.css" />
    <link rel="icon" href="gambar/WareHouse WSM.png" />
    <style>
        .header {
            background-color: #39adff;
            padding-left: 20px;
            padding-right: 20px;
            display: flex;
            justify-content: left;
            align-items: center;
            width: 100%;
            position: fixed;
        }

        .logo-header {
            width: 5%;
            height: 5%;
            margin: 8px;
        }

        .title-header {
            display: flex;
            align-items: center;
            margin-left: 20px;
            color: white;
        }

        .user {
            text-align: end;
            align-items: center;
            display: flex;
            justify-content: flex-end;
            margin-left: 220px;
        }

        .logo-avatar {
            width: 5%;
            height: 5%;
            margin-right: 8px;
        }

        .side-nav {
            height: 100%;
            width: 180px;
            position: fixed;
            z-index: 1;
            top: 93px;
            background-color: #378CE7;
            position: fixed;
        }

        .side-nav a {
            display: block;
            text-decoration: none;
            font-size: 10px;
            font-weight: bold;
            color: #96efff;
            text-align: center;
            background-color: #d9d9d9;
            padding: 15px;
            margin-bottom: 20px;
            color: black;
        }

        .side-nav a:hover {
            color: #3c2bad;
            background-color: white;
        }

        hr {
            border: solid 1px #3c2bad;
        }

        .main-data {
            margin-left: 180px;
            padding: 0px 15px;
            padding-top: 100px;
        }

        .head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 25px;
            color: #3c2bad;
            font-weight: bold;
        }

        .content {
            display: flex;
            align-items: center;
            margin-left: 20px;
            margin-top: 20px;
            justify-content: space-between;
        }

        .navbar {
            display: inline-block;
            align-items: center;
            padding-bottom: 5px;
        }
        
        .search-bar {
            padding: 6px;
            border-radius: 16px;
            margin-top: 5px;
            border-width: 1px;
        }

        .search-btn {
            padding: 6px;
            border-radius: 30px;
            margin-top: 5px;
            background-color: #3C2BAD;
            font-weight: bold;
            color: white;
            margin-left: 8px;
            border-width: 1px;
        }
        
        .buat-akun {
            background-color: #3c2bad;
            color: white;
            font-weight: bold;
            padding: 6px;
            font-size: 15px;
            border-radius: 15px;
            text-decoration: none;
            border: none;
            margin-left: 970px;
        }

        .tambah-akun {
            width: 100%;
            margin-left: 20px;
            margin-bottom: 10px;
        }

        .tambah-akun label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            }

        .tambah-akun input[type="text"],
        .tambah-akun input[type="tel"],
        .tambah-akun input[type="password"],
        .tambah-akun select {
            width: calc(20%);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }

        .tambah-akun button {
            display: block;
            background-color: #3c2bad;
            font-weight: bold;
            cursor: pointer;
            padding: 10px;
            width: 10%;
            transition: background-color 0.3s;
            border-radius: 20px;
            color: white;
        }

        .tambah-akun button:hover {
            background-color: #462bf0;
        }

        .copyright-dashboard {
            background-color: white;
            text-align: center;
            margin-top: 40px;
            color: #3c2bad;
            font-weight: bold;
            margin-left: 181px;
            padding: 2px;
        }
    </style>

  <body>
    <header class="header">
      <img
        src="gambar/WareHouse WSM.png"
        alt="Company Logo"
        class="logo-header"
      />
      <h1 class="title-header">Warehouse Management System</h1>

      <div class="user">
        <img src="gambar/avatar.png" alt="avatar-icon" class="logo-avatar" />
        <h4><?php echo $nama_pengguna; ?></h4>
      </div>
    </header>

    <div class="side-nav">
      <a href="dashboard_admin.php">Dashboard</a>
      <a href="kelola_user.php" style="background-color: white; color: #3c2bad">Kelola User</a>
      <a href="login_admin.php">Log Out</a>
    </div>

    <div class="main-data">
        <div class="head">Buat Akun</div>
        <hr />
        <div class="content">
            <div class="tambah-akun">
                <form action="buat_akun.php" method="post">
                    <label for="id">Id User</label>
                    <input type="text" id="id" name="id_user" required>
                    <label for="nama">Nama User</label>
                    <input type="text" id="nama" name="nama_user" required>
                    <label for="role">Role</label>   
                    <select id="role" name="role" required>
                        <option value="" hidden>Pilih Role</option>
                        <option value="Kepala Gudang">Kepala Gudang</option>
                        <option value="Staff Gudang">Staff Gudang</option>
                    </select>
                    <label for="nomor">No. Telepon</label>
                    <input type="tel" id="nomor" name="nomor" required>
                    <label for="pass">Password</label>
                    <input type="password" id="pass" name="pass" required>
                    <button type="submit">Buat</button>
                </form>
            </div>
        </div>
    </div>
    
    <footer class="copyright-dashboard">
        <p>Copyright &copy; F Production</p>
    </footer>
  </body>
</html>
