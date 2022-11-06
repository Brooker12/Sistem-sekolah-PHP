<?php 
    session_start();
    error_reporting(0);
    include "database.php";
    include "partials/admin_only.php";

    if(isset($_GET['siswa'])){
        $data = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE id_siswa = '".$_GET['siswa']."'");
        $title = 'Siswa';

        if(mysqli_num_rows($data) === 0){
            header('location: data-siswa.php');
        } else $a = mysqli_fetch_object($data);

    } else if(isset($_GET['guru'])){
        $data = mysqli_query($conn, "SELECT * FROM tb_guru WHERE id_guru = '".$_GET['guru']."'");
        $title = 'Guru';

        if(mysqli_num_rows($data) === 0){
            header('location: data-guru.php');
        } else $a = mysqli_fetch_object($data);

    } else if(isset($_GET['nilai'])){
        $data = mysqli_query($conn, "SELECT * FROM tb_nilai WHERE id_nilai = '".$_GET['nilai']."'");
        $title = "Nilai Siswa";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data <?php echo $title ?></title>
</head>
<body>
    <?php include "partials/navbar.php" ?>
    <div class="container">
        <h1 class="title">Detail Data <?php echo $title ?></h1>
        <?php if(isset($_GET['siswa'])){?>
            <form method="POST" enctype="multipart/form-data" autocomplete="off">
                <table class="table-form">
                    <tr>
                        <td>
                            <label class="form-label" for="nama">Nama</label>
                            <input type="text" id="nama" name="nama" placeholder="Masukkan nama anda" class="input-control" value="<?php echo $a->nama?>" required>
                        </td>
                        <td colspan="2">
                            <label class="form-label" for="jk">Jenis Kelamin</label>
                            <select name="jk" id="jk" class="input-control" required>
                                <option value="">Pilih jenis kelamin</option>
                                <option <?php echo $a->jenis_kelamin === 'Laki-laki' ? "selected" : "" ?> value="Laki-laki">Laki-laki</option>
                                <option <?php echo $a->jenis_kelamin === 'Perempuan' ? "selected" : "" ?> value="Perempuan">Perempuan</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-label" for="nisn">NISN</label>
                            <input type="text" id="nisn" name="nisn" placeholder="NISN" class="input-control" value="<?php echo $a->nisn?>" required>
                        </td>
                        <td colspan="2">
                            <label class="form-label" for="agama">Agama</label>
                            <select name="agama" id="agama" class="input-control" required>
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
                        <td>
                            <label class="form-label" for="nis">NIS</label>
                            <input type="text" id="nis" name="nis" placeholder="NIS" class="input-control" value="<?php echo $a->nis?>" required>
                        </td>
                        <td>
                            <label class="form-label" for="kls">Kelas</label>
                            <select name="kelas" id="kls" class="input-control" required>
                                <option value="">Pilih kelas</option>
                                <option <?php echo $a->kelas == 'X' ? "selected" : "" ?> value="X">X</option>
                                <option <?php echo $a->kelas == 'XI' ? "selected" : "" ?> value="XI">XI</option>
                                <option <?php echo $a->kelas == 'XII' ? "selected" : "" ?> value="XII">XII</option>
                            </select>
                        </td>
                        <td>
                            <label class="form-label" for="jrsn">Jurusan</label>
                            <select name="jurusan" id="jrsn" class="input-control" required>
                                <option value="">Pilih jurusan</option>
                                <option <?php echo $a->jurusan === 'RPL' ? "selected" : "" ?> value="RPL">RPL</option>
                                <option <?php echo $a->jurusan === 'TKJ' ? "selected" : "" ?> value="TKJ">TKJ</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-label">Ijazah SMP</label><br>
                            <a class="document-link" target="_blank" href="images/siswa/dokumen/<?php echo $a->ijazah?>"><?php echo $a->ijazah?></a>
                            <input type="hidden" name="dokumen" value="<?php echo $a->ijazah?>">
                            <input type="file" name="docs" class="input-control" accept="application/pdf">
                            <label class="form-label">Kartu Keluarga</label><br>
                            <a class="document-link" target="_blank" href="images/siswa/dokumen/<?php echo $a->kartu_keluarga?>"><?php echo $a->kartu_keluarga?></a>
                            <input type="hidden" name="Hkk" value="<?php echo $a->kartu_keluarga?>">
                            <input type="file" name="kk" class="input-control" accept="application/pdf">
                        </td>
                        <td colspan="2">
                            <label class="form-label">Kartu Vaksin</label><br>
                            <a class="document-link" target="_blank" href="images/siswa/kartu/<?php echo $a->kartu?>"><?php echo $a->kartu?></a>
                            <input type="hidden" name="kartu" value="<?php echo $a->kartu?>">
                            <input type="file" name="card" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg">
                            <label class="form-label">Foto</label><br>
                            <a class="document-link" target="_blank" href="images/siswa/<?php echo $a->foto?>"><?php echo $a->foto?></a>
                            <input type="hidden" name="gambar" value="<?php echo $a->foto?>">
                            <input type="file" name="foto" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg">
                        </td>
                    </tr>
                </table>
                <input type="submit" name="update-siswa" value="Ubah Data Siswa" class="form-submit">
                <br><br>
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
                    $gmbr = $_POST['gambar'];
                    $kartu = $_POST['kartu'];
                    $dokumen = $_POST['dokumen'];

                    $filename = $_FILES['foto']['name'];
                    $tmp_name = $_FILES['foto']['tmp_name'];
                    $fileCard = $_FILES['card'];

                    //Configurasi update foto
                    if($filename != '') {
                        $type1 = explode('.', $filename);
                        $type2 = $type1[1];
                
                        $image = $nm.$nis.'.'.$type2;

                        $allowed = array('jpg', 'jpeg', 'png', 'gif');

                        // if(!in_array($type2, $allowed)){
                        //     echo "<script>alert('File type image not allowed')</script>";
                        // } else {
                            unlink('./images/siswa/'.$gmbr);
                            move_uploaded_file($tmp_name, './images/siswa/'.$image);
                            $foto = $image;

                        // }
                    } else {
                        $foto = $gmbr;
                    } 

                    //Configurasi update kartu
                    if($fileCard['name'] != ''){
                        $typeCard = explode('.', $fileCard['name']);
                        $card = "card".$nisn.$nis.'.'.$typeCard[1];

                        unlink('./images/siswa/kartu/'.$kartu);
                        move_uploaded_file($fileCard['tmp_name'], './images/siswa/kartu/'.$card);
                        $Ckartu = $card;
                    } else {
                        $Ckartu = $kartu;
                    }
            
                    //Configurasi update ijazah
                    $fileDocs = $_FILES['docs'];
                    if($fileDocs['name'] != ''){
                        $typeDocs = explode('.', $fileDocs['name']);
                        $docs = "ijazah".$nisn.$nis.'.'.$typeDocs[1];

                        unlink('./images/siswa/dokumen/'.$dokumen);
                        move_uploaded_file($fileDocs['tmp_name'], './images/siswa/dokumen/'.$docs);
                        $docts = $docs;
                    } else {
                        $docts = $dokumen;
                    }

                    //Configurasi update Kartu Keluarga
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

                    // var_dump($docs);

                    $insert = mysqli_query($conn, "UPDATE tb_siswa SET 
                    nama = '".$nm."', 
                    nisn = '".$nisn."', 
                    nis = '".$nis."', 
                    jenis_kelamin = '".$jk."', 
                    agama = '".$agama."', 
                    kelas = '".$kls."', 
                    jurusan = '".$jrsn."',
                    ijazah = '".$docts."',
                    kartu_keluarga = '".$kartuKeluarga."',
                    foto = '".$foto."',
                    kartu = '".$Ckartu."'
                    WHERE id_siswa = '".$a->id_siswa."'
                    ");
            
                    if($insert){
                        echo "<script>alert('Data siswa berhasil diperbaharui')</script>";
                        echo "<script>window.location='data-siswa.php'</script>";
                    } else {
                        echo "Error: ".mysqli_error($conn);
                    }
                }
        
            } ?>
            <?php if(isset($_GET['guru'])){?>
                <form method="POST" autocomplete="off" enctype="multipart/form-data">
                    <label class="form-label" for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama anda" class="input-control" value="<?php echo $a->nama?>" required>
                    <label class="form-label" for="usn">Username (Opsional)</label>
                    <input type="text" id="usn" name="user" placeholder="Username" class="input-control" required value="<?php echo $a->username?>">
                    <label class="form-label" for="nip">NIP</label>
                    <input type="text" id="nip" name="nip" placeholder="NIP" class="input-control" value="<?php echo $a->nip?>" required>
                    <label class="form-label" for="jk">Jenis Kelamin</label>
                    <select id="jk" name="jk" class="input-control" required>
                        <option value="">Pilih jenis kelamin</option>
                        <option <?php echo $a->jenis_kelamin == 'Laki-laki' ? "selected" : "" ?> value="Laki-laki">Laki-laki</option>
                        <option <?php echo $a->jenis_kelamin == 'Perempuan' ? "selected" : "" ?> value="Perempuan">Perempuan</option>
                    </select>
                    <label class="form-label" for="mapel">Mata Pelajaran</label>
                    <input type="text" id="mapel" name="mapel" placeholder="Mata Pelajaran" class="input-control" value="<?php echo $a->mapel?>" required>
                    <label for="ijazah" class="form-label">Ijazah S1 - S2</label><br>
                    <a target="_blank" href="images/guru/dokumen/<?php echo $a->ijazahs1?>"><?php echo $a->ijazahs1?></a>
                    <input type="hidden" name="Hijazahs1" value="<?php echo $a->ijazahs1?>">
                    <input type="file" class="input-control" name="ijazahs1" accept="application/pdf">
                    <a target="_blank" href="images/guru/dokumen/<?php echo $a->ijazahs2?>"><?php echo $a->ijazahs2?></a>
                    <input type="hidden" name="Hijazahs2" value="<?php echo $a->ijazahs2?>">
                    <input type="file" class="input-control" name="ijazahs2" accept="application/pdf">
                    <label for="kartu" class="form-label">Kartu</label><br>
                    <img src="images/guru/kartu/<?php echo $a->kartu ?>" width="100px">
                    <p><?php echo $a->kartu?></p>
                    <input type="hidden" name="kartu" value="<?php echo $a->kartu?>">
                    <input type="file" name="card" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg">
                    <label for="foto" class="form-label">Foto</label><br>
                    <img src="images/guru/<?php echo $a->foto ?>" width="100px">
                    <p><?php echo $a->foto?></p>
                    <input type="hidden" name="gambar" value="<?php echo $a->foto?>">
                    <input type="file" name="foto" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg">
                    <input type="submit" name="tambah-guru" value="Update data Guru" class="form-submit">
                </form>
                <br><br>
                <form method="POST" autocomplete="off">
                    <h1 class="title">Set Password</h1>
                    <input type="password" name="pass1" placeholder="Password" class="input-control" required>
                    <input type="password" name="pass2" placeholder="Ulangi Password" class="input-control" required>
                    <input type="submit" name="ganti-password" value="Ganti Password" class="form-submit">
                </form>
                <br><br>
                <?php 
                    if($_POST['tambah-guru']){
                        $nm = $_POST['nama'];
                        $nip = $_POST['nip'];
                        $jk = $_POST['jk'];
                        $mpl = $_POST['mapel'];
                        $kartu = $_POST['kartu'];
                        $gmbr = $_POST['gambar'];

                        $filename = $_FILES['foto']['name'];
                        $tmp_name = $_FILES['foto']['tmp_name'];
    
                        $fileCard = $_FILES['card'];

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
                        username = '".$_POST['user']."',
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
                        $pass1 = $_POST['pass1'];
                        $pass2 = $_POST['pass2'];

                        if($pass1 !== $pass2){
                            echo "<script>alert('Perulangan Password telah salah!')</script>";
                        } else {
                            $changePass = mysqli_query($conn, "UPDATE tb_guru SET
                            password = '".MD5($pass1)."' WHERE id_guru = '".$a->id_guru."'");
    
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
</body>
</html>