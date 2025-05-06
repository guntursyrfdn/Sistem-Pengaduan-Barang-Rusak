<?php
session_start();
require "../connection/conn.php";

if (isset($_POST['ubah_laporan'])) {
    $ruangan = $_POST['ruangan'];
    $barang = $_POST['barang'];
    $foto = $_FILES['foto']['name'];
    $foto_old = $_POST['foto_old'];
    $keterangan = $_POST['keterangan'];
    $tanggal = $_POST['tanggal'];
    $id = $_POST['id']; // Add this line if id_laporan is being passed

    // Validation to check if the report already exists for the same date, room, and item

    if ($foto == "") {
        $foto = $foto_old;
    } else {
        $ekstensi_diperbolehkan = array('png', 'jpg'); // Allowed file extensions
        $x = explode('.', $foto); // Separate file name and extension
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['foto']['tmp_name'];
        $nama_foto_baru = $foto;

        if (!in_array($ekstensi, $ekstensi_diperbolehkan)) {
            $msg = "Ekstensi gambar yang boleh hanya jpg atau png";
            header("Location: tambah-laporan.php?success=false&msg=$msg");
            exit();
        }

        move_uploaded_file($file_tmp, 'gambar/' . $nama_foto_baru); // Move file to 'gambar' folder
        $foto = $nama_foto_baru; // Use the new file name for the database
    }
    // Prepare the SQL statement
    $sql = "UPDATE `laporan` SET `ruangan` = ?, `barang` = ?, `foto` = ?, `keterangan` = ?, `tanggal` = ? WHERE `id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $ruangan, $barang, $foto, $keterangan, $tanggal, $id);
    mysqli_stmt_execute($stmt);

    $query = mysqli_stmt_affected_rows($stmt);

    if ($query) {
        $msg = "Laporan berhasil diubah";
        header("Location: index.php?success=true&msg=$msg");
    } else {
        $msg = "Laporan gagal diubah: " . mysqli_error($conn);
        header("Location: index.php?success=false&msg=$msg");
    }
}

?>