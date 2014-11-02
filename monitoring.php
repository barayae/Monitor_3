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
				<p class="PAudit"> Audit status   <span class="<?php echo ($au)?'ArchiveOn':'ArchiveOff'?>"> <?php echo ($au)?'ON':'OFF'?> </span> 
					<?php
						if($au){
							echo"<br>Audit Trail : $trail" ;
						}
					?>
				</p>
				<form id="EditAudit">
					<div id="prueba"></div>

					<!--<p>Audit :</p>
					<input type="checkbox" name="query[]" value="INSERT"><label>INSERT</label>

					<input type="checkbox" name="query[]" value="DELETE"><label>DELETE</label>

					<input type="checkbox" name="query[]" value="UPDATE"><label>UPDATE</label>

					<input type="checkbox" name="query[]" value="SELECT"><label>SELECT</label>-->

					<p>Audit By</p>
					<select id="cmbMake" name="username" >
						<option value="">--All--</option>
						<?php 
							foreach ($users as $key => $user) {
								echo "<option value=".$user["USERNAME"].">".$user["USERNAME"]."</option>";
							}
						?>
					</select>

					<select id="cmbMake" name="ses/act" >
							<option value=" by session">by session</option>
							<option value=" by access">by access</option>							
					</select>

					<p>WHENEVER </p>
					<select id="status" name="status" >
							<option value="">SUCCESSFUL</option>	
							<option value=" NOT ">FAILED</option>							
					</select>
					<!--<input type="checkbox" name="status[]" value="B"><label>BOTH</label>

						<input type="checkbox" name="status[]" value="F"><label>FAILED</label>

						<input type="checkbox" name="status[]" value="S"><label>SUCCESSFUL</label>-->
							<br/>
					<button type="button" id="botton" class="botonEtitAudit" >Set Audit</button>
				</form>
				
				<form id="filter_data">

					<p>AUDIT REPORT </p>
					<p>Select Date Range :</p>
					<div>
						<label >
							Start Date:
						</label>
							<input class="datepicker" type="text" name="start_date" id="start_date">
						
						<label >
							Final Date:
						</label>
							<input class="datepicker" type="text" name="end_date" id="end_date">
						
					</div>
					<p>Select User to Monitoring :</p>

						<select id="cmbMake" name="username" >
							<option value="">--Any--</option>
							<?php 
								foreach ($users as $key => $user) {
									echo "<option value=".$user["USERNAME"].">".$user["USERNAME"]."</option>";
								}
							?>
						</select>
						<p >Query executed:</p>
						<input type="checkbox" name="query[]" value="INSERT"><label>INSERT</label>

						<input type="checkbox" name="query[]" value="DELETE"><label>DELETE</label>

						<input type="checkbox" name="query[]" value="UPDATE"><label>UPDATE</label>

						<input type="checkbox" name="query[]" value="grant"><label>GRANT</label>

						<!--<p >SQL Status:</p>
					
						<input type="checkbox" name="status[]" value="B"><label>BOTH</label>

						<input type="checkbox" name="status[]" value="F"><label>FAILED</label>

						<input type="checkbox" name="status[]" value="S"><label>SUCCESSFUL</label><br/>-->
				</form>

				<button type="submit" id="botton" class="botonMonitoreo" >MONITORING</button>
				
				<div id="results"></div>
				
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
</script>


</div> <!-- div tail-top -->
</body>
</html>