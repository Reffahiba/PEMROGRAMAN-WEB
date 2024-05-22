<?php
    include 'koneksi.php';

    // Memeriksa apakah ID dikirimkan melalui URL
    if(isset($_GET['id'])) {
        // Mengambil nilai ID dari URL
        $id = $_GET['id'];

        // Menjalankan proses penghapusan data
        $delete = $conn->prepare("DELETE FROM pengguna WHERE id_user=?");
        $delete->bind_param("s", $id);

        // Menjalankan query penghapusan
        if ($delete->execute()) {
            // Redirect kembali ke halaman kelola_user.php jika penghapusan berhasil
            header("Location: kelola_user.php");
            exit();
        } else {
            // Jika terjadi kesalahan dalam penghapusan, tampilkan pesan kesalahan
            echo "Gagal menghapus data.";
        }
    } else {
        // Jika ID tidak tersedia dalam URL, tampilkan pesan kesalahan
        echo "ID tidak ditemukan.";
    }
?>