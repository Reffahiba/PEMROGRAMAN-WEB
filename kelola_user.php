<?php
  include 'koneksi.php';

    session_start(); // Mulai sesi
    if(isset($_SESSION['admin_username'])) { // Periksa apakah pengguna telah login
      $nama_pengguna = $_SESSION['admin_username'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $search = $_POST['search'];
      $query = "SELECT * FROM pengguna WHERE nama_user LIKE '%$search%'";
    } else{
      $query = "SELECT * FROM pengguna";
    }

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
        display: flex;
        align-items: center;
        padding-bottom: 5px;
      }
      
      .search-form {
        display: inline-block;
      }

      .search-bar {
        padding: 6px;
        border-radius: 16px;
        margin-top: 5px;
        border-width: 1px;
        width: 60%;
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
        width: 20%;
        cursor: pointer;
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
        margin-left: 950px;
      }

      table {
        margin-top: 30px;
        width: 100%;
        border-collapse: collapse;
      }

      table th, table td {
        padding: 12px;
        text-align: left;
        text-align: center;
        border-bottom: 1px solid #ddd; /* Garis bawah setiap baris */
      }

      table th {
        background-color: #D9D9D9; /* Warna latar belakang untuk sel header */
        color: #333; /* Warna teks untuk sel header */
        font-weight: bold;
      }

      /* Warna latar belakang bergantian untuk setiap baris (baris genap dan ganjil) */
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

      .hapus-btn{
        background-color: red;
        color: white;
        padding: 4px;
        border-radius: 10px;
        cursor: pointer;
      }

      #overlay{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Memberikan efek gelap pada latar belakang */
        z-index: 9998; /* Z-index harus lebih rendah dari popup */
      }

      #confirmationPopup {
        display: flex;
        position: fixed;
        top: 130px;
        left: 410px;
        width: 50%;
        height: 50%;
        z-index: 9999; /* Memastikan popup muncul di atas konten lain */
      }

      .popup-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Efek bayangan untuk tampilan pop-up */
      }

      .popup-message {
        margin-bottom: 10px;
        font-weight: bold;
        text-align: center;
        color: #378CE7;
      }

      .popup-image-container{
        display: flex;
        justify-content: center; /* Memposisikan secara horizontal di tengah */
        align-items: center; /* Memposisikan secara vertikal di tengah */
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
        background-color: #378CE7; /* Warna merah untuk tombol "Ya, Hapus" */
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
        margin-top: 442px;
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
        <div class="head">Kelola User</div>
        <hr />
        <div class="content">
          <nav class="navbar">
            <form action="" method="post" class="search-form">
              <input type="text" placeholder="Search..." class="search-bar" name="search" />
              <button type="submit" class="search-btn">Cari</button>
            </form>
            <a href="buat_akun.php" class="buat-akun">+ Buat Akun</a>
          </nav>
        </div>

        <?php
        if(mysqli_num_rows($result) > 0){
        ?>
        <table>
          <thead>
            <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Role</th>
                <th>No. Telepon</th>
                <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $nomor = 1;
              // Loop melalui setiap baris hasil kueri dan tampilkan data dalam baris tabel
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>" . $nomor ."</td>";
                  echo "<td>" . $row['nama_user'] . "</td>";
                  echo "<td>" . $row['role'] . "</td>";
                  echo "<td>" . $row['no_telepon'] . "</td>";
                  echo "<td><button class='hapus-btn' data-id='" . $row['id_user'] . "' onclick=\"showConfirmation('" . $row['id_user'] . "')\">Hapus</a></button></td>";
                  echo "</tr>";
                  $nomor++;
                }
            ?>
          </tbody>
        </table>

        <div id="overlay"></div>

        <div id="confirmationPopup" class="popup" style="display: none">
            <div class="popup-content">
                <h1 class="popup-message">PERINGATAN!</h1>
                <hr>
                <div class="popup-image-container">
                  <img src="gambar/delete.png" alt="delete-icon" class="popup-image">
                </div>
                <p class="popup-message">APAKAH ANDA YAKIN INGIN MENGHAPUS AKUN?</p>
                <div class="popup-btn">
                    <button class="popup-btn" id="confirmBtn">YA, HAPUS</button>
                    <button class="popup-btn" id="cancelBtn">BATAL</button>
                </div>
            </div>
        </div>

        <script>
            function showConfirmation(userId){
              var confirmationPopup = document.getElementById("confirmationPopup");
              overlay.style.display = 'block';
              confirmationPopup.style.display = 'block';

              var confirmBtn = document.getElementById("confirmBtn");
              var cancelBtn = document.getElementById('cancelBtn');

              confirmBtn.onclick = function(){
                window.location.href = 'hapus_akun.php?id=' + userId;
              };

              cancelBtn.onclick =function(){
                overlay.style.display = 'none';
                confirmationPopup.style.display = 'none';
              };
            }

            document.querySelectorAll('.hapus-btn').forEach(item => {
              item.addEventListener('click', event => {
                event.preventDefault();
                var userId = item.getAttribute('data-id');
                showConfirmation(userId);
              });
            });
        </script>



        <?php
        } else{
            echo "<table><tr><th colspan='5'>User Tidak Ditemukan</th></tr></table>";   
        }
        ?>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $('.search-bar').on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    $('table tbody tr').filter(function() {
                      var nama_user = $(this).find('td:eq(1)').text().toLowerCase();
                        $(this).toggle(nama_user.indexOf(value) > -1);
                    });
                });
            });
        </script>

    </div>
    
    <footer class="copyright-dashboard">
        <p>Copyright &copy; F Production</p>
    </footer>
  </body>
</html>
