<?php 
@session_start();
date_default_timezone_set('America/Costa_Rica');
include ("database/conexion.php"); 
$c=new conexion();
if(isset($_REQUEST["action"])&&$_REQUEST["action"]=="check"){
	
	$c->aplicaPoliticas();
	
}else{

	$reglas=$c->CreaPoliticasLocales();
	date_default_timezone_set('America/Costa_Rica');
	$fecha=date("Ymd");
	$hora=date("Hi");
	//var_dump($fecha);
	//var_dump($hora);

	$pruebaInserta4=$c->InsertPoliticasBD1();
	//var_dump($pruebaInserta4);
	//$junto=
	$creapoli=$c->CreaPoliticasLocales();
}
?>

<script src="js/scripts.js"></script>