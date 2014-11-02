<?php 
include("plantillaArriba.php"); 
include ("database/conexion.php");
@session_start();
if(isset($_POST["username"])&&isset($_POST["password"])&&isset($_POST["SID"])){
	$_SESSION['usuario'] = $_POST["username"];
	$_SESSION['password'] = $_POST["password"];
	$_SESSION['SID'] = $_POST["SID"];
}
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
					<li class="current"><a href="sga.php" rel="0"><span>SGA Manager</span><!--<small>Get more information</small>--></a></li>
					<li><a href="logs.php" rel="1"><span>Log Manager</span><small>Get more information</small></a></li>
					<li><a href="spaceManager.php" rel="2"><span>Space Manager</span><small>Get more information</small></a></li>
					<li><a href="user.php" rel="2"><span>More Options</span></a></li>
					<!--<li><a href="role.php" rel="2"><span>Role Manager</span><small>Get more information</small></a></li>
					<li><a href="monitoring.php" rel="2"><span>Monitoring</span><small>Get more information</small></a></li>
					<li><a href="bitacora.php" rel="2"><span>Bitacora</span><small>Get more information</small></a></li>-->
				</ul>
					<?php
						$sga = new conexion();
						$etiqueta;
						$etiqueta[0] = $sga->getSGA(2)[0]; // Almacena el nombre del componente buffer.
						$etiqueta[1] = $sga->getSGA(3)[0]; // Almacena el nombre del componente shared pool.
						echo '<div id="bodyChart" >
							<div id="containerChart">
							  <canvas id="chart" width="700px" height="500px" ></canvas>
							  <table id="chartData">
								<tr>
								  <th>Component</th><th>Size MB</th>
								 </tr>
								<tr style="color: #0DA068">
								  <td>'.$sga->getSGA(0)[0].'</td><td>'.round($sga->getSGA(0)[1]). ' MB</td>
								</tr>
								<tr style="color: #194E9C">
								  <td>'.$sga->getSGA(1)[0].'</td><td>'.round($sga->getSGA(1)[1]). ' MB</td>
								</tr>
								<tr style="color: #ED9C13">
								  <td>'.$sga->getSGA(2)[0].'</td><td>'.round($sga->getSGA(2)[1]). ' MB</td>
								</tr>
								<tr style="color: #ED5713">
								  <td>'.$sga->getSGA(3)[0].'</td><td>'.round($sga->getSGA(3)[1]). ' MB</td>
								</tr>
								<tr style="color: #F6178E">
								  <td>'.$sga->getSGA(4)[0].'</td><td>'.round($sga->getSGA(4)[1]). ' MB</td>
								</tr>
								<tr style="color: #740D7C">
								  <td>'.$sga->getSGA(5)[0].'</td><td>'.round($sga->getSGA(5)[1]). ' MB</td>
								</tr>
								<tr style="color: #e0b712">
								  <td>'.$sga->getSGA(6)[0].'</td><td>'.round($sga->getSGA(6)[1]). ' MB</td>
								</tr>
							  </table>
							</div>
							<button id="botonSGA1" class="botonSGA" onclick="muestraSGARealTime()" >Real-Time SGA</button>
						</div> 					
						<div id="bodyContainer" style="visibility:hidden" >
							<div id="chartContainer" style="height: 250px; width:100%;">
								<script type="text/javascript">
									window.onload = function () {
										var dataPoints1 = [];
										var dataPoints2 = [];

										var chart = new CanvasJS.Chart("chartContainer",{
											zoomEnabled: true,
											title: {
												text: "SGA in Real Time"		
											},
											toolTip: {
												shared: true				
											},
											legend: {
												verticalAlign: "top",
												horizontalAlign: "center",
																fontSize: 14,
												fontWeight: "bold",
												fontFamily: "calibri",
												fontColor: "dimGrey"
											},
											axisX: {
												//title: "chart updates every 3 secs"
											},
											axisY:{
												title: "Size(MB)",
												//suffix: " MB",
												minimum: 0,
												includeZero: false
											}, 
											data: [{ 
												// dataSeries1
												type: "line",
												xValueType: "dateTime",
												showInLegend: true,
												name:"'.$sga->getSGA(2)[0]. '",
												dataPoints: dataPoints1
											},
											{				
												// dataSeries2
												type: "line",
												xValueType: "dateTime",
												showInLegend: true,
												name:"'.$sga->getSGA(3)[0]. '",
												dataPoints: dataPoints2
											}],
										  legend:{
											cursor:"pointer",
											itemclick : function(e) {
											  if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
												e.dataSeries.visible = false;
											  }
											  else {
												e.dataSeries.visible = true;
											  }
											  chart.render();
											}
										  }
										});
										var xVal = 0;
										var bufferCache = 0;
										var sharedPool = 0;
										var updateInterval = 20;
										var dataLength = 500; // number of dataPoints visible at any point

										var updateChart = function (count) {
											count = count || 1;
											// count is number of times loop runs to generate random dataPoints.
											
											for (var j = 0; j < count; j++) {	
												bufferCache = '.round($sga->getSGA(2)[1]). ';
												sharedPool =  '.round($sga->getSGA(3)[1]). ';
												dataPoints1.push({
													x: xVal,
													y: bufferCache
												});
												dataPoints2.push({
													x: xVal,
													y: sharedPool
												});
												xVal++;
											};
											if (dataPoints1.length > dataLength)
											{
												dataPoints1.shift();				
											}
											if (dataPoints2.length > dataLength)
											{
												dataPoints2.shift();				
											}									
											chart.render();	
										};
										// generates first set of dataPoints
										updateChart(dataLength);
										// update chart after specified time. 
										setInterval(function(){updateChart()}, updateInterval); 
									}
								</script>
							</div>
							<button id="botonSGA2" class="botonSGA" onclick="muestraSGAGeneral()" >General SGA</button>
						</div>';
					?>
					</div>
			</div>
		</div>
</div> <!-- div tail-top -->
<?php include("plantillaAbajo.php"); ?>