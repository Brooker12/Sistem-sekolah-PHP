<?php  
    session_start();
    error_reporting(0);
    include "database.php";

    $lvl = $_SESSION['status_level'];
    
    if($lvl == "admin" && isset($_GET['siswa'])){
        $data = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE id_siswa = '".$_GET['siswa']."'");
        $title = 'Siswa';

        if(mysqli_num_rows($data) === 0){
            header('location: data-siswa.php');
        } else $a = mysqli_fetch_object($data);

    } else if($lvl == "admin" && isset($_GET['guru'])){
        $data = mysqli_query($conn, "SELECT * FROM tb_guru WHERE id_guru = '".$_GET['guru']."'");
        $title = 'Guru';

        if(mysqli_num_rows($data) === 0){
            header('location: data-guru.php');
        } else $a = mysqli_fetch_object($data);

    } else if($lvl !== "siswa" && isset($_GET['nilai'])){
        $data = mysqli_query($conn, "SELECT * FROM tb_nilai WHERE id_nilai = '".$_GET['nilai']."'");
        $title = "Nilai Siswa";

        $guru = $_SESSION['status_level'] == 'guru';

        if($guru){
            $mysql = mysqli_query($conn, "SELECT mapel FROM tb_guru WHERE id_guru = '".$_SESSION['user_id']."'");
            $assoc = mysqli_fetch_assoc($mysql);
    
            $Gmapel = $assoc['mapel'];
        }

        if(mysqli_num_rows($data) === 0){
            header('location: daftar-nilai.php');
        } else $a = mysqli_fetch_object($data);
    } else {
        echo "<script>alert('Anda tidak memiliki akses');window.location='index.php'</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Detail <?php echo $title ?></title>
</head>
<body>
    <?php include "partials/navbar.php" ?>
    <div class="container">
        <div class="detail-content">
            <!-- <a style="float: right; padding: 10px 15px; margin: 5px 20px; color: #fff; border-radius: 5px; background-color: gray;" 
            href="cetak-data.php?siswa=<?php echo $a->id_siswa?>" target="_blank">Cetak Data Siswa</a> -->
            <!-- <div style="font-size: 23px; padding: 10px 20px; margin-bottom: 10px; font-weight: bold;">Detail <?php echo $title ?></div> -->
            <?php if(isset($_GET['nilai'])) {?>            
            <div class="head-content mlr-10">
                <h2 class="title">Nilai Siswa</h2>
                <a href="daftar-nilai.php" class="add-data btn-red">< Kembali</a>
            </div>
            <hr>
            <form method="POST" autocomplete="off">
                <table class="tb-data" border="0">
                    <tr>
                        <td>Pilih Siswa</td>
                        <td>:</td>
                        <td>
                            <select name="nama" required>
                                <option value="">Pilih nama siswa</option>
                                <?php 
                                    $mysql = mysqli_query($conn, "SELECT id_siswa, nama FROM tb_siswa ORDER BY nama DESC");

                                    if(mysqli_num_rows($mysql)){
                                        while($i = mysqli_fetch_array($mysql)){
                                ?>
                                <option <?= $a->id_siswa == $i['id_siswa'] ? 'selected' : '' ?> value="<?= $i['id_siswa'] ?>"><?= "[".$i['id_siswa']."] - ".$i['nama'] ?></option>
                                <?php } } ?>
                            </select>
                        </td>
                    </tr>
                    <?php if($_SESSION['status_level'] == 'admin') {?>
                    <tr>
                        <td>Mata Pelajaran</td>
                        <td>:</td>
                        <td>
                        <select name="mapel" required>
                            <option value="">Pilih Mapel</option>
                            <?php 
                                $mysql = mysqli_query($conn, "SELECT mapel FROM tb_guru GROUP BY mapel ORDER BY mapel");

                                if(mysqli_num_rows($mysql)){
                                    while($c = mysqli_fetch_array($mysql)){
                            ?>
                            <option <?= $a->mapel == $c['mapel'] ? 'selected' : '' ?>  value="<?= $c['mapel'] ?>"><?= $c['mapel'] ?></option>
                            <?php } } ?>
                        </select>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>Nilai Pengetahuan</td>
                        <td>:</td>
                        <td><input type="number" min="1" max="100" name="pengetahuan" placeholder="Nilai Pengetahuan" value="<?= $a->nilai_pengetahuan ?>" required></td>
                    </tr>
                    <tr>
                        <td>Nilai Keterampilan</td>
                        <td>:</td>
                        <td> <input type="number" min="1" max="100" name="keterampilan" placeholder="Nilai Keterampilan" value="<?= $a->nilai_keterampilan ?>" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><input type="submit" value="Perbaharui nilai siswa" name="nilai-siswa" class="form-submit"></td>
                    </tr>
                </table>
            </form>
            <?php 
                if(isset($_POST['nilai-siswa'])){
                    $siswa          = $_POST['nama'];
                    $mapel          = $guru ? $Gmapel : $_POST['mapel'];
                    $pengetahuan    = $_POST['pengetahuan'];
                    $keterampilan    = $_POST['keterampilan'];
            
                    $mysql = mysqli_query($conn, "UPDATE tb_nilai SET
                    id_siswa            = '".$siswa."', 
                    mapel               = '".$mapel."', 
                    nilai_pengetahuan   = '".$pengetahuan."', 
                    nilai_keterampilan  = '".$keterampilan."'
                    WHERE id_nilai = '".$a->id_nilai."'
                    ");

                    if($mysql){
                        echo "<script>alert('Data nilai siswa berhasil diubah');window.location='daftar-nilai.php'</script>";
                    } else {
                        echo "Error: ".mysqli_error($conn);
                    }
                }
            } ?>
            <?php if(isset($_GET['siswa'])) {?>
            <div class="head-content mlr-10">
                <h2 class="title">Detail Siswa</h2>
                <a href="data-siswa.php" class="add-data btn-red">< Kembali</a>
            </div><hr>
            <form method="POST" enctype="multipart/form-data">
                <table class="tb-data" border="0">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nama" placeholder="Nama" value="<?php echo $a->nama ?>" required>
                        </td>
                        <!-- <td rowspan="2">
                            <img width="130px" src="images/siswa/<?php echo $a->foto?>" alt="<?php echo $a->foto?>">
                        </td> -->
                        <!-- <td width="10%">NISN</td>
                        <td>:</td>
                        <td><input type="text" name="nisn" placeholder="NISN" value="<?php echo $a->nisn?>" required></td> -->
                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td>:</td>
                        <td><input type="text" name="nisn" placeholder="NISN" value="<?php echo $a->nisn?>" required></td>
                    </tr>
                    <tr>
                        <td>NIS</td>
                        <td>:</td>
                        <td><input type="text" name="nis" placeholder="NIS" value="<?php echo $a->nis?>" required></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><input type="text" name="alamat" placeholder="Alamat" value="<?php echo $a->alamat?>" required></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>
                            <select name="jk" required>
                                <option value="">Pilih jenis kelamin</option>
                                <option <?php echo $a->jenis_kelamin === 'Laki-laki' ? "selected" : "" ?> value="Laki-laki">Laki-laki</option>
                                <option <?php echo $a->jenis_kelamin === 'Perempuan' ? "selected" : "" ?> value="Perempuan">Perempuan</option>
                            </select>
                        </td>
                        <!-- <td rowspan="2">
                            <img width="130px" src="images/siswa/kartu/<?php echo $a->kartu?>" alt="<?php echo $a->kartu?>">
                        </td> -->
                    </tr>
                    <tr>
                        <td>Nama Orangtua</td>
                        <td>:</td>
                        <td><input type="text" name="nm_ortu" placeholder="Nama Orangtua" value="<?php echo $a->nama_ortu?>" required></td>
                    </tr>
                    <tr>
                        <td>No.HP Orangtua</td>
                        <td>:</td>
                        <td><input type="text" name="telp_ortu" placeholder="No.HP Orangtua" value="<?php echo $a->telp_ortu?>" required></td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                        <td>
                            <select name="agama" required>
                                <option value="">Pilih agama</option>
                                <option <?php echo $a->agama == 'Islam' ? "selected" : "" ?> value="Islam">Islam</option>
                                <option <?php echo $a->agama == 'Kristen' ? "selected" : "" ?> value="Kristen">Kristen</option>
                                <option <?php echo $a->agama == 'Budha' ? "selected" : "" ?> value="Budha">Budha</option>
                                <option <?php echo $a->agama == 'Hindu' ? "selected" : "" ?> value="Hindu">Hindu</option>
                                <option <?php echo $a->agama == 'Atheis' ? "selected" : "" ?> value="Atheis">Atheis</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td>
                            <select name="kelas" required>
                                <option value="">Pilih kelas</option>
                                <option <?php echo $a->kelas == 'X' ? "selected" : "" ?> value="X">X</option>
                                <option <?php echo $a->kelas == 'XI' ? "selected" : "" ?> value="XI">XI</option>
                                <option <?php echo $a->kelas == 'XII' ? "selected" : "" ?> value="XII">XII</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Jurusan</td>
                        <td>:</td>
                        <td>
                            <select name="jurusan" required>
                                <option value="">Pilih jurusan</option>
                                <option <?php echo $a->jurusan === 'RPL' ? "selected" : "" ?> value="RPL">RPL</option>
                                <option <?php echo $a->jurusan === 'TKJ' ? "selected" : "" ?> value="TKJ">TKJ</option>
                                <option <?php echo $a->jurusan === 'Mesin' ? "selected" : "" ?> value="Mesin">Mesin</option>
                                <option <?php echo $a->jurusan === 'Las' ? "selected" : "" ?> value="Las">Las</option>
                                <option <?php echo $a->jurusan === 'Listrik' ? "selected" : "" ?> value="Listrik">Listrik</option>
                                <option <?php echo $a->jurusan === 'DPIB' ? "selected" : "" ?> value="DPIB">DPIB</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Ijazah SMP [<a href="images/siswa/dokumen/<?php echo $a->ijazah ?>"><?php echo $a->ijazah ?></a> ]</td>
                        <input type="hidden" name="Hijazah" value="<?php echo $a->ijazah?>">
                        <td>:</td>
                        <td>
                            <input type="file" name="ijazah" accept="application/pdf">
                        </td>
                    </tr>
                    <tr>
                        <td>Kartu Keluarga [<a href="images/siswa/dokumen/<?php echo $a->kartu_keluarga ?>"><?php echo $a->kartu_keluarga ?></a> ]</td>
                        <input type="hidden" name="Hkk" value="<?php echo $a->kartu_keluarga?>">
                        <td>:</td>
                        <td>
                            <input type="file" name="kk">
                        </td>
                    </tr>
                    <tr>
                        <td>Kartu Vaksin [<a target="_blank" href="images/siswa/kartu/<?php echo $a->kartu ?>"><?php echo $a->kartu ?></a>]</td>
                        <input type="hidden" name="Hkartu" value="<?php echo $a->kartu?>">
                        <td>:</td>
                        <td>
                            <input type="file" name="kartu" accept="image/png, image/jpg, image/gif, image/jpeg">
                        </td>
                    </tr>
                    <tr>
                        <td>Foto [<a target="_blank" href="images/siswa/<?php echo $a->foto ?>"><?php echo $a->foto ?></a>]</td>
                        <input type="hidden" name="gambar" value="<?php echo $a->foto?>">
                        <td>:</td>
                        <td>
                            <input type="file" name="foto" accept="image/png, image/jpg, image/gif, image/jpeg">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><input type="submit" value="Perbaharui data siswa" name="update-siswa" class="form-submit"></td>
                    </tr>
                </table>
            </form>
            <?php
                if(isset($_POST['update-siswa'])){
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

                    //Update FOTO
                    $gmbr = $_POST['gambar'];
                    $filename = $_FILES['foto']['name'];
                    $tmp_name = $_FILES['foto']['tmp_name'];

                    if($filename != '') {
                        $type1 = explode('.', $filename);
                        $type2 = $type1[1];
                        $image = $nm.$nis.'.'.$type2;
                        
                        unlink('./images/siswa/'.$gmbr);
                        move_uploaded_file($tmp_name, './images/siswa/'.$image);
                        $foto = $image;
                    } else {
                        $foto = $gmbr;
                    } 
                    
                    //Update Kartu Vaksin
                    $fileCard = $_FILES['kartu'];
                    $kartu = $_POST['Hkartu'];

                    if($fileCard['name'] != ''){
                        $typeCard = explode('.', $fileCard['name']);
                        $card = "card".$nisn.$nis.'.'.$typeCard[1];

                        unlink('./images/siswa/kartu/'.$kartu);
                        move_uploaded_file($fileCard['tmp_name'], './images/siswa/kartu/'.$card);
                        $Ckartu = $card;
                    } else {
                        $Ckartu = $kartu;
                    }
            
                    //Update Ijazah
                    $fileDocs = $_FILES['ijazah'];
                    $ijazah = $_POST['Hijazah'];

                    if($fileDocs['name'] != ''){
                        $typeDocs = explode('.', $fileDocs['name']);
                        $docs = "ijazah".$nisn.$nis.'.'.$typeDocs[1];

                        unlink('./images/siswa/dokumen/'.$ijazah);
                        move_uploaded_file($fileDocs['tmp_name'], './images/siswa/dokumen/'.$docs);
                        $docts = $docs;
                    } else {
                        $docts = $ijazah;
                    }

                    //Update Kartu Keluarga
                    $fileKK = $_FILES['kk']; 
                    $kk = $_POST['Hkk'];

                    if($fileKK['name'] != ''){
                        $typeKK = explode('.', $fileKK['name']);
                        $kartuK = "kk".$nisn.$nis.'.'.$typeKK[1];

                        unlink('./images/siswa/dokumen/'.$kk);
                        move_uploaded_file($fileKK['tmp_name'], './images/siswa/dokumen/'.$kartuK);
                        $kartuKeluarga = $kartuK;
                    } else {
                        $kartuKeluarga = $kk;
                    }

                    $insert = mysqli_query($conn, "UPDATE tb_siswa SET 
                    nama            = '".$nm."', 
                    nisn            = '".$nisn."', 
                    nis             = '".$nis."', 
                    jenis_kelamin   = '".$jk."', 
                    nama_ortu       = '$nm_ortu',
                    telp_ortu       = '$telp_ortu',
                    alamat          = '$alamat',
                    agama           = '".$agama."', 
                    kelas           = '".$kls."', 
                    jurusan         = '".$jrsn."',
                    ijazah          = '".$docts."',
                    kartu_keluarga  = '".$kartuKeluarga."',
                    foto            = '".$foto."',
                    kartu           = '".$Ckartu."'
                    WHERE id_siswa = '".$a->id_siswa."'
                    ");
            
                    if($insert){
                        echo "<script>alert('Data siswa berhasil diperbaharui')</script>";
                        echo "<script>window.location='data-siswa.php'</script>";
                    } else {
                        echo "Error: ".mysqli_error($conn);
                    }
                }
            }?>
            <?php if(isset($_GET['guru'])) {?>
            <div class="head-content mlr-10">
                <h2 class="title">Detail Guru</h2>
                <a href="data-guru.php" class="add-data btn-red">< Kembali</a>
            </div><hr>
            <form method="POST" enctype="multipart/form-data">
                <table class="tb-data">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><input type="text" name="nama" placeholder="Nama" value="<?php echo $a->nama?>" required></td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td><input type="text" name="nip" placeholder="NIP" value="<?php echo $a->nip?>" required></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>
                            <select name="jk" required>
                                <option value="">Pilih jenis kelamin</option>
                                <option <?php echo $a->jenis_kelamin == 'Laki-laki' ? "selected" : "" ?> value="Laki-laki">Laki-laki</option>
                                <option <?php echo $a->jenis_kelamin == 'Perempuan' ? "selected" : "" ?> value="Perempuan">Perempuan</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Mata Pelajaran</td>
                        <td>:</td>
                        <td><input type="text" id="mapel" name="mapel" placeholder="Mata Pelajaran" value="<?php echo $a->mapel?>" required></td>
                    </tr>
                    <tr>
                        <td>Ijazah S1 [<a target="_blank" href="images/guru/dokumen/<?php echo $a->ijazahs1?>"><?php echo $a->ijazahs1?></a>]</td>
                        <input type="hidden" name="Hijazahs1" value="<?php echo $a->ijazahs1?>">
                        <td>:</td>
                        <td><input type="file" name="ijazahs1" accept="application/pdf"></td>
                    </tr>
                    <tr>
                        <td>Ijazah S2 [<a target="_blank" href="images/guru/dokumen/<?php echo $a->ijazahs2?>"><?php echo $a->ijazahs2?></a>]</td>
                        <input type="hidden" name="Hijazahs2" value="<?php echo $a->ijazahs2?>">
                        <td>:</td>
                        <td><input type="file" name="ijazahs2" accept="application/pdf"></td>
                    </tr>
                    <tr>
                        <td>Kartu Vaksin [<a target="_blank" href="images/guru/kartu/<?php echo $a->kartu?>"><?php echo $a->kartu?></a>]</td>
                        <input type="hidden" name="kartu" value="<?php echo $a->kartu?>">
                        <td>:</td>
                        <td><input type="file" name="card" accept="image/png, image/jpg, image/gif, image/jpeg"></td>
                    </tr>
                    <tr>
                        <td>Foto [<a target="_blank" href="images/guru/<?php echo $a->foto?>"><?php echo $a->foto?></a>]</td>
                        <input type="hidden" name="gambar" value="<?php echo $a->foto?>">
                        <td>:</td>
                        <td><input type="file" name="foto" accept="image/png, image/jpg, image/gif, image/jpeg"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><input type="submit" value="Perbaharui data guru" name="update-guru" class="form-submit"></td>
                    </tr>
                </table>
                <br><br>
            </form>
            <form method="POST" autocomplete="off">
                <div style="font-size: 23px; padding: 10px 20px; margin-bottom: 10px; font-weight: bold;">Informasi Pengguna</div>
                <hr>
                <table class="tb-data">
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td><input type="text" name="user" placeholder="Username" value="<?php echo $a->username?>" required></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td><input type="password" name="pass1" placeholder="Password" required></td>
                    </tr>
                    <tr>
                        <td>Ulangi Password</td>
                        <td>:</td>
                        <td><input type="password" name="pass2" placeholder="Ulangi Password" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><input type="submit" value="Save Data" name="ganti-password" class="form-submit"></td>
                    </tr>
                </table>
            </form>
            <?php 
                    if($_POST['update-guru']){
                        $nm = $_POST['nama'];
                        $nip = $_POST['nip'];
                        $jk = $_POST['jk'];
                        $mpl = $_POST['mapel'];

                        //FOTO
                        $filename = $_FILES['foto']['name'];
                        $tmp_name = $_FILES['foto']['tmp_name'];
                        $gmbr = $_POST['gambar'];

                        if($filename != ''){
                            $type1 = explode('.', $filename);
                            $type2 = $type1[1];
    
                            $image = 'guru'.time().'.'.$type2;
    
                            $allowed = array('jpg', 'jpeg', 'png', 'gif');
    
                            if(!in_array($type2, $allowed)){
                                echo "<script>alert('File type image not allowed')</script>";
                            } else {
                                unlink('./images/guru/'.$gmbr);
                                move_uploaded_file($tmp_name, './images/guru/'.$image);
                                $foto = $image;
                            }
                        } else {
                            $foto = $gmbr;
                        }

                        //Kartu Vaksin
                        $fileCard = $_FILES['card'];
                        $kartu = $_POST['kartu'];

                        if($fileCard['name'] != ''){
                            $typeCard = explode('.', $fileCard['name']);
                            $card = "card".$nip.'.'.$typeCard[1];
    
                            unlink('./images/guru/kartu/'.$kartu);
                            move_uploaded_file($fileCard['tmp_name'], './images/guru/kartu/'.$card);
                            $Ckartu = $card;
                        } else {
                            $Ckartu = $kartu;
                        }

                        //IJAZAH S1
                        $fileIjazahs1 = $_FILES['ijazahs1'];
                        $HS1 = $_POST['Hijazahs1'];

                        if($fileIjazahs1['name'] != ''){
                            $typeS1 = explode('.', $fileIjazahs1['name']);
                            $S1 = "ijazah".$nip."S1".'.'.$typeS1[1];

                            unlink('./images/guru/dokumen/'.$HS1);
                            move_uploaded_file($fileIjazahs1['tmp_name'], './images/guru/dokumen/'.$S1);
                            $ijazahS1 = $S1;
                        } else {
                            $ijazahS1 = $HS1;
                        }

                        //IJAZAH S2
                        $fileIjazahS2 = $_FILES['ijazahs2'];
                        $HS2 = $_POST['Hijazahs2'];

                        if($fileIjazahS2['name'] != ''){
                            $typeS2 = explode('.', $fileIjazahS2['name']);
                            $S2 = "ijazah".$nip."S2".'.'.$typeS2[1];

                            unlink('./images/guru/dokumen/'.$HS2);
                            move_uploaded_file($fileIjazahS2['tmp_name'], './images/guru/dokumen/'.$S2);
                            $ijazahS2 = $S2;
                        } else {
                            $ijazahS2 = $HS2;
                        }

                        $insert = mysqli_query($conn, "UPDATE tb_guru SET 
                        nama = '".$nm."', 
                        nip = '".$nip."',
                        jenis_kelamin = '".$jk."',
                        mapel = '".$mpl."',
                        kartu = '".$Ckartu."',
                        ijazahs1 = '".$ijazahS1."',
                        ijazahs2 = '".$ijazahS2."',
                        foto = '".$foto."'
                        WHERE id_guru = '".$a->id_guru."'
                        ");
                
                        if($insert){
                            echo "<script>alert('Data guru berhasil diperbaharui')</script>";
                            echo "<script>window.location='data-guru.php'</script>";
                        } else {
                            echo "Error: ".mysqli_error($conn);
                        }
                    } else if($_POST['ganti-password']){
                        $user  = $_POST['user'];
                        $pass1 = $_POST['pass1'];
                        $pass2 = $_POST['pass2'];

                        if($pass1 !== $pass2){
                            echo "<script>alert('Perulangan Password telah salah!')</script>";
                        } else {
                            $changePass = mysqli_query($conn, "UPDATE tb_guru SET
                            username = '".$user."',
                            password = '".MD5($pass1)."'
                            WHERE id_guru = '".$a->id_guru."'");
    
                            if($changePass){
                                echo "<script>alert('Password berhasil diperbaharui')</script>";
                                echo "<script>window.location='data-guru.php'</script>";
                            } else {
                                echo "Error: ".mysqli_error($conn);
                            }
                        }
                    }
                } ?>
        </div>
    </div>
    <br><br>
</body>
</html>