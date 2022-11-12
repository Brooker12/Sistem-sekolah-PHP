<?php 
    session_start();
    error_reporting(0);
    include "database.php";
    include "partials/status_login.php";

    if(isset($_POST['tambah-guru'])){
        $nm = $_POST['nama'];
        $nip = $_POST['nip'];
        $jk = $_POST['jk'];
        $mpl = $_POST['mapel'];

        $filename = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $type1 = explode('.', $filename);
        $type2 = $type1[1];
        $image = 'guru'.time().'.'.$type2;

        $fileCard = $_FILES['kartu'];
        $typeCard = explode('.', $fileCard['name']);
        $card = "card".$nip.'.'.$typeCard[1];

        //Ijazah
        $fileIjazah = $_FILES['ijazah'];

        $no = 1;
        $arrIjazah = array();
        foreach ($fileIjazah['name'] as $key => $value) {
            $typeIjazah = explode('.', $fileIjazah['name'][$key]);
            $ijazah = "ijazah".$nip."S".$no++.'.'.$typeIjazah[1];

            move_uploaded_file($fileIjazah['tmp_name'][$key], './images/guru/dokumen/'.$ijazah);
            $arrIjazah[] = $ijazah;
        }

        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if(!in_array($type2, $allowed)){
            echo "<script>alert('File type image not allowed!')</script>";
        } else {
            move_uploaded_file($tmp_name, './images/guru/'.$image);
            move_uploaded_file($fileCard['tmp_name'], './images/guru/kartu/'.$card);

            $insert = mysqli_query($conn, "INSERT INTO tb_guru SET 
            nama = '".$nm."', 
            nip = '".$nip."',
            jenis_kelamin = '".$jk."',
            mapel = '".$mpl."',
            kartu = '".$card."',
            ijazahs1 = '".$arrIjazah[0]."',
            ijazahs2 = '".$arrIjazah[1]."',
            foto = '".$image."'
            ");

            if($insert){
                echo "<script>alert('Data guru berhasil ditambahkan')</script>";
            } else {
                echo "Error: ".mysqli_error($conn);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Guru</title>
    <script src="js/jquery-3.6.1.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <?php include "partials/navbar.php" ?>
    <div class="container bg-logo">
        <div class="head-content">
            <h2 class="title">Table Data Guru <?= $web['nama_sekolah'] ?></h2>
            <?php if($level === "admin"){?>
            <a id="ModalBtn" class="add-data">Tambahkan +</a>
            <?php } ?>
            <a href="diagram-guru.php" class="add-data">Diagram Guru</a>
            <a href="data.php?print=guru" target="_blank" class="add-data">Cetak Data</a>
        </div>
        <form action="data-guru.php" autocomplete="off">
            <input name="search" id="search" type="text" list="searchs" placeholder="Cari nama guru" class="input-search">
            <!-- <datalist id="searchs">
            <?php 
                $list = mysqli_query($conn, "SELECT nama FROM tb_guru ORDER BY nama DESC");
                while($s = mysqli_fetch_array($list)){
            ?>
                <option value="<?php  echo $s['nama']?>"></option>
            <?php } ?> -->
            </datalist>
            <!-- <input type="submit" name="src" id="btn-search" value="Cari Guru" class="form-submit"> -->
        </form>
        <div id="content" style="width: 100%; overflow-x: auto;">
            <table class="table" border="1"> 
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Guru</th>
                        <th>NIP</th>
                        <th>Jenis Kelamin</th>
                        <th>Mata Pelajaran</th>
                        <th>Kartu Vaksin</th>
                        <th>Foto</th>
                        <?php if($level === "admin"){?>
                        <th>Dokumen</th>
                        <th colspan="2" width="10%">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $query = mysqli_query($conn, "SELECT * FROM tb_guru $where ORDER BY nama");

                        if(mysqli_num_rows($query) > 0){
                            $no = 1;
                            while($i = mysqli_fetch_array($query)){
                    ?>
                    <tr <?php echo ($i['id_guru'] === $_SESSION['user_id']) ? "style='backdrop-filter: contrast(0.8);'" : "" ?> >
                        <td align="center"><?php echo $no++ ?></td>
                        <td><?php echo $i['nama'] ?></td>
                        <td><?php echo $i['nip'] ?></td>
                        <td><?php echo $i['jenis_kelamin'] ?></td>
                        <td><?php echo $i['mapel'] ?></td>
                        <td align="center">
                            <a target="_blank" onclick="return confirm('apakah ingin membuka foto ini di tab baru?')" href="images/guru/kartu/<?php echo $i['kartu']?>">
                                <img class="foto" src="images/guru/kartu/<?php echo $i['kartu'] ?>" alt="<?php echo $i['kartu'] ?>">
                            </a>
                        </td>
                        <td align="center">
                            <a target="_blank" onclick="return confirm('apakah ingin membuka foto ini di tab baru?')" href="images/guru/<?php echo $i['foto']?>">
                                <img class="foto" src="images/guru/<?php echo $i['foto'] ?>" alt="<?php echo $i['nama'] ?>">
                            </a>
                        </td>
                        <?php if($level === "admin"){?>
                        <td>
                            <a target="_blank" href="images/guru/dokumen/<?php echo $i['ijazahs1'] ?>" class="document-link">- Ijazah S1</a><br>
                            <a target="_blank" href="images/guru/dokumen/<?php echo $i['ijazahs2'] ?>" class="document-link">- Ijazah S2</a>
                        </td>
                        <td align="center">
                            <a class="btn-update" href="detail-data.php?guru=<?php echo $i['id_guru'] ?>">Ubah</a> | 
                            <a class="btn-delete" href="delete-data.php?guru=<?php echo $i['id_guru'] ?>" 
                            onclick="return confirm('Apakah kamu benar-benar ingin menghapus data ini?\n(<?php echo $i['nama']?>)')">Hapus</a>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php } } else {?>
                        <tr>
                            <td colspan="7" align="center">Tidak ada data guru yang ditemukan</td>
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
                    <div class="title">Tambah data guru <span class="close">&times;</span></div>
                    <br>
                    <form method="POST" autocomplete="off" enctype="multipart/form-data">
                        <input type="text" name="nama" placeholder="Nama" class="input-control" required>
                        <input type="text" name="nip" placeholder="NIP" class="input-control" required>
                        <select name="jk" class="input-control" required>
                            <option value="">Pilih jenis kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <input type="text" name="mapel" placeholder="Mata Pelajaran" class="input-control" required>
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg" required>
                        <label for="foto">Kartu Vaksin</label>
                        <input type="file" name="kartu" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg" required>
                        <label for="foto">Ijazah S1-S2</label>
                        <input type="file" name="ijazah[]" class="input-control">
                        <input type="file" name="ijazah[]" class="input-control">
                        <input type="submit" name="tambah-guru" value="Tambah data Guru" class="form-submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>