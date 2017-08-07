var path, base_cdn;
path =window.location.href.split( '/' );
base_cdn = decodeURIComponent(document.cookie.replace(/(?:(?:^|.*;\s*)cpo_baseCdn\s*\=\s*([^;]*).*$)|^.*$/, '$1'));
base_url = path[0]+ "//" +path[2] + "/" + path[3];

var montoMaxOperaciones, montoMinOperaciones, dobleAutenticacion, claveValida, claveC, moneda, totaldef, pais, saldo_imp, trans, numberBeneficiary = [3 , 2, 1];

$(function() {

	//Menu desplegable transferencias
	$('.transfers').hover(function () {
		$('.submenu-transfer').attr("style", "display:block")
	}, function () {
		$('.submenu-transfer').attr("style", "display:none")
	});
	// -----------------------------------------------------------------------------------------------------------------

	//Menu desplegable usuario
	$('.user').hover(function () {
		$('.submenu-user').attr("style", "display:block")
	}, function () {
		$('.submenu-user').attr("style", "display:none")
	});
	// -----------------------------------------------------------------------------------------------------------------

	//Verifica si fue ingresada la clave de operaciones
	var confirmacion = $("#content").attr("confirmacion");
	if (confirmacion == '1') {
		$('#content-clave').hide();
		$('#tabs-menu').show();
		$('#content_plata').show();

	} else {
		$('#content-clave').show();
	}

	// -----------------------------------------------------------------------------------------------------------------

	//Boton continuar clave
	$("#continuar_transfer").click(function () {
		var pass = $("#transpwd").val();
		if(pass == '') {
			$('#transpwd').addClass('field-error');
		} else {
			$('#transpwd').removeClass('field-error');
			if ((confirmPassOperac(pass))) {
				$('#content-clave').hide();
				$('#tabs-menu').show();
				$('#content_plata').show();
			} else {

				$('#content_clave').show();
				$.balloon.defaults.classname = "field-error";
				$.balloon.defaults.css = null;
				$("#transpwd").showBalloon({position: "right", contents: "Clave inválida"});
				setTimeout(function () {
					$("#transpwd").hideBalloon();

				}, 3000);
			}
		}
	});
	// -----------------------------------------------------------------------------------------------------------------

});
/*---------------------------------------------------ESPACIO DE FUNCIONES --------------------------------------------*/

function confirmPassOperac(clave){
	var response1;
	var rpta1;
	var ajax_data = {
		"clave":hex_md5(clave)
	};

	$.ajax({
		url: base_url +"/transferencia/operaciones",
		data: ajax_data,
		type: "post",
		dataType: 'json',
        async: false,
		success: function(data) {
			rpta = $.parseJSON(data.response);
			rpta1 = $.parseJSON(data.transferir);
			if(rpta.rc == 0){
				response1 = true;
			} else {
				response1 = false;
				rpta1 = false;
			}
			if(rpta.rc == -61){
				$(location).attr('href', base_url+'/users/error_gral');
			}
		}
	});

	return rpta1;
}

