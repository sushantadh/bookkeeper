<?php 
@session_start();
try {
	$pdo=new pdo('mysql:host=localhost;dbname=library','root','');
}
catch (PDOException $e) {
	exit('DB error');
}
?>