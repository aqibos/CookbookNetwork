<?php session_start();
    unset($_SESSION);
    session_destroy();
    header("Location:index-1.html"); 

?>