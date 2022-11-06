<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'db_sekolah');

    $webConfig = mysqli_query($conn, "SELECT * FROM web_config");
    $web = mysqli_fetch_assoc($webConfig);

    if(!$conn){
        echo "Database error";
    }
?>
<link rel="stylesheet" href="styles/style.css">
<link rel="shortcut icon" href="./images/web_config/<?= $web['logo_sekolah'] ?>" type="image/x-icon">
<!-- links -->