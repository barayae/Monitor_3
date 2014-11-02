<?php include("plantillaArriba.php"); 
include ("database/conexion.php"); 
@session_start();
$c=new conexion();
$logs=$c->getlogInfo();
$archive_mode=$c->getArchiveStatus();
$class_archive=$archive_mode?"ArchiveOn":"ArchiveOff";
$text_archive=$archive_mode?"ON":"OFF";
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
					<li class="current"><a href="logs.php" rel="1"><span>Log Manager</span><!--<small>Get more information</small>--></a></li>
					<li><a href="spaceManager.php" rel="2"><span>Space Manager</span><small>Get more information</small></a></li>

					
					<li><a href="user.php" rel="2"><span>More Options</span></a></li>
					<!--<li><a href="role.php" rel="2"><span>Role Manager</span><small>Get more information</small></a></li>
					<li><a href="monitoring.php" rel="2"><span>Monitoring</span><small>Get more information</small></a></li>
					<li><a href="bitacora.php" rel="2"><span>Bitacora</span><small>Get more information</small></a></li>-->
				</ul>
					<div class='DivLogs'>
<p class= 'PArchive'> Archive log status   <span class ='<?php echo $class_archive?>'> <?php echo $text_archive?> </span> </p>
<table class='TablaLogs'>
<?php
	foreach ($logs as $index => $log) {
		if($index==0){
			foreach ($log as $index_log => $value_log) {
				echo "<td class='th'>$index_log</th>";
			}
		}
		echo "<tr>";
		foreach ($log as $index_log => $value_log) {
			if($value_log=="CURRENT"){
				echo "<td id='tdCurrent'>$value_log</td>";
			}
			else if($value_log=="INACTIVE"){
				echo "<td id='tdInactive'>$value_log</td>";
			}
			else if($value_log=="UNUSED"){
				echo "<td id='tdUnused'>$value_log</td>";
			}

			else{
				echo "<td>$value_log</td>";
			}
		}
		echo "</tr>";

	}
?>
</table>
</div>
					</div>
			</div>
		</div>
</div> <!-- div tail-top -->
<?php include("plantillaAbajo.php"); ?>