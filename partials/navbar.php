<?php 
$status_login = $_SESSION['status_login']; 
$level = $_SESSION['status_level'];
$urlname = basename($_SERVER['PHP_SELF']);

$query = mysqli_query($conn, "SELECT * FROM web_config");
$data = mysqli_fetch_assoc($query);
?>
    <nav>
        <a class="logo" href="index.php"><!-- <img src="../images/Logo-SMKN2.png" alt="Logo SMK 2 Makassar" width="30px" height="30px"> -->
        <?= $data['nama_sekolah'] ?> <?= $level ? ucfirst($level) : '' ?></a>
        <ul>
            <?php if($level === "admin" || $level === "guru"){?>
                <li><a <?php echo $urlname == 'data-guru.php' || $_GET['guru'] ? 'class="active"' : '' ?> href="data-guru.php">Data Guru</a></li>
            <?php } ?>
            <?php if(isset($status_login)){ ?>
                <li><a <?php echo $urlname == 'data-siswa.php' || $urlname == 'daftar-nilai.php' || $_GET['nilai'] || $_GET['siswa'] ? 'class="active"' : '' ?> href="data-siswa.php">Data Siswa</a></li>
            <?php } ?>
            <?php if($level === "admin") {?>
                <li><a <?php echo $urlname == 'profil.php' ? 'class="active"' : '' ?> href="profil.php">Pengaturan</a></li>
            <?php } ?>
            <?php if ($status_login !== true) {?>
                <li><a href="login.php">Login</a></li>
            <?php }  else { ?>
                <li><a href="logout.php">Logout</a></li>
            <?php } ?>
        </ul>
    </nav>