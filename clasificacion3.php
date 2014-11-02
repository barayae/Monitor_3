	<?php include("plantillaArriba2.php"); 
	include ("database/conexion.php"); 
	@session_start();


	$colors=["#0040FF","#FF8000","#04B404","#ED5713","#ED9C13","#194E9C","#0DA068","#0040FF","#FF8000","#04B404","#ED5713","#ED9C13","#194E9C","#0DA068"];
	$con = new conexion();
	/*$typ = $_GET['type'];
	if($typ == 1){
		echo '<script lang="javascript" type="text/javascript">
		$(document).ready(function () {
			$("#dialog").dialog({
				autoOpen: true
			})
		})
	</script>';
	}
	if($typ == 2){
		echo '<script lang="javascript" type="text/javascript">
		$(document).ready(function () {
			$("#addPriv").dialog({
				autoOpen: true
			})
		})
	</script>';
	}*/
	
	?>
	<script lang="javascript" type="text/javascript">
		$(document).ready(function () {
			$("#addPriv").dialog({
				autoOpen: true
			});
			$("#selectTabs3").selectmenu();
			$("#selectPrivs3").selectmenu()
		})
	</script>
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
							<label for="nameLevel">Name </label>
							<input name="nameLevel" autofocus required></input><br/><br/>
							<label for="Privilegio">Privileges</label>
							<?php
									echo $con->cargar_privilegios2();
							?>
							</br></br>
							<label for="Tabla">Table </label> <!-- TENGO Q CARGAR LAS TABLAS DE LA BASE -->
							<select id="selectTabs" id="selectTabs" name="Tabla">
								<option value="T1">T1</option>
								<option value="T2">T2</option>
								<option value="T3">T3</option>
							</select>
							</br><br/>
							<input id="buttonSubmitDialog" class="buttonSubmit" type="submit" value="OK" ></input>
						  </fieldset>
					 </form>
				</div>
				<?php
					$lv = $_GET['level'];
					$namelv = $con->get_level($lv);
					$lisprivs = $con->lis_privs_level($lv);
					$privi;
					echo'
					<div id="dialog" title="Edit Level">
						<form id="formEditarNivel" name="formEditDialog" action="database/actions.php?accion=editLevel&nvl=' . $lv .'" method="post">  
							<fieldset>
								<label for="nameLevel">Name </label></br>
								<input name="nameLevel" value = "' . $namelv . '" autofocus required></input><br/><br/>
								<div  class="divPrivs">';
								echo $con->cargar_privs($lv);
								echo '</br><a href="clasificacion3.php?level='.$lv.'" id="bottonAgregarPrivilegio"><img src="images/add.png">Add Privilege</a>
								</div></br></br>
								<input id="buttonSubmitD" class="buttonSubmit" type="submit" value="OK" ></input>
							  </fieldset>
						 </form>
					</div>
					<div id="addPriv" title="Add Privilege">
					<form id="formAgregarPrivil" name="formDialog" action="database/actions.php?accion=createPriv&nvl=' . $lv .'" method="post">  
						<fieldset>
							<label for="Privilegio">Privileges</label>';
								echo $con->cargar_privilegios3();
							echo '</br></br>
							<label for="Tabla">Table </label> <!-- TENGO Q CARGAR LAS TABLAS DE LA BASE -->
							<select id="selectTabs3" name="Tabla">
								<option value="T1">T1</option>
								<option value="T2">T2</option>
								<option value="T3">T3</option>
							</select>
							</br><br/>
							<input id="buttonSubmitD" class="buttonSubmit" type="submit" value="OK" ></input>
						  </fieldset>
					 </form>
				</div>';
				?>
				
			</div>
		</div>
	</div> <!-- div tail-top -->
	<?php include("plantillaAbajo.php"); ?>

