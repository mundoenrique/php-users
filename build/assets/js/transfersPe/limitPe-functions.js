//Función para enviar mensajes del sistema al usuario
function msgService (title, msg, modalType, redirect) {
	$("#registrar").fadeIn();
	$("#dialogo-movil").dialog({
		title	:title,
		modal	:"true",
		resizable: false,
		closeOnEscape: false,
		width	:"440px",
		open	: function(event, ui) {
			$(".ui-dialog-titlebar-close", ui.dialog).hide();
			//Cambia el tipo de alerta - warning - error - success
		  $("#modalType").addClass(modalType);
			$('#msgService').html(msg);
		}

	});
	$("#inva5").click(function(){
		$("#dialogo-movil").dialog("close");
		if(redirect == 1){
			$(location).attr('href', base_url + '/limit/pe');
		}
	});
}
