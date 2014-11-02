<?php include("plantillaArriba2.php"); 
include ("database/conexion.php"); 
@session_start();


$colors=["#0040FF","#FF8000","#04B404","#ED5713","#ED9C13","#194E9C","#0DA068","#0040FF","#FF8000","#04B404","#ED5713","#ED9C13","#194E9C","#0DA068"]
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
				</ul>
						<ul class="pagination">
					<li><a href="sga.php" rel="3"><span>Back</span></a></li>				
					<li><a href="clasificacion.php" rel="2"><span>Classification</span><small>Get more information</small></a></li>
					<li ><a href="user.php" rel="4"><span>User Manager</span><small>Get more information</small></a></li>
					<li ><a href="role.php" rel="4"><span>Roles Manager</span><small>Get more information</small></a></li>
					<li ><a href="monitoring.php" rel="5"><span>Monitoring</span><small>Get more information</small></a></li>
					<li class="current"><a href="bitacora.php" rel="6"><span>Log History</span></a></li>
				</ul>
					
					
    										
					<div class="sga_container">
			<div  id="container">
				<blockquote>
					<p>Bitacora sobre usuarios del Software: </p>
				</blockquote>




				<p>
					<label >
						Date:
						<input type="text" name="text" id="text">
					</label>
				</p>
				<p>

					<label >
						Select the user software :

					</label>
				</p>
				<p>
					<select id="cmbMake" name="Make" >
						<option value="">Select User</option>
						<option value="--Any--">--Any--</option>
						<option value="R1">US1</option>
						<option value="R2">US2</option>
					</select>
				</p>

	

				<p>
					<button id="botton" class="botonMonitoreo" >LOG</button>
				</p>




				<p>

					<label >
						Results:

					</label>
				</p>

				<p>

				<img src="image1.gif" width="280" height="125" />

				</p>


			</div>
		</div>				


								
						
			</div>
		</div>
</div> <!-- div tail-top -->
<script type="text/javascript" >
$(".sga_container #chartData td").click(function(){
		$(".detail_ts").hide();
  		var id=$(this).parent().attr("id");
  		$("#detail_"+id).fadeIn();
  });
</script>
<?php include("plantillaAbajo.php"); ?>

