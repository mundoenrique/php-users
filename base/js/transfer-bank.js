var path, base_cdn;
path =window.location.href.split( '/' );
base_cdn = decodeURIComponent(document.cookie.replace(/(?:(?:^|.*;\s*)cpo_baseCdn\s*\=\s*([^;]*).*$)|^.*$/, '$1'));
base_url = path[0]+ "//" +path[2] + "/" + path[3];
var dobleAutenticacion,claveValida,claveC,confirpass,rpta1,montoMaxDiario,montoMaxMensual,montoMasComision,saldo_imp;

$(function(){

	var confirmacion = $("#content").attr("confirmacion");
	if(confirmacion== '1'){
		$('#content-clave').hide();
		$('#tabs-menu').show();
		$('#content_bank').show();
	}else{
		$('#content-clave').show();
	}

	//Menu desplegable transferencia
	$('.transfers').hover(function(){
		$('.submenu-transfer').attr("style","display:block")
	},function(){
		$('.submenu-transfer').attr("style","display:none")
	});

	//Menu desplegable usuario
	$('.user').hover(function(){
		$('.submenu-user').attr("style","display:block")
	},function(){
		$('.submenu-user').attr("style","display:none")
	});


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

		$.each($(".dashboard-item"),function(pos,item){
			$.post(base_url + "/dashboard/saldo",{"tarjeta":$(item).attr("card")},function(data){
				var moneda=$(".dashboard-item").attr("moneda");
				var saldo=data.disponible;
				if (typeof saldo!='string'){
					saldo="---";
				}

				$(item).find(".dashboard-item-balance").html(moneda+saldo);
			});
		});

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
		});
	});

	$('li.stack-item a').click(function(){                              // FUNCIONALIDAD DE FILTROS CTAS ORIGEN
		$('.stack').find('.current-stack-item').removeClass('current-stack-item');
		$(this).parents('li').addClass('current-stack-item');
	});

	$("#continuar_transfer").click(function(){
		var pass=$("#transpwd").val();
		if((confirmPassOperac(pass))){
			$('#content-clave').hide();
			$('#tabs-menu').show();
			$('#content_bank').show();
		}
		else{
			$('#content_clave').show();
			$.balloon.defaults.classname = "field-error";
			$.balloon.defaults.css = null;
			$("#transpwd").showBalloon({position: "right", contents: "Clave inválida"});
			setTimeout(function() {

				$("#transpwd").hideBalloon();

			}, 3000);
		}
	});

	// --------------------------------------------------------- DATOS DE CUENTA ORIGEN --------------------------------------------------------------------------

	$(".dashboard-item").click(function(){              // FUNCION PARA OBTENER DATOS DE TARJETA CTA ORIGEN

		var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre, prefix;

		imagen=$(this).find('img').attr('src');
		tarjeta=$(this).attr('card');
		marca=$(this).attr('marca');
		mascara=$(this).attr('mascara');
		producto=$(this).attr('producto1');
		empresa=$(this).attr('empresa');
		nombre=$(this).attr('nombre');
		prefix=$(this).attr('prefix');
		moneda=$(this).attr("moneda");
		pais=$(this).attr('pais');

		$("#donor").children().remove();

		cadena='<div class="product-presentation">';
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
		cadena+=		'<ul class="product-balance-group">';
		cadena+=			'<li>Disponible <span class="product-balance" id="balance-available">'+moneda+' 0,00</span></li>';
		cadena+=			'<li>A debitar <span class="product-balance debitar" id="balance-debit">'+moneda+' 0,00</span></li>';
		cadena+=		'</ul>';
		cadena+=	'</div>';


		$("#donor").append(cadena);          // MOSTRAR DATOS CUENTAS ORIGEN EN LA VISTA PRINCIPAL

		$.post(base_url +"/dashboard/saldo",{"tarjeta":$(this).attr("card")},function(data){           // CARGAR SALDO CUENTAS ORIGEN
			var saldo=data.disponible;
			if (typeof saldo!='string'){
				saldo="---";
			}

			$("#balance-available").attr("saldo",saldo);
			$("#balance-available").html(moneda+saldo);
		});

		$(".product-button").removeClass("disabled-button");              // HABILITAR EDICION CUENTAS DESTINO
		$("#agregarCuenta").attr("href","#");

		$("#agregarCuenta").parents("li").removeClass("disabled-group-action-item");


		$.each($(".dashboard-item"), function(pos,item){
			if($(this).hasClass("current-dashboard-item")){
				$(this).removeClass("current-dashboard-item");
			}
		});   //FIN DATOS CTA ORIGEN

		$(this).addClass("current-dashboard-item");
		$("#content-product").dialog("close");

		$('.stack-item').click(function(){       //FUNCION PARA MODIFICAR LA TARJETA ORIGEN
			$("#content-product").dialog({
				                             title:"Selección de Cuentas Origen",
				                             modal:"true",
				                             width:"940px",
				                             open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                             });
		});

		$.post(base_url +"/transferencia/ctaDestino",{"nroTarjeta":$(this).attr("card"),"prefijo":$(this).attr("prefix"),"operacion":"P2T"},function(data){  //FUNCION PARA CARGAR CUENTAS DESTINO
			if(data.rc==-150){
				$("#content_bank").children().remove();
				$("#tabs-menu").children().remove();
				$("#content_bank").append($("#content-no-afil").html());
				$("#content-no-afil").children().remove();

			}

			//else{


			if(data.rc==0){
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
				montoComision = data.parametrosTransferencias[0].montoComision;
				dobleAutenticacion = data.parametrosTransferencias[0].dobleAutenticacion;
				console.info(montoAcumSemanal);
				//validar_transferencia(data);

				$("#dashboard-beneficiary").empty();

				$.each(data.cuentaDestinoTercero,function(pos,item){
					//var num = Math.floor(Math.random() * (5-0+1));
					var num = Math.floor(Math.random() * 5) + 1;
					var imagen = "bank-"+num;
					var cadena;
					cadena=" <li class='dashboard-item muestraDestino' id='datos_ctaD' card='"+item.noCuenta+"' comision='"+montoComision+"' marca='"+item.marca+"' nombre='"+item.beneficiario+"' mascara='"+item.noCuentaConMascara+"' empresa='"+item.nomEmp+"' id_afiliacion='"+item.id_afiliacion+"' producto='"+item.banco.replace(' ','-')+"'>";
					cadena+= "<a rel='section'>";
					//cadena+= "<img src='"+base_cdn+"/img/products/"+item.imagen+".png' width='200' height='130' alt='' />";
					cadena+= "<img src='"+base_cdn+"/img/products/default/"+imagen+".png' width='200' height='130' alt='' />";
					cadena+= "<div class='dashboard-item-info'>";
					cadena+= "<p class='dashboard-item-cardholder'>"+item.beneficiario+"</p>";
					cadena+=  "<p class='dashboard-item-cardnumber'>"+item.noCuentaConMascara+"</p>";
					cadena+=  "<p class='dashboard-item-category'>"+item.banco+"</p>";
					cadena+= "</div>";
					cadena+= " </a>";
					cadena+=  "</li>";

					$("#dashboard-beneficiary").append(cadena);

				});
			}
			if(data.rc == -61){
				$(location).attr('href', base_url+'/users/error_gral');
			}

			$(".muestraDestino").click(function(){              // FUNCION PARA OBTENER DATOS DE LA CUENTA DESTINO

				if ($(this).hasClass('disabled-dashboard-item')==true) {
					$("#content-destino").dialog("close");
					//alert("Selección Invalida");

				}
				else {

					var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre,id_afil,banco;

					imagen=$(this).find('img').attr('src');
					tarjeta=$(this).attr('card');
					mascara=$(this).attr('mascara');
					marca=$(this).attr('marca');
					producto=$(this).attr('producto');
					empresa=$(this).attr('empresa');
					nombre=$(this).attr('nombre');
					id_afil=$(this).attr('id_afiliacion');
					banco=$(this).attr('producto');
					comision=$(this).attr('comision');
					moneda=$(".dashboard-item").attr("moneda");


					$(".edit").remove();

					var number = contar_tarjetas();

					cadena= '<div class="group"> ';
					cadena+='<div class="product-presentation">';
					cadena+=	'<img src="'+imagen+'" width="200" height="130" alt="" />';
					cadena+=			'<div class=""></div>';
					cadena+=							'<input class="tarjetaDestino" name="tarjetaDestino" type="hidden" value="'+tarjeta+'" />';
					cadena+=							'<input class="id_afiliacion" name="id_afil" type="hidden" value="'+id_afil+'" />';
					cadena+=                             '<input class="banco" name="banco" type="hidden" value="'+banco+'" /> <input class="comision" name="comision" type="hidden" value="'+comision+'" /> <input class="marca" name="marca" type="hidden" value="'+marca+'" />';
					cadena+=						'</div>';
					cadena+=						'<div class="product-info">';
					cadena+=							'<p class="product-cardholder">'+nombre+'</p>';
					cadena+=							'<p class="product-cardnumber">'+mascara+'</p>';
					cadena+=							'<p class="product-metadata">'+producto+'</p>';
					cadena+=							'<nav class="product-stack">';
					cadena+=								'<ul class="stack">';
					cadena+=									'<li class="stack-item modifica">';
					cadena+=										'<a rel="section" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit"></span></a>';
					cadena+=									'</li>';
					cadena+=										'<li class="stack-item elimina">';
					cadena+=										'<a rel="section" title="Remover"><span aria-hidden="true" class="icon-cancel"></span></a>';
					cadena+=									'</li>';
					cadena+=								'</ul>';
					cadena+=							'</nav>';
					cadena+=						'</div>';
					cadena+=						'<div class="product-scheme">';
					cadena+=                             '<fieldset class="form-inline">';
					cadena+=                                    '<label for="beneficiary-1x-description" title="Descripción de la transferencia.">Concepto</label>';
					cadena+=                                    '<input class="field-large" id="beneficiary-'+number+'x-description" maxlength="60" name="beneficiary-1x-description" type="text" />';
					cadena+=                                    '<label for="beneficiary-1x-amount" title="Monto a transferir.">Importe</label>';
					cadena+=                                    '<div class="field-category" > '+moneda+'';
					cadena+=                                                    '<input id="beneficiary-1x-coin" class="importe" name="beneficiary-1x-coin" type="hidden" value="'+moneda+'." />';
					cadena+=                                    '</div>';
					cadena+=                                    '<input class="field-small monto" id="beneficiary-'+number+'-amount" maxlength="12" name="beneficiary-1x-amount" type="text" />';
					cadena+=                             '</fieldset></div></div>';

					$("#tdestino").append(cadena);
					$("#beneficiary-1x").removeClass("obscure-group");
					$("#content-destino").dialog("close");
					$("#tdestino").children("#btn-destino").remove();
					$("#tdestino").append($("#removerDestino").html());

					marcar_destino();
					var montotr = $(".monto").val().replace(',', '.');


					$('#content_bank').on('keyup','.monto',function() {

						var montotr_exp = $(this).val();
						if((pais=='Pe') || (pais=='Usd')){
							expr= /^-?[0-9]+([\.][0-9]{0,2})?$/;
							saldo_imp= $("#balance-available").attr("saldo").replace(',', '');
						}
						if((pais=='Ve') || (pais=='Co')){
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

						}
						else if((parseFloat($(this).val())+parseFloat(montoAcumDiario))>parseFloat(montoMaxDiario)){
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
						}


						else{
							m=$(".dashboard-item").attr('moneda');
							$(this).parents('.group').attr("montInput",$(this).val());
							$(this).val().replace(',', '.');
							$("#balance-debit").html(m+sumar_saldo().toFixed(2));
						}
					});

					if(contar_tarjetas() >=4){
						$("#tdestino").children("#btn-destino").remove();
					}

					if(contar_tarjetas() >= 1){
						$('#continuar').removeAttr("disabled");
					}else{
						$('#continuar').attr('disabled','');
					}
					dialogo();

				}  //fin else

			});

			marcar_destino_montos();

		});
		$('#content_bank').on('click',".modifica",function(){       // FUNCION PARA MODIFICAR LA TARJETA DESTINO
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

		$('#content_bank').on('click',".elimina",function(){
			//$('.elimina').click(function(){
			m=$(".dashboard-item").attr('moneda');
			suma=sumar_saldo();
			montoRestar=parseFloat($(this).parents('.group').attr('montInput'));
			saldo=suma-montoRestar;

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

	});

	//validar_campos();

	// -----------------------------------------------------  BOTON CONTINUAR ------------------------------------------------------------------------------

	$("#continuar").click(function(){
		var confirmacion = true;

		var contador_trans=0;
		//$("#validate").submit();
		setTimeout(function(){$("#msg").fadeOut();},5000);
		$("#montoTotal").remove();
		$("#tdestino").append("<input id='montoTotal' name='montoTotal' type='hidden' class='checkTotal' value='' />");
		$("#montoTotal").val(sumar_saldo());

		//if (form.valid() == true && confir==true) {
		total= sumar_saldo();
		//saldo = parseFloat($("#balance-available").attr("saldo"));
		saldo = saldo_imp;
		valor_concepto1= $("#beneficiary-1x-description").val();
		valor_concepto2= $("#beneficiary-2x-description").val();
		valor_concepto3= $("#beneficiary-3x-description").val();

		if((valor_concepto1=="")||(valor_concepto2=="")||(valor_concepto3=="")){
			$("#campos_vacios").dialog({
				                           title:"Error Campos",
				                           modal:"true",
				                           width:"440px",
				                           open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                           });
			$("#error_campos").click(function(){
				$("#campos_vacios").dialog("close");
			});
			confirmacion = false;
		}

		if((parseFloat(total)+parseFloat(montoComision))>saldo){

			$("#dialog-error-monto9").dialog({
				                                 title:"Error Monto",
				                                 modal:"true",
				                                 width:"440px",
				                                 open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                 });

			$("#error_monto9").click(function(){
				$("#dialog-error-monto9").dialog("close");
			});
			confirmacion = false;
		}

		if (parseFloat(acumCantidadOperacionesDiarias)+parseFloat(contador_trans)>=parseFloat(cantidadOperacionesDiarias)){

			$("#dialog-cant-ope1").dialog({
				                              title:"Cantidad de Operaciones",
				                              modal:"true",
				                              width:"440px",
				                              open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                              });

			$("#cant_ope1").click(function(){
				$("#dialog-cant-ope1").dialog("close");
			});
			confirmacion = false;

		} else if (parseFloat(acumCantidadOperacionesSemanales)+parseFloat(contador_trans)>=parseFloat(cantidadOperacionesSemanales)){
			$("#dialog-cant-ope-sm").dialog({
				                                title:"Cantidad de Operaciones",
				                                modal:"true",
				                                width:"440px",
				                                open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                });
			$("#cant_ope_sm").click(function(){
				$("#dialog-cant-ope-sm").dialog("close");
			});
			confirmacion = false;

		} else if (parseFloat(acumCantidadOperacionesMensual)+parseFloat(contador_trans)>parseFloat(cantidadOperacionesMensual)){

			$("#dialog-cant-ope2").dialog({
				                              title:"Cantidad de Operaciones",
				                              modal:"true",
				                              width:"440px",
				                              open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                              });
			$("#cant_ope2").click(function(){
				$("#dialog-cant-ope2").dialog("close");
			});
			confirmacion = false;

		}

		valor_monto1= $("#beneficiary-1-amount").val();
		valor_monto2= $("#beneficiary-2-amount").val();
		valor_monto3= $("#beneficiary-3-amount").val();

		if ( (parseFloat(valor_monto1)  < parseFloat(montoMinOperaciones)) || (parseFloat(valor_monto2)  < parseFloat(montoMinOperaciones)) || (parseFloat(valor_monto3)  < parseFloat(montoMinOperaciones)) ){

			$("#dialog-min-monto").dialog({
				                              title:"Monto no permitido",
				                              modal:"true",
				                              width:"440px",
				                              open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                              });
			$("#monto_invalido2").click(function(){
				$("#dialog-min-monto").dialog("close");
			});
			$(this).val("");
			confirmacion = false;
		}

		if((parseFloat(total)+parseFloat(montoComision)+parseFloat(montoComision))>parseFloat(montoMaxOperaciones)){
			$("#dialog-error-monto1").dialog({
				                                 title:"Error monto total",
				                                 modal:"true",
				                                 width:"440px",
				                                 open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                 });

			$("#error_monto1").click(function(){
				$("#dialog-error-monto1").dialog("close");
			});
			confirmacion = false;
		}

		if(parseFloat(total)<=0){
			$("#dialog-error-monto2").dialog({
				                                 title:"Error monto total",
				                                 modal:"true",
				                                 width:"440px",
				                                 open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                 });

			$("#error_monto2").click(function(){
				$("#dialog-error-monto2").dialog("close");
			});
			confirmacion = false;
		}

		if((parseFloat(total)+parseFloat(montoAcumDiario))>parseFloat(montoMaxDiario)){
			$("#dialog-error-monto7").dialog({
				                                 title:"Error monto total",
				                                 modal:"true",
				                                 width:"440px",
				                                 open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                 });

			$("#error_monto7").click(function(){
				$("#dialog-error-monto7").dialog("close");
			});
			confirmacion = false;
		}else if((parseFloat(total)+parseFloat(montoAcumSemanal))>parseFloat(montoMaxSemanal)){

			$("#dialog-error-monto-sm").dialog({
				                                   title:"Error monto total",
				                                   modal:"true",
				                                   width:"440px",
				                                   open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                   });

			$("#error_monto_sm").click(function(){
				$("#dialog-error-monto-sm").dialog("close");
			});
			confirmacion = false;
		}else if((parseFloat(total)+parseFloat(montoAcumMensual))>parseFloat(montoMaxMensual)){

			$("#dialog-error-monto8").dialog({
				                                 title:"Error monto total",
				                                 modal:"true",
				                                 width:"440px",
				                                 open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                                 });

			$("#error_monto8").click(function(){
				$("#dialog-error-monto8").dialog("close");
			});
			confirmacion = false;
		}


		var totaldef=parseFloat(valor_monto1)+parseFloat(valor_monto2)+parseFloat(valor_monto3);
		if (confirmacion==true) {
			var origen, nombre, mascara;

			nombre=$("#donor").find(".product-cardholder").html();
			mascara=$("#donor").find(".product-cardnumber").html();
			numeroCtaOrigen=$("#donor").find("#donor-cardnumber-origen").attr("cardOrigen");
			nombreCtaOrigen=$("#donor").find("#nombreCtaOrigen").html();
			banco=$("#donor").find(".banco").html();
			marca=$("#donor").find(".product-metadata").html();
			comision=$("#tdestino").find(".comision").val();

			origen=		  '<tr>';
			origen+=        '<td class="data-label"><label>Cuenta Origen</label></td>';
			origen+=        '<td class="data-reference" id="nombreOrigenTransfer" colspan="2" numeroCtaOrigen="'+numeroCtaOrigen+'" nombreCtaOrigen="'+nombreCtaOrigen+'">'+nombre+'<br /><span class="highlight" id="mascaraOrigenTransfer">'+mascara+'</span><br /><span class="lighten"> '+marca+' </span></td>';
			origen+=      '</tr>';

			$("#cargarConfirmacion").append(origen);

			var tr;

			tr= '<td class="data-label"><label>Cuentas Destino</label></td>';

			$("#cargarConfirmacion").append(tr);

			//var contador_trans=0;
			var num=0;

			$.each($('#tdestino').children(':not(.obscure-group, .checkTotal)'), function(pos, item){

				var destino, nombre, mascara, monto, concepto;
				num=num+1;
				nombre=$(item).find(".product-cardholder").html();
				mascara=$(item).find(".product-cardnumber").html();
				//monto=$(item).find("#beneficiary-1x-amount").val();
				//montodef=parseFloat($(item).find("#beneficiary-"+num+"-amount").val());
				montodef=$(item).find("#beneficiary-"+num+"-amount").val();
				concepto=$(item).find("#beneficiary-"+num+"x-description").val();
				ctnDestino = $(item).find(".tarjetaDestino").val();
				banco = $(item).find(".banco").val();
				id_afil = $(item).find(".id_afiliacion").val();
				//total=$(".product-scheme").find(".debitar").html();
				moneda=$(".dashboard-item").attr("moneda");
				contador_trans = contador_trans+1;
				suma = sumar_saldo();
				montoT= suma;
				if((pais=='Ve') || (pais=='Co')){
					var total = $(".product-scheme").find(".debitar").html().replace(/Bs./g, "");
					total1=total.replace(".", ",");
				}
				else{
					var total = $(".product-scheme").find(".debitar").html().replace(/S./g, "");
					total1=total;
				}
				monto_t=total1.replace(",", ".");
				//alert(monto_t);
				// suma = sumar_saldo();
				// comision= parseFloat(comision);
				// montoT= suma + comision;


				destino=              '<tr class="trdestino" card="'+ctnDestino+'" id_afil="'+id_afil+'" monto='+montodef+' concepto="'+concepto+'" banco="'+banco+'" comision="'+comision+'">';
				destino+=				  '<td class="data-label"> </td>';
				destino+=                 '<td class="data-reference" id="nombreDestinoTransfer">'+nombre+'<br /><span class="highlight" id="mascaraDestinoTransfer">'+mascara+'</span><br /><span class="lighten" id="bancoDestinoTransfer">'+banco+'</span></td>';
				destino+=	               '<td class="data-metadata data-resultado">';
				destino+=				   '<div class="data-indicator">';
				destino+=					'<span aria-hidden="true" class="iconoTransferencia"></span>';
				destino+=                 '</div><span class="data-metadata" id="conceptoDestino"><strong>Concepto: </strong>'+concepto+'<br /><strong>Monto: </strong><span class="money-amount" monto='+monto_t+' id="montoDestinoTransfer"> '+montodef+'</span><br /><strong>Estatus: </strong><span class="money-amount" id="estatus">En espera por confirmación.</span></td>';
				destino+=				'</td>';
				destino+=               '</tr>';
				destino+=               '<tr>';
				destino+=              		'<td class="data-spacing" colspan="3"></td>';
				destino+=           	'</tr>';
				$("#cargarConfirmacion").append(destino);

			});  //EACH
			comision= parseFloat(comision)*contador_trans;
			montoT= suma + comision;
			montoT = montoT.toString();
			montoT=montoT.replace(".", ",");
			$("#content_bank").children().remove();
			$("#content_bank").append($("#contentConfirmacion").html());
			$("#contentConfirmacion").remove();
			montoMasComision = montoT;

			var completar;
			completar=         '<tr>';
			completar+=                     '<td class="data-spacing" colspan="3"></td>';
			completar+=                  '</tr>';
			completar+=                  '<tr>';
			completar+=                     '<td colspan="2"></td>';
			//completar+=                     '<td class="data-metadata">Total+Comisión ('+moneda+' '+comision+')<br /><span class="money-amount">'+moneda+' '+montoT+'</span></td>';
			completar+=                     '<td class="data-metadata">Total+Comisión ('+moneda+' '+comision+')<br /><span class="money-amount" id="montocom">'+moneda+' '+montoT+'</span></td>';

			completar+=                  '</tr>';

			// completar=         '<tr>';
			// completar+=                     '<td class="data-spacing" colspan="3"></td>';
			// completar+=                  '</tr>';
			// completar+=                  '<tr>';
			// completar+=                     '<td colspan="2"></td>';
			// completar+=                     '<td class="data-metadata">Total<br /><span class="money-amount">'+total+'</span></td> <input id="montoTotal" name="montoTotal" type="hidden" total="'+total+'" />';
			// completar+=                  '</tr>';
			// completar+=                  '<tr>';

			$("#cargarConfirmacion").append(completar).html();

		}  //VALIDATE

	});	//EACH

	// ------------------------------------------------------ CONTENT CONFIRMACION ------------------------------------------------------------------------------


	$('#content_bank').on('click',"#confirmacion_t",function(){
		var transferenciaCtas
		$("#confirmacion_t").prop("disabled", true);
		if(dobleAutenticacion=="S"){
			if(crear_clave()){
				$('#dialog-confirm').dialog({
					                            modal:true, title:"Verificación requerida.",
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
								                            $.each($('.trdestino'), function(pos, item) {
									                                   cuentaDestino= $(item).attr("card");
									                                   id_afil_terceros= $(item).attr("id_afil");
									                                   monto=$(item).attr("monto").replace(',', '.');
									                                   descripcion=$(item).attr("concepto");
									                                   comision=$(item).attr("comision");
									                                   transferenciaCtas=realizar_transferencia(cuentaOrigen, cuentaDestino, monto, descripcion, idUsuario, id_afil_terceros);

									                                   if(transferenciaCtas.status != false){
										                                   resultado = true;
										                                   marcar_transferencia(resultado,item,transferenciaCtas);

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
										                                   origen+=		'<td class="data-reference" colspan="2"><br>'+nombre+'</td>';   // <span class="highlight">'+mascara+'</span><br><span class="lighten">Plata Clásica / Visa Electron / Viáticos</span>
										                                   origen+=	'</tr>';

										                                   $("#bodyConfirm").append(origen);

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

										                                   // 	$("#content_bank").children().remove();
										                                   // $("#content_bank").append($("#transferFinal").html());
										                                   // $("#confimacion_b").children().remove();

										                                   var completar;
										                                   completar= 		'<tr>';
										                                   completar+=  		'<td colspan="2"></td>';
										                                   completar+=			'<td class="data-metadata">';
										                                   completar+= 				'Total: <span class="lighten"> ('+moneda+' '+comision+' Comisión) </span> <br /><span class="money-amount"> '+moneda+' '+montoMasComision+' </span>';
										                                   completar+= 		'</td>';
										                                   completar+= 	'</tr>';

										                                   $("#bodyConfirm").append(completar).html();
										                                   $("#confimacion_b").children().remove();
										                                   completar1= 		'<button id="exit">Finalizar</button>';
										                                   $("#confimacion_b").append(completar1).html();
										                                   $('#transfer-success').show();
										                                   $("#exit").click(function(){

											                                   $(location).attr('href', base_url+'/dashboard');
										                                   });
									                                   } else {//REALIZAR TRANSFERENCIA
										                                   resultado=false;
										                                   trans = "-";
										                                   marcar_transferencia(resultado,item,transferenciaCtas);
										                                   $("#confimacion_b").children().remove();
										                                   completar1= 		'<button id="exit">Finalizar</button>';
										                                   $("#confimacion_b").append(completar1).html();
										                                   $("#exit").click(function(){
											                                   $(location).attr('href', base_url+'/dashboard');
										                                   });
									                                   }
								                                   } //IF VALIDAR CLAVE
								                            )}; //EACH
						                            }, //ACEPTAR
					                            }, //BOTONES
					                            open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				                            });//DIALOGO
			} //IF CREAR CLAVE
		} else { //DOBLE AUTENTIFICACION SI
			var cuentaOrigen = $("#nombreOrigenTransfer").attr("numeroCtaOrigen");
			var idUsuario =  $("#nombreOrigenTransfer").attr("nombreCtaOrigen");
			var cuentaDestino,id_afil_terceros,monto,descripcion, resultado;
			$(".data-indicator").show();

			$.each($('.trdestino'), function(pos, item){

				cuentaDestino= $(item).attr("card");
				id_afil_terceros= $(item).attr("id_afil");
				monto=$(item).attr("monto").replace(',', '.');
				descripcion=$(item).attr("concepto");
				comision=$(item).attr("comision");

				transferenciaCtas=realizar_transferencia(cuentaOrigen, cuentaDestino, monto, descripcion, idUsuario, id_afil_terceros);

				//trans = true;

				if(transferenciaCtas.status != false){

					resultado = true;
					marcar_transferencia(resultado,item,transferenciaCtas);

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

					$("#confimacion_b").children().remove();
					completar1= 		'<button id="exit">Finalizar</button>';
					$("#confimacion_b").append(completar1).html();
					$('#transfer-success').show();
					$("#exit").click(function(){
						$(location).attr('href', base_url+'/dashboard');
					}); //EXIT
				} else {					//REALIZAR TRANSFERENCIA

					resultado=false;
					trans="-";
					marcar_transferencia(resultado,item,transferenciaCtas);
					$("#confimacion_b").children().remove();
					completar1= 		'<button id="exit">Finalizar</button>';
					$("#confimacion_b").append(completar1).html();
					$("#exit").click(function(){

						$(location).attr('href', base_url+'/dashboard');

					});
				}

			});
		}


	});       //FIN CONTENT CONFIRMAR TRANSFERENCIA EXITOSA
	// ---------------------------------------------------------------------  ESPACIO DE FUNCIONES ----------------------------------------------------------------------- //

	function contar_tarjetas(){
		var contar;
		$.each($('#tdestino').children(), function(pos,item) {
			contar = pos;
		});
		return contar+1;
	} //FIN FUNCION CONTAR TARJETAS

	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function dialogo(){
		$('.dialogDestino').click(function(){       //FUNCION PARA ESCOGER CUENTAS DESTINO
			$("#content-destino").dialog({
				                             title:"Selección de Cuentas Destino",
				                             modal:"true",
				                             width:"940px",
				                             open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			                             });  // FIN DIALOG
			$("#close").click(function(){
				$("#content-destino").dialog("close");
			});
		});
	}

	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function marcar_destino() {			//FUNCION PARA DESHABILITAR TARJETA DESTINO SELECCIONADA

		$.each($('#dashboard-beneficiary').children('.dashboard-item'), function(posd,itemd){		//EACH 1

			$(itemd).removeClass("disabled-dashboard-item");

			$.each($('#tdestino').children(':not(.obscure-group)'), function(pos, item){

				if($(item).find(".tarjetaDestino").val()==$(itemd).attr("card")){

					$(itemd).addClass("disabled-dashboard-item");

				} 		//FIN IF
			}); 	//FIN EACH 2
		});		//FIN EACH 1
	}		//FIN FUNCION PARA DESHABILITAR TARJETA DESTINO SELECCIONADA

	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------


	function marcar_destino_montos() {			//FUNCION PARA DESHABILITAR TARJETA DESTINO SI EL MONTO MAX/MIN MENSUAL O DIARIO FUE EXCEDIDO

		$.each($('#dashboard-beneficiary').children('.dashboard-item'), function(posd,itemd){
			if(montoMaxDiario == montoAcumDiario){
				$(itemd).addClass("disabled-dashboard-item");
				alert("Para esta operacion usted supera el monto maximo diario de transferencias");
			} else {
				if(montoMaxMensual == montoAcumMensual){
					$(itemd).addClass("disabled-dashboard-item");
					alert("Para esta operacion usted supera el monto maximo diario de transferencias");
				}
			}
		});
	}	//MARCAR DESTINO MONTO

	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function sumar_saldo(){

		var saldo = 0;
		var rpl;
		$.each($('.monto'), function(pos,item){
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

	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function confirmPassOperac(clave){
		var response1;
		var rpta1;
		$.ajaxSetup({async: false});
		$.post(base_url+"/transferencia/operaciones",{"clave":hex_md5(clave)},function(data){
			rpta = $.parseJSON(data.response);
			rpta1 = $.parseJSON(data.transferir);
			if(rpta.rc == 0){
				response1 = true;
			}

			else{
				response1 = false;
				rpta1 = false;
			}
			if(rpta.rc == -61){
				$(location).attr('href', base_url+'/users/error_gral');
			}
		});

		return rpta1;
	} // CONFIRM PASS

	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

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
					                                //title:"Contraseñas no coinciden",
					                                modal:"true",
					                                width:"440px",
					                                open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				                                });

				$("#invalido2").click(function(){
					$("#dialog-error-clave").dialog("close");
					$(location).attr('href', base_url+'/transfer/index_bank');
				});
			}
			if(data.rc == -61){
				$(location).attr('href', base_url+'/users/error_gral');
			}

		});

		return valida;
	} //CREAR CLAVE

	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

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
	} //VALIDAR CLAVE

	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function realizar_transferencia(cuentaOrigen, cuentaDestino, monto, descripcion, idUsuario, id_afil_terceros){
		var transferencia;
		var idTransferencia;
		$.ajaxSetup({async: false});

		var ajax_data = {
			"cuentaOrigen"     : cuentaOrigen,
			"cuentaDestino"   : cuentaDestino,
			"monto"    : monto,
			"descripcion" : descripcion,
			"tipoOpe" : "P2T",
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
					       $("#confirmacion_t").prop("disabled", false);
				       } else {
					       transferencia = {
						       status: false,
						       rc: data.rc,
						       msg: data.msg
					       };
					       $("#confirmacion_t").prop("disabled", false);
				       }
				       if(data.rc == -61){
					       $(location).attr('href', base_url+'/users/error_gral');
					       $("#confirmacion_t").prop("disabled", false);
				       }

			       }
		       });

		$.ajaxSetup({async: true});
		return transferencia;
	} //REALIZAR TRANSFERENCIA

	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function marcar_transferencia(resultado,item,transferencia){
		if(resultado==true){
			$(item).find(".data-resultado").addClass('data-success');
			$(item).find(".iconoTransferencia").removeClass("data-indicator icon-refresh icon-spin");
			$(item).find(".iconoTransferencia").addClass('icon-ok-sign');
			$(item).find("#estatus").empty();
			$(item).find("#estatus").text("Transacción exitosa. Nro. de Referencia: "+transferencia);

			//$('#descripcion').text( $(this).val() );
		}
		else{
			var msgTranfer,
				men = transferencia.msg;
			switch (transferencia.rc) {
				case -340:
					msgTranfer = 'Cantidad de dígitos de la cuenta es invalida.';
					break;
				case -341:
					msgTranfer = 'El número de cuenta no corresponde al banco.';
					break;
				case -342:
					msgTranfer = 'Número de cuenta invalido.';
					break;
				case -343:
					msgTranfer = 'Su tarjeta se encuentra bloqueada, código de bloqueo: ' + men.substr(34,35);
					break;
				default:
					msgTranfer = 'Transacción fallida.'
			}

			$(item).find(".data-resultado").addClass('data-error');
			$(item).find(".iconoTransferencia").removeClass("data-indicator data-indicator icon-refresh icon-spin");
			$(item).find(".iconoTransferencia").addClass('icon-cancel-sign');
			$(item).find("#estatus").empty();
			$(item).find("#estatus").text(msgTranfer);
		}
	} //MARCAR TRANSFERENCIA

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



});  // FIN FUNCION GENERAL
