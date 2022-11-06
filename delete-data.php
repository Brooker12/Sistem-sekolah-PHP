<?php 
    error_reporting(0);
    include "database.php";
    include "partials/status_login.php";
    
    if($_SESSION['status_level'] == 'siswa'){
        echo "<script>alert('Anda tidak memiliki akses');window.location='index.php'</script>";
    }

    $admin = $_SESSION['status_level'];

    if($admin && $_GET['siswa']){
        $data = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE id_siswa = '".$_GET['siswa']."'");
        $d = mysqli_fetch_object($data);

        if(mysqli_num_rows($data) === 0){
            header('location: data-siswa.php');
        } else {
            unlink('./images/siswa/'.$d->foto);
            unlink('./images/siswa/kartu/'.$d->kartu);                
            unlink('./images/siswa/dokumen/'.$d->ijazah);
            unlink('./images/siswa/dokumen/'.$d->kartu_keluarga);
            $delete = mysqli_query($conn, "DELETE FROM tb_siswa WHERE id_siswa = '".$_GET['siswa']."'");

            if($delete){
                
                echo "<script>alert('Data siswa berhasil dihapus')</script>";
                echo "<script>window.location='data-siswa.php'</script>";
            } else {
                echo "Error: ".mysqli_error($conn);
            }
        }
    } else if($admin && $_GET['guru']){
        $data = mysqli_query($conn, "SELECT * FROM tb_guru WHERE id_guru = '".$_GET['guru']."'");
        $d = mysqli_fetch_object($data);

        if(mysqli_num_rows($data) === 0){
            header('location: data-guru.php');
        } else {
            unlink('./images/guru/'.$d->foto);
            unlink('./images/guru/kartu/'.$d->kartu);
            unlink('./images/guru/dokumen/'.$d->ijazahs1);
            unlink('./images/guru/dokumen/'.$d->ijazahs2);
            $delete = mysqli_query($conn, "DELETE FROM tb_guru WHERE id_guru = '".$_GET['guru']."'");

            if($delete){
                echo "<script>alert('Data guru berhasil dihapus')</script>";
                echo "<script>window.location='data-guru.php'</script>";
            } else {
                echo "Error: ".mysqli_error($conn);
            }
        }
    } else if($_GET['nilai']){
        $mysql = mysqli_query($conn, "DELETE FROM tb_nilai WHERE id_nilai = '".$_GET['nilai']."'");

        if($mysql){
            echo "<script>alert('Data nilai siswa berhasil dihapus')</script>";
            echo "<script>window.location='daftar-nilai.php'</script>";
        } else {
            echo "Error: ".mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Anda tidak memiliki akses');window.location='index.php'</script>";
    }
?>