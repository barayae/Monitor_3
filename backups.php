	<?php 
@session_start();

include ("database/conexion.php"); 
$c=new conexion();

if(!empty($_REQUEST)){ 
	if(isset($_REQUEST["ses/act"])){
		$status=isset($_REQUEST["status"])?$_REQUEST["status"]:[];
		$data=$c->EditAudit($_REQUEST["username"],$_REQUEST["ses/act"],$status);
		if($data){
			echo "Audit succeeded.";
		}else{
			echo "Audit failed.";
		}
	}else{
			$queries=isset($_REQUEST["query"])?$_REQUEST["query"]:[];
			$status=isset($_REQUEST["status"])?$_REQUEST["status"]:[];
			$data=$c->doAuditTrail($_REQUEST["start_date"],$_REQUEST["end_date"],$_REQUEST["username"],$queries,$status);
			
			if(!empty($data)){
				echo "<table class='TablaResult'>";
			foreach ($data as $index => $log) {
				if($index==0){
					foreach ($log as $index_log => $value_log) {
						echo "<td class='th'>$index_log</th>";
					}
				}
				echo "<tr>";
				foreach ($log as $index_log => $value_log) {
					
						echo "<td>$value_log</td>";
				}
				echo "</tr>";

			}
			echo "</table>";
		}else{
			echo "NO RESULTS";
		}
	}
	
	die();
}
$au=$c->getAuditStatus();
$trail=$c->getAuditTrail();
$users=$c->getUsers();
include ("plantillaArriba2.php"); 
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

<script>
  $(function() {
    $( ".datepicker" ).datepicker({dateFormat: 'dd-mm-y'} );
  });
  </script>
<!-- content -->
<section id="content" class="no_footer">
	<div id="containerCentral" class="container">
		<div id="faded">
			<ul class="slides">
				

			</ul>
			<ul class="pagination">
				<li><a href="sga.php" rel="3"><span>Back</span></a></li>				
				<li><a href="clasificacion.php" rel="2"><span>Classification</span><small>Get more information</small></a></li>
				<li ><a href="user.php" rel="4"><span>User Manager</span><small>Get more information</small></a></li>
				<li ><a href="role.php" rel="4"><span>Roles Manager</span><small>Get more information</small></a></li>
				<li class="current"><a href="monitoring.php" rel="5"><span>Monitoring</span></a></li>
				<li><a href="bitacora.php" rel="6"><span>Log History</span><small>Get more information</small></a></li>
			</ul>								

		</div>


		<div class="sga_container">
			<div  id="container">
				<?php

				//Creando BAT
				//var_dump("1");
				$reglas=$c->CreaPoliticasLocales();
				//var_dump($reglas);	
				//$r=$c->AplicaPoliticas();	
				//var_dump($reglas);

				?>
				<button onclick="getVar()">Prueba</button>

			</div>
		</div>



	</div>

<script type="text/javascript" >
$(".botonMonitoreo").click(function(e){
	e.preventDefault();
	$.post( "monitoring.php", $( "#filter_data" ).serialize() )
	.done(function( data ) {;
		$("#results").html(data);
	});

});

$(".botonEtitAudit").click(function(f){
	f.preventDefault();
	$.post( "monitoring.php", $( "#EditAudit" ).serialize() )
	.done(function( data ) {;
		$("#prueba").html(data);
	});

});
function getVar () {<?php
	$c->getPoliticasLocales();
 	?>}
  </script>
</script>


</div> <!-- div tail-top -->
</body>
</html>