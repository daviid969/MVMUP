<?php
require_once('config.php');

$conexion = mysql_connect($servidor, $usuario, $pass)
or die('Error: Database to host connection: '.mysql_error());

mysql_select_db($bbdd, $dbh)
or die('Error: Select database: '.mysql_error());
?>
