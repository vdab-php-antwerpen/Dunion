<?php

use vdab\dunion\Service\UserService;

require 'preload.php';
session_start();

if (isset($_SESSION["user"])) {
    header("location: index.php");
    exit(0);
} else if (isset($_GET["action"]) && $_GET["action"] == "register" && isset($_GET["username"]) && isset($_GET["password"]) && isset($_GET["email"])) {


    $username = $_GET["username"];
    $email = $_GET["email"];
    $password = $_GET["password"];
    $user = "";
    $jsonResponse = UserService::registerUser($username, $password, $email, $user);
    //unset($_SESSION["user"]);

    if (!empty($user) || $user != false) {
        $_SESSION["user"] = serialize($user);
    }
    
    echo $jsonResponse;
} else {
    header("location: index.php");
}