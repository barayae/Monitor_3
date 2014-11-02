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
	

	function getSGA($actual){
		$con = $this->con();
		if (!$con) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}		
		$res='';
		$stid = oci_parse($con, 'select NAME,BYTES/(1024*1024) as "Size In MB" from v$sgainfo where bytes > 0');
		oci_execute($stid);
		$res = '';
		$i = 0;
		while($i < $actual){
			($row = oci_fetch_array($stid, OCI_BOTH));
			$i = $i+1;
		}
		if (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
			$res[0] = $row[0];
			$res[1] = $row[1];
		}		
		oci_close($con);
		return $res;
	}

	////////////////////////// REDOlog //////////////////////////////////

	function getlogInfo(){
		$con = $this->con();	
		$res='';
		$query='select l.GROUP# ,l.MEMBERS , ((round(l.BYTES)/1024)/1024) SIZE_MB	,l.STATUS ,f.MEMBER Path from v$log l , v$logfile f where l.group#=f.group#';
		$stid = oci_parse($con, $query);
		oci_execute($stid);
		//echo "-------STID--------<br>";
		//var_dump($stid);
		//echo "<br>";
		if($query!=null){
			//echo "-------QUERY--------<br>";
			//var_dump($query);
			//echo "<br>";
			$grupo_actual=0;
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				//echo "-------ROW--------<br>";
				//var_dump($row);
				//echo "<br>";
				if($row["GROUP#"]!=$grupo_actual){
					$res[] = $row;
					$grupo_actual=$row["GROUP#"];
				}else{
					$res[sizeof($res)-1]["PATH"].="<br/>".$row["PATH"];
				}
		
			}
		}
		oci_close($con);
		//echo "-------res--------";
		//var_dump($res);
		return $res;
	}

 	////////////////////////// Archive acivate //////////////////////////////////

	function getArchiveStatus(){
		$con = $this->con();	
		$res=false;
		$query='select log_mode from v$database';
		$stid = oci_parse($con, $query);
		oci_execute($stid);
		if($query!=null){
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				if($row["LOG_MODE"]=="ARCHIVELOG"){
					$res=true;
				}
			}
		}
		oci_close($con);
		return $res;
	}

	
	function getTablespace(){
		$con = $this->con();	
		if (!$con) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}		
		$res='';
		$sql = "select fs.tablespace_name, (df.totalspace - fs.freespace),fs.freespace, df.totalspace,
		round(100 * (fs.freespace / df.totalspace))
		from (select tablespace_name, round(sum(bytes) / 1048576) TotalSpace
		from dba_data_files
		group by tablespace_name) df, (select tablespace_name, round(sum(bytes) / 1048576) FreeSpace from dba_free_space
		group by tablespace_name) fs where df.tablespace_name = fs.tablespace_name";
		
		$stid = oci_parse($con, $sql);
		oci_execute($stid);
		$res = '';
		$i = 0;
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$res[] = $row;
		}

		oci_close($con);
		return $res;
		
	}


function getTiempoEstimado(){

		$con = $this->con();	
		if (!$con) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}		
		$res='';
		$sql = "SELECT tablespace_name, 
		ROUND( ( (sum(bytes)/1024/1024) *100) / 365 )  uno
		FROM dba_free_space
		WHERE tablespace_name NOT LIKE 'TEMP%'
		GROUP BY tablespace_name";
		

		$stid = oci_parse($con, $sql);
		oci_execute($stid);
		$res = '';
		$i = 0;
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$res[] = $row;
		}
		
		oci_close($con);
		return $res;
		
	}


////////////////////////// Audit //////////////////////////////////

	function getAuditStatus(){
		$con = $this->con();	
		if (!$con) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}		
		$res='';
		$sql = 'select value  from v$parameter where name = \'audit_sys_operations\' ';
		$stid = oci_parse($con, $sql);
		oci_execute($stid);
		$res = '';
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$res[] = $row;
		}
		
		oci_close($con);
		return $res[0]["VALUE"];
	}


    function getAuditTrail(){
    	$con = $this->con();	
		if (!$con) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}		
		$res='';
		//$sql='@C:\BD1\prueba.sql';
		$sql = 'select value  from v$parameter where name = \'audit_trail\' ';
		$stid = oci_parse($con, $sql);
		oci_execute($stid);
		$res = '';
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$res[] = $row;
		}
		
		oci_close($con);
		return $res[0]["VALUE"];

    }
	function getUsers(){
		$con = $this->con();	
		if (!$con) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}		
		$res='';
		$sql = 'select username from dba_users';
		$stid = oci_parse($con, $sql);
		oci_execute($stid);
		$res = '';
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$res[] = $row;
		}
		oci_close($con);
		return $res;
	}



	///////////////////////////////////////////////////////////////////
function EditAudit($username,$acc_sess,$whenever){
		$con = $this->con();	
		if (!$con) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}		
		$res='';
		$cond_whenever="whenever ";
		$cond_user=" by users";
		if($username!=""){
			$cond_user= " by ".$username." ";
		}
		$cond_whenever.= "$whenever successful";
		if( $acc_sess==" by access"){
			$sql="audit all $cond_user by access $cond_whenever";
		}else{
			$sql="audit session $cond_user $cond_whenever";
		}
		$stid = oci_parse($con, $sql);
		var_dump($sql);
		if(oci_execute($stid)){
			oci_close($con);
			return true;
		}
		oci_close($con);
		return false;

	}

	///////////////////////////////////////////////////////////////////

	function doAuditTrail($start_date,$end_date,$username,$actions,$status){
		$con = $this->con();	
		if (!$con) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}		
		$res='';
		$first_cond=true;
		$cond_date="";
		$cond_user="";
		$cond_query="";
		$cond_status="";
		
		if($start_date!=""and $end_date!=""){
			$cond_date='TIMESTAMP BETWEEN \''.$start_date.'\' and \''.$end_date.'\'';
			$first_cond=false;
		}else{
			if($start_date!=""&&$end_date==""){
				$cond_date='TIMESTAMP >= \''.$start_date.'\'';
				$first_cond=false;
			}else{
				if($start_date==""&&$end_date!=""){
				$cond_date='TIMESTAMP <= \''.$end_date.'\'';
				$first_cond=false;
				}
			}
		}
		if($username!=""){
			if(!$first_cond){
				$cond_user="AND ";
			}
			$cond_user.="USERNAME='".$username."' ";
		}
		if(!empty($actions)){
			if(!$first_cond){
				$cond_user="AND ";
			}
			foreach ($actions as $key => $action) {
				if($key>0){
					$cond_query.=" OR ";
				}
				$action=strtolower($action);
				$cond_query.=" SQL_TEXT LIKE '%$action%' ";
			}
		}
		if(!empty($status)){
			if(!$first_cond){
				$cond_user="AND ";
			}
			foreach ($status as $key => $s) {
				if($key>0){
					$cond_status.=" OR ";
				}
				$cond_status.="SES_ACTIONS='$s'";
			}
		}
		$sql = 'select TIMESTAMP,USERNAME, SQL_TEXT,PRIV_USED,OBJ_NAME from dba_audit_trail WHERE SQL_TEXT IS NOT NULL';
		if($cond_date!="" || $cond_user!="" || $cond_status!="" || $cond_query!=""){
			$sql.=" AND ";
		}
		$sql .=$cond_date." ".$cond_user." ".$cond_query." ".$cond_status. 'order by 1 desc';
		$stid = oci_parse($con, $sql);
		oci_execute($stid);
		$res = '';
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$res[] = $row;
		}
		oci_close($con);
		return $res;

	}

///////////////// USERS Y ROLE///////////////////
function getUsers1(){
		$con = $this->con();	
		if (!$con) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}		
		$res='';
		$sql = 'select username, password from dba_users';
		$stid = oci_parse($con, $sql);
		oci_execute($stid);
		$res = '';
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$res[] = $row;
		}
		oci_close($con);
		return $res;
	}


	function getRoles(){
		$con = $this->con();	
		if (!$con) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}		
		$res='';
		$sql = 'SELECT * FROM DBA_ROLE_PRIVS';
		$stid = oci_parse($con, $sql);
		oci_execute($stid);
		$res = '';
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$res[] = $row;
		}
		oci_close($con);
		return $res;
	}

	function cargar_usuarios(){
		$res = $this->lista_usuarios();

		if($res != null){
			
			$tabla = '
			<div style="overflow-y: scroll;height:100px;width:358px">

			<table class= "demoTbl" id="tableLvl">
			<thead><tr><th>NAME USER</th><th  colspan="2">Options</th></thead>';
			$filas = array();
			$i = 0;
			$j = 0;
			foreach($res as $row){
				$filas[$i] = $row;
				$i = $i +1;
			}
			while($j < $i){
				$tabla .= '<tbody><tr><td>'.$filas[$j].'</td> 
				
				<td><a href="database/actions.php?accion=deleteUser&user='.$filas[$j].'"><img src= "images/delete.png" id= "boton-eliminar-lvl" class="boton-tabla"  ></img></a></td></tr></tbody>';
				$j = $j+1;
			}
			$tabla .= '<tfoot></tfoot></table>';
			
			return $tabla;
		}else{
			return '<label> No data available </label></br>';
		}
	}


		function cargar_roles(){
		$res = $this->lista_roles();

		if($res != null){
			
			$tabla = '
			<div style="overflow-y: scroll;height:100px;width:358px">
			<table class= "demoTbl" id="tableLvl">
			<thead><tr><th>ROLE NAME</th><th  colspan="2">Options</th></thead>';
			$filas = array();
			$i = 0;
			$j = 0;
			foreach($res as $row){
				$filas[$i] = $row;
				$i = $i +1;
			}
			while($j < $i){
				$tabla .= '<tbody><tr><td>'.$filas[$j].'</td> 
				<td><a href="database/actions.php?accion=deleteRole&role='.$filas[$j].'"><img src= "images/delete.png" id= "boton-eliminar-lvl" class="boton-tabla"  ></img></a></td></tr></tbody>';
				$j = $j+1;
			}
			$tabla .= '<tfoot></tfoot></table>';
			
			return $tabla;
		}else{
			return '<label> No data available </label></br>';
		}
	}



function lista_roles(){
		$con = $this->con();
		$stid = oci_parse($con, 'SELECT * from DBA_ROLES');
		//$stid = oci_parse($con, 'SELECT * FROM user_role_privs');
		oci_execute($stid);
		$res = array();
		while($row = oci_fetch_array($stid, OCI_ASSOC))
		{
			$res[] = $row['ROLE'];
		    //$res[] = $row['*****'];
		}
		oci_free_statement($stid);
		oci_close($con);
		return $res;
	}

function lista_usuarios(){
		$con = $this->con();
		$stid = oci_parse($con, 'SELECT username FROM dba_users');
		oci_execute($stid);
		$res = array();
		while($row = oci_fetch_array($stid, OCI_ASSOC))
		{
			$res[] = $row['USERNAME'];
		    //$res[] = $row['*****'];
		}
		oci_free_statement($stid);
		oci_close($con);
		return $res;
	}




		function getLevels(){
		$con = $this->con();	
		if (!$con) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}		
		$res='';
		$sql = 'SELECT idLvl,nameLvl FROM levels';
		$stid = oci_parse($con, $sql);
		oci_execute($stid);
		$res = '';
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$res[] = $row;
		}
		oci_close($con);
		return $res;
	}

function cargar_roles_usuario(){
		$res = $this->lista_roles();
		$comboBox = '<select name="Privilegio">';
		$vals = array();
		$i = 0;
		$j = 0;
		foreach($res as $row){
			$vals[$i] = $row;
			$i = $i +1;
		}
		while($j < $i){
			$comboBox .= '<option value = "'.$vals[$j].'">'.$vals[$j+1].'</option>';
			$j = $j+2;
		}		
		$comboBox .= '</select>';
		return $comboBox;
	}


function lis_roles_para_usuario(){
		$con = $this->con();
		$stid = oci_parse($con, ' SELECT * from DBA_ROLES');
		oci_execute($stid);
		$res = array();
		while($row = oci_fetch_array($stid, OCI_ASSOC))
		{
			$res[] = $row['ROLE'];
		}
		oci_free_statement($stid);
		oci_close($con);
		return $res;
	}


	function cargar_levels(){
		$res = $this->lis_levels();
		$comboBox = '<select name="Privilegio">';
		$vals = array();
		$i = 0;
		$j = 0;
		foreach($res as $row){
			$vals[$i] = $row;
			$i = $i +1;
		}
		while($j < $i){
			$comboBox .= '<option value = "'.$vals[$j].'">'.$vals[$j+1].'</option>';
			$j = $j+2;
		}		
		$comboBox .= '</select>';
		return $comboBox;
	}



  ////////PARTE DE CLASIFICACION    
	function lis_levels(){
		$con = $this->con();
		$stid = oci_parse($con, 'SELECT idLvl,nameLvl FROM levels');
		oci_execute($stid);
		$res = array();
		while($row = oci_fetch_array($stid, OCI_ASSOC))
		{
			$res[] = $row['IDLVL'];
		    $res[] = $row['NAMELVL'];
		}
		oci_free_statement($stid);
		oci_close($con);
		return $res;
	}
	function get_level($id){
		$con = $this->con();
		$stid = oci_parse($con, 'SELECT nameLvl FROM levels where idLvl = '. $id .'');
		oci_execute($stid);
		$res;
		while(oci_fetch($stid))
		{
			$res = oci_result($stid,'NAMELVL');
		}
		oci_free_statement($stid);
		oci_close($con);
		return $res;
	}	
	function get_privilege($id){
		$con = $this->con();
		$stid = oci_parse($con, 'SELECT namePriv FROM Privs where idPriv = '. $id .'');
		oci_execute($stid);
		$res;
		while(oci_fetch($stid))
		{
			$res = oci_result($stid,'NAMEPRIV');
		}
		oci_free_statement($stid);
		oci_close($con);
		return $res;
	}
	function lis_privs(){
		$con = $this->con();
		$stid = oci_parse($con, 'SELECT idPriv,namePriv FROM Privs');
		oci_execute($stid);
		$res = array();
		while($row = oci_fetch_array($stid, OCI_ASSOC))
		{
			$res[] = $row['IDPRIV'];
		    $res[] = $row['NAMEPRIV'];
		}
		oci_free_statement($stid);
		oci_close($con);
		return $res;
	}
	
	function lis_privs_level($lvl){
		$con = $this->con();
		$stid = oci_parse($con, 'SELECT idPriv,nameTab FROM Lvl_Priv where idLvl = ' . $lvl . '');
		oci_execute($stid);
		$res = array();
		while($row = oci_fetch_array($stid, OCI_ASSOC))
		{
		    $res[] = $row['IDPRIV'];
		    $res[] = $row['NAMETAB'];
		}
		oci_free_statement($stid);
		oci_close($con);
		return $res;
	}
	
	function lis_tablas(){
		$con = $this->con();
		$stid = oci_parse($con, "SELECT table_name FROM dba_tables where owner='SYSTEM'");
		//$stid = oci_parse($con, "SELECT table_name FROM dba_tables where owner='SYSTEM' and tablespace_name='PONEMOSELNOMBREDELTBSP'");
		oci_execute($stid);
		$res;
		while(oci_fetch($stid))
		{
			$res = oci_result($stid,'TABLE_NAME');
		}
		oci_free_statement($stid);
		oci_close($con);
		return $res;
	}
	
	function cargar_niveles(){
		$res = $this->lis_levels();
		$typ = 1;
		if($res != null){
			
			$tabla = '<table class= "tablaLvls" id="tableLvl"><caption> CLASSIFICATION </caption><thead><tr><th>Level ID</th><th>Level Name</th><th  colspan="2">Options</th></thead>';
			$filas = array();
			$i = 0;
			$j = 0;
			foreach($res as $row){
				$filas[$i] = $row;
				$i = $i +1;
			}
			while($j < $i){
				$tabla .= '<tbody><tr><td>'.$filas[$j].'</td><td>'.$filas[$j+1].'</td>
				<td><a id="editLevel" href="clasificacion2.php?level='.$filas[$j].'"><img src = "images/edit.png" id= "boton-editar-lvl" class="boton-tabla" ></img></a></td>
				<td><a href="database/actions.php?accion=deleteLvl&nvl='.$filas[$j].'"><img src= "images/delete.png" id= "boton-eliminar-lvl" class="boton-tabla"  ></img></a></td></tr></tbody>';
				$j = $j+2;
			}
			$tabla .= '<tfoot></tfoot></table>';
			
			return $tabla;
		}else{
			return '<label> No data available </label></br>';
		}
	}
	
	function cargar_privilegios(){
		$res = $this->lis_privs();
		$comboBox = '<select id="selectPrivs" class="selectPrivs" name="Privilegio">';
		$vals = array();
		$i = 0;
		$j = 0;
		foreach($res as $row){
			$vals[$i] = $row;
			$i = $i +1;
		}
		while($j < $i){
			$comboBox .= '<option value = "'.$vals[$j].'">'.$vals[$j+1].'</option>';
			$j = $j+2;
		}		
		$comboBox .= '</select>';
		return $comboBox;
	}
	
	function cargar_tablas(){
		$res = $this->lis_tablas();
		$comboBox = '<select id="selectTabs" class="selectTabs" name="Tablas">';
		$vals = array();
		$i = 0;
		$j = 0;
		foreach($res as $row){
			$vals[$i] = $row;
			$i = $i +1;
		}
		while($j < $i){
			$comboBox .= '<option value = "'.$vals[$j].'">'.$vals[$j+1].'</option>';
			$j = $j+2;
		}		
		$comboBox .= '</select>';
		return $comboBox;
	}
	
	function cargar_privilegios2(){ //es un duplicado de la funcion anterior, pero con el id del select diferente, xq x algun motivo, el jquery no lo reconoce
		$res = $this->lis_privs();
		$comboBox = '<select id="selectPrivs2" name="Privilegio">';
		$vals = array();
		$i = 0;
		$j = 0;
		foreach($res as $row){
			$vals[$i] = $row;
			$i = $i +1;
		}
		while($j < $i){
			$comboBox .= '<option value = "'.$vals[$j].'">'.$vals[$j+1].'</option>';
			$j = $j+2;
		}		
		$comboBox .= '</select>';
		return $comboBox;
	}
	
	function cargar_privilegios3(){ //es un duplicado de la funcion anterior, pero con el id del select diferente, xq x algun motivo, el jquery no lo reconoce
		$res = $this->lis_privs();
		$comboBox = '<select id="selectPrivs3" name="Privilegio">';
		$vals = array();
		$i = 0;
		$j = 0;
		foreach($res as $row){
			$vals[$i] = $row;
			$i = $i +1;
		}
		while($j < $i){
			$comboBox .= '<option value = "'.$vals[$j].'">'.$vals[$j+1].'</option>';
			$j = $j+2;
		}		
		$comboBox .= '</select>';
		return $comboBox;
	}
	
	function cargar_privs($lvl){
	
		$lisprivs = $this->lis_privs_level($lvl);

		if($lisprivs != null){			
			$tabla = '<table class= "demoTbl" id="tablePrivs"><caption> PRIVILEGES </caption><thead><tr><th>Name</th><th>Table</th><th>Option</th></thead>';
			$filas = array();
			$i = 0;
			$j = 0;
			foreach($lisprivs as $row){
				$filas[$i] = $row;
				$i = $i +1;
			}
			while($j < $i){
				$privi = $this->get_privilege($filas[$j]);
				$tabla .= '<tbody><tr><td>'.$privi.'</td><td>'.$filas[$j+1].'</td>
				<td><a href="database/actions.php?accion=deletePriv&priv='.$filas[$j].'&tabl='.$filas[$j+1].'&nvl='.$lvl.'"><img src= "images/delete.png" id= "boton-eliminar-lvl" class="boton-tabla"  ></img></a></td></tr></tbody>';
				$j = $j+2;
			}
			$tabla .= '<tfoot></tfoot></table>';
			
			return $tabla;
		}
		else{
			return '<label> No data available </label></br></br>';
		}
	}


//Insertar politicas a la tabla de politicas

//Modificar politicas  a la tabla


// Eliminar Politicas

//Elimina BATS y SQL

function EliminaDatos(){
	array_map('unlink', glob("C:/politicas/*.bat"));
	array_map('unlink', glob("C:/politicas/*.sql")); 
	array_map('unlink', glob("C:/politicas/*.txt")); 
}



///Creacion de todos los archivos BAT y SQL, este es ejecutado cada vez que se modifique, se crea o se borra una politica
function CreaPoliticasLocales(){
		$this->EliminaDatos();
		$con = $this->con();	
		$res=false;
		$query='select * from politicas_locales';
		$stid = oci_parse($con, $query);
		oci_execute($stid);
		if($query!=null){
			/*
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				if($row["LOG_MODE"]=="ARCHIVELOG"){
					$res=true;
				}
			}
			*/
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				$res[] = $row;
				$name= "$row[FECHA]"."$row[HORA].$row[MINUTO]";
				//var_dump($name);

				//BAT
				$file_name="C:\politicas\\".$name;

				$myfile = fopen($file_name."rman.bat", "w") or die("Unable to open file!");
				$txt = "rman target/ @$file_name"."rman.sql  
				call $file_name"."sql.bat";
				fwrite($myfile, $txt);
				fclose($myfile);
 
				//SQL
				$myfile2 = fopen($file_name."rman.sql", "w") or die("Unable to open file!");
				//$txt = "backup $row[TIPO]";


//Sentencia de Backup

				$txt = "exit;";
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
	/*



/// Aplicacion de BackUps,  este ejecuta los bats a u hora correspondiente


function AplicaPoliticas(){
		$con = $this->con();	
		$res=false;
		$query='select  from politicas_locales';
		$stid = oci_parse($con, $query);
		oci_execute($stid);
		if($query!=null){

			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				$res[] = $row;
				$name= "$row[FECHA]"."$row[HORA]";
				//var_dump($name);

				//BAT
				$file_name="C:\backup\\".$name;

				$myfile = fopen($file_name."rman.bat", "w") or die("Unable to open file!");
				$txt = "rman target/ @$file_name"."rman.sql  
				call $file_name"."sql.bat";
				fwrite($myfile, $txt);
				fclose($myfile);
 
				//SQL
				$myfile2 = fopen($file_name."rman.sql", "w") or die("Unable to open file!");
				//$txt = "backup $row[TIPO]";


//Sentencia de Backup

				$txt = "exit;";
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
	*/







}

?>