<?php
/**
 * MV
 * Version 1.01
 */

use vdab\dunion\Service\UserService;

require 'preload.php';
session_start();

if (isset($_GET["action"]) && $_GET["action"] == "logincheck") {
	if (isset($_SESSION["user"])) {
		$json = '{"loggedin": {"value": 1}}';
	} else {
		$json = '{"loggedin": {"value": 0}}';
	}
	echo $json;
	//unset($_SESSION["user"]);
}