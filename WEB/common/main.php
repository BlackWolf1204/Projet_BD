<?php

$BDD_NAME = "maisoneco";
$BDD_HOST = "localhost";
$BDD_USER = "root";
$BDD_PASSWD = "";

if (!isset($ROOT)) {
	error_log("ROOT is not set");
	echo "ROOT is not set";
	exit();
}

require_once("bdd.php");
