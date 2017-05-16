var path, base_cdn;
path =window.location.href.split( '/' );
base_cdn = path[0]+ "//" +path[2].replace('online','cdn')+'/'+path[3];
base_url = path[0]+ "//" +path[2] + "/" + path[3];

var montoMaxOperaciones,montoMinOperaciones,dobleAutenticacion,claveValida,claveC,montoComision,moneda,montoMasComision,saldo_imp;

$(function(){

	var confirmacion = $("#content").attr("confirmacion");
	if(confirmacion== '1'){
		$('#content-clave').hide();
		$('#content_tdc').show();
	}
	else{
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
					var saldo=data.disponible;
					if (typeof saldo!='string'){
						saldo="---";
					}

	  			$(item).find(".dashboard-item-balance").html(saldo);
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

	//Boton continuar clave
	$("#continuar_transfer").click(function(){
		var pass=$("#transpwd").val();
		if((confirmPassOperac(pass))){
			$('#content-clave').hide();
			$('#content_tdc').show();
		}
		else{
			$('#content_clave').show();
			//alert("Clave invalida");
			$.balloon.defaults.classname = "field-error";
			$.balloon.defaults.css = null;
			$("#transpwd").showBalloon({position: "right", contents: "Clave inválida"});
			setTimeout(function() {

				$("#transpwd").hideBalloon();

			}, 3000);
		}
	});

	$(".dashboard-item").click(function(){              // FUNCION PARA OBTENER DATOS DE TARJETA CTA ORIGEN

		var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre;

		imagen=$(this).find('img').attr('src');
		tarjeta=$(this).attr('card');
		marca=$(this).attr('marca');
		mascara=$(this).attr('mascara');
		producto=$(this).attr('producto1');
		empresa=$(this).attr('empresa');
		nombre=$(this).attr('nombre');
		moneda=$(this).attr('moneda');
		pais=$(this).attr("pais");

		$("#donor").children().remove();

		cadena='<div class="product-presentation">';
		cadena+=    '<img src="'+imagen+'" width="200" height="130" alt="" />';
		cadena+=            '<div class="product-network '+marca.toLowerCase()+'"></div>';
		cadena+=               '<input id="origin-cardnumber" name="donor-cardnumber" type="hidden" value="'+tarjeta+'" />';
		cadena+=            '</div>';
		cadena+=            '<div class="product-info">';
		cadena+=                '<p class="product-cardholder">'+nombre+'</p>';
		cadena+=                '<p class="product-cardnumber">'+mascara+'</p>';
		cadena+=                '<p class="product-metadata">'+producto+'</p>';
		cadena+=                '<nav class="product-stack">';
		cadena+=                    '<ul class="stack">';
		cadena+=                        '<li class="stack-item">';
		cadena+=                            '<a dialog button product-button rel="section" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit"></span></a>';
		cadena+=                        '</li>';
		cadena+=                    '</ul>';
		cadena+=                '</nav>';
		cadena+=            '</div>';
		cadena+=    '<div class="product-scheme">';
		cadena+=        '<ul class="product-balance-group">';
		cadena+=            '<li>Disponible <span class="product-balance" id="balance-available" > '+moneda+' 0,00</span></li>';
		cadena+=            '<li>A debitar <span class="product-balance" id="balance-debit"> '+moneda+' 0,00</span></li>';
		cadena+=        '</ul>';
		cadena+=    '</div>';


		$("#donor").append(cadena);

		$.post(base_url+"/dashboard/saldo",{"tarjeta":$(this).attr("card")},function(data){
			var saldo=data.disponible;
			if (typeof saldo!='string'){
				saldo="---";
			}

			$("#balance-available").attr("saldo",saldo);
			$("#balance-available").html(moneda+saldo);
		});

		$(".product-button").removeClass("disabled-button");
		$("#agregarCuenta").attr("href","#");

		$("#agregarCuenta").parents("li").removeClass("disabled-group-action-item");

		$.each($(".dashboard-item"), function(pos,item){
			if($(this).hasClass("current-dashboard-item")){
				$(this).removeClass("current-dashboard-item");
			}
		});

		$(this).addClass("current-dashboard-item");
		$("#content-product").dialog("close");

		$('.stack-item:not(.modifica)').click(function(){
			$("#tdestino").children(":not(#btn-destino)").remove();
			$("#content-product").dialog({
				title:"Selección de Cuentas Origen",
				modal:"true",
				width:"940px",
				open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }

			});
		});

		$.post(base_url+"/transferencia/ctaDestino",{"nroTarjeta":$(this).attr("card"), "prefijo":$(this).attr("prefix"), "operacion":"P2C"},function(data){  //FUNCION PARA CARGAR CUENTAS DESTINO
			if(data.rc==-150){
				$("#content_tdc").children().remove();
				$("#tabs-menu").children().remove();
				$("#content_tdc").append($("#content-no-afil").html());
				$("#content-no-afil").children().remove();

			}
			else{
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
			montoComision = data.parametrosTransferencias[0].montoComision;

			$("#dashboard-beneficiary").empty();

			var cadena;

			$.each(data.tarjetaDestinoTercero,function(pos,item){
				var num = Math.floor(Math.random() * 5) + 1;
				var imagen = "card-"+num;
				var cadena;

				cadena="<li class='dashboard-item muestraDestino' card='"+item.noCuenta+"' marca='"+item.marca+"' nombre='"+item.beneficiario+"' comision='"+montoComision+"' mascara='"+item.noCuentaConMascara+"' banco ='"+item.banco+"' id_afiliacion='"+item.id_afiliacion+"'>";
				cadena+= "<a rel='section'>";
				//cadena+= "<img src='"+base_cdn+"/img/products/"+item.imagen+".png' width='200' height='130' alt='' />";
				cadena+= "<img src='"+base_cdn+"/img/products/default/"+imagen+".png' width='200' height='130' alt='' />";
				cadena+=  "<div class=''></div>";
				cadena+= "<div class='dashboard-item-info'>";
				cadena+= "<p class='dashboard-item-cardholder'>"+item.beneficiario+"</p>";
				cadena+=  "<p class='dashboard-item-cardnumber'>"+item.noCuentaConMascara+"</p>";
				cadena+=  "<p class='dashboard-item-category'>"+item.banco+"</p>";
				cadena+= "</div>"
				cadena+= " </a>"
				cadena+=  "</li>";

				$("#dashboard-beneficiary").append(cadena);

			});

		}
// -----------------------------------------------------  MUESTRA DESTINO  ------------------------------------------------------------------------------


			$(".muestraDestino").click(function(){              // FUNCION PARA OBTENER DATOS DE LA CUENTA DESTINO

				if ($(this).hasClass('disabled-dashboard-item')==true) {
					$("#content-destino").dialog("close");
					//alert("SelecciÃ³n Invalida");

				} else {

					var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre;

					imagen=$(this).find('img').attr('src');
					tarjeta=$(this).attr('card');
					mascara=$(this).attr('mascara');
					marca=$(this).attr('marca');
					producto=$(this).attr('banco');
					nombre=$(this).attr('nombre');
					id_afil=$(this).attr('id_afiliacion');
					banco=$(this).attr('banco');
					comision=$(this).attr('comision');

					$(".edit").remove();

					var number = contar_tarjetas();

					cadena= '<div class="group"> ';
					cadena+='<div class="product-presentation">';
					cadena+=    '<img src="'+imagen+'" width="200" height="130" alt="" />';
					cadena+=            '<div class=""></div>';
					cadena+=                            '<input id="tarjetaDestino" class="tarjetaDestino" id="donor-cardnumber" name="donor-cardnumber" type="hidden" value="'+tarjeta+'" />';
					cadena+=							'<input class="id_afiliacion" name="id_afil" type="hidden" value="'+id_afil+'" />';
					cadena+=							'<input class="banco" name="id_afil" type="hidden" value="'+banco+'" /> <input class="comision" name="comision" type="hidden" value="'+comision+'" />';
					cadena+=                        '</div>';
					cadena+=                        '<div class="product-info">';
					cadena+=                            '<p class="product-cardholder">'+nombre+'</p>';
					cadena+=                            '<p class="product-cardnumber">'+mascara+'</p>';
					cadena+=                            '<p class="product-metadata">'+producto+'</p>';
					cadena+=                            '<nav class="product-stack">';
					cadena+=                                '<ul class="stack">';
					cadena+=                                    '<li class="stack-item modifica">';
					cadena+=                                        '<a rel="section" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit"></span></a>';
					cadena+=                                    '</li>';
					cadena+=                                        '<li class="stack-item elimina">';
					cadena+=                                        '<a rel="section" title="Remover"><span aria-hidden="true" class="icon-cancel"></span></a>';
					cadena+=                                    '</li>';
					cadena+=                                '</ul>';
					cadena+=                            '</nav>';
					cadena+=                        '</div>';
					cadena+=                        '<div class="product-scheme">';
					cadena+=                             '<fieldset class="form-inline">';
					cadena+=                                    '<label for="beneficiary-1x-description" title="Descripción del pago.">Concepto</label>';
					cadena+=                                    '<input class="field-large" id="beneficiary-'+number+'x-description" maxlength="60" name="beneficiary-'+number+'x-description" type="text"/>';
					cadena+=                                    '<label for="beneficiary-1x-amount" title="Monto a transferir.">Importe</label>';
					cadena+=                                    '<div class="field-category"> '+moneda+' ';
					cadena+=                                                    '<input id="beneficiary-1x-coin" name="beneficiary-1x-coin" type="hidden" value="'+moneda+'" />';
					cadena+=                                    '</div>';
					cadena+=                                    '<input class="field-small monto dinero" id="beneficiary-'+number+'x-amount" maxlength="12"  name="beneficiary-'+number+'x-amount" type="text" />';
					cadena+=                             '</fieldset></div></div>';


					$("#content_tdc #tdestino").append(cadena);
					$("#beneficiary-1x").removeClass("obscure-group");
					$("#content-destino").dialog("close");
					$("#tdestino").children("#btn-destino").remove();
					$("#tdestino").append($("#removerDestino").html());
					marcar_destino();
					var montotr = $(".monto").val().replace(',', '.');

					$('#content_tdc').on('keyup','.monto',function() {

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
					 		 if((parseFloat(montotr)) > saldo_imp){
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

					 		if((parseFloat($(this).val())+parseFloat(montoAcumDiario))>parseFloat(montoMaxDiario)){

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

					 		} else if((parseFloat(montotr)+parseFloat(montoAcumMensual))>parseFloat(montoMaxMensual)){

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

							} else {
					 			m=$(".dashboard-item").attr('moneda');
								$(this).parents('.group').attr("montInput",$(this).val());
								$(this).val().replace(',', '.');
								$("#balance-debit").html(m+sumar_saldo().toFixed(2));
					 		}
 						});

					if(contar_tarjetas() >= 4){
						$("#tdestino").children("#btn-destino").remove();
					}

					if(contar_tarjetas() > 1){
						$('#continuar').removeAttr("disabled");
					}else{
						$('#continuar').attr('disabled','');
					}

					dialogo();

				}

			});
				$('#content_tdc').on('click',".modifica",function(){
						$(this).parents('.group').addClass('edit');
						$("#content-destino").dialog({
							title:"Selección de Cuentas Destino",
							modal:"true",
							width:"940px",
							beforeClose: function( event, ui ) {
								$('.group').removeClass('edit');
							},
							open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
						});
					});

					$('#content_tdc').on('click',".elimina",function(){
						m=$(".dashboard-item").attr('moneda');
						suma=sumar_saldo();
						montoRestar=parseFloat($(this).parents('.group').attr('montInput'));
						saldo=suma-montoRestar;

						if(saldo<0){
							$("#balance-debit").html(m+0.00);
						}
						else{
							$("#balance-debit").html(m+saldo);
						}
						$(this).parents('.group').remove();
						marcar_destino();
						if($("#tdestino").find("#btn-destino").length == 0){
							$("#tdestino").append($("#removerDestino").html());
						}
						if(contar_tarjetas() >= 1){
							$('#continuar').removeAttr("disabled");
						}else{
							$('#continuar').attr('disabled','');
						}
					});

			marcar_destino_montos();

			});


			dialogo();

		});

			//validar_campos();

// ------------------------------------------------------- BOTON CONTINUAR -------------------------------------------------------------------------------------

	$("#continuar").click(function(){

		var confirmacion = true;
		var contador_trans=0;
		$("#montoTotal").remove();
		$("#tdestino").append("<input id='montoTotal' name='montoTotal' type='hidden' class='checkTotal' value='' />");
		$("#montoTotal").val(sumar_saldo());
		$("#validate").submit();
		//setTimeout(function(){$("#msg").fadeOut();},5000);
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

			valor_monto1= $("#beneficiary-1x-amount").val();
			valor_monto2= $("#beneficiary-2x-amount").val();
			valor_monto3= $("#beneficiary-3x-amount").val();

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
				// alert(parseFloat(total)+parseFloat(montoAcumDiario)+" - "+ parseFloat(montoMaxDiario));
				// alert(parseFloat(total)+parseFloat(montoAcumSemanal)+" - "+parseFloat(montoMaxSemanal));
				// alert(parseFloat(total)+parseFloat(montoAcumMensual)+" - "+parseFloat(montoMaxMensual));


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


		//var form = $("#validate");

		//if(form.valid() && confirmacion== true){
		if (confirmacion==true) {

			var origen, nombre, mascara, producto, tr, compretar, estino, nombre, mascara, monto, concepto, producto, tarjeta, idUsuario;

			nombre=$("#donor").find(".product-cardholder").html();
			mascara=$("#donor").find(".product-cardnumber").html();
			producto=$("#donor").find(".product-metadata").html();
			tarjeta=$("#origin-cardnumber").val();
			idUsuario =$("#content").attr("idUsuario");
			comision=$("#tdestino").find(".comision").val();

			origen=		  '<tr id="trorigen" card="'+tarjeta+'" idUsuario="'+idUsuario+'">';
			origen+=        '<td class="data-label"><label>Cuenta Origen</label></td>';
			origen+=        '<td class="data-reference" colspan="2" id="nombreOrigenTransfer">'+nombre+'<br /><span class="highlight">'+mascara+'</span><br /><span class="lighten">'+producto+'</span></td>';
			origen+=      '</tr>';

			$("#tbody").append(origen);

			tr= '<td class="data-label"><label>Cuentas Destino</label></td>';

			$("#tbody").append(tr);
			var contador_trans=0;

			$.each($('#tdestino').children(':not(.obscure-group, .checkTotal)'), function(pos, item){

				nombre=$(item).find(".product-cardholder").html();
				mascara=$(item).find(".product-cardnumber").html();
				producto=$(item).find(".product-metadata").html();
				monto=$("#beneficiary-"+(pos+1)+"x-amount").val();
				concepto=$("#beneficiary-"+(pos+1)+"x-description").val();
				ctnDestino = $(item).find(".tarjetaDestino").val();
				id_afil = $(item).find(".id_afiliacion").val();
				banco = $(item).find(".banco").val();
				contador_trans = contador_trans+1;
				suma = sumar_saldo();
				//comision= parseFloat(comision);
				//montoT= suma + comision;
				montoT= suma;
				// var total = $(".product-scheme").find(".debitar").html().replace(/BsF./g, "");
				// total1=total.replace(".", ",")
				if((pais=='Ve') || (pais=='Co')){
						//var total = $(".product-scheme").find(".debitar").html().replace(/Bs./g, "");
						var total = $(".product-scheme").find("#balance-debit").html().replace(/Bs./g, "");
						total1=total.replace(".", ",");
				}
				else{
					//var total = $(".product-scheme").find(".debitar").html().replace(/S./g, "");
					var total = $(".product-scheme").find("#balance-debit").html().replace(/S./g, "");
					total1=total;
				}
				monto_t=total1.replace(",", ".");

					destino=              '<tr class="trdestino" card="'+ctnDestino+'" id_afil="'+id_afil+'" monto="'+monto+'" concepto="'+concepto+'" banco="'+banco+'" comision="'+comision+'">';
					destino+=				  '<td class="data-label"> </td>';
					destino+=                 '<td class="data-reference" id="nombreDestinoTransfer">'+nombre+'<br /><span class="highlight" id="mascaraDestinoTransfer">'+mascara+'</span><br /><span class="lighten" id="bancoDestinoTransfer">'+banco+'</span></td>';
					destino+=	               '<td class="data-metadata data-resultado">';
					destino+=				   '<div class="data-indicator">';
					destino+=					'<span aria-hidden="true" class="iconoTransferencia"></span>';
					destino+=                 '</div><span class="data-metadata" id="conceptoDestino"><strong>Concepto: </strong>'+concepto+'<br /><strong>monto: </strong><span class="money-amount" monto="'+monto+'" id="montoDestinoTransfer">'+moneda+' '+monto+'</span><br /><strong>Estatus: </strong><span class="money-amount" id="estatus">En espera por confirmación.</span></td>';
					destino+=				'</td>';
					destino+=               '</tr>';
					destino+=               '<tr>';
					destino+=              		'<td class="data-spacing" colspan="3"></td>';
					destino+=           	'</tr>';

				$("#tbody").append(destino);

			});  //EACH
				comision= parseFloat(comision)*contador_trans;
				montoT= suma + comision;
				montoT = montoT.toString();
				montoT=montoT.replace(".", ",");
				montoMasComision = montoT;

				completar=         '<tr>';
				completar+=                     '<td class="data-spacing" colspan="3"></td>';
				completar+=                  '</tr>';
				completar+=                  '<tr>';
				completar+=                     '<td colspan="2"></td>';
				completar+=                     '<td class="data-metadata">Total+Comisión ('+moneda+' '+comision+')<br /><span class="money-amount">'+moneda+' '+montoT+'</span></td>';
				completar+=                  '</tr>';

				$("#tbody").append(completar);
				$("#content-transfer-P2C").children().remove();
				$("#content-transfer-P2C").append($("#confirm-transfer").html());
				$("#confirm-transfer").remove();

			}  //FORM VALIDATE

	});  //END

// ------------------------------------------------------ CONTENT CONFIRMACION ------------------------------------------------------------------------------

	// $("#continue_trans").click(function(){

	$('#content_tdc').on('click',"#continue_trans",function(){
		$('#continue_trans').prop('disabled',true);
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

									// var cuentaOrigen = $("#nombreOrigenTransfer").attr("numeroCtaOrigen");
									// var idUsuario =  $("#nombreOrigenTransfer").attr("nombreCtaOrigen");
									var cuentaOrigen = $("#trorigen").attr("card");
									var idUsuario =  $("#trorigen").attr("idUsuario");
									var cuentaDestino,id_afil_terceros,monto,descripcion, resultado;
									$(".data-indicator").show();

									$.each($('.trdestino'), function(pos, item){


										cuentaDestino= $(item).attr("card");
										id_afil_terceros= $(item).attr("id_afil");
										monto=$(item).attr("monto").replace(',', '.');
										descripcion=$(item).attr("concepto");
										comision=$(item).attr("comision");

										transferencia=realizar_transferencia(cuentaOrigen, cuentaDestino, monto, descripcion, idUsuario, id_afil_terceros);
										//trans = true;
											if(transferencia != false){
												resultado = true;
												marcar_transferencia(resultado,item,transferencia);

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

													// 	$("#content_tdc").children().remove();
													// $("#content_tdc").append($("#transferFinal").html());
													// $("#confimacion_b").children().remove();

													var completar;

													completar= 		'<tr>';
													completar+=  		'<td colspan="2"></td>';
													completar+=			'<td class="data-metadata">';
													completar+= 				'Total: <span class="lighten"> ('+moneda+' '+comision+' Comisión) </span> <br /><span class="money-amount"> '+moneda+' '+montoMasComision+' </span>';
													completar+= 		'</td>';
													completar+= 	'</tr>';

												 $("#bodyConfirm").append(completar).html();
												 $("#confimacion_t").children().remove();
												  completar1= 		'<button id="exit">Finalizar</button>';
				            					$("#confimacion_t").append(completar1).html();
				            					$("#exit").click(function(){

													$(location).attr('href', base_url+'/dashboard');

												});
											}
											else{					//REALIZAR TRANSFERENCIA

												resultado=false;
												trans = "-"
												marcar_transferencia(resultado,item,transferencia);
												$("#confimacion_t").children().remove();
												completar1= 		'<button id="exit">Finalizar</button>';
												$("#confimacion_t").append(completar1).html();
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


	} //DOBLE AUTENTIFICACION SI
	else {
		// var cuentaOrigen = $("#nombreOrigenTransfer").attr("numeroCtaOrigen");
		// var idUsuario =  $("#nombreOrigenTransfer").attr("nombreCtaOrigen");
		var cuentaOrigen = $("#trorigen").attr("card");
		var idUsuario =  $("#trorigen").attr("idUsuario");
		var cuentaDestino,id_afil_terceros,monto,descripcion, resultado;
		$(".data-indicator").show();

		$.each($('.trdestino'), function(pos, item){

			cuentaDestino= $(item).attr("card");
			id_afil_terceros= $(item).attr("id_afil");
			monto=$(item).attr("monto");
			descripcion=$(item).attr("concepto");
			comision=$(item).attr("comision");

			transferencia=realizar_transferencia(cuentaOrigen, cuentaDestino, monto, descripcion, idUsuario, id_afil_terceros);
			//trans = true;

				if(transferencia != false){

					resultado = true;
					marcar_transferencia(resultado,item,transferencia);

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
					trans="-";
					marcar_transferencia(resultado,item,transferencia);
					$("#confimacion_t").children().remove();
					completar1= 		'<button id="exit">Finalizar</button>';
					$("#confimacion_t").append(completar1).html();
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
}

// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

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


// -------------------------------------------------------------------------------------------------------------------------------------------------------------------
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

// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

function marcar_destino() {

	$.each($('#dashboard-beneficiary').children('.dashboard-item'), function(posd,itemd){

		$(itemd).removeClass("disabled-dashboard-item");

		$.each($('#tdestino').children(':not(.obscure-group)'), function(pos, item){

			if($(item).find("#tarjetaDestino").val()==$(itemd).attr("card")){

				$(itemd).addClass("disabled-dashboard-item");

			}
		});
	});
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
		}else{
			response1 = false;
			rpta1 = false;
		}
	});

	return rpta1;
}

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
              title:"ContraseÃ±as no coinciden",
              modal:"true",
              width:"440px",
              open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
            });

            $("#invalido2").click(function(){
              $("#dialog-error-clave").dialog("close");
              $(location).attr('href', base_url+'/transfer/index_tdc');
            });
		}
	});

	return valida;
}

// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

function validar_clave(claveConfir){

	$.ajaxSetup({async: false});

	var claveValida;

	$.post(base_url +"/transferencia/confirmacion",{'clave':hex_md5(claveConfir)},function(data){

		if(data.rc==0){
			claveValida = true;

		} else {
			claveValida = false;
			 $("#dialog-error-correo").dialog({
              title:"ContraseÃ±as no coinciden",
              modal:"true",
              width:"440px",
              open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
            });

            $("#invalido").click(function(){
              $("#dialog-error-correo").dialog("close");
            });
		}

	});

	return claveValida;
}

// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function realizar_transferencia(cuentaOrigen, cuentaDestino, monto, descripcion, idUsuario, id_afil_terceros){
		var transferencia;
		var idTransferencia;
		$.ajaxSetup({async: false});
		//transferencia = 1111;
		// $.post(base_url +"/transferencia/procesar",{"cuentaOrigen":cuentaOrigen,"cuentaDestino":cuentaDestino,"monto":monto,"descripcion":descripcion,"tipoOpe":"P2C","idUsuario":idUsuario,"id_afil_terceros":id_afil_terceros},function(data){
		// 	if(data.rc==0){

	 //   			var idTransferencia=data.dataTransaccion.referencia;
	 //   			transferencia = idTransferencia;
	 //   			$(".comision").html(comision+" comisiÃ³n");

	 //   		}else{
	 //   			transferencia = false;
	 //   		}
	 //   	});
	var ajax_data = {
		  "cuentaOrigen"     : cuentaOrigen,
		  "cuentaDestino"   : cuentaDestino,
		  "monto"    : monto,
		  "descripcion" : descripcion,
		  "tipoOpe" : "P2C",
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
				$('#continue_trans').prop('disabled',false);

	   		}else{

	   			transferencia = false;
				$('#continue_trans').prop('disabled',false);
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
			$(item).find("#estatus").text("Transacción exitosa. Nro. Transacción: "+transferencia);
		}
		else{
			$(item).find(".data-resultado").addClass('data-error');
			$(item).find(".iconoTransferencia").removeClass("data-indicator data-indicator icon-refresh icon-spin");
			$(item).find(".iconoTransferencia").addClass('icon-cancel-sign');
			$(item).find("#estatus").empty();
			$(item).find("#estatus").text("Transacción fallida.");
		}
	} //MARCAR TRANSFERENCIA

// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

//FUNCION PARA DESHABILITAR TARJETA DESTINO SI EL MONTO MAX/MIN MENSUAL O DIARIO FUE EXCEDIDO
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
