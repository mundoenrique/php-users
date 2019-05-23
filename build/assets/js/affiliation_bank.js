var base_url, base_cdn, expDate;
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');

$(function(){

	// MENU WIDGET TRANSFERENCIAS
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
	});		 // FIN DE CARGA MODAL CTAS ORIGEN

	// FUNCIONALIDAD DE FILTROS CTAS ORIGEN
	$('li.stack-item a').click(function(){
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
		cadena+=							'<input id="donor-cardnumber-origen" name="donor-cardnumber" type="hidden" producto="'+producto+'"  prefix="'+prefix+'"  cardOrigen="'+tarjeta+'" />';
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

		$(".product-button").removeClass("disabled-button");              // HABILITAR EDICION
		$("#year-exp").attr("disabled",false);              // HABILITAR EDICION
		$("#month-exp").attr("disabled",false);
		$("#card-number").attr("disabled",false);
		$("#bank-account-holder").attr("disabled",false);
		$("#bank-account-holder-id").attr("disabled",false);
		$("#bank-account-holder-email").attr("disabled",false);
		$("#afiliarBank").attr("disabled",false);

		$("#agregarCuenta").attr("href","#");

		$("#agregarCuenta").parents("li").removeClass("disabled-group-action-item");

		$.each($(".dashboard-item"), function(pos,item){
			if($(this).hasClass("current-dashboard-item")){
				$(this).removeClass("current-dashboard-item");
			}
		});   //FIN DATOS CUENTA ORIGEN


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

		$("#afiliarBank").removeClass('disabled-button');

	});//FIN

	getBancos();

	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	// BOTON AFILIAR USUARIO
	$('#content-holder').on('click',"#afiliarBank",function(){

		validar_campos();

		$("#validate_afiliacion").submit();

		setTimeout(function(){$("#msg").fadeOut();},5000);

		var form, value, beneficiario, numeroCta, cedula, email, nombre, mascara, numeroCtaOrigen, nombreCtaOrigen, marca, datos_afiliacion;

		form=$("#validate_afiliacion");

		banco=$('#bank-name option:selected').text();
		codBanco=$('#bank-name option:selected').val();
		beneficiario=$("#content-holder").find("#bank-account-holder").val();
		numeroCta=$("#content-holder").find("#card-number").val();
		var tipo_doc=$('#doc-name option:selected').val();
		cedula=$("#content-holder").find("#bank-account-holder-id").val();
		email=$("#content-holder").find("#bank-account-holder-email").val();

		var id_per_comp= tipo_doc+cedula;

		nombre=$("#donor").find(".product-cardholder").html();
		mascara=$("#donor").find(".product-cardnumber").html();
		numeroCtaOrigen=$("#donor").find("#donor-cardnumber-origen").attr("cardOrigen");
		nombreCtaOrigen=$("#donor").find("#nombreCtaOrigen").html();
		//marca=$("#donor").find("#marca").html();
		marca=$("#donor").find("#donor-cardnumber-origen").attr("producto");
		prefix=$("#donor").find("#donor-cardnumber-origen").attr("prefix");
		expDate = $('#month-exp').val() + $('#year-exp').val();

		datos_afiliacion=		 '<tr>';
		datos_afiliacion+=        '<td class="data-label"><label>Cuenta Origen</label></td>';
		datos_afiliacion+=        '<td class="data-reference" id="nombreOrigenTransfer" colspan="2" numeroCtaOrigen="'+numeroCtaOrigen+'" nombreCtaOrigen="'+nombreCtaOrigen+'" prefix="'+prefix+'" mascara="'+mascara+'" marca="'+marca+'">'+nombre+'<br /><span class="highlight" id="mascaraOrigenTransfer">'+mascara+'</span><br /><span class="lighten"> '+marca+' </span></td>';
		datos_afiliacion+=      '</tr>';
		datos_afiliacion+=      '<tr>';
		datos_afiliacion+=       '<td class="data-label"><label>Cuenta Destino a Afiliar</label></td>';
		datos_afiliacion+=       '<td class="data-reference" id="ctaAfiliar" beneficiario="'+beneficiario+'" email="'+email+'" cedula="'+id_per_comp+'" numeroCta="'+numeroCta+'" banco="'+banco+'" codBanco="'+codBanco+'">"'+beneficiario+'" <span class="lighten">("'+email+'")</span><br />'+id_per_comp+'<br /><span class="highlight">'+numeroCta+'</span><br /><span class="lighten">'+banco+'</span></td>';
		datos_afiliacion+=      '</tr>';

		//VALIDACION DE CODIGO DE BANCO
		cod_ban=numeroCta.substr(0,4);
		banc=true;
		if (cod_ban!=codBanco){
			banc=false;
			$("#dialog-banco").dialog({
				title:"Cuenta inválida",
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

		}

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
			mascara= $("#cargarConfirmacion").find("#nombreOrigenTransfer").attr("mascara");
			beneficiario=$("#cargarConfirmacion").find("#ctaAfiliar").attr("beneficiario");
			numeroCta=$("#cargarConfirmacion").find("#ctaAfiliar").attr("numeroCta");
			email=$("#cargarConfirmacion").find("#ctaAfiliar").attr("email");
			cedula=$("#cargarConfirmacion").find("#ctaAfiliar").attr("cedula");
			banco=$("#cargarConfirmacion").find("#ctaAfiliar").attr("codBanco");
			nombre_banco=$("#cargarConfirmacion").find("#ctaAfiliar").attr("banco");
			marca=$("#cargarConfirmacion").find("#nombreOrigenTransfer").attr("marca");

			$.post(base_url +"/affiliation/affiliation_P2T",{"nroPlasticoOrigen":numeroCtaOrigen,"beneficiario":beneficiario,"nroCuentaDestino":numeroCta,"tipoOperacion":"P2T","email":email,"cedula":cedula,"banco":banco,"prefix":prefix, "expDate":expDate},function(data){
				if(data.rc == -61){
					$(location).attr('href', base_url+'/users/error_gral');
				} else if(data.rc==0 || data.rc==-188) {

					datos_finalizacion =      '<tr>';
					datos_finalizacion+=        '<td class="data-label"><label>Fecha de Operación:</label></td>';
					datos_finalizacion+=        '<td class="data-reference"><span class="lighten"> '+fecha+' '+hora+' </span></td>';
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

					if(data.rc==0){
						$("#content").append($("#content-finalizar").html());
					}else{
						$("#content").append($("#content-finalizar2").html());
						$("#cargarFinalizacion3").append(datos_finalizacion);
					}
				} else if(data.rc==-195){
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
						$(location).attr('href', base_url+'/affiliation/affiliation_bank');
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
							msgAfiliation = 'la fecha de vencimiento indicada es incorrecta';
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


				} //ELSE
				//console.log("HOLA");
			}); //POST

		});	//BOTON CONTINUAR

	});  //AFILIAR BANK


	//ESPACIO DE FUNCIONES

	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	// OBTENER LISTADO DE BANCOS
	function getBancos() {

		$.ajaxSetup({async: false});
		$.post(base_url +"/affiliation/bancos",function(data){
			$.each(data.lista,function(pos,item){

				var lista;

				lista="<option value="+item.codBcv+"> "+item.nomBanco+" </option>";
				$("#bank-name").append(lista);

			});

		});
	} //GET BANCOS


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
		// 	//return this.optional(element) || /^[a-z\s]+$/i.test(value);
		// 	console.log(value);
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

				"bank-name": "required",
				"card-number": {"required":true,"number":true, "minlength":20, "maxlength": 20},    //{"required":true,"number":true}
				"doc-name": {"required":true},
				"bank-account-holder-id": {"number":true, "required":true, "maxlength": 14, "minlength":5, "numOnly":true},
				"bank-account-holder": {"required":true, "pattern":letter},
				"bank-account-holder-email": {"required":true, "email": true},
				"month-exp": {"required": true},
				"year-exp": {"required": true}
			},
			messages: {

				"bank-name": "Debe seleccionar el banco",
				"card-number": "El número de cuenta no puede estar vacío y debe contener 20 dígitos",
				"doc-name": "El Tipo de Documento no puede estar vacío.",
				"bank-account-holder-id": {
					required: "El documento de identidad no puede estar vacío",
					number: "El documento de identidad debe ser numérico y no debe tener caracteres especiales",
					minlength: "El documento de identidad debe tener un mínimo de 5 caracteres",
					numOnly: "El documento de identidad debe ser numérico y no debe tener caracteres especiales"
				},
				"bank-account-holder": {
					required: "El beneficiario no puede estar vacío",
					pattern: "El beneficiario no debe tener caracteres especiales"
				},
				"bank-account-holder-email": "El correo electrónico no puede estar vacío y debe contener formato correcto. (xxxxx@ejemplo.com)",
				"month-exp": "Seleccione el mes de vencimiento de su tarjeta",
				"year-exp": "Seleccione el año de vencimiento de su tarjeta"
			}
		}); // VALIDATE
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
