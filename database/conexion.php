<?php 

class conexion{
	
	var $conexion;
	var $user="sanjose";
	var $pass="sanjose";
	var $host="localhost/XE";


	function con(){ 
		/*
		if(isset($_SESSION['usuario']) && isset($_SESSION['password']) && isset($_SESSION['SID'])) {
			$this->user=$_SESSION['usuario'];
			$this->pass=$_SESSION['password'];
			$this->host="localhost/".$_SESSION['SID'];	
		}*/
		
		$cone = oci_connect($this->user, $this->pass, $this->host);
		if (!$cone) {
			$e = oci_error();
			//trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);*/
			$_SESSION["error_cnx"]=$e['message'];
			header("Location: index.php");
		}
		return $cone;
	}

//Insertar politicas a la tabla de politicas generales
function InsertaPoliticasGenerales($fecha,$hora,$tipo,$bd){
		$con = $this->con();	
		$res=false;
		$query="insert into politicas_generales (fecha,hora,tipo,bd) values ('".$fecha."','".$hora."','".$tipo."','".$bd."')";
		var_dump($query);
		$stid = oci_parse($con, $query);
		oci_execute($stid);
		oci_close($con);
}

// Inserta en politicas politcas locales

function SelectPoliticas($db){
		$con = $this->con();	
		$res=false;
		$query="select * from politicas_generales where BD = '$db'";
		//var_dump($query);
		$stid = oci_parse($con, $query);
		oci_execute($stid);
		if($query!=null){
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				$res[] = $row;
			}
		}
		oci_close($con);
		return $res;
}
/*
function SelectPoliticasBD2(){
		$con = $this->con();	
		$res=false;
		$query='select * from politicas_generales where BD = BD2';
		var_dump($query);
		$stid = oci_parse($con, $query);
		oci_execute($stid);
		if($query!=null){
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				$res[] = $row;
			}
		}
		oci_close($con);
		return $res;
}
function SelectPoliticasB3(){
		$con = $this->con();	
		$res=false;
		$query='select * from politicas_generales where BD = BD3';
		var_dump($query);
		$stid = oci_parse($con, $query);
		oci_execute($stid);
		if($query!=null){
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				$res[] = $row;
			}
		}
		oci_close($con);
		return $res;
}
*/
function InsertPoliticasBD1(){
		$select=$this->SelectPoliticas("BD1");
		$con = $this->con();	
		foreach ($select as $key => $politica) {
			var_dump($politica);
			$ruta="c:\politicas\\".$politica["FECHA"].$politica["HORA"]."rman.bat";
			$query="insert into politicas_locales (id,fecha,hora,ruta,tipo) values ('".$politica["ID"]."','".$politica["FECHA"]."','".$politica["HORA"]."','".$ruta."','".$politica["TIPO"]."')";
			var_dump($query);
			$stid = oci_parse($con, $query);
			oci_execute($stid);
		}
		oci_close($con);
}

function InsertPoliticasLocalesRemotas(){

}



//Modificar politicas  a la tabla


// Eliminar Politicas

//Elimina BATS y SQL


function EliminaDatos(){
	array_map('unlink', glob("C:/politicas/*.bat"));
	array_map('unlink', glob("C:/politicas/*.sql")); 
	array_map('unlink', glob("C:/politicas/*.txt")); 
}

///Creacion de todos los archivos BAT y SQL, este es ejecutado cada vez que se modifique, se crea o se borra una politica
function CreaPoliticasBkupFiles(){
		$this->EliminaDatos();
		$con = $this->con();	
		$res=false;
		$query='select * from politicas_locales';
		$stid = oci_parse($con, $query);
		oci_execute($stid);
		if($query!=null){
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				$res[] = $row;
				$name= "$row[FECHA]$row[HORA]";
				//var_dump($name);

				//BAT
				$file_name="C:\politicas\\".$name;
				$myfile = fopen($file_name."rman.bat", "w") or die("Unable to open file!");
				$txt = "rman target/ @$file_name"."rman.sql  
				call ".$file_name."sql.bat";
				fwrite($myfile, $txt);
				fclose($myfile);
 
				//SQL
				$myfile2 = fopen($file_name.'rman.sql', "w") or die("Unable to open file!");
				//$txt = "backup $row[TIPO]";


//Sentencia de Backup

				$txt = " backup database;";

////////////////////////				
				fwrite($myfile2, $txt);
				fclose($myfile2);

				$myfile3 = fopen($file_name."sql.bat", "w") or die("Unable to open file!");
				$txt = "sqlplus sanjose/sanjose @$file_name"."sql.sql";
				fwrite($myfile3, $txt);
				fclose($myfile3);

				//SQL
				$myfile4 = fopen($file_name."sql.sql", "w") or die("Unable to open file!");
				//$txt = "backup $row[TIPO]";
				$txt = "execute procedimiento de logs();";
				fwrite($myfile4, $txt);
				fclose($myfile4);
			}
		}
		oci_close($con);
		return $res;
	}

function aplicaPoliticas(){
	$con = $this->con();	
	$date=date("Ymd");
	$time=date("Hi");
	$date="20141102";
	$time="1659";
	$res=[];
	$query="select * from politicas_locales where fecha='".$date."' and hora='".$time."'";
	$stid = oci_parse($con, $query);
		oci_execute($stid);
		if($query!=null){
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				$res[] = $row;
			}
		}
		oci_close($con);
		if(!empty($res)){
			system("cmd /c ".$res[0]["RUTA"]);
		}
}
	







}//cierra clase

?>