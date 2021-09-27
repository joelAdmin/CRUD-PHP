<?php
$dbuser = 'root';
$dbpass = '';
/*$dbuser = 'root';
$dbpass = '';*/
$params = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

$pdo = new PDO('mysql:host=localhost;dbname=db_sistem;charset=utf8', $dbuser, $dbpass, $params);

?>