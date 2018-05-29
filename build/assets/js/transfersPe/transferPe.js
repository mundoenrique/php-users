$(function() {
	operationType = 'P2P';
	var montoLabel = $("#montoLabel").val();

	//CARGA MODAL CTA ORIGEN------------------------------------------------------------------------
	$(".dialog").on('click', function() {
		modalCtasOrigen();
	});
	//----------------------------------------------------------------------------------------------



	//CAMBIO DATA DE TRANSFERENCIA TEL-NUMERO CUENTA------------------------------------------------
	$("input:radio[name=tipoRef]").on('change', function(e){
		//validación
		$("#msg-history").html("");
		//Cambio
		var tipo = $("input:radio[name=tipoRef]:checked").val();

		if(tipo == 1){
			//activa e inactiva elementos de transaccion
			$("#cardSelect").hide();
			$("#cardText").show();
			$("#telefonoDestino").attr('disabled',true);
			$('#form-trx').find('input, textarea, button, select').attr('disabled',false);
			$("#ctaDestino").addClass('ignore');
			$("#ctaDestinoText").removeClass('ignore');
			$("#telefonoDestino").val('');
			$('#search-cards').attr('disabled',true);
			$("#continuar").attr('disabled',false);

			//limpia validaciones
			$('#form-search').find('input, textarea, button, select').removeClass('field-error field-success');

		}
		else{
			//activa e inactiva elementos de transaccion
			$("#ctaDestino").removeClass('ignore');
			$("#ctaDestinoText").addClass('ignore');
			$("#cardSelect").show();
			$("#cardText").hide();
			$('#form-trx').find('input, textarea, button, select').attr('disabled',true);
			$('#form-search').find('input, textarea, button, select').attr('disabled',false);
			$("#ctaDestinoText").val('');
			$('#search-cards').attr('disabled',false);
			$("#continuar").attr('disabled',true);

			//limpia validaciones
			$('#form-trx')[0].reset();
			$('#form-trx').find('input, textarea, button, select').removeClass('field-error field-success');
		}
	})

	//----------------------------------------------------------------------------------------------

	//OBTENER DATOS CTA ORIGEN----------------------------------------------------------------------
	$(".dashboard-item").click(function() {
		var imagen, tarjeta, marca, mascara, producto, empresa, montoDebitar, cadena, nombre,
			saldoCero, i;


		imagen = $(this).find('img').attr('src');
		tarjeta = $(this).attr('card');
		marca = $(this).attr('marca').toLowerCase();
		mascara = $(this).attr('mascara');
		producto = $(this).attr('producto1');
		empresa = $(this).attr('empresa');
		nombre = $(this).attr('nombre');
		pais = $(this).attr("pais");
		montoDebitar = saldoCero = (pais == 'Pe' || pais == 'Usd') ? '0.00' : '0,00';
		$("#ctaOrigen").val(tarjeta);

		$("#donor").children().remove();

		cadena='<div class="product-presentation" producto="'+producto+'">';
		cadena+=	'<img src="'+imagen+'" width="200" height="130" alt="" />';
		cadena+=			'<div class="product-network '+marca.toLowerCase()+'"></div>';
		cadena+=				'<input id="donor-cardnumber-origen" name="donor-cardnumber" type="hidden" cardOrigen="'+tarjeta+'" />';
		cadena+=			'</div>';
		cadena+=			'<div class="product-info">';
		cadena+=				'<p class="product-cardholder" id="nombreCtaOrigen">'+nombre+'</p>';
		cadena+=				'<p class="product-cardnumber">'+mascara+'</p>';
		cadena+=				'<p class="product-metadata">'+producto+'</p>';
		cadena+=				'<nav class="product-stack">';
		cadena+=					'<ul class="stack">';
		cadena+=						'<li class="stack-item">';
		cadena+=							'<a dialog button product-button rel="section" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit"></span></a>';
		cadena+=						'</li>';
		cadena+=					'</ul>';
		cadena+=				'</nav>';
		cadena+=			'</div>';
		cadena+=	'<div class="product-scheme">';
		cadena+=		'<ul class="product-balance-group" style="margin: 10px 0">';
		cadena+=			'<li>Disponible <span class="product-balance" id="balance-available">' + moneda +' ' + saldoCero + '</span></li>';
		cadena+=			'<li>A debitar <span class="product-balance debitar" monto-transfer id="balance-debit">' + moneda + ' ' + montoDebitar + '</span></li>';
		cadena+=		'</ul>';
		cadena+= 	"<ul class='field-group'>";
		cadena+= 		"<li class='field-group-item'>";
		cadena+= 		"</li>";
		cadena+=	"</ul>";
		cadena+= '</div>';

		// HABILITA CAMPOS DE TRANSACCIÓN ----------------------------------------------------------
		$("#tipoRef").removeAttr('disabled');
		$("#tipoRef2").removeAttr('disabled');
		$("#telefonoDestino").removeAttr('disabled');
		$('#search-cards').removeAttr('disabled');

		// MOSTRAR DATOS CUENTAS ORIGEN EN LA VISTA PRINCIPAL---------------------------------------
		$("#donor").append(cadena);


		// CARGAR SALDO CUENTAS ORIGEN--------------------------------------------------------------
		$.post(base_url + "/dashboard/saldo", {"tarjeta":$(this).attr("card")},
			function(data) {
				var saldoCtaOrigen = data.disponible;
				if (typeof saldoCtaOrigen != 'string') {
					saldoCtaOrigen = "---";
				}

				$("#balance-available").html(moneda + ' ' + saldoCtaOrigen);
				$("#balance-available").attr("saldo", saldoCtaOrigen);
			});

		// QUITA EL ESTILO DE SELECCIONADO A LA TARJETA -------------------------------------------
		$.each($(".dashboard-item"), function(pos,item){
			if($(this).hasClass("current-dashboard-item")){
				$(this).removeClass("current-dashboard-item");
			}
		});

		// QUITA EL ESTILO DE SELECCIONADO A LA TARJETA -------------------------------------------
		$(this).addClass("current-dashboard-item");
		$("#content-product").dialog("close");
		var nroTarjeta = $(this).attr("card"),
			prefijo = $(this).attr("prefix"),
			operacion = 'P2P';

	});

	//EDITAR CUENTAS ORIGEN-------------------------------------------------------------------------

	$('#donor').on('click', '.stack-item', function() {
		modalCtasOrigen();
	});

	//BUSCAR LAS TARJETAS ASOCIADAS AL TELEFONO --------------------------------------------------------------
	$("#search-cards").on('click',function(){
		validar_campos();
		$("#form-search").submit();
		$("#form-search").valid();
	});
});

//REALIZAR TRANSACCION PE---------------------------------------------------------------------------------
$("#continuar").on('click',function(){
	var form;
	var action =  $("#continuar").attr('action');
	//Selecciona el formulario a enviar

	switch(action){
		case 'form-confirm':
				form = $("#form-trx");

			break;
		case 'form-trx':
				var cuentaDestino = ($("#ctaDestinoText").val() === '') ? $("#ctaDestino").val() : $("#ctaDestinoText").val();
				var ajax_data = {
						'ctaOrigen' : $("#donor-cardnumber-origen").attr('cardorigen'),
						'ctaDestino' : cuentaDestino,
						'monto' : $("#monto").val(),
						'descripcion' : $("#descripcion").val(),
						'pin' : ''
				};
				var formData = $.param(ajax_data);
				makeTransferPe(formData);
				$('#progress > ul > li:nth-child(3)')
					.addClass('current-step-item');
			break;
		case 'form-pin':
				form = $("#form-pin");
		break;
	}

	if(form !== "")
	{
		validar_campos();
		form.submit();
		form.valid();
	}

});
//FINALIZA TRANZACCION ---------------------------------------------------------------------------------

/*-----------------------------------------ESPACIO DE FUNCIONES-----------------------------------*/

//MODAL CTAS ORIGEN---------------------------------------------------------------------------------
function modalCtasOrigen()
{
	$("#content-product").dialog({
		title:"Selección de Cuentas Origen",
		modal:"true",
		width:"950px",
		open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
	});
	$("#cerrar").click(function(){
		$("#content-product").dialog("close");
	});
}

/*------------------------------------------------------------------------------------------------*/
