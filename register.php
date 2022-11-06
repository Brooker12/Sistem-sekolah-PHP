<?php 
    session_start();
    error_reporting(0);
    include "database.php";

    if(isset($_POST['tambah-siswa'])){
        $nm = $_POST['nama'];
        $nisn = $_POST['nisn'];
        $nis = $_POST['nis'];
        $jk = $_POST['jk'];
        $agama = $_POST['agama'];
        $kls = $_POST['kelas'];
        $jrsn = $_POST['jurusan'];

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
        nama = '".$nm."', 
        nisn = '".$nisn."', 
        nis = '".$nis."', 
        jenis_kelamin = '".$jk."', 
        agama = '".$agama."', 
        kelas = '".$kls."', 
        jurusan = '".$jrsn."',
        ijazah = '".$ijazah."',
        kartu_keluarga = '".$kk."',
        foto = '".$image."',
        kartu = '".$card."'
        ");

        if($insert){
            echo "<script>alert('Akun anda berhasil dibuat, Silahkan login')</script>";
            echo "<script>window.location='login.php'</script>";
        } else {
            echo "Error: ".mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Diri</title>
</head>
<body>
    <?php include "partials/navbar.php" ?>
    <div class="container bg-logo">
        <div class="title">Buat akun siswa</div>
        <br>
        <form method="POST" autocomplete="off" enctype="multipart/form-data">
            <input type="text" name="nama" placeholder="Nama" class="input-control" required>
            <input type="text" name="nisn" placeholder="NISN" class="input-control" required>
            <input type="text" name="nis" placeholder="NIS" class="input-control" required>
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
            </select>
            <label for="dokumen">Ijazah SMP</label>
            <input type="file" name="dokumen" id="dokumen" class="input-control" accept="application/pdf" required>
            <label for="kk">Kartu Keluarga</label>
            <input type="file" name="kk" id="kk" class="input-control" required>
            <label for="kartu">Kartu Vaksin</label>
            <input type="file" name="kartu" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg" required>
            <label for="foto">Foto</label>
            <input type="file" name="foto" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg" required>
            <input type="submit" name="tambah-siswa" value="Buat akun anda" class="form-submit">
        </form><br><br>
    </div>
</body>
</html>