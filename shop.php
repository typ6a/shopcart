<?php
// Initialize the session
require_once 'loader.php'; 
// If session variable is not set it will redirect to login page
isLoggedIn();
// pre(class_exists('Cart'));
require_once "views/shopView.php";