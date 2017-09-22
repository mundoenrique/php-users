var path, base_cdn, expDate;
path =window.location.href.split( '/' );
base_cdn = path[0]+ "//" +path[2].replace('online','cdn')+'/'+path[3];
base_url = path[0]+ "//" +path[2] + "/" + path[3];


$(function(){

	//  MENU WIDGET TRANSFERENCIAS
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
			// don't proceed if already selected
			if ( $this.hasClass('selected') ) {
				return false;
			}
			var $optionSet = $this.parents('.option-set');
			$optionSet.find('.selected').removeClass('selected');
			$this.addClass('selected');

			// make option object dynamically, i.e. { filter: '.my-filter-class' }
			var options = {},
				key = $optionSet.attr('data-option-key'),
				value = $this.attr('data-option-value');
			// parse 'false' as false boolean
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
	});    // FIN DE CARGA MODAL CTAS ORIGEN

	// FUNCIONALIDAD DE FILTROS CTAS ORIGEN
	$('li.stack-item a').click(function(){
		$('.stack').find('.current-stack-item').removeClass('current-stack-item');
		$(this).parents('li').addClass('current-stack-item');
	});


	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	// FUNCION PARA OBTENER DATOS DE TARJETA CUENTA ORIGEN
	$(".dashboard-item").click(function(){

		var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre;

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
		cadena+=  '<img src="'+imagen+'" width="200" height="130" alt="" />';
		cadena+=      '<div class="product-network '+marca.toLowerCase()+'"></div>';
		cadena+=              '<input id="donor-cardnumber-origen" name="donor-cardnumber" type="hidden" prefix="'+prefix+'" producto="'+producto+'" cardOrigen="'+tarjeta+'" />';
		cadena+=      '</div>';
		cadena+=      '<div class="product-info">';
		cadena+=        '<p class="product-cardholder" id="nombreCtaOrigen">'+nombre+'</p>';
		cadena+=        '<p class="product-cardnumber" id="mascara">'+mascara+'</p>';
		cadena+=        '<p class="product-metadata" id="marca">'+producto+'</p>';
		cadena+=        '<nav class="product-stack">';
		cadena+=          '<ul class="stack">';
		cadena+=            '<li class="stack-item">';
		cadena+=              '<a dialog button product-button rel="section" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit"></span></a>';
		cadena+=            '</li>';
		cadena+=          '</ul>';
		cadena+=        '</nav>';
		cadena+=      '</div>';

		$("#donor").append(cadena);          // MOSTRAR DATOS CUENTAS ORIGEN EN LA VISTA PRINCIPAL

		$(".product-button").removeClass("disabled-button");              // HABILITAR EDICION
		$("#card-number").attr("disabled",false);
		$("#yearExp").attr("disabled",false);
		$("#MonthExp").attr("disabled",false);
		$("#bank-account-holder").attr("disabled",false);
		$("#bank-account-holder-id").attr("disabled",false);
		$("#bank-account-holder-email").attr("disabled",false);
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

	}); //FIN CUENTA ORIGEN

	getBancos();

	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	// BOTON AFILIAR USUARIO
	$("#afiliar").click(function(){

		validar_campos();

		$("#validate_afiliacion").submit();
		setTimeout(function(){$("#msg").fadeOut();},5000);

		var form=$("#validate_afiliacion");

		var numeroCta, beneficiario, cedula, email,datos_afiliacion;
		nombre=$("#donor").find(".product-cardholder").html();
		mascara=$("#donor").find(".product-cardnumber").html();
		numeroCtaOrigen=$("#donor").find("#donor-cardnumber-origen").attr("cardOrigen");
		nombreCtaOrigen=$("#donor").find("#nombreCtaOrigen").html();
		marca=$("#donor").find("#donor-cardnumber-origen").attr("producto");
		//marca=$("#donor").find("#marca").html();
		//banco=$("#donor").find(".banco").html();

		numeroCta=$("#content-holder").find(".nrocta").val();
		beneficiario=$("#content-holder").find("#bank-account-holder").val();
		cedula=$("#content-holder").find("#bank-account-holder-id").val();
		email=$("#content-holder").find("#bank-account-holder-email").val();
		banco=$('#bank-name option:selected').val();
		nombre_banco = $('#bank-name option:selected').text();
		prefix=$("#donor").find("#donor-cardnumber-origen").attr("prefix");
		expDate = $('#MonthExp').val() + $('#yearExp').val();
		var tipo_doc=$('#doc-name option:selected').val();

		var id_per_comp= tipo_doc+cedula;

		datos_afiliacion=     '<tr>';
		datos_afiliacion+=        '<td class="data-label"><label>Cuenta Origen</label></td>';
		datos_afiliacion+=        '<td class="data-reference" id="nombreOrigenTransfer" colspan="2" nombreCtaOrigen="'+nombreCtaOrigen+'" numeroCtaOrigen="'+numeroCtaOrigen+'" prefix="'+prefix+'" mascara="'+mascara+'" marca="'+marca+'">'+nombre+'<br /><span class="highlight" id="mascaraOrigenTransfer">'+mascara+'</span><br /><span class="lighten"> '+marca+' </span></td>';
		datos_afiliacion+=      '</tr>';
		datos_afiliacion+=       '<tr>';
		datos_afiliacion+=       '<td class="data-label"><label>Cuenta Destino a Afiliar</label></td>';
		datos_afiliacion+=       '<td class="data-reference" id="ctaAfiliar" beneficiario="'+beneficiario+'" email="'+email+'" cedula="'+id_per_comp+'" numeroCta="'+numeroCta+'" nombre_banco="'+nombre_banco+'" banco="'+banco+'">"'+beneficiario+'" <span class="lighten">("'+email+'")</span><br />'+id_per_comp+'<br /><span class="highlight">'+numeroCta+'</span><br /><span class="lighten">"'+nombre_banco+'"</span></td>';
		datos_afiliacion+=    '</tr><tr>';

		cod_ban=numeroCta.substr(0,1);
		banc=true;
		if ((cod_ban!='5')&&cod_ban!='4'){
			banc=false;
			$("#dialog-banco").dialog({
				title:"Tarjeta inválida",
				modal:"true",
				width:"440px",
				open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			});

			$("#banco_inv").click(function(){
				$("#dialog-banco").dialog("close");
			});
			$(this).val("");
		}


		if ((form.valid() == true) && (banc==true)){

			$("#content").children().remove();
			$("#content").append($("#content-confirmacion").html());
			$("#cargarConfirmacion").append(datos_afiliacion);

			// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

			// BOTON CONTINUAR AFILIACION
			$(".continuar").click(function(){

				var datos_finalizacion;
				var today = new Date();
				hora= (today.getHours())+':'+today.getMinutes()+':'+today.getSeconds();
				var dd = today.getDate();
				var mm = today.getMonth()+1;//January is 0!
				var yyyy = today.getFullYear();
				if(dd<10){dd='0'+dd}
				if(mm<10){mm='0'+mm}
				var fecha = dd+'/'+mm+'/'+yyyy;
				numeroCtaOrigen=$("#cargarConfirmacion").find("#nombreOrigenTransfer").attr("numeroCtaOrigen");
				nombreCtaOrigen=$("#cargarConfirmacion").find("#nombreOrigenTransfer").attr("nombreCtaOrigen");
				prefix=$("#cargarConfirmacion").find("#nombreOrigenTransfer").attr("prefix");
				marca=$("#cargarConfirmacion").find("#nombreOrigenTransfer").attr("marca");
				mascara= $("#cargarConfirmacion").find("#nombreOrigenTransfer").attr("mascara");
				beneficiario=$("#cargarConfirmacion").find("#ctaAfiliar").attr("beneficiario");
				numeroCta=$("#cargarConfirmacion").find("#ctaAfiliar").attr("numeroCta");
				email= $("#cargarConfirmacion").find("#ctaAfiliar").attr("email");
				cedula =$("#cargarConfirmacion").find("#ctaAfiliar").attr("cedula");
				banco =$("#cargarConfirmacion").find("#ctaAfiliar").attr("banco");
				nombre_banco = $("#cargarConfirmacion").find("#ctaAfiliar").attr("nombre_banco");

				$.post(base_url +"/affiliation/affiliation_P2T",{"nroPlasticoOrigen":numeroCtaOrigen,"beneficiario":beneficiario,"nroCuentaDestino":numeroCta,"tipoOperacion":"P2C","email":email,"cedula":cedula,"banco":banco,"prefix":prefix, "expDate":expDate},function(data){
					if(data.rc == -61){
						$(location).attr('href', base_url+'/users/error_gral');
					}
					if(data.rc==0||data.rc==-188){

						datos_finalizacion=      '<tr>';
						datos_finalizacion+=        '<td class="data-label"><label>Fecha de Operación</label></td>';
						datos_finalizacion+=        '<td class="data-reference"> <span class="lighten"> '+fecha+'  '+hora+' </span></td>';
						datos_finalizacion+=      '</tr>';
						datos_finalizacion+=      '<tr>';
						datos_finalizacion+=        '<td class="data-label"><label>Cuenta de Origen</label></td>';
						datos_finalizacion+=        '<td class="data-reference">"'+nombreCtaOrigen+'"<br /><span class="highlight">"'+mascara+'"</span><br /> <span class="lighten"> "'+marca+'" </span> </td>';
						datos_finalizacion+=      '</tr>';
						datos_finalizacion+=      '<tr>';
						datos_finalizacion+=        '<td class="data-label"><label>Cuenta Destino Afiliada</label></td>';
						datos_finalizacion+=        '<td class="data-reference">"'+beneficiario+'"<span class="lighten">("'+email+'")</span><br />"'+cedula+'"<br /><span class="highlight">"'+numeroCta+'"</span><br /><span class="lighten">"'+nombre_banco+'"</span></td>';
						datos_finalizacion+=      '</tr>';

						$("#content").children().remove();
						$("#cargarFinalizacion").append(datos_finalizacion);
						if (data.rc==0){
							$("#content").append($("#content-finalizar").html());
						} else {
							$("#content").append($("#content-finalizar2").html());
							$("#cargarFinalizacion3").append(datos_finalizacion);
						}

					}
					else if(data.rc==-178) {
						$("#dialog-error-afil2").dialog({
							title:"Error Afiliación",
							modal:"true",
							width:"440px",
							open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
						});

						$("#invalido3").click(function(){
							$("#dialog-error-afil2").dialog("close");
							$(location).attr('href', base_url+'/affiliation/affiliation_bank');
						});
					}
					else if(data.rc==-210){
						$("#dialog-error-afil").dialog({
							title:"Error Afiliación",
							modal:"true",
							width:"440px",
							open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
						});

						$("#invalido2").click(function(){
							$("#dialog-error-afil").dialog("close");
							$(location).attr('href', base_url+'/affiliation/affiliation_tdc');
						});

					} else {
						var msgAfiliation = '';


						switch (data.rc) {
							case -340:
								msgAfiliation = 'Cantidad de dígitos de la cuenta es invalida.';
								break;
							case -341:
								msgAfiliation = 'El número de cuenta no corresponde al banco.';
								break;
							case -342:
								msgAfiliation = 'Número de cuenta invalido';
								break;
							case -343:
								var men = transferencia.msg;
								msgAfiliation = 'Su tarjeta se encuentra bloqueada, código de bloqueo: (' + men.substr(34,35) + ')';
							case -344:
								msgAfiliation = 'la fecha de expiracion indicada es incorrecta';
								break;
							default:

						}

						datos_finalizacion =      '<tr>';
						datos_finalizacion+=        '<td class="data-label"><label>Fecha de Operación:</label></td>';
						datos_finalizacion+=        '<td class="data-reference"><span class="lighten"> '+fecha+' '+hora+' </span></td>';
						datos_finalizacion+=      '</tr>';
						datos_finalizacion+=      '<tr>';
						datos_finalizacion+=        '<td class="data-label"><label>Cuenta de Origen</label></td>';
						datos_finalizacion+=        '<td class="data-reference">"'+nombreCtaOrigen+'"<br /><span class="highlight">"'+mascara+'"</span><br /> <span class="lighten"> "'+marca+'" </span> </td>';
						datos_finalizacion+=      '</tr>';
						datos_finalizacion+=      '<tr>';
						datos_finalizacion+=        '<td class="data-label"><label>Cuenta Destino</label></td>';
						datos_finalizacion+=        '<td class="data-reference">"'+beneficiario+'"<span class="lighten">("'+email+'")</span><br />"'+cedula+'"<br /><span class="highlight">"'+numeroCta+'"</span><br /><span class="lighten">"'+nombre_banco+'"</span></td>';
						datos_finalizacion+=      '</tr>';


						$("#content").children().remove();
						$("#content").append($("#content-finalizar3").html());
						$('#nonAfiliation').text(msgAfiliation);
						$("#cargarFinalizacion2").append(datos_finalizacion);

					}   //ELSE
				});  // POST

			});//BOTON CONTINUAR
		}   //FORM VALID

	});   //BOTON AFILIAR

	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	// FUNCION VALIDAR CAMPOS
	function validar_campos(){
		jQuery.validator.setDefaults({
			debug: true,
			success: "valid"
		});

		jQuery.validator.addMethod("numOnly", function(value, element) {
			var regEx = /^[a-zA-Z0-9]+$/,
				token = element.value;

			if (regEx.test(token)) {
				return true;
			} else {
				return false;
			}
		});

		// jQuery.validator.addMethod("lettersonly", function(value, element){
		// 	return this.optional(element) || /^[a-z," "]+$/i.test(value);
		// });

		var letter = /^[a-zA-Z_áéíóúñ\s]*$/;

		$("#validate_afiliacion").validate({

			errorElement: "label",
			ignore: "",
			errorContainer: "#msg",
			errorClass: "field-error",
			validClass: "field-success",
			errorLabelContainer: "#msg",
			rules: {
				"bank-name":"required",
				"bank-account-holder": {"required":true, "pattern":letter},
				"doc-name": {"required":true},
				"card-number":{"required":true,"number":true, "minlength":16, "maxlength": 16},
				"bank-account-holder-id": {"number":true, "required":true, "maxlength": 14, "minlength":5, "numOnly":true},
				"bank-account-holder-email": {"required":true, "email": true},
				"MonthExp": {"required": true},
				"yearExp": {"required": true}
			},
			messages: {
				"bank-name":"Debe seleccionar un banco",
				"bank-account-holder": {
					required: "El beneficiario no puede estar vacío",
					pattern: "El beneficiario no debe tener caracteres especiales"
				},
				"card-number": "El número de cuenta no puede estar vacío y debe contener solo números y debe contener 16 números",
				"doc-name": "El Tipo de Documento no puede estar vacío.",
				"bank-account-holder-id": {
					required: "El documento de identidad no puede estar vacío",
					number: "El documento de identidad debe ser numérico y no debe tener caracteres especiales",
					minlength: "El documento de identidad debe tener un mínimo de 5 caracteres",
					numOnly: "El documento de identidad debe ser numérico y no debe tener caracteres especiales"
				},
				"bank-account-holder-email": "El correo electrónico no puede estar vacío y debe contener formato correcto. (xxxxx@ejemplo.com)",
				"MonthExp": "Seleccione el mes de vencimiento de su tarjeta",
				"yearExp": "Seleccione el año de vencimiento de su tarjeta"
			}
		}); // VALIDATE
	}

	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	// FUNCION PARA OBTENER LISTADO DE BANCOS
	function getBancos() {

		$.ajaxSetup({async: false});

		$.post(base_url +"/affiliation/bancos",function(data){

			$.each(data.lista,function(pos,item){

				var lista;

				lista="<option value="+item.codBcv+" nombre="+item.nomBanco+"> "+item.nomBanco+" </option>";
				$("#bank-name").append(lista);

			});

		});
	}

	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

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
