<?php
    include "partials/status_login.php";
    
    if($_SESSION['status_level'] != 'admin'){
        echo "<script>alert('Anda tidak memiliki akses');window.location='index.php'</script>";
    }
?>