<?php
  include 'koneksi.php';

    session_start(); // Mulai sesi
    if(isset($_SESSION['user_username'])) { // Periksa apakah pengguna telah login
        $nama_pengguna = $_SESSION['user_username'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_transaksi = $_POST["id_transaksi"];
        $tanggal = $_POST["tanggal_keluar"];
        $id_barang = $_POST["id_barang"];
        $nama_barang = $_POST["nama_barang"];
        $jumlah_keluar = $_POST["jumlah_keluar"];

        // Validasi bahwa semua bidang telah diisi
        if (empty($id_transaksi) || empty($tanggal) || empty($id_barang) || empty($nama_barang) || empty($jumlah_keluar)) {
            echo "Semua bidang harus diisi.";
        } else {
            // Ambil jumlah stok barang yang ada berdasarkan id_barang dari tabel stok barang
            $get_stok_query = "SELECT stok FROM stok_barang WHERE id_barang = '$id_barang'";
            $stok_result = mysqli_query($conn, $get_stok_query);

            // Periksa apakah id_barang ada di tabel stok barang
            if (mysqli_num_rows($stok_result) > 0) {
                $row = mysqli_fetch_assoc($stok_result);
                $jumlah_stok_sekarang = $row['stok'];

                // Hitung jumlah stok baru dengan menambahkan jumlah_masuk ke jumlah_stok_sekarang
                $jumlah_stok_baru = $jumlah_stok_sekarang - $jumlah_keluar;

                // Update jumlah stok barang dalam tabel stok barang dengan jumlah baru
                $update_stok_query = "UPDATE stok_barang SET stok = '$jumlah_stok_baru' WHERE id_barang = '$id_barang'";
                $update_result = mysqli_query($conn, $update_stok_query);

                if ($update_result) {
                    // Jika berhasil update stok barang, lanjutkan dengan proses penambahan data barang masuk
                    // Buat kueri SQL untuk memasukkan data barang masuk ke dalam tabel barang_masuk
                    $sql = "INSERT INTO barang_keluar (id_transaksi, tanggal, id_barang, nama_barang, jumlah_keluar) VALUES ('$id_transaksi', '$tanggal', '$id_barang', '$nama_barang', '$jumlah_keluar')";
                    
                    if (mysqli_query($conn, $sql)) {
                        // Jika penambahan data barang masuk berhasil, redirect ke halaman barang_masuk.php
                        header("Location: barang_keluar.php");
                        exit();
                    } else {
                        // Jika terjadi kesalahan saat menambahkan data barang masuk, tampilkan pesan kesalahan
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                } else {
                    // Jika gagal update stok barang, tampilkan pesan kesalahan
                    echo "Error updating stok: " . mysqli_error($conn);
                }
            } else {
                // Jika id_barang tidak ditemukan di tabel stok barang, tampilkan pesan kesalahan
                echo "ID Barang tidak ditemukan di tabel stok barang.";
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
        .tambah-akun input[type="number"],
        .tambah-akun input[type="date"],
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
            margin-top: 65px;
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
      <a href="dashboard_staff_gudang.php">Dashboard</a>
      <a href="stok_barang.php">Data Barang</a>
      <a href="barang_masuk.php">Barang Masuk</a>
      <a href="barang_keluar.php" style="background-color: white; color: #3c2bad">Barang Keluar</a>
      <a href="login_admin.php">Log Out</a>
    </div>

    <div class="main-data">
        <div class="head">Tambah Data</div>
        <hr />
        <div class="content">
            <div class="tambah-akun">
                <form action="tambah_barang_keluar.php" method="post">
                    <label for="id_transaksi">Id Transaksi</label>
                    <input type="text" id="id" name="id_transaksi" required>
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" id="id" name="tanggal_keluar" required>
                    <label for="id_barang">Id Barang</label>   
                    <select id="id_barang" name="id_barang" required>
                        <?php
                            $sql_id_barang = "SELECT id_barang FROM stok_barang";
                            $result_id_barang = mysqli_query($conn, $sql_id_barang);
                            while($row_id_barang = mysqli_fetch_assoc($result_id_barang)){
                                echo "<option value='" . $row_id_barang['id_barang'] . "'>" . $row_id_barang['id_barang'] . "</option>";
                            }
                        ?>
                    </select>
                    <label for="nama">Nama Barang</label>
                    <select id="nama_barang" name="nama_barang" required></select>
                    <label for="jumlah_masuk">Jumlah Keluar</label>
                    <input type="number" id="jumlah_keluar" name="jumlah_keluar" required>
                    <button type="submit">Tambah</button>
                </form>

                <script>
                    document.getElementById("id_barang").addEventListener("change", function() {
                    var id_barang = this.value;
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var nama_barang = JSON.parse(this.responseText);
                            var select_nama_barang = document.getElementById("nama_barang");
                            select_nama_barang.innerHTML = "";
                            for (var i = 0; i < nama_barang.length; i++) {
                                var option = document.createElement("option");
                                option.value = nama_barang[i];
                                option.text = nama_barang[i];
                                select_nama_barang.appendChild(option);
                            }
                        }
                    };
                    xhr.open("GET", "get_nama_barang.php?id_barang=" + id_barang, true);
                    xhr.send();
                    });
                </script>
            </div>
        </div>
    </div>
    
    <footer class="copyright-dashboard">
        <p>Copyright &copy; F Production</p>
    </footer>
  </body>
</html>
