var base_url, base_cdn, expDate;
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');
var pais;

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
			open: function(event, ui) {
				$(".ui-dialog-titlebar-close", ui.dialog).hide();
			}
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

		var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre;

		imagen=$(this).find('img').attr('src');
		tarjeta=$(this).attr('card');
		marca=$(this).attr('marca');
		mascara=$(this).attr('mascara');
		producto=$(this).attr('producto1');
		empresa=$(this).attr('empresa');
		nombre=$(this).attr('nombre');
		pais=$(this).attr("pais");

		$("#donor").children().remove();

		cadena='<div class="product-presentation" producto="'+producto+'">';
		cadena+=	'<img src="'+imagen+'" width="200" height="130" alt="" />';
		cadena+=			'<div class="product-network '+marca.toLowerCase()+'"></div>';
		cadena+=							'<input id="donor-cardnumber-origen" name="donor-cardnumber" type="hidden" nombreOrigen="'+nombre+'" cardOrigen="'+tarjeta+'" masCtaOrigen="'+masCtaOrigen+'" marcaCtaOrigen="'+marca+'"  />';
		cadena+=			'</div>';
		cadena+=			'<div class="product-info-full">';
		cadena+=				'<p class="product-cardholder" id="nombreCtaOrigen">'+nombre+'</p>';
		cadena+=				'<p class="product-cardnumber" id="mascara">'+mascara+'</p>';
		cadena+=				'<p class="product-metadata" id="marca">'+producto+'</p>';
		cadena+=				'<nav class="product-stack" id="selCtaOrigen">';
		cadena+=					'<ul class="stack">';
		cadena+=						'<li class="stack-item">';
		cadena+=							'<a dialog button product-button rel="section" id="buscarCta" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit"></span></a>';
		cadena+=						'</li>';
		cadena+=					'</ul>';
		cadena+=				'</nav>';
		cadena+=			'</div>';

		$("#donor").append(cadena);          // MOSTRAR DATOS CUENTAS ORIGEN EN LA VISTA PRINCIPAL
		$(".product-button").removeClass("disabled-button");              // HABILITAR EDICION
		$("#agregarCuenta").attr("href","#");

		$("#agregarCuenta").parents("li").removeClass("disabled-group-action-item");
		$(this).addClass("current-dashboard-item");
		$("#content-product").dialog("close");

		// var ctaOrigen=$(this).attr("card");
		var ctaOrigen=$("#donor-cardnumber-origen").attr("cardorigen");
		var masCtaOrigen=$("#donor-cardnumber-origen").attr("masCtaOrigen");
		var marcaCtaOrigen=$("#donor-cardnumber-origen").attr("marcaCtaOrigen");
		var nombreOrigen=$("#donor-cardnumber-origen").attr("nombreOrigen");
		var prefijo = $(this).attr("prefix")
		mes = $("#filter-month").val();
		anio = $("#filter-year").val();

		$("#buscar").removeClass("disabled-button");  //Habilita el boton buscar del filtro

		$('#list-detail').children().remove();
		buscar_ctaDestino(ctaOrigen,prefijo,masCtaOrigen,marcaCtaOrigen,nombreOrigen);


		$('.stack-item').click(function(){       //FUNCION PARA MODIFICAR LA TARJETA ORIGEN
			$('#dashboard').children().remove();
			//$("#tdestino").append($("#removerDestino").html());
			$("#botonContinuar").attr("disabled",true);
			$("#content-product").dialog({
				                             title:"Selección de Cuentas Origen",
				                             modal:"true",
				                             width:"940px",
				                             open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                             });
		});

	});//FIN
	//$(".muestraDestino").click(function(){

	function buscar_ctaDestino(ctaOrigen,prefijo,masCtaOrigen,marcaCtaOrigen,nombreOrigen){
		var clase,clase1;

		var cpo_cook = decodeURIComponent(
			document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);

		var dataRequest = JSON.stringify ({
			"nroTarjeta":ctaOrigen,
			"prefijo":prefijo,
			"operacion":"P2P"
		})

		dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

		$.post("transferencia/ctaDestino",{request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},function(response) {

			data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
			if(data.rc == -61){
				$(location).attr('href', base_url+'/users/error_gral');
			}
			if(data.rc==0){
				$('#empty-state').remove();
				$.each(data.cuentaDestinoPlata,function(pos,item){
					imagen1=item.nombre_producto.toLowerCase();
					imagen2=normaliza(imagen1);
					imagen3=imagen2.replace(" ", "-");
					imagen4=imagen3.replace(" ", "-");
					imagen=imagen4.replace('/','-');
					var cadena;

					cadena=  "<li class='dashboard-item "+item.nomEmp+" muestraDestino' card='"+item.noTarjeta+"' id_ext_per='"+item.id_ext_per+"' nombre='"+item.NombreCliente+"' emailCliente='"+item.emailCliente+"' id_afiliacion='"+item.id_afiliacion+"' marca='"+item.marca+"' mascara='"+item.noTarjetaConMascara+"' empresa='"+item.nomEmp+"' producto='"+item.nombre_producto.replace(' ','-')+"'>";
					cadena+=		"<div class='dashboard-item-box'>"
					cadena+=			"<img src='"+base_cdn+"img/products/"+pais+"/"+imagen+".png' width='200' height='130' alt='' />"
					cadena+=			"<div class='dashboard-item-network "+item.marca.toLowerCase()+"'>"+item.marca+"</div>"
					cadena+=			"<div class='dashboard-item-info'>"
					cadena+=				"<p class='dashboard-item-cardholder'>"+item.NombreCliente+"</p>"
					cadena+=				"<ul class='dashboard-item-actions'>"
					cadena+=					"<li class='actions-item'>"
					cadena+=						"<a title='Modificar' id='modificar'><span aria-hidden='true' class='icon-edit'></span></a>"
					cadena+=					"</li>"
					cadena+=					"<li class='actions-item' id='eliminar'>"
					cadena+=						"<a title='Remover'><span aria-hidden='true' class='icon-remove'></span></a>"
					cadena+=					"</li>"
					cadena+=				"</ul>"
					cadena+=				"<p class='dashboard-item-cardnumber'>"+item.noTarjetaConMascara+"</p>"
					cadena+=				"<p class='dashboard-item-category'>"+item.nombre_producto+"</p>"
					cadena+=			"</div>"
					cadena+=		"</div>"
					cadena+=	"</li>"

					$("#dashboard").append(cadena);

				});

				$('.muestraDestino').on('click',"#modificar",function(){

					var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre;

					tarjeta =$(this).parents(".dashboard-item").attr('card');
					id_ext_per=$(this).parents(".dashboard-item").attr('id_ext_per');
					nombre=$(this).parents(".dashboard-item").attr('nombre');
					emailCliente=$(this).parents(".dashboard-item").attr('emailCliente');
					id_afiliacion=$(this).parents(".dashboard-item").attr('id_afiliacion');


					$('#selCtaOrigen').attr("style","display:none");

					$("#content-holder").children().remove();

					var ctaDestino, fechaExp,yearNow, fullYearDate,fiveyearLess, fiveYearMore, i, yearSelect = [];
					yearNow = new Date();
					fullYearDate = yearNow.getFullYear();
					fiveyearLess = fullYearDate - 5;
					fiveYearMore = fullYearDate + 15;

					for (i = fiveyearLess; i <= fiveYearMore; i++){
						yearSelect.push(i);
					}

					ctaDestino = "<div id='progress'>"
					ctaDestino+= 	"<ul class='steps'>"
					ctaDestino+= 		"<li class='step-item current-step-item'><span aria-hidden='true' class='icon-edit'></span> Modificación de Afiliación</li>"
					ctaDestino+= 		"<li class='step-item'><span aria-hidden='true' class='icon-view'></span> Confirmación</li>"
					ctaDestino+= 		"<li class='step-item'><span aria-hidden='true' class='icon-thumbs-up'></span> Finalización</li>"
					ctaDestino+= 	"</ul>"
					ctaDestino+= "</div>"
					ctaDestino+= "<div id='content-holder'>"
					ctaDestino+= "<form id='datos'>"
					ctaDestino+= "<ul class='field-group'>"
					ctaDestino+= 	"<li class='field-group-item'>"
					ctaDestino+= 		"<label for='dayExp'>Fecha de vcto. cta. origen</label>"
					ctaDestino+= 		"<select id='month-exp' name='month-exp' style='margin-right: 5px;'>"
					ctaDestino+=            "<option value=''>Mes</option>"
					ctaDestino+=			"<option value='01'>01</option>"
					ctaDestino+=			"<option value='02'>02</option>"
					ctaDestino+=			"<option value='03'>03</option>"
					ctaDestino+=			"<option value='04'>04</option>"
					ctaDestino+=			"<option value='05'>05</option>"
					ctaDestino+=			"<option value='06'>06</option>"
					ctaDestino+=			"<option value='07'>07</option>"
					ctaDestino+=			"<option value='08'>08</option>"
					ctaDestino+=			"<option value='09'>09</option>"
					ctaDestino+=			"<option value='10'>10</option>"
					ctaDestino+=			"<option value='11'>11</option>"
					ctaDestino+=			"<option value='12'>12</option>"
					ctaDestino+= 		"</select>"
					ctaDestino+= 		"<select id='year-exp' name='year-exp'>"
					ctaDestino+=			"<option value=''>Año</option>"
					ctaDestino+= 		"</select>"
					ctaDestino+= 	"</li>"
					ctaDestino+=    "<li class='field-group-item'>"
					ctaDestino+=       "<label for='card-number'>N° de Cuenta Destino</label>"
					ctaDestino+=       "<input class='field-medium' id='card-number' name='card-number' maxlength='16' type='text' value="+tarjeta+" />"
					ctaDestino+=    "</li>"
					ctaDestino+=   " <li class='field-group-item'>"
					ctaDestino+=       "<label for='card-holder'>Beneficiario</label>"
					ctaDestino+=       "<input class='field-large' id='card-holder' name='card-holder' maxlength='30' type='text' value='"+nombre+"' />"
					ctaDestino+=    "</li>"
					ctaDestino+= "</ul>"
					ctaDestino+=  "<ul class='field-group'>"
					ctaDestino+=    "<li class='field-group-item'>"
					ctaDestino+=       "<label for='bank-account-holder-id'>Documento de Identidad</label>"
					ctaDestino+=       "<input class='field-medium' id='bank-account-holder-id' name='bank-account-holder-id' maxlength='9' type='text' value="+id_ext_per+" />"
					ctaDestino+=    "</li>"
					ctaDestino+=    "<li class='field-group-item'>"
					ctaDestino+=       "<label for='card-holder-email'>Correo Electrónico</label>"
					ctaDestino+=       "<input class='field-large' id='card-holder-email' name='card-holder-email' maxlength='30'  type='text' value="+emailCliente+" />"
					ctaDestino+=    "</li>"
					ctaDestino+= "</ul>"
					ctaDestino+= "</form>"
					ctaDestino+="<div class='form-actions'>"
					ctaDestino+="<button id='cancelar1' type='reset' class='novo-btn-secondary'>Cancelar</button>";
					ctaDestino+="<button id='cambiar' class='novo-btn-primary'>Modificar</button>"
					ctaDestino+="</div>"
					ctaDestino+="</div>"
					ctaDestino+="<div id='msg'></div>"

					$("#content-holder").append(ctaDestino);

					$.each(yearSelect,function(index,value){
						var lastDigit = value.toString().substring(2,4);
						var yearPrueba =  "<option value='"+lastDigit+"'>"+value+"</option>";
						$("#year-exp").append(yearPrueba);
					})

					$("#cancelar1").click(function(){

						$(location).attr('href', base_url+'/adm');

					});

					$("#cambiar").click(function(){


						validar_campos();

						$("#datos").submit();

						setTimeout(function(){$("#msg").fadeOut();},5000);

						var form, notSms, notEmail;

						form=$("#datos");
						if(form.valid() == true) {
							var confirmacion;
							var cDestino=$("#card-number").val();
							var nombreDest=$("#card-holder").val();
							var id_per=$("#bank-account-holder-id").val();
							var emailClienteD=$("#card-holder-email").val();
							expDate = $('#month-exp').val() + $('#year-exp').val();


							$('#selCtaOrigen').attr("style","display:none");
							$("#content-holder").children().remove();

							confirmacion= "<div id='progress'>"
							confirmacion+= "<ul class='steps'>"
							confirmacion+= 	"<li class='step-item completed-step-item'><span aria-hidden='true' class='icon-edit'></span> Modificación de Afiliación</li>"
							confirmacion+= 	"<li class='step-item current-step-item'><span aria-hidden='true' class='icon-view'></span> Confirmación</li>"
							confirmacion+= 	"<li class='step-item'><span aria-hidden='true' class='icon-thumbs-up'></span> Finalización</li>"
							confirmacion+= "</ul>"
							confirmacion+= "</div>"
							confirmacion+= "<div id='content-holder'>"
							confirmacion+= "<h2>Confirmación</h2>";
							confirmacion+= 	"<table class='receipt' cellpadding='0' cellspacing='0' width='100%'>"
							confirmacion+= 		"<tbody>";
							confirmacion+= 			"<tr>";
							confirmacion+= 				"<td class='data-label'><label>Cuenta de Origen</label></td>";
							confirmacion+= 				"<td class='data-reference'>"+nombreOrigen+"<br /><span class='highlight'>"+ctaOrigen+"</span><br /><span class='lighten'>"+marcaCtaOrigen+"</span></td>";
							confirmacion+= 			"</tr>";
							confirmacion+= 			"<tr>";
							confirmacion+= 				"<td class='data-label'><label>Cuenta Destino a Afiliar</label></td>";
							confirmacion+= 				"<td class='data-reference'>"+nombreDest+"<span class='lighten'>( "+emailClienteD+" )</span><br /> "+id_per+" <br /><span class='highlight'>"+cDestino+"</span></td>";
							confirmacion+= 			"</tr>";
							confirmacion+= 		"</tbody>";
							confirmacion+= 	"</table>";
							confirmacion+= 	"<div class='form-actions'>";
							confirmacion+= 		"<button id='cancelar2' type='reset' class='novo-btn-secondary'>Cancelar</button>";
							confirmacion+= 		"<button id='continuar' class='novo-btn-primary'>Continuar</button>";
							confirmacion+= 	"</div>";
							confirmacion+=   "</div>";
							$("#content-holder").append(confirmacion);

							$("#cancelar2").click(function(){

								$(location).attr('href', base_url+'/adm');

							});

							$("#continuar").click(function(){

								var cpo_cook = decodeURIComponent(
									document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
								  );

									var dataRequest = JSON.stringify ({
										"id_afiliacion":id_afiliacion,
										"nroPlasticoOrigen":ctaOrigen,
										"nroCuentaDestino":cDestino,
										"id_ext_per":id_per,
										"beneficiario":nombreDest,
										"tipoOperacion":"P2P",
										"email":emailClienteD,
										"banco":"",
										"expDate":expDate
									})

									dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();
								$.post("adm/modificar",{request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},function(response) {

									data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));

									if(data.rc==0){
										var exito;
										$("#progress").attr('style','display:none');
										$("#content-holder").children().remove();
										exito= "<div id='progress'>"
										exito+=		"<ul class='steps'>"
										exito+=			"<li class='step-item completed-step-item'><span aria-hidden='true' class='icon-edit'></span> Modificación de Afiliación</li>"
										exito+=			"<li class='step-item completed-step-item'><span aria-hidden='true' class='icon-view'></span> Confirmación</li>"
										exito+=			"<li class='step-item current-step-item'><span aria-hidden='true' class='icon-thumbs-up'></span> Finalización</li>"
										exito+=		"</ul>"
										exito+=	"</div>"
										exito+=	"<div class='alert-success' id='message'>"
										exito+=	"<span aria-hidden='true' class='icon-ok-sign'></span> Afiliación modificada satisfactoriamente"
										exito+= "</div>";
										exito+= 	"<div class='form-actions'>";
										exito+= 		"<button id='exit' class='novo-btn-primary'>Finalizar</button>";
										exito+= 	"</div>";
										$("#content-holder").append(exito);
									}

									else{
										var exito;
										var msg = data.rc === -344 ? 'la fecha de expiracion indicada es incorrecta' : '';
										$("#progress").attr('style','display:none');
										$("#content-holder").children().remove();
										exito= "<div class='alert-error' id='message'>";
										exito+=	"<span aria-hidden='true' class='icon-cancel-sign'></span> Afiliación no modificada, " + msg;
										exito+= "</div>";
										exito+= 	"<div class='form-actions'>";
										exito+= 		"<button id='exit' class='novo-btn-primary'>Finalizar</button>";
										exito+= 	"</div>";
										$("#content-holder").append(exito);
									}

									$("#exit").click(function(){

										$(location).attr('href', base_url+'/adm');

									});
								});
							});
						}
						$("#cancelar").click(function(){

							$(location).attr('href', base_url+'/adm');

						});

					});

				});

				$('.muestraDestino').on('click',"#eliminar",function(){

					tarjeta =$(this).parents(".dashboard-item").attr('card');
					id_ext_per=$(this).parents(".dashboard-item").attr('id_ext_per');
					nombre=$(this).parents(".dashboard-item").attr('nombre');
					emailCliente=$(this).parents(".dashboard-item").attr('emailCliente');

					$('#selCtaOrigen').attr("style","display:none");
					var eliminar;
					$("#content-holder").children().remove();

					eliminar= "<div id='progress'>"
					eliminar+=		"<ul class='steps two-steps'>"
					eliminar+=			"<li class='step-item current-step-item'><span aria-hidden='true' class='icon-remove'></span> Eliminación de Afiliación</li>"
					eliminar+=			"<li class='step-item'><span aria-hidden='true' class='icon-thumbs-up'></span> Finalización</li>"
					eliminar+=		"</ul>"
					eliminar+=	"</div>"
					eliminar+=	"<div id='content-holder'>"
					eliminar+=		"<h2>Eliminación de Afiliación</h2>"
					eliminar+=		"<p>Por favor, verifique los datos de la afiliación que Ud. está a punto de remover.</p>"
					eliminar+=			"<table class='receipt' cellpadding='0' cellspacing='0' width='100%'>"
					eliminar+=				"<tbody>"
					eliminar+=					"<tr>"
					eliminar+=						"<td class='data-label'><label>Cuenta de Origen</label></td>"
					eliminar+=						"<td class='data-reference'>"+nombreOrigen+"<br /><span class='highlight'>"+ctaOrigen+"</span><br /><span class='lighten'>"+marcaCtaOrigen+"</span></td>"
					eliminar+=					"</tr>"
					eliminar+=					"<tr>"
					eliminar+=						"<td class='data-label'><label>Cuenta Destino Afiliada</label></td>"
					eliminar+=						"<td class='data-reference'>"+nombre+"<span class='lighten'>( "+emailCliente+" )</span><br />"+id_ext_per+"<br /><span class='highlight'>"+tarjeta+"</span></td>";
					eliminar+=					"</tr>"
					eliminar+=				"</tbody>"
					eliminar+=			"</table>"
					eliminar+=			"<div class='form-actions'>"
					eliminar+=				"<button id='cancel' type='reset' class='novo-btn-secondary'>Cancelar</button>"
					eliminar+=				"<button id='cont' class='novo-btn-primary'>Continuar</button>"
					eliminar+=			"</div>"
					eliminar+=	"</div>"
					$("#content-holder").append(eliminar);

					$("#cont").click(function(){
						$.ajaxSetup({async: false});

						var cpo_cook = decodeURIComponent(
							document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
						  );

							var dataRequest = JSON.stringify ({
							"noTarjeta":ctaOrigen,
							"noCuentaDestino":tarjeta,
							"tipoOperacion":"P2P",
							"cpo_name":cpo_cook
							})

							dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

						$.ajax({
							       url: base_url +"/adm/eliminar",
							       data: {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},
							       type: "post",
							       dataType: 'json',
							       success: function(response) {
											data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));

								       if(data.rc==0){

									       $("#progress").attr('style','display:none');
									       $("#content-holder").children().remove();
									       exito= "<div id='progress'>";
									       exito+= "<ul class='steps two-steps'>";
									       exito+= "<li class='step-item completed-step-item'><span aria-hidden='true' class='icon-remove'></span> Eliminación de Afiliación</li>";
									       exito+= "<li class='step-item current-step-item'><span aria-hidden='true' class='icon-thumbs-up'></span> Finalización</li>";
									       exito+= "</ul>";
									       exito+= "</div>";
									       exito+= "<div class='alert-success' id='message'>";
									       exito+=	"<span aria-hidden='true' class='icon-ok-sign'></span> Afiliación eliminada satisfactoriamente";
									       exito+= "</div>";
									       exito+= 	"<div class='form-actions'>";
									       exito+= 		"<button id='exit' class='novo-btn-primary'>Finalizar</button>";
									       exito+= 	"</div>";
									       $("#content-holder").append(exito);
								       }
								       else{
									       var exito;
									       $("#progress").attr('style','display:none');
									       $("#content-holder").children().remove();
									       exito= "<div class='alert-error' id='message'>";
									       exito+=	"<span aria-hidden='true' class='icon-cancel-sign'></span> Afiliación no eliminada";
									       exito+= "</div>";
									       exito+= 	"<div class='form-actions'>";
									       exito+= 		"<button id='exit' class='novo-btn-primary'>Finalizar</button>";
									       exito+= 	"</div>";
									       $("#content-holder").append(exito);
								       }

								       $("#exit").click(function(){

									       $(location).attr('href', base_url+'/adm');

								       });

							       }
						       });

						$.ajaxSetup({async: true});
						//$.post("adm/eliminar",{"noTarjeta":ctaOrigen, "noCuentaDestino":tarjeta,"tipoOperacion":"P2P"},function(data) {
						// if(data.rc==0){

						// 	$("#progress").attr('style','display:none');
						//      		$("#content-holder").children().remove();
						// 	exito= "<div id='progress'>";
						// 	exito+= "<ul class='steps two-steps'>";
						// 	exito+= "<li class='step-item completed-step-item'><span aria-hidden='true' class='icon-remove'></span> Eliminación de Afiliación</li>";
						// 	exito+= "<li class='step-item current-step-item'><span aria-hidden='true' class='icon-thumbs-up'></span> Finalización</li>";
						// 	exito+= "</ul>";
						// 	exito+= "</div>";
						// 	exito+= "<div class='alert-success' id='message'>";
						// 	exito+=	"<span aria-hidden='true' class='icon-ok-sign'></span> Afiliación eliminada satisfactoriamente";
						// 	exito+= "</div>";
						// 	exito+= 	"<div class='form-actions'>";
						// 	exito+= 		"<button id='exit'>Finalizar</button>";
						// 	exito+= 	"</div>";
						// 	$("#content-holder").append(exito);
						// }
						// if(data.rc == -61){
						// 	$(location).attr('href', base_url+'/users/error_gral');
						// }
						// else{
						// 	var exito;
						//      		$("#progress").attr('style','display:none');
						//      		$("#content-holder").children().remove();
						// 	exito= "<div class='alert-error' id='message'>";
						// 	exito+=	"<span aria-hidden='true' class='icon-cancel-sign'></span> Afiliación no eliminada";
						// 	exito+= "</div>";
						// 	exito+= 	"<div class='form-actions'>";
						// 	exito+= 		"<button id='exit'>Finalizar</button>";
						// 	exito+= 	"</div>";
						// 	$("#content-holder").append(exito);
						// }
						// $("#exit").click(function(){

						// 					$(location).attr('href', base_url+'/adm');

						// 			});
						//});

					});

					$("#cancel").click(function(){
						$(location).attr('href', base_url+'/adm');

					});
				});

			}else{
				$('#empty-state').children().remove();
				var cadena='<div id="empty-state" style="position: static;">';
				cadena+=                '<h2>No se encontraron tarjetas asociadas</h2>';
				cadena+=                 '<p>Vuelva a realizar la búsqueda con una tarjeta distinta.</p>';
				cadena+=                '<span aria-hidden="true" class="icon-cancel-sign" style="position: relative;right: -415px;"></span>';
				cadena+=             '</div>';
				$("#empty-state").append(cadena);

			}
		});

	}

	// VALIDACIONES

	function validar_campos(){

		jQuery.validator.setDefaults({
			                             debug: true,
			                             success: "valid"
		                             });


		$("#datos").validate({

			                     errorElement: "label",
			                     ignore: "",
			                     errorContainer: "#msg",
			                     errorClass: "field-error",
			                     validClass: "field-success",
			                     errorLabelContainer: "#msg",
			                     rules: {
				                     "card-number": {"required":true,"number": true, "minlength":16},
				                     "card-holder": {"required":true},
				                     "bank-account-holder-id": {"required":true,"number": true},
				                     "card-holder-email": {"required":true, "email": true},
				                     "month-exp": {"required": true},
				                     "year-exp": {"required": true}
			                     },

			                     messages: {
				                     "card-number": "El n° de cuenta destino no puede estar vacío y debe contener solo números.",
				                     "card-holder": "El beneficiario no puede estar vacío.",
				                     "bank-account-holder-id": "El documento de identidad no puede estar vacío y debe contener solo números.",
				                     "card-holder-email": "El correo electrónico no puede estar vacío y debe contener formato correcto. (xxxxx@ejemplo.com).",
				                     "month-exp": "Seleccione el mes de vencimiento de su tarjeta",
				                     "year-exp": "Seleccione el año de vencimiento de su tarjeta"
			                     }
		                     }); // VALIDATE
	}
	function normaliza(text) {

		var acentos = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç";

		var original = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc";

		for (var i=0; i<acentos.length; i++) {

			text = text.replace(acentos.charAt(i), original.charAt(i));

		}

		return text;

	}

});  //FIN DE LA FUNCION GENERAL


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
