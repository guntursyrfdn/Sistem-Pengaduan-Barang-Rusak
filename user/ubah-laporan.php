<?php
require "../connection/conn.php";
require "layout/top.php";
if (isset($_SESSION['id_update'])) {
  $id = $_SESSION['id_update'];
} else {
  $id = $_GET['id'];
}

$query = "SELECT * FROM laporan WHERE id='$id' ";
$result = mysqli_query($conn, $query);

if (!$result) {
  echo mysqli_error($conn);
}

$data = mysqli_fetch_assoc($result);
?>
<main  class="card shadow mb-4">
  <div class="container-fluid px-4">
    <h1 class="mt-4 mb-4 font-weight-bold">Ubah Laporan </h1>
    <form action="update-laporan.php" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <input type="text" name="id" id="id" value="<?= $data['id'] ?>" hidden>
        <label for="ruangan" class="form-label">Ruangan</label>
        <input type="text" class="form-control" id="ruangan" name="ruangan" required placeholder="ex : 3.10"
          value="<?= $data['ruangan'] ?>">
      </div>
      <div class="mb-3">
        <label for="barang" class="form-label">Barang</label>
        <select class="form-control" id="barang" name="barang">
          <option value="">Pilih Barang</option>
          <option value="Kursi" <?php if ($data['barang'] == 'Kursi') { echo "selected"; } ?>>Kursi</option>
          <option value="Meja" <?php if ($data['barang'] == 'Meja') { echo "selected"; } ?>>Meja</option>
          <option value="AC" <?php if ($data['barang'] == 'AC') { echo "selected"; } ?>>AC</option>
          <option value="Lampu" <?php if ($data['barang'] == 'Lampu') { echo "selected"; } ?>>Lampu</option>
          <option value="Proyektor" <?php if ($data['barang'] == 'Proyektor') { echo "selected"; } ?>>Proyektor</option>
          <option value="Lainnya" <?php if ($data['barang'] == 'Lainnya') { echo "selected"; } ?>>Lainnya</option>
          <?php
          $queryBarang = "SELECT DISTINCT barang FROM laporan WHERE barang NOT IN ('Kursi', 'Meja', 'AC', 'Lampu', 'Proyektor', 'Lainnya')";
          $resultBarang = mysqli_query($conn, $queryBarang);
          while ($dataBarang = mysqli_fetch_assoc($resultBarang)) {
            echo "<option value='" . $dataBarang['barang'] . "'";
            if ($dataBarang['barang'] == $data['barang']) {
              echo "selected";
            }
            echo ">" . $dataBarang['barang'] . "</option>";
          }
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="foto" class="form-label">Foto Barang</label>
        <div class="input-group">
          <input type="file" class="form-control" id="foto" name="foto">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="view-foto">Lihat Foto Lama</button>
          </div>
        </div>
        <input type="text" class="form-control mt-2" id="foto-view" name="foto" readonly
          value="<?= $data['foto'] ? $data['foto'] : '' ?>" style="display: none;">
      </div>
      <script>
        document.getElementById("view-foto").addEventListener("click", function () {
          var fotoView = document.getElementById("foto-view");
          fotoView.style.display = fotoView.style.display === "none" ? "block" : "none";
        });
      </script>
      <input class="d-none" type="text" id="foto_old" name="foto_old" value="<?= $data['foto'] ?>">
      <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea type="text" class="form-control" id="keterangan" name="keterangan" required
          placeholder="Detail Kerusakan"><?= $data['keterangan'] ?></textarea>
      </div>
      <div class="mb-3" hidden>
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $data['tanggal'] ?>" readonly
          required>
      </div>
      <div class="d-grid gap-2 d-md-block">
        <button class="btn btn-warning" type="submit" name="ubah_laporan">Ubah</button>
        <a class="btn btn-success" href="index.php">Kembali</a>
      </div>
    </form>
  </div>
</main>
<?php
require "layout/footer.php";
require "layout/bottom.php";
?>
