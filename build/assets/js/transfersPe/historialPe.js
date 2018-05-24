var base_url, base_cdn;
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

			var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre;

			imagen=$(this).find('img').attr('src');
			tarjeta=$(this).attr('card');
			marca=$(this).attr('marca').toLowerCase();
			mascara=$(this).attr('mascara');
			producto=$(this).attr('producto1');
			empresa=$(this).attr('empresa');
			nombre=$(this).attr('nombre');

			$("#donor").children().remove();

			cadena='<div class="product-presentation" producto="'+producto+'">';
			cadena+=	'<img src="'+imagen+'" width="200" height="130" alt="" />';
			cadena+=			'<div class="product-network '+marca+'"></div>';
			cadena+=							'<input id="donor-cardnumber-origen" name="donor-cardnumber" type="hidden" cardOrigen="'+tarjeta+'"/>';
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

			 $("#donor").append(cadena);          // MOSTRAR DATOS CUENTAS ORIGEN EN LA VISTA PRINCIPA

			 $(".product-button").removeClass("disabled-button");              // HABILITAR EDICION
			$("#agregarCuenta").attr("href","#");
			$("#agregarCuenta").parents("li").removeClass("disabled-group-action-item");
			$.each($(".dashboard-item"), function(pos,item){
				if($(this).hasClass("current-dashboard-item")){
					$(this).removeClass("current-dashboard-item");
				}
			});
			$(this).addClass("current-dashboard-item");

			$("#content-product").dialog("close");

			   // var ctaOrigen=$(this).attr("card");
			var ctaOrigen=$("#donor-cardnumber-origen").attr("cardorigen");
			// d = new Date();
			// var mes = d.getMonth()+1;
			// var anio = d.getFullYear();
			mes = $("#filter-month").val();
			anio = $("#filter-year").val();

			$("#buscar").removeClass("disabled-button");  //Habilita el boton buscar del filtro

			$('#list-detail').children().remove();
			buscar_historial(ctaOrigen, mes, anio);


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

		});//FIN

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	// BOTON BUSCAR
	$('#content').on('click',"#buscar",function(){
			//$("#buscar").click(function(){
				var ctaOrigen=$("#donor-cardnumber-origen").attr("cardorigen");
				mes = $("#filter-month").val();
				anio = $("#filter-year").val();
				$('#list-detail').children().remove();
				console.log(mes);
				buscar_historial(ctaOrigen,mes,anio);

	});	//BOTON BUSCAR

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	// FUNCION PARA TRAER LOS REGISTROS DE HISTORIAL
	function buscar_historial(ctaOrigen,mes,anio){
		var status, tipo = "Transferencia realizada", clase, clase1, cargando, verified = "";
		cargando = '<div id ="loading" class="data-indicator" style="text-align: center;">';
        cargando +=     '<h3 style="border-bottom: 0px;">Cargando</h3>';
        cargando +=     '<span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 50px;"></span>';
        cargando += '</div>';
        $('#carga').append(cargando);


				var ajax_data = {
						"noTarjeta":ctaOrigen,
						"mes":mes,
						"anio":anio
				};

				var data_seralize = $.param(ajax_data);


				$.ajax({
					url: base_url + '/transferencia/peGeneral',
					type: "post",
					data: {data : data_seralize, model : "historial_loadPe"},
					datatype: 'JSON',
					success: function(data) {

						switch(data.code){
								case 0:
									$('#carga').children().remove();
									$('#list-detail').children().remove();

									$.each(data.listaTransferenciasRealizadas,function(pos,item){

										 if(item.estatusOperacion == '1'){
											clase = 'icon-ok-sign';
											clase1 = 'feed-success';
											status = 'Procesado';
											verified = '<div class="verified">Verificado</div>';
										}else {
											clase = 'icon-cancel-sign';
											clase1 = 'feed-error';
											status = 'Rechazado';
											tipo = "Transferencia rechazada";
										}

										verified = (item.Autorizacion === true) ? '<div class="verified">Verificado</div>' : '';

													var fecha = item.fechaTransferencia.split('/');
													var dia = fecha[0];
													var mes;
													var moneda=$(".dashboard-item").attr("moneda");


													switch (fecha[1]){
														case "01":
														 mes="Ene";
															break;
														case "02":
															mes="Feb";
															break;
														case "03":
															mes="Mar";
															break;
														case "04":
															mes="Abr";
															break;
														case "05":
															mes="May";
															break;
														case "06":
															mes="Jun";
															break;
														case "07":
															mes="Jul";
															break;
														case "08":
															mes="Ago";
															break;
															case "09":
															mes="Sep";
															break;
														case "10":
															mes="Oct";
															break;
														case "11":
															mes="Nov";
															break;
														case "12":
															mes="Dic";
															break;
													}

														var lista =  '<li class="feed-item '+clase1+'">';
														lista+=				'<div class="feed-date">'+dia+'<span class="feed-date-month">'+mes+'</span></div>';
														lista+=				'<div class="feed-status">';
														lista+=					'<span aria-hidden="true" class="'+clase+'" title="'+status+'"></span>';
														lista+=				'</div>';
														lista+=				tipo + ': ' +item.beneficiario+'<span class="money-amount">'+ verified +'<div class="amount-history">'+moneda+' '+item.montoTransferencia+'</div> </span>'; //'+moneda+'
														lista+=				'<ul class="feed-metadata">';
														lista+=					'<li class="feed-metadata-item"><span aria-hidden="true" class="icon-mail"></span>   '+item.concepto+'</li>';
														lista+=				'</ul>';
														lista+=			'</li>';
													$('#list-detail').append(lista);
												});

										break;
								case 1:
									$(location).attr('href', base_url+'/users/error_gral');
									break;

								default:
												$('#carga').children().remove();
												var cadena='<div id="empty-state" style="position: static;">';
												cadena+=                '<h2>No se encontraron movimientos</h2>';
												cadena+=                 '<p>Vuelva a realizar la búsqueda con un filtro distinto para obtener resultados.</p>';
												cadena+=                '<span aria-hidden="true" class="icon-cancel-sign" style="position: relative;right: -415px;"></span>';
												cadena+=             '</div>';
												$("#list-detail").append(cadena);
									break;
							}
						}

				});

	}// FIN

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
