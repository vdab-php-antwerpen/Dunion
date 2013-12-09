<?php
session_start();
$session = unserialize($_SESSION["user"]);
var_dump($session);
exit(0);