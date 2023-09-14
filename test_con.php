<?php 
error_reporting (E_ALL);
require_once 'config.php';
$db = new db();
$q = "SELECT * FROM employees";
$aset = $db->manual_query($q);
echo json_decode($aset);