<?php 
    include "./database.php";
    session_start();
    error_reporting(0);

    $jumlahSiswa = mysqli_query($conn, "SELECT COUNT(nama) as JumlahSiswa FROM tb_siswa GROUP BY jurusan");
    $jurusan = mysqli_query($conn, "SELECT jurusan FROM tb_siswa GROUP BY jurusan");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Diagram</title>
    <script src="./charts/Chart.bundle.js"></script>
</head>
<body>
    <?php include "partials/navbar.php" ?>
    <div class="container">
        <div class="head-content">
            <h2 class="title">Data kelas</h2>
            <a href="data-siswa.php" class="add-data btn-red">< Kembali</a>
        </div>
        <div class="box">
            <canvas id="siswa"></canvas>
        </div>
    </div>
    <script>
        const ctx = document.getElementById('siswa');

        const Dsiswa = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [ <?php while($a = mysqli_fetch_array($jurusan)) { echo '"'.$a['jurusan'].'", '; }?> ],
                datasets: [{
                    label: 'Data kelas siswa',
                    data: [ <?php while($b = mysqli_fetch_array($jumlahSiswa)) { echo '"'.$b['JumlahSiswa'].'", '; }?> ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        })
    </script>
</body>
</html>