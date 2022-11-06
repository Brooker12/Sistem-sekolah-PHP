<?php 
    session_start();
    include "../database.php";
    $level = $_SESSION['status_level'];
    $key = $_GET['key'];
    $page = strpos($_GET['page'], 'siswa') ? "siswa" : "guru";

    if(strpos($_GET['page'], 'siswa')){
        $sql = "SELECT * FROM tb_siswa WHERE nama LIKE '%".$key."%' OR nisn LIKE '%".$key."%' 
        OR nis LIKE '%".$key."%' OR jurusan LIKE '%".$key."%'";
    } else if(strpos($_GET['page'], 'guru')){
        $sql ="SELECT * FROM tb_guru WHERE nama LIKE '%".$key."%' OR nip LIKE '%".$key."%' 
        OR mapel LIKE '%".$key."%'";
    }

    $sql .= "ORDER BY nama";
    $query = mysqli_query($conn, $sql);

?>
    <?php if($page == "siswa") {?>
        <table class="table" border="1"> 
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>NIS</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Kartu Vaksin</th>
                        <th>Foto</th>
                        <?php if($level === "admin"){?>
                        <th>Dokumen</th>
                        <th colspan="2">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if(mysqli_num_rows($query) > 0){
                            $no = 1;
                            while($i = mysqli_fetch_array($query)){
                    ?>
                    <tr <?php echo ($i['id_siswa'] === $_SESSION['user_id']) ? "style='backdrop-filter: contrast(0.8);'" : "" ?>>
                        <td align="center"><?php echo $no++ ?></td>
                        <td><?php echo $i['nama'] ?></td>
                        <td><?php echo $i['nisn'] ?></td>
                        <td><?php echo $i['nis'] ?></td>
                        <td><?php echo $i['jenis_kelamin'] ?></td>
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
                            <a class="document-link" target="_blank" href="images/siswa/dokumen/<?php echo $i['ijazah']?>">- Ijazah</a><br>
                            <a class="document-link" target="_blank" href="images/siswa/dokumen/<?php echo $i['kartu_keluarga']?>">- Kartu Keluarga</a>
                        </td>
                        <td align="center">
                            <a class="btn-update" href="detail-data.php?siswa=<?php echo $i['id_siswa'] ?>">Detail</a>
                            <!-- <a class="btn-update" href="detail-data.php?siswa=<?php echo $i['id_siswa'] ?>">Detail</a> -->
                        </td>
                        <td align="center">
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
    <?php } else if($page == "guru") {?>
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
                            <a class="btn-update" href="detail-data.php?guru=<?php echo $i['id_guru'] ?>">Detail</a>
                        </td>
                        <td align="center">
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
    <?php }?>