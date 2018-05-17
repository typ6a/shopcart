<?php
function isLoggedIn()
{
    // If session variable is not set it will redirect to login page
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
        redirectTo('login.php');
    exit;
    }
}

function redirectTo($path)
{
    header("location: ".$path);
}