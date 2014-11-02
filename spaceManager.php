<?php include("plantillaArriba.php"); 
include ("database/conexion.php"); 
@session_start();
$sga = new conexion();
$data=$sga->getTablespace();
$data1=$sga->getTiempoEstimado();
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
				<ul class="pagination">
					<li><a href="sga.php" rel="0"><span>SGA Manager</span><small>Get more information</small></a></li>
					<li ><a href="logs.php" rel="1"><span>Log Manager</span><small>Get more information</small></a></li>
					<li class="current"><a href="spaceManager.php" rel="2"><span>Space Manager</span><!--<small>Get more information</small>--></a></li>

				
					<li><a href="user.php" rel="2"><span>More Options</span></a></li>
				</ul>
					
					<div class="sga_container">
						<div  id="container">
							<canvas id="chart" width="700" height="500"></canvas>
							<table id="chartData">
								<tr>
							      <th>TABLE SPACE</th><th>SIZE</th> 
							    </tr>
								 
								<?php 
									foreach ($data as $key => $value) {
										echo '<tr id="ts_'.$key.'" style="color: '.$colors[$key].'">
      <td>'.$value["TABLESPACE_NAME"].'</td> 
      <td>'.$value["TOTALSPACE"]. ' MB</td>
    </tr>';
									}
								?>
							</table>
							<?php 
									foreach ($data as $key => $value) {	
    									echo "<div style='color:$colors[$key]; border:2px solid $colors[$key]' class='detail_ts' id='detail_ts_$key'>
    									<p><b>Total Space: </b> $value[TOTALSPACE] MB</p>
    									<p><b>FREE SPACE: </b>".$value['ROUND(100*(FS.FREESPACE/DF.TOTALSPACE))']."%</p>
    									<p><b>TIEMPO LLENADO : </b>".$data1[$key]['UNO']." Días</p>";
    						
    									echo "</div>";

								
										

   										}
    										
									


								
								?>
						</div>
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

