	<?php include("plantillaArriba2.php"); 
	include ("database/conexion.php"); 
	@session_start();


	$colors=["#0040FF","#FF8000","#04B404","#ED5713","#ED9C13","#194E9C","#0DA068","#0040FF","#FF8000","#04B404","#ED5713","#ED9C13","#194E9C","#0DA068"];
	$con = new conexion();
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
					<li class="current"><a href="clasificacion.php" rel="2"><span>Classification</span></a></li>
					<li><a href="user.php" rel="4"><span>User Manager</span><small>Get more information</small></a></li>
					<li><a href="role.php" rel="4"><span>Roles Manager</span><small>Get more information</small></a></li>
					<li><a href="monitoring.php" rel="5"><span>Monitoring</span><small>Get more information</small></a></li>
					<li><a href="bitacora.php" rel="6"><span>Log History</span><small>Get more information</small></a></li>
				</ul>


				<div class="sga_container">
					<div  class="divNvls">
						<?php
							echo $con->cargar_niveles();
						?>
						<a href="#" id="bottonAgregarNivel"><img src="images/add.png">Add Level</a>
						
					</div>
				</div>
				<div id="cosa" title="Add Level">
					<form id="formAgregarNivel" name="formDialog" action="database/actions.php?accion=createLevel" method="post">  
						<fieldset>
							<label for="nameLevel">Name </label></br>
							<input name="nameLevel" autofocus required></input></br></br>
							<label for="Privilegio">Privileges</label>
							<?php
									echo $con->cargar_privilegios();
							?>
							</br></br>
							<label for="Tabla">Table </label> <!-- TENGO Q CARGAR LAS TABLAS DE LA BASE -->
							<select id="selectTabs" name="Tabla">
								<option value="T1">T1</option>
								<option value="T2">T2</option>
								<option value="T3">T3</option>
							</select>
							</br><br/>
							<input id="buttonSubmitDialog" class="buttonSubmit" type="submit" value="OK" ></input>
						  </fieldset>
					 </form>
				</div>
			</div>
		</div>
	</div> <!-- div tail-top -->
	<?php include("plantillaAbajo.php"); ?>

