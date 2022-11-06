<?php 
    session_start();
    error_reporting(0);
    include "database.php";

    if($_SESSION['status_level'] == 'siswa'){
        echo "<script>alert('Anda tidak memiliki akses');window.location='index.php'</script>";
    }
    
    $print = $_GET['print'];

    if($print == 'siswa'){
        $sql = "SELECT * FROM tb_siswa";
    } else if($print == 'guru'){
        $sql = "SELECT * FROM tb_guru";
    }

    $query = mysqli_query($conn, $sql);
    $no = 1;

    if(mysqli_num_rows($query) < 1){
        header('location: index.php');
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data <?php echo ucfirst($print); ?> SMKN 2 Makassar</title>
    <style>
        table{
            white-space: nowrap;
        }
        th, td {
           padding: 10px 15px;
        }
    </style>
</head>
    <body onload="window.print(); window.onafterprint = window.close;">
    <!-- <body> -->
    <?php if($print == 'siswa'){?>
        <h1 class="title">Data siswa SMKN 2 Makassar</h1>
        <table border="1" cellspacing="0" cellpadding="0"> 
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>NISN</th>
                    <th>NIS</th>
                    <th>Jenis Kelamin</th>
                    <th>Agama</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Kartu Identitas</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php  while($i = mysqli_fetch_array($query)){ ?>
                <tr>
                    <td align="center"><?php echo $no++ ?></td>
                    <td><?php echo $i['nama'] ?></td>
                    <td><?php echo $i['nisn'] ?></td>
                    <td><?php echo $i['nis'] ?></td>
                    <td><?php echo $i['jenis_kelamin'] ?></td>
                    <td><?php echo $i['agama'] ?></td>
                    <td align="center"><?php echo $i['kelas'] ?></td>
                    <td><?php echo $i['jurusan'] ?></td>
                    <td align="center"><img class="foto" src="images/siswa/kartu/<?php echo $i['kartu']?>" alt="<?php echo $i['kartu']?>"></td>
                    <td align="center"><img class="foto" src="images/siswa/<?php echo $i['foto'] ?>" alt="<?php echo $i['foto'] ?>"></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else if($print == 'guru'){?>
        <h1 class="title">Data guru SMKN 2 Makassar</h1>
        <table border="1" cellspacing="0" cellpadding="0"> 
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Guru</th>
                    <th>NIP</th>
                    <th>Jenis Kelamin</th>
                    <th>Mata Pelajaran</th>
                    <th>Kartu Vaksin</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php while($i = mysqli_fetch_array($query)){ ?>
                <tr>
                    <td align="center"><?php echo $no++ ?></td>
                    <td><?php echo $i['nama'] ?></td>
                    <td><?php echo $i['nip'] ?></td>
                    <td><?php echo $i['jenis_kelamin'] ?></td>
                    <td><?php echo $i['mapel'] ?></td>
                    <td align="center"><img class="foto" src="images/guru/kartu/<?php echo $i['kartu'] ?>" alt="<?php echo $i['kartu'] ?>"></td>
                    <td align="center"><img class="foto" src="images/guru/<?php echo $i['foto'] ?>" alt="<?php echo $i['foto'] ?>"></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php }?>
</body>
</html>