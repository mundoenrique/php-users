var path, base_cdn;
path =window.location.href.split( '/' );
base_cdn = decodeURIComponent(document.cookie.replace(/(?:(?:^|.*;\s*)cpo_baseCdn\s*\=\s*([^;]*).*$)|^.*$/, '$1'));
base_url = path[0]+ "//" +path[2] + "/" + path[3];

var montoMaxOperaciones,montoMinOperaciones,dobleAutenticacion,claveValida,claveC,moneda,totaldef, pais,saldo_imp,trans;

$(function(){

	var confirmacion = $("#content").attr("confirmacion");
	if(confirmacion== '1'){
		$('#content-clave').hide();
		$('#tabs-menu').show();
		$('#content_plata').show();

	}else{
		$('#content-clave').show();
	}

	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//Menu desplegable

	$('.transfers').hover(function(){
		$('.submenu-transfer').attr("style","display:block")
	},function(){
		$('.submenu-transfer').attr("style","display:none")
	});

	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//Menu desplegable usuario

	$('.user').hover(function(){
		$('.submenu-user').attr("style","display:block")
	},function(){
		$('.submenu-user').attr("style","display:none")
	});


	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//Boton continuar clave

	$("#continuar_transfer").click(function(){
		var pass=$("#transpwd").val();
		if((confirmPassOperac(pass))){
			$('#content-clave').hide();
			$('#content_plata').show();
		}else{
			$('#content_clave').show();

			$.balloon.defaults.classname = "field-error";
			$.balloon.defaults.css = null;
			$("#transpwd").showBalloon({position: "right", contents: "Clave inválida"});
			setTimeout(function() {
				$("#transpwd").hideBalloon();

			}, 3000);
		}
	});



	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//count=contar_tarjetas_destino();

	$(".dialog").click(function() {                    // CARGA MODAL CTA ORIGEN

		$("#content-product").dialog({
			title:"Selección de Cuentas Origen",
			modal:"true",
			width:"940px",
			open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
		});
		$("#cerrar").click(function(){
			$("#content-product").dialog("close");
		});

		$.each($(".dashboard-item"),function(pos,item){					// MUESTRA CTAS ORIGEN EN MODAL
			$.post(base_url+"/dashboard/saldo",{"tarjeta":$(item).attr("card")},function(data){
				var moneda=$(".dashboard-item").attr("moneda");
				var saldo=data.disponible;
				if (typeof saldo!='string'){
					saldo="---";
				}

				$(item).find(".dashboard-item-balance").html(moneda+saldo);
			});
		});

		var $container = $('#dashboard-donor');        // INICIA CONFIGURACION DEL FILTRO TEBCA - SERVITEBCA

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


	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	$('li.stack-item a').click(function(){                              // FUNCIONALIDAD DE FILTROS CTAS ORIGEN
		$('.stack').find('.current-stack-item').removeClass('current-stack-item');
		$(this).parents('li').addClass('current-stack-item');
	});


	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	$(".dashboard-item").click(function(){              // FUNCION PARA OBTENER DATOS DE TARJETA CUENTA ORIGEN

		var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre, moneda, fechaExp, yearNow, fullYearDate, fiveyearLess, fiveYearMore, i, yearSelect = [];
		yearNow = new Date();
		fullYearDate = yearNow.getFullYear();
		fiveyearLess = fullYearDate - 5;
		fiveYearMore = fullYearDate +5;


		for (i = fiveyearLess; i <= fiveYearMore; i++) {
			yearSelect.push(i);
		}

		imagen=$(this).find('img').attr('src');
		tarjeta=$(this).attr('card');
		marca=$(this).attr('marca').toLowerCase();
		mascara=$(this).attr('mascara');
		producto=$(this).attr('producto1');
		empresa=$(this).attr('empresa');
		nombre=$(this).attr('nombre');
		moneda=$(this).attr("moneda");
		pais=$(this).attr("pais");

		$("#donor").children().remove();

		cadena='<div class="product-presentation" producto="'+producto+'">';
		cadena+=	'<img src="'+imagen+'" width="200" height="130" alt="" />';
		cadena+=			'<div class="product-network '+marca+'"></div>';
		cadena+=							'<input id="donor-cardnumber-origen" name="donor-cardnumber" type="hidden" cardOrigen="'+tarjeta+'" />';
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
		cadena+=			'<li>Disponible <span class="product-balance" id="balance-available">'+moneda+' 0.00</span></li>';
		cadena+=			'<li>A debitar <span class="product-balance debitar" id="balance-debit">'+moneda+' 0.00</span></li>';
		cadena+=		'</ul>';
		cadena+= 	"<ul class='field-group'>";
		cadena+= 		"<li class='field-group-item'>";
		cadena+= 			"<label for='dayExp'>Fecha de Vencimiento</label>";
		cadena+= 			"<select id='MonthExp' name='MonthExp'>";
		cadena+=            	"<option value=''>Mes</option>";
		cadena+=				"<option value='01'>01</option>";
		cadena+=				"<option value='02'>02</option>";
		cadena+=				"<option value='03'>03</option>";
		cadena+=				"<option value='04'>04</option>";
		cadena+=				"<option value='05'>05</option>";
		cadena+=				"<option value='06'>06</option>";
		cadena+=				"<option value='07'>07</option>";
		cadena+=				"<option value='08'>08</option>";
		cadena+=				"<option value='09'>09</option>";
		cadena+=				"<option value='10'>10</option>";
		cadena+=				"<option value='11'>11</option>";
		cadena+=				"<option value='12'>12</option>";
		cadena+= 			"</select>";
		cadena+= 			"<select id='yearExp' name='yearExp'>";
		cadena+=				"<option value=''>Año</option>";
		cadena+= 			"</select>";
		cadena+= 		"</li>";
		cadena+=	"</ul>";
		cadena+=	'</div>';

		$("#donor").append(cadena);          // MOSTRAR DATOS CUENTAS ORIGEN EN LA VISTA PRINCIPAL
		$.each(yearSelect,function(index,value){
			var lastDigit = value.toString().substring(2,4);
			var yearPrueba =  "<option value='"+lastDigit+"'>"+value+"</option>";
			$("#yearExp").append(yearPrueba);
		});

		$.post(base_url+"/dashboard/saldo",{"tarjeta":$(this).attr("card")},function(data){           // CARGAR SALDO CUENTAS ORIGEN
			var saldo=data.disponible;
			if (typeof saldo!='string'){
				saldo="---";
			}

			$("#balance-available").html(moneda+saldo);
			$("#balance-available").attr("saldo",saldo);
		});

		$(".product-button").removeClass("disabled-button");              // HABILITAR EDICION CUENTAS DESTINO
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
			$("#continuar").attr("disabled",true);
			$("#content-product").dialog({
				                             title:"Selección de Cuentas Origen",
				                             modal:"true",
				                             width:"940px",
				                             open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                             });
		});

		$.post("transferencia/ctaDestino",{"nroTarjeta":$(this).attr("card"),"prefijo":$(this).attr("prefix"),"operacion":"P2P"},function(data) {  //FUNCION PARA CARGAR CUENTAS DESTINO
			if(data.rc==-150){

				$("#content_plata").children().remove();
				$("#tabs-menu").children().remove();
				$("#content_plata").append($("#content-no-afil").html());
				$("#content-no-afil").children().remove();
				$("#content-destino").dialog("close");
			}

			//else{
			if(data.rc==-0){

				montoMaxOperaciones = data.parametrosTransferencias[0].montoMaxOperaciones;
				montoMinOperaciones = data.parametrosTransferencias[0].montoMinOperaciones;
				montoMaxDiario =data.parametrosTransferencias[0].montoMaxDiario;
				montoMaxSemanal =data.parametrosTransferencias[0].montoMaxSemanal;
				montoMaxMensual =data.parametrosTransferencias[0].montoMaxMensual;
				cantidadOperacionesDiarias =data.parametrosTransferencias[0].cantidadOperacionesDiarias;
				cantidadOperacionesSemanales =data.parametrosTransferencias[0].cantidadOperacionesSemanales;
				cantidadOperacionesMensual =data.parametrosTransferencias[0].cantidadOperacionesMensual;
				montoAcumDiario =data.parametrosTransferencias[0].montoAcumDiario;
				montoAcumSemanal =data.parametrosTransferencias[0].montoAcumSemanal;
				montoAcumMensual =data.parametrosTransferencias[0].montoAcumMensual;
				acumCantidadOperacionesDiarias =data.parametrosTransferencias[0].acumCantidadOperacionesDiarias;
				acumCantidadOperacionesSemanales =data.parametrosTransferencias[0].acumCantidadOperacionesSemanales;
				acumCantidadOperacionesMensual =data.parametrosTransferencias[0].acumCantidadOperacionesMensual;
				dobleAutenticacion = data.parametrosTransferencias[0].dobleAutenticacion;

				$("#dashboard-beneficiary").empty();

				$.each(data.cuentaDestinoPlata,function(pos,item){

					imagen1=item.nombre_producto.toLowerCase();
					imagen2=normaliza(imagen1);
					imagen3=imagen2.replace(" ", "-");
					imagen4=imagen3.replace(" ", "-");
					imagen=imagen4.replace('/','-');

					cadena=" <li class='dashboard-item "+item.nomEmp+" muestraDestino' card='"+item.noTarjeta+"' nombre='"+item.NombreCliente+"' marca='"+item.marca+"' mascara='"+item.noTarjetaConMascara+"' empresa='"+item.nomEmp+"' producto='"+item.nombre_producto+"'>";
					cadena+= "<a rel='section' class='escogerDestino'>";
					cadena+= "<img src='"+base_cdn+"/img/products/"+pais+"/"+imagen+".png' width='200' height='130' alt='' />";
					cadena+=  "<div class='dashboard-item-network "+item.marca.toLowerCase()+"'>"+item.marca+"</div>";
					cadena+= "<div class='dashboard-item-info'>";
					cadena+= "<p class='dashboard-item-cardholder'>"+item.NombreCliente+"</p>";
					cadena+=  "<p class='dashboard-item-cardnumber'>"+item.noTarjetaConMascara+"</p>";
					cadena+=  "<p class='dashboard-item-category'>"+item.nombre_producto+"</p>";
					cadena+= "</div>";
					cadena+= " </a>";
					cadena+=  "</li>";

					$("#dashboard-beneficiary").append(cadena);

				});

			}
			if(data.rc == -61) {
				$(location).attr('href', base_url+'/users/error_gral');
			}
			// -----------------------------------------------------  MUESTRA DESTINO  ------------------------------------------------------------------------------

			// FUNCION PARA OBTENER DATOS DE LA CUENTA DESTINO
			$(".muestraDestino").click(function() {

				if ($(this).hasClass('disabled-dashboard-item') == true) {
					$("#content-destino").dialog("close");

				} else {

					var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre;

					imagen=$(this).find('img').attr('src');
					tarjeta=$(this).attr('card');
					marca=$(this).attr('marca');
					mascara=$(this).attr('mascara');
					producto=$(this).attr('producto');
					empresa=$(this).attr('empresa');
					nombre=$(this).attr('nombre');

					$(".edit").remove();

					var number = contar_tarjetas();

					cadena= '<div class="group"> ';
					cadena+=    '<div class="product-presentation">';
					cadena+=	    '<img src="'+imagen+'" width="200" height="130" alt="" />';
					cadena+=		'<div class="product-network '+marca.toLowerCase()+'"></div>';
					cadena+=		    '<input id="tarjetaDestino" name="tarjetaDestino" type="hidden" value="'+tarjeta+'" />';
					cadena+=			'<input id="marcaDestino" name="marcaDestino" type="hidden" value="'+moneda+'" />';
					cadena+=			'<input id="marca" name="marcaDestino" type="hidden" value="'+producto+'" />';
					cadena+=        '</div>';
					cadena+=		'<div class="product-info">';
					cadena+=			'<p class="product-cardholder">'+nombre+'</p>';
					cadena+=			'<p class="product-cardnumber">'+mascara+'</p>';
					cadena+=			'<p class="product-metadata">'+producto+'</p>';
					cadena+=			'<nav class="product-stack">';
					cadena+=				'<ul class="stack">';
					cadena+=					'<li class="stack-item modifica">';
					cadena+=					    '<a rel="section" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit"></span></a>';
					cadena+=					'</li>';
					cadena+=					'<li class="stack-item elimina">';
					cadena+=					   	'<a rel="section" title="Remover"><span aria-hidden="true" class="icon-cancel"></span></a>';
					cadena+=					'</li>';
					cadena+=				'</ul>';
					cadena+=			'</nav>';
					cadena+=		'</div>';
					cadena+=		'<div class="product-scheme">';
					cadena+=            '<fieldset class="form-inline">';
					cadena+=                '<label for="beneficiary-1x-description" title="Descripción de la transferencia.">Concepto</label>';
					cadena+=                '<input class="field-large mont" id="beneficiary-'+number+'x-description" maxlength="60" name="beneficiary-1x-description" type="text" />';
					cadena+=                '<label for="beneficiary-1x-amount" title="Monto a transferir.">Importe</label>';
					cadena+=                '<div class="field-category"> '+moneda+' ';
					cadena+=                    '<input id="beneficiary-1x-coin" name="beneficiary-1x-coin" type="hidden" value="'+moneda+'."/>';
					cadena+=                '</div>';
					cadena+=                    '<input class="field-small monto dinero" id="beneficiary-'+number+'-amount" maxlength="12" name="beneficiary-1x-amount"/> <br/>';
					cadena+=            '</fieldset>';
					cadena+=        '</div>';
					cadena+= '</div>';


					$("#content_plata #tdestino").append(cadena);          // FUNCION PARA MOSTRAR LA TARJETA DESTINO SELECCIONADA
					$("#beneficiary-1x").removeClass("obscure-group");   //FUNCION PARA HABILITAR CAMPOS PARA EL DETALLE
					$("#content-destino").dialog("close");   // CIERRO EL MODAL AL ESCOGER LA TARJETA
					$("#tdestino").children("#btn-destino").remove();
					$("#tdestino").append($("#removerDestino").html());

					marcar_destino();

					var montotr = $(".monto").val().replace(',', '.');
					$('#content_plata').on('keyup','.monto',function() {
						var montotr_exp = $(this).val();
						if((pais=='Pe') || (pais=='Usd')) {
							expr= /^-?[0-9]+([\.][0-9]{0,2})?$/;
							saldo_imp= $("#balance-available").attr("saldo").replace(',', '');
						}
						if((pais=='Ve') || (pais=='Co')) {
							expr= /^-?[0-9]+([\,][0-9]{0,2})?$/;
							saldo_imp1= $("#balance-available").attr("saldo").replace('.', '');
							saldo_imp= saldo_imp1.replace(',', '.');
						}

						if(!expr.test(montotr_exp)) {

							if((pais=='Pe') || (pais=='Usd')){
								$("#dialog-error-monto").dialog({
									title:"Monto no permitido",
									modal:"true",
									width:"440px",
									open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
								});

								$("#monto_invalido").click(function(){
									$("#dialog-error-monto").dialog("close");
								});
							}
							if((pais=='Ve') || (pais=='Co')){
								$("#dialog-error-monto-vc").dialog({
									                                   title:"Monto no permitido",
									                                   modal:"true",
									                                   width:"440px",
									                                   open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
								                                   });

								$("#monto_invalido_vc").click(function(){
									$("#dialog-error-monto-vc").dialog("close");
								});
							}
							$(this).val("");
						}

						montotr = $(this).val().replace(',', '.');

						if((parseFloat(montotr)) >saldo_imp){
							$("#dialog-max-monto1").dialog({
								                               title:"Monto no permitido",
								                               modal:"true",
								                               width:"440px",
								                               open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
							                               });

							$("#monto_inv").click(function(){
								$("#dialog-max-monto1").dialog("close");
							});
							$(this).val("");
						}
						if ( (parseFloat(montotr)) > parseFloat(montoMaxOperaciones)){

							$("#dialog-max-monto").dialog({
								                              title:"Monto no permitido",
								                              modal:"true",
								                              width:"440px",
								                              open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
							                              });

							$("#monto_invalido1").click(function(){
								$("#dialog-max-monto").dialog("close");
							});
							$(this).val("");
						}

						if((parseFloat(montotr)+parseFloat(montoAcumMensual))>parseFloat(montoMaxMensual)){

							$("#dialog-min-monto2").dialog({
								                               title:"Monto no permitido",
								                               modal:"true",
								                               width:"440px",
								                               open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
							                               });

							$("#monto_invalido3").click(function(){
								$("#dialog-min-monto2").dialog("close");
							});
							$(this).val("");
							$("#balance-debit").html(m+sumar_saldo().toFixed(2));

						} else if((parseFloat($(this).val())+parseFloat(montoAcumDiario))>parseFloat(montoMaxDiario)){

							$("#dialog-min-monto3").dialog({
								                               title:"Monto no permitido",
								                               modal:"true",
								                               width:"440px",
								                               open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
							                               });

							$("#monto_invalido4").click(function(){
								$("#dialog-min-monto3").dialog("close");
							});
							$(this).val("");
							$("#balance-debit").html(m+sumar_saldo().toFixed(2));

						} else{
							m=$(".dashboard-item").attr('moneda');
							$(this).parents('.group').attr("montInput",$(this).val());
							$(this).val().replace(',', '.');
							$("#balance-debit").html(m+sumar_saldo().toFixed(2));
						}
					});


					dialogo();
					//alert(number);
					if(number >=3){
						$("#tdestino").children("#btn-destino").remove();
					}

					if(number >= 1){
						$('#continuar').removeAttr("disabled");
					}else{
						$('#continuar').attr('disabled','');
					}


				} //ELSE

			});   //FIN FUNCION OBTENER DATOS CUENTA DESTINO


		});  //FIN EACH CUENTA DESTINO
		$('.modifica').click(function(){       // FUNCION PARA MODIFICAR LA TARJETA DESTINO
			$(this).parents('.group').addClass('edit');
			$("#content-destino").dialog({
				                             title:"Selección de Cuentas Destino",
				                             modal:"true",
				                             width:"940px",
				                             beforeClose: function( event, ui ) {
					                             $('.group').removeClass('edit');
				                             },
				                             open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                             }); //FIN DIALOG MODIFICA
		}); // FIN MODIFICAR TARJETA

		$('#content_plata').on('click',".elimina",function(){
			m=$(".dashboard-item").attr('moneda');
			suma=sumar_saldo();
			if(suma!=0){
				montoR1=$(this).parents('.group').attr('montInput').replace(',', '.');
				montoRestar=parseFloat(montoR1);
			}
			else{
				montoRestar=0;
			}
			//montoRestar=parseFloat($(this).parents('.group').attr('montInput'));

			saldo1=suma-montoRestar;
			saldo=saldo1.toFixed(2);

			if((saldo<0)||isNaN(saldo)){
				$("#balance-debit").html(m+0.00);
			}
			else{
				$("#balance-debit").html(m+saldo);
			}
			$(this).parents('.group').remove();
			marcar_destino();
			if($("#tdestino").find("#btn-destino").length == 0){
				$("#tdestino").append($("#removerDestino").html());
				dialogo();
			}
			if(contar_tarjetas() > 1){
				$('#continuar').removeAttr("disabled");
			}else{
				$('#continuar').attr('disabled','');
			}
		});


		dialogo();

	}); //FIN FUNCION DE SELECCION DESTINO

	//validar_campos();

	// ------------------------------------------------------- BOTON CONTINUAR -------------------------------------------------------------------------------------
	//$("#continuar").click(function(){

	$('#content_plata').on('click',".confir",function(){
		var confirmacion = true;
		var contador_trans=0;
		var validateInput = [];
		var sinImporte = false;
		$("#validate").submit();
		//setTimeout(function(){$("#msg").fadeOut();},5000);
		$("#montoTotal").remove();
		$("#tdestino").append("<input id='montoTotal' name='montoTotal' type='hidden' class='checkTotal' value='' />");
		$("#montoTotal").val(sumar_saldo());
		total= sumar_saldo();
		saldo= saldo_imp;

		//conceptos de las transferencias
		valor_concepto1= $("#beneficiary-1x-description").val();
		valor_concepto2= $("#beneficiary-2x-description").val();
		valor_concepto3= $("#beneficiary-3x-description").val();

		//monto de las trnasferencias
		valor_monto1= $("#beneficiary-1-amount").val();
		valor_monto2= $("#beneficiary-2-amount").val();
		valor_monto3= $("#beneficiary-3-amount").val();

		if($('#MonthExp').val() === '') {
			validateInput.push('Seleccione el mes de vencimiento');
			confirmacion = false;
		}

		if($('#yearExp').val() === '') {
			validateInput.push('Seleccione el año de vencimiento');
			confirmacion = false;
		}


		if((valor_concepto1 === '') || (valor_concepto2 === '') || (valor_concepto3 === '')) {
			validateInput.push('El campo concepto no debe estar vacío.');
			/*$("#campos_vacios").dialog({
				                           title:"Error Campos",
				                           modal:"true",
				                           width:"440px",
				                           open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                           });

			$("#error_campos").click(function(){
				$("#campos_vacios").dialog("close");
			});*/
			confirmacion = false;
		}

		if((valor_monto1 === '') || (valor_monto2 === '') || (valor_monto3 === '')) {
			validateInput.push('El campo importe no debe estar vacío.');
			sinImporte = true;
		} else {
			sinImporte = false;
		}

		if(parseFloat(total)>saldo){
			validateInput.push('El monto total excede su saldo disponible.');
			/*$("#dialog-error-monto9").dialog({
				                                 title:"Error Monto",
				                                 modal:"true",
				                                 width:"440px",
				                                 open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                 });

			$("#error_monto9").click(function(){
				$("#dialog-error-monto9").dialog("close");
			});*/
			confirmacion = false;
		}

		if (parseFloat(acumCantidadOperacionesDiarias)+parseFloat(contador_trans)>=parseFloat(cantidadOperacionesDiarias)){
			validateInput.push('Usted excede el límite diario permitido.');
			/*$("#dialog-cant-ope1").dialog({
				                              title:"Cantidad de Operaciones",
				                              modal:"true",
				                              width:"440px",
				                              open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                              });

			$("#cant_ope1").click(function(){
				$("#dialog-cant-ope1").dialog("close");
			});*/
			confirmacion = false;

		}
		if (parseFloat(acumCantidadOperacionesSemanales)+parseFloat(contador_trans)>=parseFloat(cantidadOperacionesSemanales)){
			validateInput.push('Usted excede el límite semanal permitido.');
			/*$("#dialog-cant-ope-sm").dialog({
				                                title:"Cantidad de Operaciones",
				                                modal:"true",
				                                width:"440px",
				                                open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                });

			$("#cant_ope_sm").click(function(){
				$("#dialog-cant-ope-sm").dialog("close");
			});*/
			confirmacion = false;

		}
		if (parseFloat(acumCantidadOperacionesMensual)+parseFloat(contador_trans)>parseFloat(cantidadOperacionesMensual)){
			validateInput.push('Usted excede el límite mensual permitido.');
			/*$("#dialog-cant-ope2").dialog({
				                              title:"Cantidad de Operaciones",
				                              modal:"true",
				                              width:"440px",
				                              open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                              });

			$("#cant_ope2").click(function(){
				$("#dialog-cant-ope2").dialog("close");
			});*/
			confirmacion = false;

		}

		// if ( (parseFloat(valor_monto1)  < parseFloat(montoMinOperaciones)) || (parseFloat(valor_monto2)  < parseFloat(montoMinOperaciones)) || (parseFloat(valor_monto3)  < parseFloat(montoMinOperaciones)) ){
		// 	validateInput.push('El monto a debitar es menor al monto mínimo de operaciones.');
		// 	$("#dialog-min-monto").dialog({
		// 		                              title:"Monto no permitido",
		// 		                              modal:"true",
		// 		                              width:"440px",
		// 		                              open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
		// 	                              });
		//
		// 	$("#monto_invalido2").click(function(){
		// 		$("#dialog-min-monto").dialog("close");
		// 	});
		// 	$(this).val("");
		// 	confirmacion = false;
		// }

		if(parseFloat(total)>parseFloat(montoMaxOperaciones)){
			validateInput.push('El monto a total a debitar supera el monto máximo de operaciones.');
			/*$("#dialog-error-monto1").dialog({
				                                 title:"Error monto total",
				                                 modal:"true",
				                                 width:"440px",
				                                 open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                 });

			$("#error_monto1").click(function(){
				$("#dialog-error-monto1").dialog("close");
			});*/
			confirmacion = false;
		}

		if((parseFloat(total)<parseFloat(montoMinOperaciones)) && sinImporte == false){
			validateInput.push('El monto total a debitar es menor al monto mínimo de operaciones.');
			/*$("#dialog-error-monto2").dialog({
				                                 title:"Error monto total",
				                                 modal:"true",
				                                 width:"440px",
				                                 open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                 });

			$("#error_monto2").click(function(){
				$("#dialog-error-monto2").dialog("close");
			});*/
			confirmacion = false;
		}


		if((parseFloat(total)+parseFloat(montoAcumDiario))>parseFloat(montoMaxDiario)){
			validateInput.push('El monto total a debitar es mayor al monto maximo diario permitido.');
			/*$("#dialog-error-monto7").dialog({
				                                 title:"Error monto total",
				                                 modal:"true",
				                                 width:"440px",
				                                 open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                 });

			$("#error_monto7").click(function(){
				$("#dialog-error-monto7").dialog("close");
			});*/
			confirmacion = false;

		} else if((parseFloat(total)+parseFloat(montoAcumSemanal))>parseFloat(montoMaxSemanal)){
			validateInput.push('El monto total a debitar es mayor al monto maximo diario permitido.');
			/*$("#dialog-error-monto-sm").dialog({
				                                   title:"Error monto total",
				                                   modal:"true",
				                                   width:"440px",
				                                   open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                   });

			$("#error_monto_sm").click(function(){
				$("#dialog-error-monto-sm").dialog("close");
			});*/
			confirmacion = false;
		}else if((parseFloat(total)+parseFloat(montoAcumMensual))>parseFloat(montoMaxMensual)){
			validateInput.push('El monto total a debitar es mayor al monto maximo mensual permitido.');
			/*$("#dialog-error-monto8").dialog({
				                                 title:"Error monto total",
				                                 modal:"true",
				                                 width:"440px",
				                                 open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                 });

			$("#error_monto8").click(function(){
				$("#dialog-error-monto8").dialog("close");
			});*/
			confirmacion = false;
		}


		totaldef=parseFloat(valor_monto1)+parseFloat(valor_monto2)+parseFloat(valor_monto3);

		if(confirmacion === false) {
			$('#inputValid').dialog({
				                        title: 'Transferencia entre tarjetas',
				                        modal: 'true',
				                        width: '440px',
				                        open: function(event, ui) {
					                        $(".ui-dialog-titlebar-close", ui.dialog).hide();
					                        console.log(validateInput);
					                        $.each(validateInput, function(index, value) {
						                        $('#contentValid').append('<p>' + value + '</p>');
					                        });

				                        }
			                        });
			$('#closeValid').on('click', function(){
				$(this).off('click');
				validateInput = [];
				$('#contentValid').children().not('span').remove();
				console.log(validateInput);
				$('#inputValid').dialog('close');
			});
		} else if (confirmacion==true) {
			var origen, nombre, mascara;

			nombre=$("#donor").find(".product-cardholder").html();
			mascara=$("#donor").find(".product-cardnumber").html();
			numeroCtaOrigen=$("#donor").find("#donor-cardnumber-origen").attr("cardOrigen");
			nombreCtaOrigen=$("#donor").find("#nombreCtaOrigen").html();
			banco=$("#donor").find(".banco").html();
			marca=$("#donor").find(".product-metadata").html();

			origen=		  '<tr>';
			origen+=        '<td class="data-label"><label>Cuenta Origen</label></td>';
			origen+=        '<td class="data-reference" id="nombreOrigenTransfer" colspan="2" numeroCtaOrigen="'+numeroCtaOrigen+'" nombreCtaOrigen="'+nombreCtaOrigen+'">'+nombre+'<br /><span class="highlight" id="mascaraOrigenTransfer">'+mascara+'</span><br /><span class="lighten"> '+marca+' </span></td>';
			origen+=      '</tr>';

			$("#cargarConfirmacion").append(origen);

			var tr;


			var num=0;
			montodef=0;
			$.each($('#tdestino').children(':not(.obscure-group, .checkTotal)'), function(pos, item){

				var destino, nombre, mascara, monto, concepto;
				num=num+1;
				nombre=$(item).find(".product-cardholder").html();
				mascara=$(item).find(".product-cardnumber").html();
				monto=$(item).find("#beneficiary-"+num+"-amount").val();
				montodef=parseFloat($(item).find("#beneficiary-"+num+"-amount").val())+montodef;
				concepto=$(item).find("#beneficiary-"+num+"x-description").val();
				marcad=$(item).find("#marca").val();
				ctnDestino = $(item).find("#tarjetaDestino").val();
				id_afil = $(item).find(".id_afiliacion").val();
				if((pais=='Ve') || (pais=='Co')){
					var total = $(".product-scheme").find(".debitar").html().replace(/Bs./g, "");
					total1=total.replace(".", ",");
				}
				else{
					var total = $(".product-scheme").find(".debitar").html().replace(/S../g, "");
					total1=total;
				}


				moneda=$(".dashboard-item").attr("moneda");
				contador_trans = contador_trans+1;

				destino=              '<tr class="trdestino" card="'+ctnDestino+'" id_afil="'+id_afil+'" nombre="'+nombre+'" monto="'+monto+'" concepto="'+concepto+'" moneda="'+moneda+'" mascara="'+mascara+'" marca="'+marcad+'">';
				destino+=				  '<td class="data-label"><label>Cuentas Destino</label></td>';
				destino+=                 '<td class="data-reference" id="nombreDestinoTransfer">'+nombre+'<br /><span class="highlight" id="mascaraDestinoTransfer">'+mascara+'</span><br /><span class="lighten"> '+marcad+' </span></td>';
				destino+=	               '<td class="data-metadata data-resultado">';
				destino+=				   '<div class="data-indicator">';
				destino+=					'<span aria-hidden="true" class="iconoTransferencia"></span>';
				destino+=                 '</div><span class="data-metadata" id="conceptoDestino"><strong>Concepto: </strong>'+concepto+'<br /><strong>Monto: </strong> <span class="money-amount" monto="'+monto+'" id="montoDestinoTransfer"> '+moneda+' '+monto+'<br /> </span><strong>Estatus: </strong><span class="money-amount" id="estatus">En espera por confirmación.</span></td>';
				destino+=				'</td>';
				destino+=               '</tr>';
				destino+=               '<tr>';
				destino+=              		'<td class="data-spacing" colspan="3"></td>';
				destino+=           	'</tr>';
				$("#cargarConfirmacion").append(destino);

			});  //EACH

			$("#content_plata").children().remove();
			$("#content_plata").append($("#contentConfirmacion").html());
			$("#contentConfirmacion").remove();

			var completar;

			completar=         '<tr>';
			completar+=                     '<td class="data-spacing" colspan="3"></td>';
			completar+=                  '</tr>';
			completar+=                  '<tr>';
			completar+=                     '<td colspan="2"></td>';
			completar+=                     '<td class="data-metadata">Total<br /><span class="money-amount" id="mm">'+moneda+' '+total1+'</span></td> <input id="montoTotal" name="montoTotal" type="hidden" total="'+total+'" />';
			completar+=                  '</tr>';

			$("#cargarConfirmacion").append(completar).html();

		}

	});


	// ------------------------------------------------------ CONTENT CONFIRMACION ------------------------------------------------------------------------------


	$('#content_plata').on('click',"#confTransfer",function(){
		$('#confTransfer').prop('disabled', true);
		var clave=$("#transpwd").val();
		if(dobleAutenticacion=="S"){
			if(crear_clave()){
				$('#dialog-confirm').dialog({modal:true, title:"Verificación requerida.",
					                            buttons: {
						                            Cancelar: function() {

							                            $(this).dialog("close");
						                            },
						                            "Aceptar": function() {
							                            var claveConfir=$("#transpwd_confirmacion").val();

							                            if(validar_clave(claveConfir)){
								                            $("#dialog-confirm").dialog( "close" );

								                            var cuentaOrigen = $("#nombreOrigenTransfer").attr("numeroCtaOrigen");
								                            var idUsuario =  $("#nombreOrigenTransfer").attr("nombreCtaOrigen");
								                            var cuentaDestino,id_afil_terceros,monto,descripcion, resultado;
								                            $(".data-indicator").show();

								                            $.each($('.trdestino'), function(pos, item){

									                                   cuentaDestino= $(item).attr("card");
									                                   id_afil_terceros= "";
									                                   nombre1= $(item).attr("nombre");
									                                   monto=$(item).attr("monto").replace(',', '.');
									                                   descripcion=$(item).attr("concepto");

									                                   trans=realizar_transferencia(cuentaOrigen, cuentaDestino, monto, descripcion, idUsuario, id_afil_terceros);
									                                   //trans = true;

									                                   if(trans != false){

										                                   resultado = true;
										                                   marcar_transferencia(resultado,item,trans);

										                                   var origen, time;

										                                   nombre=$("#nombreOrigenTransfer").html();
										                                   mascara=$("#mascaraOrigenTransfer").html();
										                                   var today = new Date();
										                                   hora= (today.getHours())+':'+today.getMinutes()+':'+today.getSeconds();
										                                   var dd = today.getDate();
										                                   var mm = today.getMonth()+1;//January is 0!
										                                   var yyyy = today.getFullYear();
										                                   if(dd<10){dd='0'+dd}
										                                   if(mm<10){mm='0'+mm}
										                                   var fecha = dd+'/'+mm+'/'+yyyy;

										                                   origen=		'<tr>';
										                                   origen+=		'<td class="data-label"><label>Cuenta Origen</label></td>';
										                                   origen+=		'<td class="data-reference" colspan="2"><br>'+nombre+'</td>';   // <span class="highlight">'+mascara+'</span><br><span class="lighten">Plata ClÃ¡sica / Visa Electron / ViÃ¡ticos</span>
										                                   origen+=	'</tr>';



										                                   $("#progress").children().remove();
										                                   cabecera = "<ul class='steps'>";
										                                   cabecera+=		"<li class='step-item completed-step-item'><span aria-hidden='true' class='icon-exchange'></span> Transferir</li>";
										                                   cabecera+=      "<li class='step-item completed-step-item'><span aria-hidden='true' class='icon-view'></span> Confirmación</li>";
										                                   cabecera+=      "<li class='step-item current-step-item'><span aria-hidden='true' class='icon-thumbs-up'></span> Finalización</li>";
										                                   cabecera+= "</ul>";
										                                   $("#progress").append(cabecera).html();

										                                   $("#titulo").children().remove();
										                                   titulo = "<h2>Finalización</h2>"
										                                   $("#titulo").append(titulo).html();

										                                   $("#confimacion_t").children().remove();
										                                   completar1= 		'<button id="exit">Finalizar</button>';
										                                   $("#confimacion_t").append(completar1).html();
										                                   $("#exit").click(function(){

											                                   $(location).attr('href', base_url+'/dashboard');
										                                   }); //EXIT
									                                   }
									                                   else{					//REALIZAR TRANSFERENCIA

										                                   resultado=false;
										                                   trans = "-"
										                                   marcar_transferencia(resultado,item,trans);
										                                   $("#confimacion_t").children().remove();
										                                   completar1= 		'<button id="exit">Finalizar</button>';
										                                   $("#confimacion_t").append(completar1).html();
										                                   $('#transfer-success').show();
										                                   $("#exit").click(function(){

											                                   $(location).attr('href', base_url+'/transferencia');

										                                   });
									                                   }

								                                   } //IF VALIDAR CLAVE

								                            )}; //EACH
						                            }, //ACEPTAR
					                            }, //BOTONES
					                            open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				                            });//DIALOGO

			} //IF CREAR CLAVE


		} //DOBLE AUTENTIFICACION SI
		else {
			var cuentaOrigen = $("#nombreOrigenTransfer").attr("numeroCtaOrigen");
			var idUsuario =  $("#nombreOrigenTransfer").attr("nombreCtaOrigen");
			var cuentaDestino,id_afil_terceros,monto,descripcion, resultado;
			$(".data-indicator").show();

			$.each($('.trdestino'), function(pos, item){

				cuentaDestino= $(item).attr("card");
				id_afil_terceros= "";
				nombre1= $(item).attr("nombre");
				monto=$(item).attr("monto").replace(',', '.');
				descripcion=$(item).attr("concepto");

				trans=realizar_transferencia(cuentaOrigen, cuentaDestino, monto, descripcion, idUsuario, id_afil_terceros);
				//trans = true;

				if(trans != false){

					resultado = true;
					marcar_transferencia(resultado,item,trans);

					var origen, time;

					nombre=$("#nombreOrigenTransfer").html();
					mascara=$("#mascaraOrigenTransfer").html();
					var today = new Date();
					hora= (today.getHours())+':'+today.getMinutes()+':'+today.getSeconds();
					var dd = today.getDate();
					var mm = today.getMonth()+1;//January is 0!
					var yyyy = today.getFullYear();
					if(dd<10){dd='0'+dd}
					if(mm<10){mm='0'+mm}
					var fecha = dd+'/'+mm+'/'+yyyy;

					origen=		'<tr>';
					origen+=		'<td class="data-label"><label>Cuenta Origen</label></td>';
					origen+=		'<td class="data-reference" colspan="2"><br>'+nombre+'</td>';   // <span class="highlight">'+mascara+'</span><br><span class="lighten">Plata ClÃ¡sica / Visa Electron / ViÃ¡ticos</span>
					origen+=	'</tr>';



					$("#progress").children().remove();
					cabecera = "<ul class='steps'>";
					cabecera+=		"<li class='step-item completed-step-item'><span aria-hidden='true' class='icon-exchange'></span> Transferir</li>";
					cabecera+=      "<li class='step-item completed-step-item'><span aria-hidden='true' class='icon-view'></span> Confirmación</li>";
					cabecera+=      "<li class='step-item current-step-item'><span aria-hidden='true' class='icon-thumbs-up'></span> Finalización</li>";
					cabecera+= "</ul>";
					$("#progress").append(cabecera).html();

					$("#titulo").children().remove();
					titulo = "<h2>Finalización</h2>"
					$("#titulo").append(titulo).html();

					$("#confimacion_t").children().remove();
					completar1= 		'<button id="exit">Finalizar</button>';
					$("#confimacion_t").append(completar1).html();
					$('#transfer-success').show();
					$("#exit").click(function(){

						$(location).attr('href', base_url+'/dashboard');
					}); //EXIT
				}
				else{					//REALIZAR TRANSFERENCIA

					resultado=false;
					trans="-";
					marcar_transferencia(resultado,item,trans);
					$("#confimacion_t").children().remove();
					completar1= 		'<button id="exit">Finalizar</button>';
					$("#confimacion_t").append(completar1).html();
					$("#exit").click(function(){

						$(location).attr('href', base_url+'/transferencia');

					});
				}

			});
		}


	});       //FIN CONTENT CONFIRMAR TRANSFERENCIA EXITOSA


	// // ---------------------------------------------------------------------  ESPACIO DE FUNCIONES ----------------------------------------------------------------------- //

	function contar_tarjetas(){
		var contar;
		$.each($('#tdestino').children(), function(pos,item) {
			contar = pos;
		});
		return contar+1;
	} //FIN FUNCION CONTAR TARJETAS


	// // -------------------------------------------------------------------------------------------------------------------------------------------------------------------


	function dialogo(){

		$('.dialogDestino').click(function(){
			$("#content-destino").dialog({
				                             title:"Selección de Cuentas Destino",
				                             modal:"true",
				                             width:"940px",
				                             open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                             });
			$("#close").click(function(){
				$("#content-destino").dialog("close");
			});
		});
	}
	// // -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function contar_tarjetas_destino(){		//FUNCION CONTAR TARJETAS
		var contar;

		$.each($(".dashboard-item"),function(pos,item){
			contar = pos;
		});

		tarjetas = contar+1;
		return tarjetas;

	} 		//FIN FUNCION CONTAR TARJETAS


	function marcar_destino() 			//FUNCION PARA DESHABILITAR TARJETA DESTINO SELECCIONADA

	{

		$.each($('#dashboard-beneficiary').children('.dashboard-item'), function(posd,itemd){		//EACH 1

			$(itemd).removeClass("disabled-dashboard-item");

			$.each($('#tdestino').children(':not(.obscure-group)'), function(pos, item){		//EACH 2

				if($(item).find("#tarjetaDestino").val()==$(itemd).attr("card")){

					$(itemd).addClass("disabled-dashboard-item");

				} 		//FIN IF

			}); 	//FIN EACH 2

		});		//FIN EACH 1

	}		//FIN FUNCION PARA DESHABILITAR TARJETA DESTINO SELECCIONADA


	// // -------------------------------------------------------------------------------------------------------------------------------------------------------------------


	function sumar_saldo(){

		var saldo = 0;
		var rpl;
		$.each($('.dinero'), function(pos,item){
			rpl= $(item).val().replace(',', '.')
			//saldo = saldo + parseFloat($(item).val());
			saldo = saldo + parseFloat(rpl);
			saldo.toFixed(2);
		});

		if(isNaN(saldo)) {

			saldo=0;
		}

		return saldo;
	}


	// // -------------------------------------------------------------------------------------------------------------------------------------------------------------------


	function confirmPassOperac(clave){
		var response1;
		var rpta1;
		$.ajaxSetup({async: false});
		var ajax_data = {
			"clave":hex_md5(clave),
		};

		$.ajax({
			       url: base_url +"/transferencia/operaciones",
			       data: ajax_data,
			       type: "post",
			       dataType: 'json',
			       success: function(data) {
				       rpta = $.parseJSON(data.response);
				       rpta1 = $.parseJSON(data.transferir);
				       if(rpta.rc == 0){
					       response1 = true;
				       }
				       else {
					       response1 = false;
					       rpta1 = false;
				       }
				       if(rpta.rc == -61){
					       $(location).attr('href', base_url+'/users/error_gral');
				       }


			       }
		       });

		$.ajaxSetup({async: true});
		// $.post(base_url+"/transferencia/operaciones",{"clave":hex_md5(clave)},function(data){
		// 	rpta = $.parseJSON(data.response);
		// 	rpta1 = $.parseJSON(data.transferir);
		// 	if(rpta.rc == 0){
		// 		response1 = true;
		// 	}
		// 	if(rpta.rc == -61){
		//           	$(location).attr('href', base_url+'/users/error_gral');
		//       	}
		// 	else{
		// 		response1 = false;
		// 		rpta1 = false;
		// 	}
		// });

		return rpta1;
	}


	// // -------------------------------------------------------------------------------------------------------------------------------------------------------------------


	function crear_clave(){

		$.ajaxSetup({async: false});

		var valida;
		$.post(base_url +"/transferencia/crearClave",function(data){

			if(data.rc==0){
				valida = true;
			}
			else{
				valida = false;
				$("#dialog-error-clave").dialog({
					                                //title:"ContraseÃ±as no coinciden",
					                                modal:"true",
					                                width:"440px",
					                                open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				                                });

				$("#invalido2").click(function(){
					$("#dialog-error-clave").dialog("close");
					$(location).attr('href', base_url+'/transfer');
				});
			}
			if(data.rc == -61){
				$(location).attr('href', base_url+'/users/error_gral');
			}
		});

		return valida;
	}


	// // -------------------------------------------------------------------------------------------------------------------------------------------------------------------


	function validar_clave(claveConfir){

		$.ajaxSetup({async: false});

		var claveValida;
		$.post(base_url +"/transferencia/confirmacion",{'clave':hex_md5(claveConfir)},function(data){

			if(data.rc==0){
				claveValida = true;
			}

			else {
				claveValida = false;
				$("#dialog-error-correo").dialog({
					                                 title:"Contraseñas no coinciden",
					                                 modal:"true",
					                                 width:"440px",
					                                 open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				                                 });

				$("#invalido").click(function(){
					$("#dialog-error-correo").dialog("close");
				});

			}
			if(data.rc == -61){
				$(location).attr('href', base_url+'/users/error_gral');
			}

		});

		return claveValida;
	}


	// // -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function realizar_transferencia(cuentaOrigen, cuentaDestino, monto, descripcion, idUsuario, id_afil_terceros){

		var transferencia;
		var idTransferencia;
		//transferencia = 1111;
		$.ajaxSetup({async: false});

		// $.post(base_url +"/transferencia/procesar",{"cuentaOrigen":cuentaOrigen,"cuentaDestino":cuentaDestino,"monto":monto,"descripcion":descripcion,"tipoOpe":"P2P","idUsuario":idUsuario,"id_afil_terceros":id_afil_terceros},function(data){
		// 	if(data.rc==0){

		//   			idTransferencia= data.dataTransaccion.referencia;
		//       		transferencia = idTransferencia;

		//   		}else{

		//   			transferencia = false;
		//   		}
		//   	});

		var ajax_data = {
			"cuentaOrigen"     : cuentaOrigen,
			"cuentaDestino"   : cuentaDestino,
			"monto"    : monto,
			"descripcion" : descripcion,
			"tipoOpe" : "P2P",
			"idUsuario" : idUsuario,
			"id_afil_terceros":id_afil_terceros
		};

		$.ajax({
			       url: base_url +"/transferencia/procesar",
			       data: ajax_data,
			       type: "post",
			       dataType: 'json',
			       success: function(data) {
				       if(data.rc==0){
					       idTransferencia= data.dataTransaccion.referencia;
					       transferencia = idTransferencia;
					       $("#confTransfer").prop("disabled", false);
				       }else{
					       transferencia = false;
					       $("#confTransfer").prop("disabled", false);
				       }
				       if(data.rc == -61){
					       $(location).attr('href', base_url+'/users/error_gral');
					       $("#confTransfer").prop("disabled", false);
				       }

			       }
		       });

		$.ajaxSetup({async: true});
		return transferencia;

	} //REALIZAR TRANSFERENCIA

	// // -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function marcar_transferencia(resultado,item,trans){

		if(resultado==true){

			$(item).find(".data-resultado").addClass('data-success');
			$(item).find(".iconoTransferencia").removeClass("data-indicator icon-refresh icon-spin");
			$(item).find(".iconoTransferencia").addClass('icon-ok-sign');
			$(item).find("#estatus").empty();
			$(item).find("#estatus").text("Transacción exitosa. No. de Referencia: "+trans);

		}else{

			$(item).find(".data-resultado").addClass('data-error');
			$(item).find(".iconoTransferencia").removeClass("data-indicator data-indicator icon-refresh icon-spin");
			$(item).find(".iconoTransferencia").addClass('icon-cancel-sign');
			$(item).find("#estatus").empty();
			$(item).find("#estatus").text("Transacción fallida.");
			//COLOCAR QUE FALLO LA TRANSFERENCIA
		}
	}

	// // -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// //FUNCION PARA DESHABILITAR TARJETA DESTINO SI EL MONTO MAX/MIN MENSUAL O DIARIO FUE EXCEDIDO
	function marcar_destino_montos() {

		$.each($('#dashboard-beneficiary').children('.dashboard-item'), function(posd,itemd){
			if(montoMaxDiario == montoAcumDiario){
				$(itemd).addClass("disabled-dashboard-item");
				alert("Para esta operacion usted supera el monto maximo diario de transferencias");
			}
			else{
				if(montoMaxMensual == montoAcumMensual){
					$(itemd).addClass("disabled-dashboard-item");
					alert("Para esta operacion usted supera el monto maximo diario de transferencias");
				}
			}

		});
	}

	function normaliza(text) {

		var acentos = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç";

		var original = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc";

		for (var i=0; i<acentos.length; i++) {

			text = text.replace(acentos.charAt(i), original.charAt(i));

		}

		return text;

	}




	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// MODAL TERMINOS Y CONDICIONES
	$(".label-inline").on("click", "a", function() {

		$("#dialog-tc").dialog({
			                       /**/
			                       modal:"true",
			                       width:"940px",
			                       open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
		                       });

		$("#ok").click(function(){
			$("#dialog-tc").dialog("close");
		});

	});


});  //FIN DE LA FUNCION GENERAL
