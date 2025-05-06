<?php
require "../connection/conn.php";
require "layout/top.php";

// Fetch data for the chart
$query = "SELECT * FROM laporan";
$result = mysqli_query($conn, $query);

// Initialize variables to count the items
$jumlah_kursi = $jumlah_meja = $jumlah_AC = $jumlah_proyektor = $jumlah_lampu = $jumlah_lainnya = 0;

while ($row = mysqli_fetch_assoc($result)) {
  switch ($row['barang']) {
    case 'Kursi':
      $jumlah_kursi++;
      break;
    case 'Meja':
      $jumlah_meja++;
      break;
    case 'AC':
      $jumlah_AC++;
      break;
    case 'Proyektor':
      $jumlah_proyektor++;
      break;
    case 'Lampu':
      $jumlah_lampu++;
      break;
    default:
      $jumlah_lainnya++;
      break;
  }
}

$bulan = date('m');
$tahun = date('Y');
$bulanTahun = $bulan . $tahun;
?>
<h1 class="mb-2 text-gray-800 font-weight-bold">Grafik Laporan Kerusakan</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-success">Data Grafik Laporan</h6>
  </div>
  <div class="card-body">
    <!-- Filter Bulan dan Tahun -->
    <form action="chart.php" method="get">
      <div class="mb-3 form-group row">
        <label for="filterYear" class="col-sm-2 col-form-label">Filter per tahun:</label>
        <select class="form-control col-sm-2" style="margin-right: 10px" id="filterYear" name="filterYear">
          <option value="">Pilih Tahun</option>
          <?php
          for ($i = $tahun - 5; $i <= $tahun; $i++) {
            echo '<option value="' . $i . '">' . $i . '</option>';
          }
          ?>
        </select>
        <button class="btn btn-primary" style="height: fit-content" type="submit">Filter</button>
      </div>
    </form>

    <!-- Chart -->
    <div class="chart-bar" style="width: fit-cover; height: fit-content">
      <canvas id="myBarChart"></canvas>
    </div>

    <!-- Tombol Unduh -->
    <button class="btn btn-primary mt-3" onclick="downloadChart()">Unduh Grafik</button>

    <script>
      function generateRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = 'rgba(';
        for (var i = 0; i < 3; i++) {
          color += Math.floor(Math.random() * 256) + ', ';
        }
        // Opasitas (alpha) diset ke 0.5 (50%)
        color += '0.5)';
        return color;
      }

      var labels = ["Kursi", "Meja", "AC", "Proyektor", "Lampu", "Lainnya"];
      var dataValues = [
        <?= $jumlah_kursi ?>,
        <?= $jumlah_meja ?>,
        <?= $jumlah_AC ?>,
        <?= $jumlah_proyektor ?>,
        <?= $jumlah_lampu ?>,
        <?= $jumlah_lainnya ?>
      ];

      var backgroundColor = [];
      var borderColor = [];
      for (var i = 0; i < labels.length; i++) {
        var randomColor = generateRandomColor();
        backgroundColor.push(randomColor);
        // Border color diatur menjadi warna yang sama dengan opasitas 1 (100%)
        borderColor.push(randomColor.replace('0.5', '1'));
      }

      function downloadChart() {
        // Logika untuk mengunduh grafik, misalnya menggunakan Chart.js built-in method
        var url = myChart.toBase64Image();
        var link = document.createElement('a');
        link.href = url;
        link.download = 'chart.png';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      }

      var ctx = document.getElementById("myBarChart").getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: "Jumlah",
            data: dataValues,
            backgroundColor: backgroundColor,
            borderColor: borderColor,
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    </script>

    <hr>
  </div>
</div>

<?php
require "layout/footer.php";
require "layout/bottom.php";
?>