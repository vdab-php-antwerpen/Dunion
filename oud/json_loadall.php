<?php
/**
 * MV
 * Version 1.01
 */

use vdab\dunion\Service\ControlService;

require 'preload.php';
session_start();

if (!isset($_SESSION["user"])) {
	header("location: index.php");
	exit(0);
} else if (isset($_GET["action"]) && $_GET["action"] == "loadall") {
	$user = unserialize($_SESSION["user"]);
	$jsonResponse = ControlService::getAllData($user);
    
	echo $jsonResponse;

} else {
	header("location: index.php");
}