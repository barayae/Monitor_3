<?php
include('conexion.php');
$conexion = new conexion;


if($_GET['accion'] == 'createLevel'){
		$con = $conexion->con();
		$namelvl = $_POST["nameLevel"];
		$privi = $_POST["Privilegio"];
		$tabla = $_POST["Tabla"];
		
		
		$stid = oci_parse($con, "INSERT INTO levels(nameLvl) VALUES('" . $namelvl . "')");
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
		oci_free_statement($stid);
		
		$stid = oci_parse($con, "SELECT idLvl FROM levels WHERE rowid=(select max(rowid) from levels)"); //Obtenemos el ultimo id de levels, o sea, el acabamos de insertar
		oci_execute($stid);
		$idlv;
		while(oci_fetch($stid))
		{
			$idlv = oci_result($stid,'IDLVL');
		}
		var_dump($idlv);
		
		$stid = oci_parse($con, "INSERT INTO Lvl_Priv VALUES(". $idlv . ", ". $privi . ", '". $tabla . "')");
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);	
		oci_free_statement($stid);	
		
		oci_close($con);
		
		header('location:../clasificacion.php');
}
if($_GET['accion'] == 'createPriv'){
		$con = $conexion->con();
		$privi = $_POST["Privilegio"];
		$tabla = $_POST["Tabla"];
		$idlvl = $_GET["nvl"];
		
		$stid = oci_parse($con, "INSERT INTO Lvl_Priv VALUES(". $idlvl . ", ". $privi . ", '". $tabla . "')");
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
		
		oci_close($con);
		header('location:../clasificacion2.php?level=' . $idlvl .'');

}
if($_GET['accion'] == 'deleteLvl'){
		$con = $conexion->con();
		$idLv = $_GET["nvl"];
		
		$stid = oci_parse($con, 'DELETE FROM Lvl_Priv where idLvl=' . $idLv . '');
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);	
		oci_free_statement($stid);	
		
		$stid = oci_parse($con, 'DELETE FROM levels where idLvl=' . $idLv . '');
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);	
		oci_free_statement($stid);	
		
		oci_close($con);
		header('location:../clasificacion.php');
}
if($_GET['accion'] == 'deletePriv'){
		$con = $conexion->con();
		$pri = $_GET["priv"];
		$tab = $_GET["tabl"];
		$id = $_GET["nvl"];
		
		$stid = oci_parse($con, "DELETE FROM Lvl_Priv where idPriv=" . $pri . " and nameTab= '" . $tab . "'");
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);	
		oci_free_statement($stid);	
		
		
		oci_close($con);
		header('location:../clasificacion2.php?level=' . $id .'');
}
if($_GET['accion'] == 'editLevel'){
		$con = $conexion->con();
		$id = $_GET["nvl"];
		$name = $_POST["nameLevel"];
		
		$stid = oci_parse($con, "UPDATE levels SET nameLvl='" . $name . "' WHERE idLvl=" . $id . "");
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);	
		oci_free_statement($stid);	
		
		
		oci_close($con);
		header('location:../clasificacion2.php?level=' . $id .'');
}

///////////// ROLES Y USUARIOS//////////////


if($_GET['accion'] == 'createUser'){
		$con = $conexion->con();
		$nameUser = $_POST["nameUser"];
		$pass = $_POST["pass"];
		$roles = $_POST["roles"];
		
		$stid = oci_parse($con, "CREATE USER ". $nameUser." IDENTIFIED BY ". $pass." ");
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
		oci_free_statement($stid);
		
		$stid = oci_parse($con, "GRANT ". $roles." IDENTIFIED BY ". $nameUser." ");
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
		oci_free_statement($stid);
		
		oci_close($con);
		
		header('location:../user.php');
}


if($_GET['accion'] == 'createRole'){
		$con = $conexion->con();
		$nameRole = $_POST["nameRole"];
		
		$stid = oci_parse($con, "CREATE ROLE ". $nameRole." ");
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
		oci_free_statement($stid);
		
		
		oci_close($con);
		
		header('location:../role.php');
}


if($_GET['accion'] == 'deleteRole'){
		$con = $conexion->con();
		$role = $_GET["role"];
		
		$stid = oci_parse($con, "  DROP ROLE ". $role." ");
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);	
		oci_free_statement($stid);	
		
		
		oci_close($con);
		header('location:../role.php?pri=' . $role .'');
}

if($_GET['accion'] == 'deleteUser'){
		$con = $conexion->con();
		$user = $_GET["user"];
		
		$stid = oci_parse($con, "  DROP USER ". $user." CASCADE ");
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);	
		oci_free_statement($stid);	
		
		
		oci_close($con);
		header('location:../user.php?pri=' . $user .'');
}

if($_GET['accion'] == 'createRole2'){
		$con = $conexion->con();
		$nameRole = $_POST["nameRole"];
		$nameLevel = $_POST["nameLevel"];
		
		$stid = oci_parse($con, "CREATE ROLE ". $nameRole." ");
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
		oci_free_statement($stid);


		////SELECT QUE ME DA EL ID DEL LEVEL
		
		$sql = "SELECT l.idlvl from Lvl_Priv l, Levels p where p.namelvl ='  ". $nameLevel."  ' ";
		$stid = oci_parse($con, $sql);
		oci_execute($stid);
		$res = '';
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$res[] = $row;
		}

		/////SELECT QUE ME DA EL NOMBRE DEL PRIVILEGIO

		$sql2 = "SELECT  p.namepriv  from Lvl_Priv l, privs p where l.idLvl = '  ". $res['IDPRIV']."  ' ";
		$stid = oci_parse($con, $sql2);
		oci_execute($stid);
		$res2 = '';
		while ($row2 = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$res2[] = $row2;
		}

		////SELECT QUE ME DA EL NOMBRE DE LA TABLA

		$sql3 = "SELECT  nametab  from lvl_priv where idLvl = '  ". $res['IDPRIV']."  ' ";
		$stid = oci_parse($con, $sql2);
		oci_execute($stid);
		$res3 = '';
		while ($row3 = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$res3[] = $row3;
		}

		//////GRANT CON EL QUE LE OTORGO PRIVILEGIOS AL ROL ESPECIFICO 

		$stid = oci_parse($con, "GRANT ". $res2['NAMEPRIV']." ON ". $res3['NAMETAB']." TO ". $nameRole." ");
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
		oci_free_statement($stid);

		oci_close($con);
		
		header('location:../role.php');
}






?>