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

session_start();

require_once("bdd.php");
require_once("fonctions.php");
