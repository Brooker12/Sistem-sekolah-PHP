<?php 
    include "./database.php";
    session_start();
    error_reporting(0);

    $jumlahGuru = mysqli_query($conn, "SELECT COUNT(nama) as JmlGuru FROM tb_guru GROUP BY mapel");
    $mapel = mysqli_query($conn, "SELECT mapel FROM tb_guru GROUP BY mapel");
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
            <h2 class="title">Data Diagram</h2>
            <a href="data-guru.php" class="add-data btn-red">< Kembali</a>
        </div>
        <div class="box">
            <canvas id="DiagramGuru"></canvas>
        </div>
    </div>
    <script>
        const ctx = document.getElementById('DiagramGuru');

        const Dguru = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [ <?php while($a = mysqli_fetch_array($mapel)) { echo '"'.$a['mapel'].'", '; }?> ],
                datasets: [{
                    data: [ <?php while($b = mysqli_fetch_array($jumlahGuru)) { echo '"'.$b['JmlGuru'].'", '; }?> ],
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
                responsive: true,
                title: {
                 display: true,
                 text: 'Diagram Data Guru'   
                }
            }
        })
    </script>
</body>
</html>