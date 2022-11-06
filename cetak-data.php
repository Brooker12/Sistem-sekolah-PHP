<?php 
    error_reporting(0);
    require "database.php";

    if($_SESSION['status_level'] === 'siswa'){
        echo "<script>alert('Anda tidak memiliki akses');window.location='index.php'</script>";
    }

    if($_GET['siswa']){
        $data = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE id_siswa = '".$_GET['siswa']."'");
        $title = 'Siswa';

        if(mysqli_num_rows($data) === 0){
            header('location: data-siswa.php');
        } else $a = mysqli_fetch_object($data);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Siswa <?php echo $a->nama?></title>
    <style>
    /* .tb-data td:nth-child(1) {
        width: 20%;
        padding-left: 20px;
    } */
    </style>
</head>
<body onload="window.print(); window.onafterprint = window.close;">
    <h1 style="margin-left: 20px; margin-top: 10px">Data Siswa <?php echo $a->nama?></h1>
    <table class="tb-data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $a->nama?></td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>:</td>
            <td><?php echo $a->nisn?></td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>:</td>
            <td><?php echo $a->nis?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $a->jenis_kelamin?></td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td><?php echo $a->agama?></td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td><?php echo $a->kelas?></td>
        </tr>
        <tr>
            <td>Jurusan</td>
            <td>:</td>
            <td><?php echo $a->jurusan?> </td>
        </tr>
    </table>
    <div style="position: absolute;top: 10%;right: 20%;">
        <p align="center">Foto</p>
        <img src="images/siswa/<?php echo $a->foto ?>" width="100px">
    </div>
    <div style="position: absolute;top: 36%;right: 20%;">
        <p align="center">Kartu</p>
        <img src="images/siswa/kartu/<?php echo $a->kartu ?>" width="100px">
    </div>
</body>
</html>