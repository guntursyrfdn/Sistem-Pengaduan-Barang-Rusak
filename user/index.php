<?php
require "layout/top.php";
require "../connection/conn.php";
$nim = $_SESSION['actor']['nim'];
$query = "SELECT * FROM laporan WHERE nim = '$nim'";
$result = mysqli_query($conn, $query);
// $data = mysqli_fetch_array($result);
// var_dump($data);
?>
<h1 class="mb-2 text-gray-800 font-weight-bold">Daftar Laporan</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-dark">Tabel Daftar Laporan
        </h6>
        <a href="tambah-laporan.php" class="btn btn-primary">Buat Laporan</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id Laporan</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Ruangan</th>
                        <th>Nama Barang</th>
                        <th>Foto Barang</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $angka = 1; ?>
                    <?php foreach ($result as $data): ?>
                        <tr>
                            <td><?= $data['id'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['tanggal'] ?></td>
                            <td><?= $data['ruangan'] ?></td>
                            <td><?= $data['barang'] ?></td>
                            <td><img src="../user/gambar/<?php echo $data['foto']; ?>" style="max-width: 100%;"></td>
                            <td><?php echo (str_word_count($data['keterangan']) > 5) ? implode(' ', array_slice(explode(' ', $data['keterangan']), 0, 5)) . '...' : $data['keterangan']; ?>
                            </td>
                            <td>
                                <?php
                                if ($data['status'] == "Belum Diperbaiki") {
                                    ?>
                                    <span class="badge rounded-pill bg-danger text-white"><?= $data['status'] ?></span>
                                    <?php
                                } else if ($data['status'] == "Sedang Diperbaiki") {
                                    ?>
                                        <span class="badge rounded-pill bg-warning text-white"><?= $data['status'] ?></span>
                                    <?php
                                } else if ($data['status'] == "Sudah Diperbaiki") {
                                    ?>
                                            <span class="badge rounded-pill bg-success text-white"><?= $data['status'] ?></span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td>
                                <a href="./ubah-laporan.php?id=<?= $data['id'] ?>" class="btn btn-warning">Edit</a>
                                <a href="./delete-laporan.php?id=<?= $data['id'] ?>" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <?php $angka++ ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
require "layout/footer.php";
?>
<?php
require "layout/bottom.php";
?>