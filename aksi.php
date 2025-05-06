<?php
session_start();
require "./connection/conn.php";
$nim = $_POST['nim'];
$password = $_POST['password'];
$query = "SELECT * FROM `actor` WHERE nim='$nim' && password='$password'";
$login = mysqli_query($conn, $query);
$isLogin = mysqli_num_rows($login);
// var_dump($isLogin);

if (isset($_POST['login'])) {
    if ($isLogin > 0) {
        $data = mysqli_fetch_assoc($login);
        var_dump($data);
        $_SESSION['actor'] = $data;
        if ($data['level'] == 1) {
            $_SESSION['level'] = $data['level'];
            header("Location: admin/index.php");
        } elseif ($data['level'] == 2) {
            $_SESSION['level'] = $data['level'];
            header("Location: unit/index.php");
        } else {
            $_SESSION['level'] = $data['level'];
            header("Location: user/index.php");
        }
    } else {
        $msg = "<p class='alert alert-danger'>User/Password salah... </p>";
        header("Location: index.php?msg=$msg");
        exit;
    }

}
if (isset($_POST['signup'])) {
    //    echo "tombol dubmit ditekan" 
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $profesi = $_POST['profesi'];
    $password = $_POST['password'];

    $query = "INSERT INTO `actor`(`nim`, `nama`, `profesi`, `password`, `level`) VALUES ('$nim','$nama','$profesi','$password','3')";

    if (mysqli_query($conn, $query)) {
        $msg = "Selamat Datang di Web Aduan Kerusakan";
        header("Location: index.php?msg=$msg");
    } else {
        $msg = "data gagal" . mysqli_error($conn);
        header("Location: index.php?msg=$msg");
    }
}
