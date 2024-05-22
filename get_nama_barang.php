<?php
include 'koneksi.php';

if (isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];
    $sql_nama_barang = "SELECT nama_barang FROM stok_barang WHERE id_barang = '$id_barang'";
    $result_nama_barang = mysqli_query($conn, $sql_nama_barang);
    $nama_barang = array();
    while ($row_nama_barang = mysqli_fetch_assoc($result_nama_barang)) {
        $nama_barang[] = $row_nama_barang['nama_barang'];
    }
    echo json_encode($nama_barang);
}
?>
