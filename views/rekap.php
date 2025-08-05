<?php
include '../function/koneksi.php'; // Menghubungkan dengan file koneksi

// Query untuk menghitung jumlah pengajuan per NIM, termasuk Nama dan Prodi
$sql_count = "SELECT u.nim_nik, u.nama_lengkap AS Nama, u.id_prodi AS Prodi, COUNT(p.nim_nik) AS TotalPengajuan
              FROM pengajuan_usulan p
              JOIN users u ON p.nim_nik = u.nim_nik
              GROUP BY u.nim_nik, u.nama_lengkap, u.id_prodi
              ORDER BY u.nim_nik";

$result_count = $conn->query($sql_count);

// Menyimpan hasil dalam array
$data_count = [];
if ($result_count->num_rows > 0) {
    while ($row = $result_count->fetch_assoc()) {
        $data_count[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rekap Pengajuan</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  
</head>
<body>
<div class="container my-5">
  <h2 class="mb-4">Rekap Jumlah Pengajuan</h2>

  <div class="table-responsive">
    <table id="rekapTable" class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>NIM</th>
          <th>Nama</th>
          <th>Prodi</th>
          <th>Total Pengajuan</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Menampilkan data dari hasil query
        foreach ($data_count as $row) {
            echo "<tr>
                    <td>{$row['nim_nik']}</td>
                    <td>{$row['Nama']}</td>
                    <td>{$row['Prodi']}</td>
                    <td>{$row['TotalPengajuan']}</td>
                  </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
  $(document).ready(function () {
    $('#rekapTable').DataTable({
      "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
      }
    });
  });
</script>
</body>
</html>
