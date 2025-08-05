<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Persetujuan</title>
    <link rel="stylesheet" href="styles.css"> <!-- Tambahkan path file CSS jika diperlukan -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .container p {
            color: #555;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .loader {
            border: 6px solid #f3f3f3; /* Light grey */
            border-top: 6px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pengajuan Anda Sedang Diproses</h1>
        <p>Terima kasih telah mengajukan program MBKM. Pengajuan Anda telah berhasil dikirim dan saat ini sedang menunggu persetujuan dari pihak terkait.</p>
        <div class="loader"></div>
        <p>Anda akan menerima pemberitahuan setelah pengajuan Anda disetujui atau ditolak.</p>
        <a href="dashboard-mahasiswa.php" class="btn">Kembali ke Dashboard</a>
    </div>
</body>
</html>
