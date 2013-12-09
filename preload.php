<?php
use Doctrine\Common\ClassLoader;
require_once("Doctrine/Common/ClassLoader.php");
$classLoader = new ClassLoader("vdab", "src");
$classLoader->register();
