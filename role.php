<?php include("plantillaArriba2.php"); 
include ("database/conexion.php"); 
@session_start();
$sga = new conexion();
$role=$sga->getRoles();
$level=$sga->getLevels();

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
				<li ><a href="user.php" rel="4"><span>User Manager</span><small>Get more information</small></a></li>
				<li class="current"><a href="role.php" rel="4"><span>Roles Manager</span></a></li>
				<li><a href="monitoring.php" rel="5"><span>Monitoring</span><small>Get more information</small></a></li>
				<li><a href="bitacora.php" rel="6"><span>Log History</span><small>Get more information</small></a></li>
			</ul>




			<div class="sga_container">
					<div  class="divNvls1">

					<caption> ROLES </caption>
					<div>
						<?php
						echo $sga->cargar_roles();
						?>

					</div>
				</div>

					<a href="#" id="bottonAgregarNivel"><img src="images/add.png">Add Role</a>


					<div id="cosa" title="Add Role">
						<form id="formAgregarNivel" name="formDialog" action="database/actions.php?accion=createRole2" method="post">  
							<fieldset>
								<label for="nameRole">Name </label>
								<input name="nameRole" autofocus required></input><br/><br/>

								<label for="nameLevel">Level </label>


								<?php
								echo $level_for_role = $sga->cargar_levels();

					
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

