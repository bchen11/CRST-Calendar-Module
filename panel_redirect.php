<?php
    session_start();
    //here this page directs user and admin to appropriate page, change this variable to account for your user's type
    if($_SESSION['role'] == 'admin'){
        header("Location:panel_admin.php");
    }else{
        header("Location:panel_user.php");
    }
?>