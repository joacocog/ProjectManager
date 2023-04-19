<?php

function autenticed_user(){
    if(!user_review()){
        header('Location:login.php');
        exit();
    }
}

function user_review(){
    return isset($_SESSION['name']);
}


session_start();
autenticed_user();