function muestraSGARealTime(){
	document.getElementById("bodyContainer").style.visibility = "visible";
	document.getElementById("bodyChart").style.visibility = "hidden";
};

function muestraSGAGeneral(){
	document.getElementById("bodyContainer").style.visibility = "hidden";
	document.getElementById("bodyChart").style.visibility = "visible";
};
$(function() {
			$("#cosa").dialog({
				autoOpen: false
			});
			$("#bottonAgregarNivel").on("click", function() {
				$("#cosa").dialog("open")
			});
			$("#dialog").dialog({
				autoOpen: false
			});
			$("#editLevel").on("click", function() {
				$("#dialog").dialog("open")
			});
			$("#bottonAgregarPrivilegio").on("click", function() {
				$("#addPriv").dialog("open")
			});
			$("#buttonSubmitDialog").button();
			$("#buttonSubmitD").button();
			$("#selectPrivs").selectmenu();
			$("#selectPrivs2").selectmenu();
			$("#selectTabs").selectmenu();
			$("#selectTabs2").selectmenu();
		});