<?php
session_start();
if(isset($_SESSION['admin_name'])) {
    header("location:panel.php");
}else{
    header("location:register/login.php");
}