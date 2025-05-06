<?php
session_start();
require "../connection/conn.php";

$nama = $_POST['nama'];
$tanggal = $_POST['tanggal'];
$ruangan = $_POST['ruangan'];
$barang = $_POST['barang'];
$foto = $_FILES['foto']['name'];
$status = $_POST['status'];
$keterangan = $_POST['keterangan'];
$nim = $_POST['nim'];
$conn = mysqli_connect ("localhost", "root", "", "aduan_invent");

// echo $foto;
// die;

$validation = "SELECT * FROM laporan WHERE tanggal = '$tanggal'";
$cek = mysqli_query($conn, $validation);
$matchFound = false;

foreach ($cek as $data) {
    if ($data['tanggal'] == $tanggal and $data['barang'] == $barang and $data['ruangan'] == $ruangan) {
        $matchFound = true;
        break;
    }
}

if ($foto != "") {
    $ekstensi_diperbolehkan = array('png','jpg'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $foto); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['foto']['tmp_name'];   
    $nama_foto_baru = $foto;
    
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        move_uploaded_file($file_tmp, 'gambar/'.$nama_foto_baru); //memindah file gambar ke folder gambar
        
        if ($matchFound) {
            $msg = "laporan sudah pernah dibuat user lain";
            header("Location: index.php?success=false&msg=$msg");
        } else {
            // Escape the string using prepared statements to prevent SQL injection
            $sql = "INSERT INTO `laporan`(`nama`, `tanggal`, `ruangan`, `barang`, `foto`, `status`, `keterangan`, `nim`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssss", $nama, $tanggal, $ruangan, $barang, $foto, $status, $keterangan, $nim);
            mysqli_stmt_execute($stmt);
            $query = mysqli_stmt_affected_rows($stmt);
        
            if ($query) {
                $msg = "laporan berhasil buat";
                header("Location: index.php?success=true&msg=$msg");
            } else {
                $msg = "laporan gagal dibuat" . mysqli_error($conn);
                header("Location: index.php?success=false&msg=$msg");
            }
        }
    } else {
        $msg = "Ekstensi gambar yang boleh hanya jpg atau png" . mysqli_error($conn);
        header("Location: tambah-laporan.php?success=false&msg=$msg");
    }
} else {

}

?>