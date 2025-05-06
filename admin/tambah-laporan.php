<?php
require "../connection/conn.php";
require "layout/top.php";
$query = "SELECT max(id) as maxId FROM laporan";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_array($result);
$maxId = $data['maxId'];
$noUrut = (int) substr($maxId, 3, 3);
$noUrut++;
$char = "J";
$id_jadwal = $char . sprintf("%04s", $noUrut);

$queryPJ = "SELECT * FROM actor";
$resultPJ = mysqli_query($conn, $queryPJ);

$nip = $_SESSION['actor']['nim'];
?>

<main class="card shadow mb-4">
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-4 font-weight-bold">Formulir Laporan Kerusakan </h1>
    <form action="add-laporan.php" method="post" enctype="multipart/form-data" >
      <div class="mb-3">
        <label for="nim" class="form-label">NIM</label>
        <input type="text" class="form-control" id="nim" name="nim" required value="<?= $_SESSION['actor']['nim'] ?>"
          readonly>
      </div>
      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" required value="<?= $_SESSION['actor']['nama'] ?>"
          readonly>
      </div>
      <div class="mb-3">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="tanggal" name="tanggal" readonly required>
      </div>
      <div class="mb-3">
        <label for="ruangan" class="form-label">Ruangan</label>
        <input type="text" class="form-control" id="ruangan" name="ruangan" required placeholder="ex : 3.10">
      </div>
      <div class="mb-3">
        <label for="barang" class="form-label">Barang</label>
        <select class="form-control" id="barang" name="barang">
          <option value="">Pilih Barang</option>
          <option value="Kursi">Kursi</option>
          <option value="Meja">Meja</option>
          <option value="AC">AC</option>
          <option value="Proyektor">Proyektor</option>
          <option value="Lampu">Lampu</option>
          <option value="Lainnya">Lainnya</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="foto" class="form-label">Foto Barang</label>
        <input type="file" class="form-control" id="foto" name="foto" required>
      </div>
      <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea type="text" class="form-control" id="keterangan" name="keterangan" required
          placeholder="Detail Kerusakan"></textarea>
      </div>
      <div class="mb-3">
        <select class="form-select" id="status" name="status" required hidden>
          <option value="Belum Diperbaiki">Belum Diperbaiki</option>
          <option value="Sedang Diperbaiki">Sedang Diperbaiki</option>
          <option value="Sudah Diperbaiki">Sudah Diperbaiki</option>
        </select>
      </div>
      <div class="d-grid gap-2 d-md-block">
        <button class="btn btn-primary" type="submit" name="submit_lap">Kirim</button>
        <button class="btn btn-danger" type="reset">Reset</button>
      </div>
      <script>
        document.addEventListener("DOMContentLoaded", function () {
          var today = new Date();
          var dd = String(today.getDate()).padStart(2, '0');
          var mm = String(today.getMonth() + 1).padStart(2, '0'); // January = 0
          var yyyy = today.getFullYear();
          var formattedDate = yyyy + '-' + mm + '-' + dd;
          document.getElementById('tanggal').value = formattedDate;
        });
      </script>
    </form>
  </div>
</main>
<?php
require "layout/footer.php";
require "layout/bottom.php";
?>