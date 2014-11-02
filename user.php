<?php include ("plantillaArriba2.php");
@session_start();
include ("database/conexion.php"); 


$c = new conexion();




$data=$c->getUsers1();
$role=$c->getRoles();

?>

<!-- content -->
<section id="content">
	<div id="containerCentral" class="container">
		<div id="faded">
			<ul class="slides">
				<!-- Aqui se ponen los graficos -->
				<!-- Ejemplo del formato -->
				<!-- <li><img src="images/slide-title1.gif"><a href="#"><span><span>Learn More</span></span></a></li> -->

			</ul>
			<ul class="pagination">
				<li><a href="sga.php" rel="3"><span>Back</span></a></li>				
				<li><a href="clasificacion.php" rel="2"><span>Classification</span><small>Get more information</small></a></li>
				<li class="current"><a href="user.php" rel="4"><span>User Manager</span></a></li>
				<li><a href="role.php" rel="4"><span>Roles Manager</span><small>Get more information</small></a></li>
				<li><a href="monitoring.php" rel="5"><span>Monitoring</span><small>Get more information</small></a></li>
				<li><a href="bitacora.php" rel="6"><span>Log History</span><small>Get more information</small></a></li>
			</ul>





			<div class="sga_container">
				<div  id="container">
				<caption> USUARIOS </caption>
				<div  class="divNvls">
				<div>
					<?php
					echo $c->cargar_usuarios();
					?>
				</div>

		<a href="#" id="bottonAgregarNivel"><img src="images/add.png">Add User</a>


		<div id="cosa" title="Add User">
			<form id="formAgregarNivel" name="formDialog" action="database/actions.php?accion=createUser" method="post">  
				<fieldset>
					<label for="nameUser">Name </label>
					<input name="nameUser" autofocus required></input><br/><br/>

					<label for="pass">Password </label>
					<input name="pass" autofocus required></input><br/><br/>


					<label for="roles">Roles</label>
					<?php
					echo $c->cargar_roles_usuario();
					?>

			</br><br/>

			<input id="buttonSubmitDialog" class="buttonSubmit" type="submit" value="OK" ></input>
	</fieldset>
					 </form>
				</div>
			</div>
		</div>
	</div> <!-- div tail-top -->
<?php include("plantillaAbajo.php"); ?>
