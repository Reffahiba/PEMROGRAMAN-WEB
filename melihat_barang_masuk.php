<?php
  include 'koneksi.php';

    session_start(); // Mulai sesi
    if(isset($_SESSION['user_username'])) { // Periksa apakah pengguna telah login
      $nama_pengguna = $_SESSION['user_username'];
    }

    $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    $query = "SELECT * FROM barang_masuk LIMIT $limit OFFSET $offset";
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

      .main-container{
        display: flex;
        flex-direction: column;
        min-height: 100vh;
      }

      .main-data {
        margin-left: 180px;
        padding: 0px 15px;
        padding-top: 100px;
        flex: 1;
        min-height: calc(100vh - 93px);
        padding-bottom: 60px;
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
        display: flex;
        align-items: center;
        padding-bottom: 5px;
      }

      .search-bar {
        padding: 6px;
        border-radius: 16px;
        margin-top: 5px;
        border-width: 1px;
      }
    
      .tambah-data{
        background-color: #3c2bad;
        color: white;
        font-weight: bold;
        padding: 6px;
        font-size: 15px;
        border-radius: 15px;
        text-decoration: none;
        border: none;
        margin-left: 930px;
      }

      select {
        margin-top: 10px;
        padding: 8px; 
        border: 1px solid #ccc; 
        border-radius: 2px; 
        font-size: 14px;  
      }

      option {
        padding: 8px; 
        font-size: 14px; 
      }

      select:focus {
        outline: none; 
        border-color: #3C2BAD; 
        box-shadow: 0 0 5px rgba(60, 43, 173, 0.5); 
      }

      .table-container{
        margin-top: 30px;
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid white;
        border-radius: 5px;
      }

      .table-container:hover{
        border-color: #999;
      }

      table {
        width: 100%;
        border-collapse: collapse;
      }

      table th, table td {
        padding: 12px;
        text-align: left;
        text-align: center;
      }

      table th {
        background-color: #D9D9D9; 
        color: #333; 
        font-weight: bold;
      }

      table tr:nth-child(even) {
        background-color: #D9D9D9;
      }

      table tr:nth-child(odd) {
        background-color: #f9f9f9;
      }

      /* Hover efek pada baris tabel */
      table tr:hover {
        background-color: white;
      }

      .edit-btn{
        background-color: blue;
        color: white;
        padding: 4px;
        border-radius: 10px;
        cursor: pointer;
      }

      .hapus-btn{
        background-color: red;
        color: white;
        padding: 4px;
        border-radius: 10px;
        cursor: pointer;
      }

      .pagination {
        margin-top: 20px;
      }

      .pagination a {
        display: inline-block;
        padding: 8px 16px;
        margin: 0px 5px;
        background-color: #f9f9f9;
        color: #333;
        text-decoration: none;
        border-radius: 5px;
        margin-bottom: 10px;
      }

      .pagination a:hover {
        background-color: #ccc;
      }

      .pagination a.disabled {
        pointer-events: none;
        background-color: #ddd;
        color: #999;
      }

      #overlay{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); 
        z-index: 9998; 
      }

      #confirmationPopup {
        display: flex;
        position: fixed;
        top: 130px;
        left: 410px;
        width: 50%;
        height: 50%;
        z-index: 9999; 
      }

      .popup-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); 
      }

      .popup-message {
        margin-bottom: 10px;
        font-weight: bold;
        text-align: center;
        color: #378CE7;
      }

      .popup-image-container{
        display: flex;
        justify-content: center; 
        align-items: center; 
        padding-right: 20px;
      }

      .popup-image{
        width: 35%;
        height: 35%;
      }

      .popup-btn {
        padding: 8px 16px;
        margin-right: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        flex-direction: column;
      }

      #confirmBtn {
        background-color: #378CE7; 
        color: white;
        margin-bottom: 20px;
      }

      #cancelBtn {
        color: #378CE7;
        display: flex;
        justify-content: center;
      }

      .copyright-dashboard {
        background-color: white;
        text-align: center;
        color: #3c2bad;
        font-weight: bold;
        margin-left: 181px;
        padding: 10px;
        flex-shrink: 0;
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
      <a href="dashboard_kepala_gudang.php">Dashboard</a>
      <a href="melihat_stok_barang.php">Data Barang</a>
      <a href="melihat_barang_masuk.php" style="background-color: white; color: #3c2bad">Barang Masuk</a>
      <a href="melihat_barang_keluar.php">Barang Keluar</a>
      <a href="login_user.php">Log Out</a>
    </div>

    <div class="main-container">
      <div class="main-data">
          <div class="head">Barang Masuk</div>
          <hr />
          <div class="content">
            <nav class="navbar">
              <input type="text" placeholder="Search..." class="search-bar" name="search" />
              <a href="tambah_barang_masuk.php" class="tambah-data">+ Tambah Data</a>
            </nav>
          </div>

          <br>
          <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option value="?limit=10" <?php echo ($limit == '10') ? 'selected' : ''; ?>>10</option>
            <option value="?limit=25" <?php echo ($limit == '25') ? 'selected' : ''; ?>>25</option>
            <option value="?limit=50" <?php echo ($limit == '50') ? 'selected' : ''; ?>>50</option>
            <option value="?limit=100" <?php echo ($limit == '100') ? 'selected' : ''; ?>>100</option>
          </select>

          <?php
          if(mysqli_num_rows($result) > 0){
          ?>

          <div class="table-container">
            <table>
              <thead>
                <tr>
                    <th>No</th>
                    <th>Id Transaksi</th>
                    <th>Tanggal</th>
                    <th>Id Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Masuk</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $nomor = (($page - 1) * $limit) + 1;
                // Loop melalui setiap baris hasil kueri dan tampilkan data dalam baris tabel
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $nomor ."</td>";
                    echo "<td>" . $row['id_transaksi'] . "</td>";
                    echo "<td>" . $row['tanggal'] . "</td>";
                    echo "<td>" . $row['id_barang'] . "</td>";
                    echo "<td>" . $row['nama_barang'] . "</td>";
                    echo "<td>" . $row['jumlah_masuk'] . "</td>";
                    echo "</tr>";
                    $nomor++;
                  }
                ?>
              </tbody>
            </table>
          </div>

          <?php
          } else{
              echo "<table><tr><th colspan='5'>Barang Tidak Ditemukan</th></tr></table>";   
          }
          ?>

          <div class="pagination">
            <?php if ($page > 1): ?>
              <a href="?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>">Previous</a>
            <?php endif; ?>
            <?php if (mysqli_num_rows($result) == $limit): ?>
              <a href="?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>">Next</a>
            <?php endif; ?>
          </div>
      </div>

      <script>
          $(document).ready(function() {
              $('.search-bar').on('keyup', function() {
                  var value = $(this).val().toLowerCase();
                  $('table tbody tr').filter(function() {
                    var nama_barang = $(this).find('td:eq(4)').text().toLowerCase();
                      $(this).toggle(nama_barang.indexOf(value) > -1);
                  });
              });
          });
      </script>
      
      <footer class="copyright-dashboard">
          <p>Copyright &copy; F Production</p>
      </footer>

    </div>
  </body>
</html>