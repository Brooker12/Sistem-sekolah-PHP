<?php 
    session_start();
    error_reporting(0);
    include "database.php";
    // include "partials/status_cookie.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - <?= $web['nama_sekolah'] ?></title>
</head>
<body class="bg-sekolah" style="background-image: url(./images/web_config/<?= $web['background'] ?>);">
    <?php include "./partials/navbar.php" ?>
    <!-- <div class="container mt-5">
        <h3>Users Information</h3>
        <div class="box">
            <h4>Login: <?php echo $_SESSION['status_login'] ? "true" : "false" ?></h4>
            <h4>Level: <?php echo  $_SESSION['status_level'] ? $_SESSION['status_level'] : "false"  ?></h4>
            <h4>Name: <?php echo $_SESSION['user_name'] ? $_SESSION['user_name'] : "false" ?></h4>
            <h4>ID: <?php echo  $_SESSION['user_id'] ? $_SESSION['user_id'] : "false"  ?></h4>
            <?php 
                $result = mysqli_query($conn, "SELECT * FROM multiuser WHERE id_user = '".$_SESSION['user_id']."'"); 
                $data = mysqli_fetch_object($result);

                $multiuser = $data > 0 ? "Yes" : "No"
            ?>
            <h4>Multiuser: <?= $multiuser ?></h4>
            <h4>Data: <?php echo $_COOKIE['key'] ? "Cookie" : "Session" ?></h4>
        </div>
    </div> -->
    <div style="height:89%; display: flex; align-items: center; justify-content: center;">
        <div>
            <img src="./images/web_config/<?= $web['logo_sekolah'] ?>" width="280px" alt="Logo <?= $web['nama_sekolah'] ?>">
        </div>
        <div style="color: #fff; padding: 15px; width: 600px">
            <?php if($_SESSION['status_login'] != true) { ?>
            <h1>Selamat Datang di <?= $web['nama_sekolah'] ?></h1>
            <p style="font-size: 20px; color: #efefef">Silahkan masuk untuk mendapatkan informasi lebih</p><br>
            <a class="btn-update" href="login.php" >Masuk sekarang!</a>
            <?php } else {?>
            <h1>Hi, <?= $_SESSION['user_name'] ?> Selamat datang kembali.</h1>
            <h3>Anda telah masuk sebagai <?= $_SESSION['status_level'] ?></h3>
            <?php } ?>
        </div>
    </div>
</body>
</html>