<?php
require "../connection/conn.php";
$id = $_GET['id'];

$query = mysqli_query($conn, "DELETE FROM laporan WHERE id = '$id'");
if ($query == 'true') {
    $msg = "jadwal berhasil dihapus";
    header("Location: index.php?success=true&msg=$msg");
} else {
    $msg = "jadwal gagal dihapus" . mysqli_error($conn);
    header("Location: index.php?success=false&msg=$msg");
}