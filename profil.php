<?php 
    session_start();
    error_reporting(0);
    include "database.php";
    include "partials/admin_only.php"; 

    $data = mysqli_query($conn, "SELECT * FROM tb_admin WHERE id_admin = '".$_SESSION['user_id']."'");
    $data2 = mysqli_query($conn, "SELECT * FROM multiuser WHERE id_user = '".$_SESSION['user_id']."'" );

    // $a = (mysqli_num_rows($data)) ? mysqli_fetch_object($data) : mysqli_fetch_object($data2);

    if(mysqli_num_rows($data) > 0){
        $a = mysqli_fetch_object($data);
    } else if(mysqli_num_rows($data2) > 0){
        $a = mysqli_fetch_object($data2);
        $multiuser = true;
    }else {
        echo "<script>alert('Error id data')</script>";
        echo "<script>window.location='index.php'</script>";
    }

    $webConfig = mysqli_query($conn, "SELECT * FROM web_config");
    if(mysqli_num_rows($webConfig)){
        $web = mysqli_fetch_assoc($webConfig);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profil</title>
</head>
<body class="bg-logo">
    <?php include "partials/navbar.php"; ?>
    <div class="container">
        <div style="display: flex;">
            <div style="width: 50%; padding: 10px;">
                <div class="title">Pengaturan Pengguna</div>
                <form action="" method="post">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username anda" class="input-control" value="<?php echo $a->username?>" required>
                    <label class="form-label" for="nickname">Nickname</label>
                    <input type="text" id="nickname" name="nickname" placeholder="Masukkan nickname anda" class="input-control" value="<?php echo $a->nickname?>" required>
                    <input type="submit" name="ubah-pengguna" value="Simpan Pengaturan" class="form-submit">
                </form>
                <?php 
                    if(isset($_POST['ubah-pengguna'])){
                        $nick = $_POST['nickname'];
                        $user = $_POST['username'];

                        $update = mysqli_query($conn, "UPDATE tb_admin SET 
                        nickname = '".$nick."', username = '".$user."' 
                        WHERE id_admin = '".$a->id_admin."'");

                        if($update){
                            echo "<script>alert('Data berhasil diubah')</script>";
                            echo "<script>window.location='profil.php'</script>";
                        } else {
                            echo mysqli_error($conn);
                        }
                    }
                ?>
                <div class="title">Ganti Password</div>
                <form action="" method="post">
                    <input type="password" name="pass1" placeholder="Password" class="input-control" required>
                    <input type="password" name="pass2" placeholder="Ulangi Password" class="input-control" required>
                    <input type="submit" name="ganti-pass" value="Ganti Password" class="form-submit">
                </form>
                <?php 
                    if(isset($_POST['ganti-pass'])){
                        $pass1 = $_POST['pass1'];
                        $pass2 = $_POST['pass2'];

                        if($pass1 != $pass2){
                            echo "<script>alert('Password tidak sama!')</script>";
                        } else {
                            $change = mysqli_query($conn, "UPDATE tb_admin SET password = '".MD5($pass1)."'");

                            if($change){
                                echo "<script>alert('Password berhasil diubah')</script>";
                                echo "<script>window.location='profil.php'</script>";
                            } else {
                                echo mysqli_error($conn);
                            }
                        }
                    }
                ?> 
            </div>
            <div style="width: 50%; padding: 10px;">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="title">Pengaturan Sekolah</div>
                    <label for="#" class="form-label">Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" placeholder="Nama Sekolah" class="input-control" value="<?= $web['nama_sekolah'] ?>" required>
                    <label for="#" class="form-label">Logo Sekolah</label><br>
                    <img width="100px" src="./images/web_config/<?= $web['logo_sekolah'] ?>" alt="<?= $web['logo_sekolah'] ?>">
                    <p style="color: #777;"><?= $web['logo_sekolah'] ?></p>
                    <input type="hidden" name="Hlogo" value="<?= $web['logo_sekolah'] ?>">
                    <input type="file" name="logo_sekolah" placeholder="Logo Sekolah" class="input-control">
                    <label for="#" class="form-label">Background Sekolah</label><br>
                    <img width="100px" src="./images/web_config/<?= $web['background'] ?>" alt="<?= $web['background'] ?>">
                    <p style="color: #777;"><?= $web['background'] ?></p>
                    <input type="hidden" name="Hbackground" value="<?= $web['background'] ?>">
                    <input type="file" name="background_sekolah" placeholder="background Sekolah" class="input-control">
                    <input type="submit" name="web-config" value="Simpan Pengaturan" class="form-submit">
                </form>
                <?php 
                    if(isset($_POST['web-config'])){
                        $nama = $_POST['nama_sekolah'];

                        $fileLogo = $_FILES['logo_sekolah']; 
                        $hiddenLogo = $_POST['Hlogo'];
                        if($fileLogo['name'] != ''){
                            $typeLogo = explode('.', $fileLogo['name']);
                            $namaLogo = "logo_sekolah".time().'.'.$typeLogo[1];
    
                            unlink('./images/web_config/'.$hiddenLogo);
                            move_uploaded_file($fileLogo['tmp_name'], './images/web_config/'.$namaLogo);
                            $logo = $namaLogo;
                        } else {
                            $logo = $hiddenLogo;
                        }

                        $filebackground = $_FILES['background_sekolah']; 
                        $hiddenbackground = $_POST['Hbackground'];
                        if($filebackground['name'] != ''){
                            $typebackground = explode('.', $filebackground['name']);
                            $namabackground = "background".time().'.'.$typebackground[1];
    
                            unlink('./images/web_config/'.$hiddenbackground);
                            move_uploaded_file($filebackground['tmp_name'], './images/web_config/'.$namabackground);
                            $background = $namabackground;
                        } else {
                            $background = $hiddenbackground;
                        }

                        $config = mysqli_query($conn, "UPDATE web_config SET
                        nama_sekolah    = '$nama', 
                        logo_sekolah    = '$logo', 
                        background      = '$background' 
                        WHERE 1");

                        if($config){
                            echo "<script>alert('Pengaturan berhasil diubah');
                            window.location='profil.php'</script>";
                        } else {
                            echo mysqli_error($conn);
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>