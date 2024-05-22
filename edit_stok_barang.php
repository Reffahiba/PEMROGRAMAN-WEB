<?php
  include 'koneksi.php';

    session_start(); // Mulai sesi
    if(isset($_SESSION['user_username'])) { // Periksa apakah pengguna telah login
        $nama_pengguna = $_SESSION['user_username'];
    }
    
    $id = $_GET['id_barang'];
    $query = "SELECT * FROM stok_barang WHERE id_barang = '$id'";
    $result = mysqli_query($conn, $query);
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

        .edit-barang {
            width: 100%;
            margin-left: 20px;
            margin-bottom: 10px;
        }

        .edit-barang label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            }

        .edit-barang input[type="text"],
        .edit-barang input[type="number"],
        .edit-barang input[type="password"] {
            width: calc(20%);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        /* .edit-barang button {
            display: inline;
            background-color: #3c2bad;
            font-weight: bold;
            cursor: pointer;
            padding: 10px;
            width: 10%;
            transition: background-color 0.3s;
            border-radius: 20px;
            color: white;
            margin-bottom: 20px;
        } */

        .btn-edit{
            display: flex;
        }

        .edit-btn{
            background-color: #3c2bad;
            cursor: pointer;
            padding: 8px;
            margin-right: 2px;
            width: 10%;
            font-size: 14px;
            color: white;
            font-weight: bold;
            border-radius: 20px;
        }

        .batal-btn{
            background-color: red;
            cursor: pointer;
            padding: 8px;
            margin-left: 2px;
            font-size: 14px;
            width: 9%;
            font-weight: bold;
            border-radius: 20px;
            text-decoration: none;
            color: white;
            text-align: center;
        }
        
        .edit-btn:hover {
            background-color: #462bf0;
        }

        .batal-btn:hover{
            background-color: #FF6500;
        }

        .copyright-dashboard {
            background-color: white;
            text-align: center;
            margin-top: 68px;
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
      <a href="dashboard_user.php">Dashboard</a>
      <a href="stok_barang.php" style="background-color: white; color: #3c2bad">Data Barang</a>
      <a href="barang_masuk.php">Barang Masuk</a>
      <a href="barang_keluar.php">Barang Keluar</a>
      <a href="login_admin.php">Log Out</a>
    </div>

    <div class="main-data">
        <div class="head">Edit Data</div>
        <hr />
        <div class="content">
            <div class="edit-barang">
                <?php 
                    while($row = mysqli_fetch_assoc($result)){
                ?>
                    <form action="update_data.php" method="post">
                        <label for="id">Id Barang</label>
                        <input type="text" id="id" name="id_barang" value="<?php echo $row['id_barang'] ?>" readonly>
                        <label for="nama">Nama Barang</label>
                        <input type="text" id="nama" name="nama_barang" value="<?php echo $row['nama_barang'] ?>" required>
                        <label for="stok">Stok</label>
                        <input type="number" id="stok" name="stok" value="<?php echo $row['stok'] ?>" required>
                        <label for="berat">Berat</label>
                        <input type="text" id="berat" name="berat" value="<?php echo $row['berat'] ?>" required>
                        <div class="btn-edit">
                            <button class="edit-btn" type="submit" name="submit">Edit</button>
                            <a href="stok_barang.php" class="batal-btn">Batal</a>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
    
    <footer class="copyright-dashboard">
        <p>Copyright &copy; F Production</p>
    </footer>
  </body>
</html>
