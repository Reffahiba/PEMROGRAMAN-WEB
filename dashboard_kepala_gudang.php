<?php
  include 'koneksi.php';

  session_start(); // Mulai sesi
  if(isset($_SESSION['user_username'])) { // Periksa apakah pengguna telah login
    $nama_pengguna = $_SESSION['user_username'];
  }
  
  // Buat kueri SQL untuk memeriksa keberadaan username di dalam tabel pengguna
    $check_query = "SELECT SUM(stok) AS 'jumlah_stok_barang' FROM stok_barang";
    $check_query2 = "SELECT SUM(jumlah_masuk) AS 'jumlah_barang_masuk' FROM barang_masuk";
    $check_query3 = "SELECT SUM(jumlah_keluar) AS 'jumlah_barang_keluar' FROM barang_keluar";
    
    $result = mysqli_query($conn, $check_query);
    $result2 = mysqli_query($conn, $check_query2);
    $result3 = mysqli_query($conn, $check_query3);

    $row = mysqli_fetch_assoc($result);
    $row2 = mysqli_fetch_assoc($result2);
    $row3 = mysqli_fetch_assoc($result3);

    $jumlah_stok = $row['jumlah_stok_barang'];
    $jumlah_barang_masuk = $row2['jumlah_barang_masuk'];
    $jumlah_barang_keluar = $row3['jumlah_barang_keluar'];
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

      .main-dashboard {
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
        margin-top: 20px;
        justify-content: space-evenly;
      }

      .kotak-satu {
        background-color: #ffffff;
        width: 20%;
        margin-right: 50px;
        color: black;
        margin-left: 10px;
        text-align: left;
      }

      .more-info-satu {
        text-decoration: none;
        background-color: #39adff;
        font: 10px;
        font-weight: bold;
        color: rgb(0, 0, 0);
        width: 100%;
        display: flex;
        text-align: center;
        justify-content: center;
      }

      .text {
        margin-left: 8px; 
      }

      .logo-kotak {
        display: flex;
        align-content: end;
        width: 50%;
        height: 60%;
        padding-left: 80px;
        padding-top: 20px;
        opacity: 40%;
      }

      .wrapper {
        display: flex;
      }

      .copyright-dashboard {
        background-color: white;
        text-align: center;
        margin-top: 309px;
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
      <a href="dashboard_kepala_gudang.php" style="background-color: white; color: #3c2bad">Dashboard</a>
      <a href="melihat_stok_barang.php">Data Barang</a>
      <a href="melihat_barang_masuk.php">Barang Masuk</a>
      <a href="melihat_barang_keluar.php">Barang Keluar</a>
      <a href="login_user.php">Log Out</a>
    </div>

    <div class="main-dashboard">
        <div class="head">Dashboard</div>
        <hr />
        <div class="content">
          <div class="kotak-satu">
            <div class="wrapper">
              <div>
                <h1 class="text"><?php echo $jumlah_stok; ?></h1>
                <h4 class="text">Stok Barang Gudang</h4>
              </div>
              <div>
                <img src="gambar/stok_barang.png" alt="gambar" class="logo-kotak">
              </div>
            </div>
          <a href="melihat_stok_barang.php" class="more-info-satu">More info</a>
          </div>

          <div class="kotak-satu">
            <div class="wrapper">
              <div>
                <h1 class="text"><?php echo $jumlah_barang_masuk; ?></h1>
                <h4 class="text">Stok Barang Masuk</h4>
              </div>
              <div>
                <img src="gambar/barang_masuk.png" alt="gambar" class="logo-kotak">
              </div>
            </div>
          <a href="melihat_barang_masuk.php" class="more-info-satu">More info</a>
          </div>

          <div class="kotak-satu">
            <div class="wrapper">
              <div>
                <h1 class="text"><?php echo $jumlah_barang_keluar; ?></h1>
                <h4 class="text">Stok Barang Keluar</h4>
              </div>
              <div>
                <img src="gambar/barang_keluar.png" alt="gambar" class="logo-kotak">
              </div>
            </div>
          <a href="melihat_barang_keluar.php" class="more-info-satu">More info</a>
          </div>
        </div>
    </div>
    
    <footer class="copyright-dashboard">
        <p>Copyright &copy; F Production</p>
    </footer>
  </body>
</html>
