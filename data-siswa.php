<?php
    session_start();
    error_reporting(0);
    include "database.php";
    include "partials/status_login.php";

    if(isset($_POST['tambah-siswa'])){
        $nm = $_POST['nama'];
        $nisn = $_POST['nisn'];
        $nis = $_POST['nis'];
        $jk = $_POST['jk'];
        $agama = $_POST['agama'];
        $kls = $_POST['kelas'];
        $jrsn = $_POST['jurusan'];
        $alamat = $_POST['alamat'];

        //Orangtua
        $nm_ortu = $_POST['nm_ortu'];
        $telp_ortu = $_POST['telp_ortu'];

        //FOTO
        $filename = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $type1 = explode('.', $filename);
        $type2 = $type1[1];
        $image = $nm.$nis.'.'.$type2;

        //Kartu
        $fileCard = $_FILES['kartu'];
        $typeCard = explode('.', $fileCard['name']);
        $card = "card".$nisn.$nis.'.'.$typeCard[1];

        //Ijazah
        $fileIjazah = $_FILES['dokumen'];
        $typeIjazah = explode('.', $fileIjazah['name']);
        $ijazah = "ijazah".$nisn.$nis.'.'.$typeIjazah[1];

        //Kartu Keluarga
        $fileKK = $_FILES['kk'];
        $typeKK = explode('.', $fileKK['name']);
        $kk = "kk".$nisn.$nis.'.'.$typeKK[1];

        // $allowed = array('jpg', 'jpeg', 'png', 'gif');

        // $countDocs = count($fileIjazah['name']);
        // var_dump($countDocs);

        // if($countDocs){
            // for($i = 0; $i<$countDocs; $i++){
            //     $dock = explode('.pdf', $fileIjazah['name'][$i]);
            //     var_dump($dock);
            //     // move_uploaded_file($fileIjazah['tmp_name'][$i], './images/siswa/dokumen/'.$ijazah);
            // }
        // }
        move_uploaded_file($tmp_name, './images/siswa/'.$image);
        move_uploaded_file($fileCard['tmp_name'], './images/siswa/kartu/'.$card);
        move_uploaded_file($fileIjazah['tmp_name'], './images/siswa/dokumen/'.$ijazah);
        move_uploaded_file($fileKK['tmp_name'], './images/siswa/dokumen/'.$kk);

        $insert = mysqli_query($conn, "INSERT INTO tb_siswa SET 
        nama            = '".$nm."', 
        nisn            = '".$nisn."', 
        nis             = '".$nis."', 
        nama_ortu       = '$nm_ortu',
        telp_ortu       = '$telp_ortu',
        alamat          = '$alamat',
        jenis_kelamin   = '".$jk."', 
        agama           = '".$agama."', 
        kelas           = '".$kls."', 
        jurusan         = '".$jrsn."',
        ijazah          = '".$ijazah."',
        kartu_keluarga  = '".$kk."',
        foto            = '".$image."',
        kartu           = '".$card."'
        ");

        if($insert){
            echo "<script>alert('Data siswa berhasil ditambahkan')</script>";
        } else {
            echo "Error: ".mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Siswa</title>
    <script src="js/jquery-3.6.1.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <?php include "partials/navbar.php" ?>
    <div class="container bg-logo">
        <div class="head-content">
            <h2 class="title">Table Data Siswa <?= $web['nama_sekolah'] ?></h2>
            <?php if($level != "siswa"){?>
                <?php if($level == "admin"){?>
                <a id="ModalBtn" class="add-data">Tambahkan +</a>
                <?php } ?>
                <a target="_blank" href="data.php?print=siswa" class="add-data">Cetak Data</a>
                <?php } ?>
            <a href="diagram-siswa.php" class="add-data">Diagram Siswa</a>
            <a href="daftar-nilai.php" class="add-data">Daftar Nilai</a>
        </div>
        <form action="data-siswa.php" autocomplete="off">
            <input name="search" id="search" type="text" list="searchs" placeholder="Cari nama siswa" class="input-search">
            <!-- <datalist id="searchs">
            <?php 
                $list = mysqli_query($conn, "SELECT nama FROM tb_siswa ORDER BY nama");
                while($s = mysqli_fetch_array($list)){
            ?>
                <option value="<?php  echo $s['nama']?>"></option>
            <?php } ?> -->
            </datalist>
            <!-- <input type="submit" name="src" id="btn-search" value="Cari Siswa" class="form-submit"> -->
        </form>
        <div id="content" style="width: 100%; overflow-x: auto;">
            <table class="table"> 
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>NIS</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>
                        <th>Nama Orangtua</th> 
                        <th>No.HP Orangtua</th>
                        <th>Agama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Kartu Vaksin</th>
                        <th>Foto</th>
                        <?php if($level === "admin"){?>
                        <th>Dokumen</th>
                        <th style="position: sticky; right: 0; background: #ddd; z-index: 2;">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $query = mysqli_query($conn, "SELECT * FROM tb_siswa $where ORDER BY nama");

                        if(mysqli_num_rows($query) > 0){
                            $no = 1;
                            while($i = mysqli_fetch_array($query)){
                    ?>
                    <tr <?php echo ($i['id_siswa'] === $_SESSION['user_id']) ? "style='backdrop-filter: contrast(0.8);'" : "" ?>>
                        <td align="center"><?php echo $no++ ?></td>
                        <td><?php echo $i['nama'] ?></td>
                        <td><?php echo $i['nisn'] ?></td>
                        <td><?php echo $i['nis'] ?></td>
                        <td><?= $i['alamat']  ?></td>
                        <td><?php echo $i['jenis_kelamin'] ?></td>
                        <td><?= $i['nama_ortu'] ?></td>
                        <td><?= $i['telp_ortu'] ?></td>
                        <td><?php echo $i['agama'] ?></td>
                        <td align="center"><?php echo $i['kelas'] ?></td>
                        <td><?php echo $i['jurusan'] ?></td>
                        <td align="center">
                            <a target="_blank" onclick="return confirm('apakah ingin membuka kartu ini di tab baru?')" href="images/siswa/kartu/<?php echo $i['kartu']?>">
                                <img class="foto" src="images/siswa/kartu/<?php echo $i['kartu']?>" alt="<?php echo $i['kartu'] ?>">
                            </a>
                        </td>
                        <td align="center">
                            <a target="_blank" onclick="return confirm('apakah ingin membuka foto ini di tab baru?')" href="images/siswa/<?php echo $i['foto']?>">
                                <img class="foto" src="images/siswa/<?php echo $i['foto'] ?>" alt="<?php echo $i['nama'] ?>">
                            </a>
                        </td>
                        <?php if($level === "admin"){?>
                        <td>
                            <a class="document-link" target="_blank" href="images/siswa/dokumen/<?php echo $i['ijazah']?>">- Ijazah SMP</a><br>
                            <a class="document-link" target="_blank" href="images/siswa/dokumen/<?php echo $i['kartu_keluarga']?>">- Kartu Keluarga</a>
                        </td>
                        <td align="center" style="position: sticky; right: 0; z-index: 2; background: #efefef;">
                            <a class="btn-update" href="detail-data.php?siswa=<?php echo $i['id_siswa'] ?>">Ubah</a> | 
                            <a class="btn-delete" href="delete-data.php?siswa=<?php echo $i['id_siswa'] ?>" 
                            onclick="return confirm('Apakah kamu benar-benar ingin menghapus data ini?\n(<?php echo $i['nama']?>)')">Hapus</a>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php } } else {?>
                        <tr>
                            <td colspan="10" align="center">Tidak ada data siswa yang ditemukan</td>
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
                    <div class="title">Tambah data siswa <span class="close">&times;</span></div>
                    <br>
                    <form method="POST" autocomplete="off" enctype="multipart/form-data">
                        <input type="text" name="nama" placeholder="Nama" class="input-control" required>
                        <input type="text" name="nisn" placeholder="NISN" class="input-control" required>
                        <input type="text" name="nis" placeholder="NIS" class="input-control" required>
                        <input type="text" name="alamat" placeholder="Alamat" class="input-control" required>
                        <input type="text" name="nm_ortu" placeholder="Nama Orangtua" class="input-control" required>
                        <input type="text" name="telp_ortu" placeholder="No.HP Orangtua" class="input-control" required>
                        <select name="jk" class="input-control" required>
                            <option value="">Pilih jenis kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <select name="agama" class="input-control" required>
                            <option value="">Pilih agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Budha">Budha</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Atheis">Atheis</option>
                        </select>
                        <select name="kelas" class="input-control" required>
                            <option value="">Pilih kelas</option>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                        <select name="jurusan" class="input-control" required>
                            <option value="">Pilih jurusan</option>
                            <option value="RPL">RPL</option>
                            <option value="TKJ">TKJ</option>
                            <option value="Mesin">Mesin</option>
                            <option value="Las">Las</option>
                            <option value="Listrik">Listrik</option>
                            <option value="DPIB">DPIB</option>
                        </select>
                        <label for="dokumen">Ijazah SMP</label>
                        <input type="file" name="dokumen" id="dokumen" class="input-control" accept="application/pdf" required>
                        <label for="kk">Kartu Keluarga</label>
                        <input type="file" name="kk" id="kk" class="input-control" required>
                        <label for="kartu">Kartu Vaksin</label>
                        <input type="file" name="kartu" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg" required>
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg" required>
                        <input type="submit" name="tambah-siswa" value="Tambah data siswa" class="form-submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="styles/modal.js"></script>
</body>
</html>