<?php session_start();
    $id = $session['User_id'];//user have user_id attribute
    unset($_SESSION);
    header("Location:index-1.html"); ?>