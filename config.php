<?php
require 'libs/Configuracion.class.php';
require 'libs/Idioma.class.php';
require "libs/Config.php";
require 'libs/SPDO.php'; //PDO con singleton
require 'libs/ControllerBase.php'; //Clase controlador base
require 'libs/ModelBase.php'; //Clase modelo base
require 'libs/View.php'; //Mini motor de plantillas


//require 'libs/config.php';

$config = Config::singleton();
 
$config->set('controllersFolder', 'controlador/');
$config->set('modelsFolder', 'modelo/');
$config->set('viewsFolder', 'vista/');

$config->set('dbhost', 'localhost');
$config->set('dbname', 'admin_friopan');
$config->set('dbuser', 'admin_friopan');
$config->set('dbpass', 'n0Mo02d*');
//$config->set('dbpass', 'La141cas');
//$config->set('dbpass', 'root');
?>
