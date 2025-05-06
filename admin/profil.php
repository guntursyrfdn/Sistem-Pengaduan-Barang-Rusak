<?php
require "layout/top.php";
require "../connection/conn.php";
$nim = $_SESSION['actor']['nim'];
$query = "SELECT * FROM actor WHERE nim = '$nim'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_array($result);
// var_dump($data);
?>
<main  class="card shadow mb-4">
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-4 font-weight-bold">Profil</h1>
    <hr class="my-4">
    <form action="update-profi.php" method="post" enctype="multipart/form-data">
      <div class="mb-3 row">
        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="nama" name="nama" required readonly
            value="<?= $data['nama'] ?>">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="nim" name="nim" required readonly
            value="<?= $data['nim'] ?>">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="profesi" class="col-sm-2 col-form-label">Profesi</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="profesi" name="profesi" required readonly
            value="<?= $data['profesi'] ?>">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="password" name="password" required readonly
            value="<?= $data['password'] ?>">
        </div>
      </div>
      <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-warning mr-2" type="submit" name="ubah_profil">Edit</button>
      </div>
    </form>
  </div>
</main>
<?php
require "layout/footer.php";
?>
<?php
require "layout/bottom.php";
?>
