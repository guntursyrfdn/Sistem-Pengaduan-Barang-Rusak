<?php
session_start();
require "../connection/conn.php";

if (isset($_POST['ubah_laporan'])) {
    $status = $_POST['status'];
    $id = $_POST['id'];

    // Prepare the SQL statement
    $sql = "UPDATE `laporan` SET `status` = ? WHERE `id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $id);
    mysqli_stmt_execute($stmt);

    $query = mysqli_stmt_affected_rows($stmt);

    if ($query) {
        $msg = "Status berhasil diubah";
        header("Location: index.php?success=true&msg=$msg");
    } else {
        $msg = "Status gagal diubah: " . mysqli_error($conn);
        header("Location: index.php?success=false&msg=$msg");
    }
}
?>
