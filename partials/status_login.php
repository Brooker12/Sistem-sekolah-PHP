<?php
    session_start();
    require "database.php";

    if($_COOKIE['id'] && $_COOKIE['key'] && $_COOKIE['level']){
        include "partials/status_cookie.php";
    }

    if(!isset($_SESSION['status_login']) || !isset($_SESSION['user_id'])){
        header("location: index.php");
        exit;
    } 
?>