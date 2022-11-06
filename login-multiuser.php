<?php 
    session_start();
    include "database.php";

    if(isset($_SESSION['status_login']) == true){
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
</head>
<body class="bg-login">
    <div class="login-box">
        <div class="form-login">
            <h2>Login ke akun</h2>
            <form method="POST" autocomplete="off">
                <input type="text" id="user" name="user" placeholder="Masukkan username anda" class="input-control" required>
                <input type="password" name="pass" id="pass" placeholder="Masukkan password" class="input-control" required>
                <!-- <select name="level" class="input-control" required>
                    <option value="">Select Level</option>
                    <option value="admin">Admin</option>
                    <option value="guru">Guru</option>
                    <option value="siswa">Siswa</option>
                </select> -->
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Ingat Saya !</label><br>
                <input type="submit" name="login" value="Masuk" class="form-submit">
                <p class="register">Belum punya akun? <a href="register.php">Buat Akun</a></p>
            </form>
        </div>
    </div>
    <?php 
        if(isset($_POST['login'])){
            $user = mysqli_real_escape_string($conn, $_POST['user']);
            $pass = mysqli_real_escape_string($conn, $_POST['pass']);
            // $levels = $_POST['level'];

            // if($levels === 'admin'){
            //     $query ="SELECT * FROM tb_admin WHERE username = '".$user."' AND password = '".MD5($pass)."'";
            // } else if($levels === 'guru'){
            //     $query = "SELECT * FROM tb_guru WHERE username = '".$user."' AND password = '".MD5($pass)."'";
            // } else {
            //     $query = "SELECT * FROM tb_siswa WHERE nisn = '".$user."' AND nis = '".$pass."'";
            // }

            $query = "SELECT * FROM multiuser WHERE username = '".$user."' AND password = '".MD5($pass)."'";

            $verf = mysqli_query($conn, $query);
            $object = mysqli_fetch_object($verf);

            // if($level === 'admin'){
            //     $name = $object->nickname;
            // } else {
            //     $name = $object->nama;
            // }

            if(mysqli_num_rows($verf) > 0){
                // $id = "id_$level";
                $_SESSION['status_login'] = true;
                $_SESSION['status_level'] = $object->level;
                $_SESSION['user_id'] = $object->id_user;
                $_SESSION['user_name'] = $object->username;

                if(isset($_POST['remember'])){
                    // $keys = ($level == 'siswa' ? $pass : MD5($pass));

                    setcookie("id", $object->$id, time() + 86400);
                    // setcookie("key", hash("sha256", $keys), time() + 86400);
                    setcookie("key", hash("sha256", $pass), time() + 86400);
                    setcookie("level", $level, time() + 86400);
                }

                echo "<script>alert('Anda berhasil masuk sebagai ".$_SESSION['status_level']."')</script>";
                echo "<script>window.location='index.php'</script>";
            } else {
                echo "<script>alert('Password atau Username salah')</script>";
            }
        }
    ?>
</body>
</html>