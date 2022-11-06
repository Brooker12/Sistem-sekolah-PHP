<?php 
    include "database.php";

    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];
    $lvl = $_COOKIE['level'];

    if($lvl == 'admin' || $lvl == 'guru'){
        $query = "SELECT id_$lvl, nickname, password FROM tb_$lvl WHERE id_$lvl = $id";
    } else if($lvl == 'siswa'){
        $query = "SELECT id_$lvl, nama, nis FROM tb_$lvl WHERE id_$lvl = $id";
    }

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $pass = ($lvl == 'siswa' ? $row['nis'] : $row['password']);
    $name = ($lvl == 'admin' ? $row['nickname'] : $row['nama']);

    if(mysqli_num_rows($result)){
        if(hash("sha256", $pass) === $key){
            $_SESSION['status_login'] = true;
            $_SESSION['status_level'] = $lvl;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_id'] = $row["id_$lvl"];
        }
    }
?>