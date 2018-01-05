var fecha = new Date();
fecha = fecha.getFullYear();
var i=0;
var anio,fechaIni,fechaFin,tipoConsulta,producto,tipoConsulta,reporte;
do {
	anio= parseInt(fecha)-i;
    $(".sub-stack").append('<li class="sub-stack-item"><a href="#" rel="subsection" >'+anio.toString()+'</a></li>');
	i=i+1;
} while(i!=3);

$(document).ready(function(){
		$(".nodata-state").hide();
		$("#dialog").css("display", "none");
		$("#download-boxes").hide();
		$("#filter-range-from").prop("disabled", true);
		$("#filter-range-to").prop("disabled", true);
		$("#detalle").prop( "disabled", true );
		$("#grafico").prop( "disabled", true );
	});

$(function(){



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

	$('#anio').hover(function(){
        $('.sub-stack').attr("style","display:block")
    },function(){
        $('.sub-stack').attr("style","display:none")
    });

	dialogo();

	/*----------------------------------------------------------------------------------*/
	$.datepicker.regional['es'] ={
		  closeText: 'Cerrar',

		  prevText: 'Previo',

		  nextText: 'Próximo',

		  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],

		  monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
		  'Jul','Ago','Sep','Oct','Nov','Dic'],

		  monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
		  dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],

		  dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],

		  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],

		  dateFormat: 'dd/mm/yy', firstDay: 0,

		  initStatus: 'Selecciona la fecha', isRTL: false
    };

	$.datepicker.setDefaults($.datepicker.regional['es']);

	$( "#filter-range-from" ).datepicker({
		onSelect: function(selected){
		 $( "#filter-range-to" ).datepicker('option','minDate',selected)
		}
	});
	$( "#filter-range-to" ).datepicker({
		onSelect: function(selected){
		$( "#filter-range-from" ).datepicker('option','maxDate',selected)
		}

	});

	$(".dashboard-item").click(function(event){
		event.preventDefault();

		var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre, tipo;

		imagen=$(this).find('img').attr('src');
		tarjeta=$(this).attr('card');
		marca=$(this).attr('marca');
		mascara=$(this).attr('mascara');
		producto=$(this).attr('producto1');
		empresa=$(this).attr('empresa');
		nombre=$(this).attr('nombre');
		idexper=$(this).attr('idpersona');
		tipo =$(this).attr('tipo');
		id= $(this).attr('id');
		prefix =$(this).attr('prefix');

		$("#donor").children().remove();

		var rangeBottom = $('#filter-range-from');
		var rangeTop = $('#filter-range-to');
		rangeBottom.val('');
		rangeBottom.removeClass('field-success');
		rangeBottom.removeClass('field-error');
		rangeTop.val('');
		rangeTop.removeClass('field-success');
		rangeTop.removeClass('field-error');

		cadena='<div class="product-presentation">';
		cadena+=    '<img src="'+imagen+'" width="200" height="130" alt="" />';
		cadena+=            '<div class="product-network '+marca+'"></div>';
		cadena+=               '<input id="donor-cardnumber" name="donor-cardnumber" prefix="'+prefix+'" tarjeta="'+tarjeta+'" idexper="'+idexper+'" tipo="'+tipo+'" type="hidden" value="'+tarjeta+'" />';
		cadena+=            '</div>';
		cadena+=            '<div class="productoct-info-full">';
		cadena+=                '<p class="product-cardholder">'+nombre+' <span class="product-cardholder-id">'+id+' '+idexper+'</span></p>';
		cadena+=                '<p class="product-cardnumber">'+mascara+'</p>';
		cadena+=                '<p class="product-metadata">'+producto+'</p>';
		cadena+=                '<nav class="product-stack">';
		cadena+=                    '<ul class="stack">';
		cadena+=                        '<li class="stack-item dialog">';
		cadena+=                            '<a rel="section" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit dialog"></span></a>';
		cadena+=                        '</li>';
		cadena+=                    '</ul>';
		cadena+=                '</nav>';
		cadena+=            '</div>';


		$("#donor").append(cadena);
		$("#content-product").dialog("close");
		dialogo();
		$("#mens").removeClass("disabled-button");  //Habilita el boton buscar del filtro

		producto = $("#donor").find("#donor-cardnumber").attr('prefix');
		var fecha = new Date();
		var anio = fecha.getFullYear();
		fechaIni = "01/01/"+anio;
		fechaFin = "31/12/"+anio;
		tipoConsulta = "0";
		generar_info(tarjeta,tipoConsulta,producto,idexper, fechaIni,fechaFin,"anual");

		$("#filter-range-from").prop("disabled", false);
		$("#filter-range-to").prop("disabled", false);

		$(".nodata-state").show();




		$(".content-anio").show();
		$(".content-mes").hide();
		$("#empty-state").hide();

		$(".anual").click(function(){
			tipoConsulta = "0";
			generar_info(tarjeta,tipoConsulta, tipo, idexper, "anual");
			$(".content-anio").show();
			$(".content-mes").hide();
		});
		validar_campos();

		$("#mens").click(function(){
			$("#detalle").prop("checked", true);
			$("#grafico").prop("disabled", true);
			$("#dialog").show();
		});

		$(".mensual").click(function(){

			$("#fechas").submit();
			setTimeout(function(){$("#msg").fadeOut();},2000);

			var form=$("#fechas");

			fechaIni=$("#filter-range-from").val();
			fechaFin=$("#filter-range-to").val();
			tipoConsulta = "1";
			if (form.valid() == true){
				generar_info(tarjeta, tipoConsulta, producto, idexper, fechaIni, fechaFin, "mensual");
				$(".content-mes").show();
				$(".content-anio").hide();

			}
		});

	$("#export_pdf").click(function(event){
		event.preventDefault();
		if(reporte == false){
         	$("#report-detail").children().remove();
         	$("#chart").children().remove();
			cadena='<div id="empty-state" style="position: static;">';
        	cadena+=                '<h2>No se encontraron movimientos</h2>';
        	cadena+=                 '<p>Vuelva a realizar la busqueda con un filtro distinto para obtener resultados.</p>';
        	cadena+=                '<span aria-hidden="true" class="icon-cancel-sign" style="position: relative;right: -410px;"></span>';
        	cadena+=             '</div>';
        	$("#report-detail").append(cadena);
        	$("#chart").append(cadena);
        }
        else{
			$("#tarjeta_pdf").val($("#donor-cardnumber").attr("tarjeta"));
        	$("#idpersona_pdf").val(idexper);
        	$("#producto_pdf").val($("#donor-cardnumber").attr("prefix"));
        	$("#tipoConsulta_pdf").val(tipoConsulta);
        	$("#fechaIni_pdf").val(fechaIni);
        	$("#fechaFin_pdf").val(fechaFin);
			$("#form_pdf").submit();
		}

	});
	$("#export_excel").click(function(event){
		event.preventDefault();
		if(reporte == false){
         	$("#report-detail").children().remove();
         	$("#chart").children().remove();
			cadena='<div id="empty-state" style="position: static;">';
        	cadena+=                '<h2>No se encontraron movimientos</h2>';
        	cadena+=                 '<p>Vuelva a realizar la busqueda con un filtro distinto para obtener resultados.</p>';
        	cadena+=                '<span aria-hidden="true" class="icon-cancel-sign" style="position: relative;right: -410px;"></span>';
        	cadena+=             '</div>';
        	$("#report-detail").append(cadena);
        	$("#chart").append(cadena);
        }
        else{
			$("#tarjeta").val($("#donor-cardnumber").attr("tarjeta"));
        	$("#idpersona").val(idexper);
        	$("#producto").val($("#donor-cardnumber").attr("prefix"));
        	$("#tipoConsulta").val(tipoConsulta);
        	$("#fechaIni").val(fechaIni);
        	$("#fechaFin").val(fechaFin);
			$("#form").submit();
		}

	});

});


	$("#grafico").click(function(){
		$("#chart").show();
		$("#results").hide();
		$("#empty-state").hide();
		$("#chart").children("svg").css("width","910px" );

	});

	$("#detalle").click(function(){
			$("#chart").hide();
			$("#results").show();
			// $("#empty-state").hide();

	});



	function dialogo(){
		$(".dialog").click(function(event){
			event.preventDefault();

			$("#content-product").dialog({
				title:"Seleccion de Cuentas Origen",
				modal:"true",
				width:"940px",
				open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			});
			$("#cerrar").click(function(){
				$("#content-product").dialog("close");
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

			$optionLinks.click(function(event){
				event.preventDefault();

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

		$('li.stack-item a').click(function(){
			$('.stack').find('.current-stack-item').removeClass('current-stack-item');
			$(this).parents('li').addClass('current-stack-item');
		});
	}

	function generar_info(tarjeta, tipo, producto, idpersona, fechaIni, fechaFin, consulta){
		$("#dialog").show();
		var moneda=$("#reporte").attr("moneda");
		$.post(base_url + "/report/CallWsGastos", {"tarjeta":tarjeta,"idpersona":idpersona,"tipo":tipo, "producto":producto,"fechaIni":fechaIni,"fechaFin":fechaFin}, function(data){
			if(data.rc == -61){
            	$(location).attr('href', base_url+'/users/error_gral');
            	$("#dialog").css("display", "none");
        	}
            if(data.rc != 0){

            	if (data.rc == -150) {
							$("#report-detail").children().remove();
							$("#chart").children().remove();
							$("#tbody-datos-mes").children().remove();
							$("#totales-mes td:not(.feed-headline)").remove();
							$("#tabla_detalle").attr("style","display:none");
							$("#dialog").css("display", "none");
							$("#empty-state").hide();
							$('[data-result="noresult"]').show();


            	}else {
							$("#report-detail").children().remove();
							$("#chart").children().remove();
							$("#tbody-datos-mes").children().remove();
							$("#totales-mes td:not(.feed-headline)").remove();
							$("#tabla_detalle").attr("style","display:none");

							cadena='<div id="empty-state" style="position: static;">';
            	cadena+=                '<h2>No se encontraron movimientos</h2>';
            	cadena+=                 '<p>Vuelva a realizar la busqueda con un filtro distinto para obtener resultados.</p>';
            	cadena+=                '<span aria-hidden="true" class="icon-cancel-sign" style="position: relative;right: -410px;"></span>';
            	cadena+=             '</div>';

            	$("#report-detail").append(cadena);
            	$("#chart").append(cadena);
            	$("#totales-mes td:not(.feed-headline)").append(cadena);
            	$("#tbody-datos-mes").append(cadena);
            	$("#dialog").css("display", "none");

            	reporte = false;
            }
        } else {
        		$("#download-boxes").show();

            	$(".nodata-state").hide();
            	$("#dialog").css("display", "none");
				$("#chart").hide();
				$("#results").show();
				$("#empty-state").hide();
				$("#grafico").prop( "disabled", false );
				$("#detalle").prop( "disabled", false );

            	$("#tabla_detalle").removeAttr('style');
            	reporte = true;
							var jsonChart={
								seriesDefaults: {
									labels: {
										template: "#= category #  #= kendo.format('{0:P}')#",
										position: "outsideEnd",
										visible: false,
										background: "transparent",
										format: moneda+ " {0}"
									}
								},
								seriesColors: ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#f1c40f", "#e67e22", "#e74c3c", "#16a085", "#27ae60", "#2980b9"],
								series:[{
									type: "pie",
	                overlay: {
	                  gradient: "none"
	                },
									data:[]
								}],
								legend: {
									visible: true
								},
								categoryAxis:{
									categories:[]
								},
								tooltip: {
									visible: true,
									template: "${category} - "+moneda+" ${value}"
								}
							}
			var datos = {};
			$.each(data.listaGrafico[0].categorias,function(posLista,itemLista){
				jsonChart.categoryAxis.categories.push(itemLista.nombreCategoria);
			});

			var info = data;
			$.each(info.listaGrafico[0].categorias,function(posLista,itemLista){
				$.each(info.listaGrafico[0].series,function(pos,item){
					datos = {};
					datos.category = itemLista.nombreCategoria;
					datos.value = parseFloat(item.valores[posLista]);
					jsonChart.series[0].data.push(datos);
				});
			});

			$("#chart").kendoChart(jsonChart);

			if(consulta == "anual"){

			$("tbody td:not(.feed-headline, #tbody-datos-mes)").remove();
			$("tfoot td:not(.feed-headline)").remove();
				$.each(data.listaGrupo,function(posLista,itemLista){
						$.each(itemLista.gastoMensual,function(pos,item){
							if(item.mes == "ENERO"){
								tr=$("#enero");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-monetary");
							}
							if(item.mes == "FEBRERO"){
								tr=$("#febrero");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-monetary");
							}

							if(item.mes == "MARZO"){
								tr=$("#marzo");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-monetary");
							}

							if(item.mes == "ABRIL"){
								tr=$("#abril");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-monetary");
							}

							if(item.mes == "MAYO"){
								tr=$("#mayo");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-monetary");
							}

							if(item.mes == "JUNIO"){
								tr=$("#junio");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-monetary");
							}

							if(item.mes == "JULIO"){
								tr=$("#julio");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-monetary");
							}

							if(item.mes == "AGOSTO"){
								tr=$("#agosto");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-monetary");
							}

							if(item.mes == "SEPTIEMBRE"){
								tr=$("#septiembre");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-monetary");
							}

							if(item.mes == "OCTUBRE"){
								tr=$("#octubre");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-monetary");
							}

							if(item.mes == "NOVIEMBRE"){
								tr=$("#noviembre");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-monetary");
							}

							if(item.mes == "DICIEMBRE"){
								tr=$("#diciembre");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-monetary");
							}

						});

					tr=$("#totales");
					th=$(document.createElement("td")).appendTo(tr);
					th.html(itemLista.totalCategoria);
					th.attr("class","feed-monetary feed-category-"+(posLista+1)+"x");

				});

					$.each(data.totalesAlMes,function(pos,item){
							if(item.mes == "ENERO"){
								tr=$("#enero");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-total");
							}
							if(item.mes == "FEBRERO"){
								tr=$("#febrero");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-total");
							}

							if(item.mes == "MARZO"){
								tr=$("#marzo");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-total");
							}

							if(item.mes == "ABRIL"){
								tr=$("#abril");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-total");
							}

							if(item.mes == "MAYO"){
								tr=$("#mayo");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-total");
							}

							if(item.mes == "JUNIO"){
								tr=$("#junio");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-total");
							}

							if(item.mes == "JULIO"){
								tr=$("#julio");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-total");
							}

							if(item.mes == "AGOSTO"){
								tr=$("#agosto");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-total");
							}

							if(item.mes == "SEPTIEMBRE"){
								tr=$("#septiembre");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-total");
							}

							if(item.mes == "OCTUBRE"){
								tr=$("#octubre");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-total");
							}

							if(item.mes == "NOVIEMBRE"){
								tr=$("#noviembre");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-total");
							}

							if(item.mes == "DICIEMBRE"){
								tr=$("#diciembre");
								td=$(document.createElement("td")).appendTo(tr);
								td.html(item.monto);
								td.attr("class","feed-total");
							}

						});

						tr=$("#totales");
						th=$(document.createElement("td")).appendTo(tr);
						th.html(data.totalGeneral);
						th.attr("class","feed-total");

        	}else{

        		$("#tbody-datos-mes").children().remove();
				$("#totales-mes td:not(.feed-headline)").remove();
				$("#dialog").css("display", "none");

    			var tbody=$("#tbody-datos-mes");
				tbody.empty();
				var trr=$("#totales-mes");
				trr.empty();
				$.each(data.totalesPorDia,function(pos,item){
					tr=$(document.createElement("tr")).appendTo(tbody);
					td=$(document.createElement("td")).appendTo(tr);
					td.html(item.fechaDia);
					td.attr("class","feed-headline");
					$.each(data.listaGrupo,function(Listapos,Listaitem){
						$.each(Listaitem.gastoDiario,function(posLista,itemLista){
							if(item.fechaDia == itemLista.fechaDia){
								td=$(document.createElement("td")).appendTo(tr);
								td.html(itemLista.monto);
							}
						});
					});
					td=$(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class","feed-monetary");
				});

				th=$(document.createElement("td")).appendTo(trr);
				th.html("Totales");
				th.attr("class","feed-total");
				$.each(data.listaGrupo,function(Listapos,Listaitem){
					th=$(document.createElement("td")).appendTo(trr);
					th.attr("class","feed-monetary feed-category-"+(Listapos+1)+"x");
					th.html(Listaitem.totalCategoria);

				});

				th=$(document.createElement("td")).appendTo(trr);
				th.html(data.totalGeneral);
				th.attr("class","feed-total");

        	}

        }


		});
	}
		function validar_campos(){
		jQuery.validator.setDefaults({
	 		debug: true,
	 		success: "valid"
	 	});

		$("#fechas").validate({

			errorElement: "label",
			ignore: "",
			errorContainer: "#msg",
			errorClass: "field-error",
			validClass: "field-success",
			errorLabelContainer: "#msg",
			rules: {
				"filter-range-from": {"required":true, "dpDate": true},
				"filter-range-to":{"required":true, "dpDate": true}

			},
			messages: {
				"filter-range-from": "El campo Fecha no posee el formato correcto (dd/mm/aaaa) ",
				"filter-range-to": "El campo Fecha no posee el formato correcto (dd/mm/aaaa) "
			}
		}); // VALIDATE
	}

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
});
