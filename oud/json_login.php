<?php
/**
 * MV
 * Version 1.01
 */

use vdab\dunion\Service\UserService;

require 'preload.php';
session_start();

if (isset($_SESSION["user"])) {
	header("location: index.php");
	exit(0);
} else if (isset($_GET["action"]) && $_GET["action"] == "login" && isset($_GET["loginname"]) && isset($_GET["password"])) {
	$loginname = $_GET["loginname"];
	$password = $_GET["password"];
	$user = "";
	$jsonResponse = UserService::login($loginname, $password, $user);
	
	if (!empty($user) || $user != false) {
		$_SESSION["user"]  = serialize($user);
	}
    
	echo $jsonResponse;

} else {
	header("location: index.php");
}