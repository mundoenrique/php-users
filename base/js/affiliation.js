var path, expDate;
path =window.location.href.split( '/' );
base_url = path[0]+ "//" +path[2] + "/" + path[3];

$(function() {
	// MENU WIDGET TRANSFERENCIA
	$('.transfers').hover(function(){
		$('.submenu-transfer').attr("style","display:block")
	},function(){
		$('.submenu-transfer').attr("style","display:none")
	});

	// MENU WIDGET USUARIO
	$('.user').hover(function(){
		$('.submenu-user').attr("style","display:block")
	},function(){
		$('.submenu-user').attr("style","display:none")
	});

	// CARGA MODAL CTA ORIGEN
	$(".dialog").click(function(){
		$("#content-product").dialog({
			title:"Selección de Cuentas Origen",
			modal:"true",
			width:"940px",
			open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
		});
		$("#cerrar").click(function(){
			$("#content-product").dialog("close");
		});

		// INICIA CONFIGURACION DEL FILTRO TEBCA - SERVITEBCA
		var $container = $('#dashboard-donor');

		$container.isotope({
			itemSelector : '.dashboard-item',
			animationEngine :'jQuery',
			animationOptions: {
				duration: 800,
				easing: 'easeOutBack',
				queue: true
			}
		});

		var $optionSets = $('#filters-stack .option-set'),
			$optionLinks = $optionSets.find('a');

		$optionLinks.click(function(){
			var $this = $(this);

			if($this.hasClass('selected')) {
				return false;
			}
			var $optionSet = $this.parents('.option-set');
			$optionSet.find('.selected').removeClass('selected');
			$this.addClass('selected');

			var options = {},
				key = $optionSet.attr('data-option-key'),
				value = $this.attr('data-option-value');

			value = value === 'false' ? false : value;
			options[ key ] = value;
			if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
				// changes in layout modes need extra logic
				changeLayoutMode( $this, options )
			} else {
				// otherwise, apply new options
				$container.isotope( options );
			}

			return false;
		});          // FINALIZA CONFIGURACION DE FILTROS
	});		 // FIN DE CARGA MODAL CTAS ORIGEN

	$('li.stack-item a').click(function(){                              // FUNCIONALIDAD DE FILTROS CTAS ORIGEN
		$('.stack').find('.current-stack-item').removeClass('current-stack-item');
		$(this).parents('li').addClass('current-stack-item');
	});


	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	// FUNCION PARA OBTENER DATOS DE TARJETA CUENTA ORIGEN
	$(".dashboard-item").click(function(){

		var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre,prefix;

		imagen=$(this).find('img').attr('src');
		tarjeta=$(this).attr('card');
		marca=$(this).attr('marca');
		mascara=$(this).attr('mascara');
		producto=$(this).attr('producto1');
		empresa=$(this).attr('empresa');
		nombre=$(this).attr('nombre');
		prefix=$(this).attr('prefix');

		$("#donor").children().remove();

		cadena='<div class="product-presentation" producto="'+producto+'">';
		cadena+=	'<img src="'+imagen+'" width="200" height="130" alt="" />';
		cadena+=			'<div class="product-network '+marca.toLowerCase()+'"></div>';
		cadena+=							'<input id="donor-cardnumber-origen" name="donor-cardnumber" type="hidden" producto="'+producto+'"  prefix="'+prefix+'" cardOrigen="'+tarjeta+'" />';
		cadena+=			'</div>';
		cadena+=			'<div class="product-info">';
		cadena+=				'<p class="product-cardholder" id="nombreCtaOrigen">'+nombre+'</p>';
		cadena+=				'<p class="product-cardnumber" id="mascara">'+mascara+'</p>';
		cadena+=				'<p class="product-metadata" id="marca">'+producto+'</p>';
		cadena+=				'<nav class="product-stack">';
		cadena+=					'<ul class="stack">';
		cadena+=						'<li class="stack-item">';
		cadena+=							'<a dialog button product-button rel="section" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit"></span></a>';
		cadena+=						'</li>';
		cadena+=					'</ul>';
		cadena+=				'</nav>';
		cadena+=			'</div>';

		$("#donor").append(cadena);          // MOSTRAR DATOS CUENTAS ORIGEN EN LA VISTA PRINCIPAL

		$(".product-button").removeClass("disabled-button");
		$("#month-exp").attr("disabled",false);              // HABILITAR EDICION
		$("#year-exp").attr("disabled",false);
		$("#card-number").attr("disabled",false);
		$("#card-holder").attr("disabled",false);
		$("#bank-account-holder-id").attr("disabled",false);
		$("#card-holder-email").attr("disabled",false);
		$("#afiliar").attr("disabled",false);

		$("#agregarCuenta").attr("href","#");

		$("#agregarCuenta").parents("li").removeClass("disabled-group-action-item");
		$(this).addClass("current-dashboard-item");
		$("#content-product").dialog("close");

		$('.stack-item').click(function(){       //FUNCION PARA MODIFICAR LA TARJETA ORIGEN
			$('#tdestino').children().remove();
			$("#tdestino").append($("#removerDestino").html());
			$("#botonContinuar").attr("disabled",true);
			$("#content-product").dialog({
				title:"Selección de Cuentas Origen",
				modal:"true",
				width:"940px",
				open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			});
		});

	}); //FIN DATOS CUENTA ORIGEN

	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------


	// BOTON AFILIAR USUARIO
	$("#afiliar").click(function(){

		validar_campos();
		$("#validate_afiliacion").submit();
		setTimeout(function(){$("#msg").fadeOut();},5000);
		var form=$("#validate_afiliacion");
		numeroCta=$("#content-holder").find(".nrocta").val();

		email=$("#cargarConfirmacion").find("#ctaAfiliar").attr("email");
		if (form.valid() == true){
			$.post(base_url +"/affiliation/cuentasP2P",{"noTarjeta":numeroCta},function(data){
				if(data.rc == 0){

					beneficiario = data.beneficiario;
					cedula = data.id_ext_per;
					nombre=$("#donor").find(".product-cardholder").html();
					mascara=$("#donor").find(".product-cardnumber").html();
					numeroCtaOrigen=$("#donor").find("#donor-cardnumber-origen").attr("cardOrigen");
					prefix=$("#donor").find("#donor-cardnumber-origen").attr("prefix");
					nombreCtaOrigen=$("#donor").find("#nombreCtaOrigen").html();
					marca=$("#donor").find("#donor-cardnumber-origen").attr("producto");
					email=$("#content-holder").find("#card-holder-email").val();
					expDate = $("#month-exp").val() + $("#year-exp").val();
					var today = new Date();
					hora= (today.getHours())+':'+today.getMinutes()+':'+today.getSeconds();
					var dd = today.getDate();
					var mm = today.getMonth()+1;//January is 0!
					var yyyy = today.getFullYear();
					if(dd<10){dd='0'+dd}
					if(mm<10){mm='0'+mm}
					var fecha = dd+'/'+mm+'/'+yyyy;

					datos_afiliacion=		  '<tr>';
					datos_afiliacion +=        '<td class="data-label"><label>Cuenta Origen</label></td>';
					datos_afiliacion +=        '<td class="data-reference" id="nombreOrigenTransfer" colspan="2" numeroCtaOrigen="'+numeroCtaOrigen+'" nombreCtaOrigen="'+nombre+'" prefix="'+prefix+'" mascara="'+mascara+'" marca="'+marca+'">'+nombre+'<br /><span class="highlight" id="mascaraOrigenTransfer">'+mascara+'</span><br /><span class="lighten"> '+marca+' </span></td>';
					datos_afiliacion +=      '</tr>';
					datos_afiliacion +=       '<tr>';
					datos_afiliacion  +=       '<td class="data-label"><label>Cuenta Destino a Afiliar</label></td>';
					datos_afiliacion  +=       '<td class="data-reference" id="ctaAfiliar" beneficiario="'+beneficiario+'" email="'+email+'" cedula="'+cedula+'" numeroCta="'+numeroCta+'">"'+beneficiario+'" <span class="lighten">("'+email+'")</span><br /> "'+cedula+'"<br /><span class="highlight">"'+numeroCta+'"</span></td>';
					datos_afiliacion  +=    '</tr><tr>';

					$("#cargarConfirmacion").append(datos_afiliacion);
					$("#content-holder").children().remove();
					$("#content-holder").append($("#content-confirmacion").html());

					$(".continuar").click(function(){
						$.post(base_url +"/affiliation/affiliation",{"nroPlasticoOrigen":numeroCtaOrigen,"beneficiario":beneficiario,"nroCuentaDestino":numeroCta,"tipoOperacion":"P2P","email":email,"cedula":cedula,"prefix":prefix, "expDate":expDate},function(data){

							if(data.rc==0||data.rc==-188) {
								datos_finalizacion= 			'<tr>';
								datos_finalizacion+=				'<td class="data-label"><label>Fecha de Operación</label></td>';
								datos_finalizacion+=				'<td class="data-reference">'+fecha+' '+hora+' </td>';
								datos_finalizacion+=			'</tr>';
								datos_finalizacion+=			'<tr>';
								datos_finalizacion+=				'<td class="data-label"><label>Cuenta de Origen</label></td>';
								datos_finalizacion+=				'<td class="data-reference">"'+nombreCtaOrigen+'"<br /><span class="highlight">"'+mascara+'"</span><br /> <span class="lighten"> "'+marca+'" </span> </td>';
								datos_finalizacion+=			'</tr>';
								datos_finalizacion+=			'<tr>';
								datos_finalizacion+=				'<td class="data-label"><label>Cuenta Destino Afiliada</label></td>';
								datos_finalizacion+=				'<td class="data-reference">"'+beneficiario+'"<span class="lighten">("'+email+'")</span><br />"'+cedula+'"<br /><span class="highlight">"'+numeroCta+'"</span><br /></td>';
								datos_finalizacion+=			'</tr>';

								$("#cargarFinalizacion").append(datos_finalizacion);
								$("#content-holder").children().remove();
								if(data.rc==0){
									$("#content-holder").append($("#content-finalizar").html());
								} else {
									$("#content-holder").append($("#content-finalizar2").html());
									$("#cargarFinalizacion3").append(datos_finalizacion);
								}

							} else if(data.rc==-178 || data.rc==-344) {
								var msg;
								$("#dialog-error-afil3").dialog({
									title:"Error Afiliación",
									modal:"true",
									width:"440px",
									open: function(event, ui) {
										$(".ui-dialog-titlebar-close", ui.dialog).hide();
										msg = data.rc === -178 ? 'No se puede realizar el registro. <strong>Cuenta ya afiliada.</strong>' : 'La fecha de vencimiento indicada es incorrecta';
										$('#msgNon').html(msg);
									}
								});

								$("#invalido5").click(function(){
									$("#dialog-error-afil3").dialog("close");
									$(location).attr('href', base_url+'/affiliation');
								});
							} else if(data.rc==-210) {
								$("#dialog-error-afil").dialog({
									title:"Error Afiliación",
									modal:"true",
									width:"440px",
									open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
								});

								$("#invalido2").click(function() {
									$("#dialog-error-afil").dialog("close");
									$(location).attr('href', base_url+'/affiliation');
								});

							} else {
								datos_finalizacion = 			'<tr>';
								datos_finalizacion+=				'<td class="data-label"><label>Fecha de Operación</label></td>';
								datos_finalizacion+=				'<td class="data-reference">'+fecha+' '+hora+' </td>';
								datos_finalizacion+=			'</tr>';
								datos_finalizacion+=			'<tr>';
								datos_finalizacion+=				'<td class="data-label"><label>Cuenta de Origen</label></td>';
								datos_finalizacion+=				'<td class="data-reference">"'+nombreCtaOrigen+'"<br /><span class="highlight">"'+mascara+'"</span><br/> <span class="lighten"> "'+marca+'" </span> </td>';
								datos_finalizacion+=			'</tr>';
								datos_finalizacion+=			'<tr>';
								datos_finalizacion+=				'<td class="data-label"><label>Cuenta Destino Afiliada</label></td>';
								datos_finalizacion+=				'<td class="data-reference">"'+beneficiario+'"<span class="lighten">("'+email+'")</span><br />Documento de Identidad "'+cedula+'"<br /><span class="highlight">"'+numeroCta+'"</span><br /></td>';
								datos_finalizacion+=			'</tr>';

								$("#cargarFinalizacion2").append(datos_finalizacion);
								$("#content-holder").children().remove();
								$("#content-holder").append($("#content-finalizar3").html());

							}
						});

					});//Boton Continuar

				} else if(data.rc == -221 ) {
					$("#dialog-error-afil1").dialog({
						title:"Error Afiliación",
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#invalido3").click(function(){
						$("#dialog-error-afil1").dialog("close");
						$(location).attr('href', base_url+'/affiliation');
					});
				} else {
					$("#dialog-error-afil2").dialog({
						title:"Error Afiliación",
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});
					$("#invalido4").click(function(){
						$("#dialog-error-afil2").dialog("close");
						$(location).attr('href', base_url+'/dashboard');
					});
				}
			});

		}//IF FORM VALID
	});	//BOTON AFILIAR

	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//ESPACIO DE FUNCIONES

	function validar_campos(){
		jQuery.validator.setDefaults({
			debug: true,
			success: "valid"
		});

		$("#validate_afiliacion").validate({
			errorElement: "label",
			ignore: "",
			errorContainer: "#msg",
			errorClass: "field-error",
			validClass: "field-success",
			errorLabelContainer: "#msg",

			rules: {
				"card-number":{"required":true,"number":true,"minlength":16},
				"card-holder-email": {"required":true, "email": true},
				"month-exp": {"required": true},
				"year-exp": {"required": true}
			},
			messages: {
				"card-number": "El número de cuenta no puede estar vacío y debe contener 16 números",
				"card-holder-email": "El correo electrónico no puede estar vacío y debe contener formato correcto. (xxxxx@ejemplo.com)",
				"month-exp": "Seleccione el mes de vencimiento de su tarjeta",
				"year-exp": "Seleccione el año de vencimiento de su tarjeta"
			}
		}); // VALIDATE
	}

	// MODAL TERMINOS Y CONDICIONES
	$(".label-inline").on("click", "a", function() {

		$("#dialog-tc").dialog({
			modal:"true",
			width:"940px",
			open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
		});
		$("#ok").click(function(){
			$("#dialog-tc").dialog("close");
		});

	});


});  //FIN DE LA FUNCION GENERAL
