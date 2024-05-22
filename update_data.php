<?php
    include 'koneksi.php';

    if(isset($_POST['submit'])){
        $id = $_POST['id_barang'];
        $nama = $_POST['nama_barang'];
        $stok = $_POST['stok'];
        $berat = $_POST['berat'];

        $update = "UPDATE stok_barang SET nama_barang = '$nama', stok = '$stok', berat = '$berat' WHERE id_barang = '$id'";
        if(mysqli_query($conn, $update)){
            header('Location: stok_barang.php');
            exit();
        } else{
            echo "Gagal mengupdate data";
        }
    } else{
        echo "ID tidak ditemukan";
    }
?>