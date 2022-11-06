<?php
    session_start();
    error_reporting(0);
    include "database.php";
    include "partials/status_login.php";

    // if($_SESSION['status_level'] == 'siswa'){
    //     echo "<script>alert('Anda tidak memiliki akses');window.location='index.php'</script>";
    // }

    $guru = $_SESSION['status_level'] == 'guru';

    if($guru){
        $mysql = mysqli_query($conn, "SELECT mapel FROM tb_guru WHERE id_guru = '".$_SESSION['user_id']."'");
        $data = mysqli_fetch_assoc($mysql);

        $Gmapel = $data['mapel'];
    }

    if(isset($_POST['nilai-siswa'])){
        $siswa          = $_POST['nama'];
        $mapel          = $guru ? $Gmapel : $_POST['mapel'];
        $pengetahuan    = $_POST['pengetahuan'];
        $keterampilan    = $_POST['keterampilan'];

        $mysql = mysqli_query($conn, "INSERT INTO tb_nilai SET
        id_siswa            = '".$siswa."', 
        mapel               = '".$mapel."', 
        nilai_pengetahuan   = '".$pengetahuan."', 
        nilai_keterampilan  = '".$keterampilan."'
        ");

        if($mysql){
            echo "<script>alert('Data nilai siswa berhasil ditambahkan')</script>";
        } else {
            echo "Error: ".mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Nilai Siswa</title>
</head>
<body>
    <?php include "./partials/navbar.php" ?>
    <div class="container bg-logo">
        <div class="head-content">
            <h2 class="title">Daftar Nilai  <?= $guru ? $Gmapel : 'Siswa' ?></h2>
            <?php if($_SESSION['status_level'] != 'siswa'){ ?>
            <a id="ModalBtn" class="add-data">Tambahkan Data +</a>
            <?php } ?>
            <a href="data-siswa.php" class="add-data btn-red">< Kembali</a>
        </div>
        <form method="POST" autocomplete="off">
            <input name="search" id="search" type="text" list="searchs" placeholder="Cari nama siswa" class="input-search">
            <datalist id="searchs">
            <?php 
                $list = mysqli_query($conn, "SELECT nama FROM tb_nilai LEFT JOIN tb_siswa USING(id_siswa) ORDER BY nama DESC");
                while($s = mysqli_fetch_array($list)){
            ?>
                <option value="<?php  echo $s['nama']?>"></option>
            <?php } ?>
            </datalist>
            <input type="submit" id="btn-search" value="Cari Siswa" class="form-submit">
        </form>
        <div id="content" style="width: 100%; overflow-x: auto;">
            <table class="table" border="1">
                <thead>
                    <tr>
                        <th rowspan="2">Nama</th>
                        <th rowspan="2">Kelas</th>
                        <th rowspan="2">Mata Pelajaran</th>
                        <th width="30%" colspan="2">Nilai</th>
                        <?php if($_SESSION['status_level'] != 'siswa'){ ?>
                        <th width="15%" rowspan="2" colspan="2">Aksi</th>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th>Pengetahuan</th>
                        <th>Keterampilan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $where = $_POST['search'] != '' ? "WHERE nama LIKE '%".$_POST['search']."%' OR mapel LIKE '%".$_POST['search']."%'" : '';
                        if($guru){
                            $where .= "WHERE mapel = '".$Gmapel."'";
                        }
                        $mysql = mysqli_query($conn, "SELECT * FROM tb_nilai LEFT JOIN tb_siswa USING(id_siswa) $where ORDER BY jurusan DESC");

                        if(mysqli_num_rows($mysql)){
                            while($i = mysqli_fetch_array($mysql)){
                    ?>
                    <tr <?php echo ($i['id_siswa'] === $_SESSION['user_id']) ? "style='backdrop-filter: contrast(0.8);'" : "" ?>>
                        <td><?= $i['nama'] ?></td>
                        <td><?= $i['kelas'].' '.$i['jurusan'] ?></td>
                        <td><?= $i['mapel'] ?></td>
                        <td align="center" <?= $i['nilai_pengetahuan'] < 75 ? "class='text-red'" : '' ?>><?= $i['nilai_pengetahuan'] ?></td>
                        <td align="center"<?= $i['nilai_keterampilan'] < 75 ? "class='text-red'" : '' ?>><?= $i['nilai_keterampilan'] ?></td>
                        <?php if($_SESSION['status_level'] != 'siswa'){ ?>
                        <td align="center">
                            <a href="detail-data.php?nilai=<?= $i['id_nilai'] ?>" class="btn-update">Ubah</a>
                        </td>
                        <td align="center">
                            <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini? [<?= $i['nama'] ?>]')" 
                            href="delete-data.php?nilai=<?= $i['id_nilai'] ?>" class="btn-delete">Hapus</a>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php }} else {?>
                        <tr>
                            <td colspan="6" align="center">Not Data Found</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="container">
        <div class="modal" id="myModal">
            <div class="modal-content">
                <div class="container">
                    <div class="title">Tambah data nilai siswa <span class="close">&times;</span></div>
                    <br>
                    <form method="POST" autocomplete="off">
                        <select name="nama" class="input-control" required>
                            <option value="">Pilih nama siswa</option>
                            <?php 
                                $mysql = mysqli_query($conn, "SELECT id_siswa, nama FROM tb_siswa ORDER BY nama");

                                //"[".$a['id_siswa']."] - ".$a['nama'] 

                                if(mysqli_num_rows($mysql)){
                                    while($a = mysqli_fetch_array($mysql)){
                            ?>
                            <option value="<?= $a['id_siswa'] ?>"><?= $a['nama'] ?></option>
                            <?php } } ?>
                        </select>
                        <?php if($_SESSION['status_level'] == 'admin') {?>
                        <select name="mapel" class="input-control" required>
                            <option value="">Pilih Mapel</option>
                            <?php 
                                $mysql = mysqli_query($conn, "SELECT mapel FROM tb_guru GROUP BY mapel ORDER BY mapel");

                                if(mysqli_num_rows($mysql)){
                                    while($a = mysqli_fetch_array($mysql)){
                            ?>
                            <option value="<?= $a['mapel'] ?>"><?= $a['mapel'] ?></option>
                            <?php } } ?>
                        </select>
                        <?php } ?>
                        <!-- <input type="text" name="mapel" placeholder="Mata Pelajaran" class="input-control" required> -->
                        <input type="number" min="1" max="100"name="pengetahuan" placeholder="Nilai Pengetahuan" class="input-control" required>
                        <input type="number" min="1" max="100" name="keterampilan" placeholder="Nilai Keterampilan" class="input-control" required>
                        <input type="submit" name="nilai-siswa" value="Tambah nilai siswa" class="form-submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="styles/modal.js"></script>
</body>
</html>