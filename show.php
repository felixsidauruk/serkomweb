<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>Data Pemesanan Hotel</title>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.html">Hotel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.html">Produk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="daftarharga.html">Daftar Harga</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.html">Tentang Kami</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pesankamar.html">Pesan Kamar</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="show.php">Show Data</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container text-center p-5 mt-5">
  <h3>Data Pemesanan Kamar</h3>
</div>

<!-- Tampilkan Pesan Sukses atau Error -->
<div class="container mt-4">
  <?php if(isset($_GET['status'])): ?>
    <?php if($_GET['status'] == 'success'): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Pesanan berhasil disimpan!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php elseif($_GET['status'] == 'error'): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Terjadi kesalahan saat menyimpan pesanan.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>



<div class="container">
  <table class="table table-bordered mt-3">
    <thead class="thead-dark">
      <tr>
        <th>Nama Pemesan</th>
        <th>Nomor Identitas</th>
        <th>Jenis Kelamin</th>
        <th>Tipe Kamar</th>
        <th>Durasi Menginap</th>
        <th>Diskon</th>
        <th>Total Bayar</th>
      </tr>
    </thead>
    <tbody id="data-table">
      <?php
      // PHP untuk mengambil data dari database
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "hotel_booking";

      // Buat koneksi
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Periksa koneksi
      if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
      }

      $sql = "SELECT * FROM bookings";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>" . $row["nama_pemesan"] . "</td>
                  <td>" . $row["nomor_identitas"] . "</td>
                  <td>" . $row["jenis_kelamin"] . "</td>
                  <td>" . $row["tipe_kamar"] . "</td>
                  <td>" . $row["durasi_menginap"] . "</td>
                  <td>" . $row["diskon"] . "</td>
                  <td>" . $row["total_bayar"] . "</td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
      }

      $conn->close();
      ?>
    </tbody>
  </table>
</div>

<div class="container mt-5">
  <canvas id="bookingChart" width="400" height="600"></canvas>
</div>

<script>
  document.addEventListener('DOMContentLoaded', (event) => {
    let dataRows = document.querySelectorAll('#data-table tr');
    let roomTypes = {
      'Standar': 0,
      'Deluxe': 0,
      'Executif': 0
    };

    dataRows.forEach((row) => {
      let roomType = row.children[3].innerText.trim();
      if (roomTypes.hasOwnProperty(roomType)) {
        roomTypes[roomType]++;
      }
    });

    let labels = Object.keys(roomTypes);

    let standarData = [roomTypes['Standar'], 0, 0];
    let deluxeData = [0, roomTypes['Deluxe'], 0];
    let executifData = [0, 0, roomTypes['Executif']];

    let backgroundColors = [
      'rgba(75, 192, 192, 0.2)', 
      'rgba(255, 159, 64, 0.2)', 
      'rgba(153, 102, 255, 0.2)'
    ];
    let borderColors = [
      'rgba(75, 192, 192, 1)', 
      'rgba(255, 159, 64, 1)', 
      'rgba(153, 102, 255, 1)'
    ];

    new Chart(document.getElementById('bookingChart'), {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Standar',
            data: standarData,
            backgroundColor: backgroundColors[0],
            borderColor: borderColors[0],
            borderWidth: 1
          },
          {
            label: 'Deluxe',
            data: deluxeData,
            backgroundColor: backgroundColors[1],
            borderColor: borderColors[1],
            borderWidth: 1
          },
          {
            label: 'Executif',
            data: executifData,
            backgroundColor: backgroundColors[2],
            borderColor: borderColors[2],
            borderWidth: 1
          }
        ]
      },
      options: {
        scales: {
          x: {
            stacked: true,
            beginAtZero: true,
            title: {
              display: true,
              text: 'Tipe Kamar'
            }
          },
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Jumlah Pemesanan'
            }
          }
        },
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          }
        }
      }
    });
  });
</script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
