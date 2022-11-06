<?php 
    session_start();
    session_destroy();

    setcookie("id", "", time() - 86400);
    setcookie("key", "", time() - 86400);
    setcookie("level", "", time() - 86400);

    header("location: index.php");
?>