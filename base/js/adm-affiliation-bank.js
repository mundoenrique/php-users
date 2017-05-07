var path, base_cdn;
path =window.location.href.split( '/' );
base_cdn = path[0]+ "//" +path[2].replace('online','cdn')+'/'+path[3];
base_url = path[0]+ "//" +path[2] + "/" + path[3];


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
			marca=$(this).attr('marca');
			mascara=$(this).attr('mascara');
			producto=$(this).attr('producto1');
			empresa=$(this).attr('empresa');
			nombre=$(this).attr('nombre');

			$("#donor").children().remove();

			cadena='<div class="product-presentation" producto="'+producto+'">';
			cadena+=	'<img src="'+imagen+'" width="200" height="130" alt="" />';
			cadena+=			'<div class="product-network '+marca.toLowerCase()+'"></div>';
			cadena+=							'<input id="donor-cardnumber-origen" name="donor-cardnumber" type="hidden" producto="'+producto+'" nombreOrigen="'+nombre+'" cardOrigen="'+tarjeta+'" masCtaOrigen="'+masCtaOrigen+'" marcaCtaOrigen="'+marca+'"  />';
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
			var marcaCtaOrigen=$("#donor-cardnumber-origen").attr("producto");
			var producto=$("#donor-cardnumber-origen").attr("producto");
			var nombreOrigen=$("#donor-cardnumber-origen").attr("nombreOrigen");
			var prefijo = $(this).attr("prefix")
			// d = new Date();
			// var mes = 01;
			// var anio = d.getFullYear();
			mes = $("#filter-month").val();
			anio = $("#filter-year").val();

			$("#buscar").removeClass("disabled-button");  //Habilita el boton buscar del filtro

			$('#list-detail').children().remove();
			buscar_ctaDestino(ctaOrigen,prefijo,masCtaOrigen,marcaCtaOrigen,nombreOrigen,producto);


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

	function buscar_ctaDestino(ctaOrigen,prefijo,masCtaOrigen,marcaCtaOrigen,nombreOrigen,producto){
		var clase,clase1;
		$.post(base_url +"/transferencia/ctaDestino",{"nroTarjeta":ctaOrigen,"prefijo":prefijo,"operacion":"P2T"},function(data) {
			if(data.rc == -61){
				$(location).attr('href', base_url+'/users/error_gral');
			}
			if(data.rc==0){
				$('#empty-state').remove();
				$.each(data.cuentaDestinoTercero,function(pos,item){
          var num = Math.floor(Math.random() * 5) + 1;
					var imagen = "bank-"+num;
						var cadena;

						cadena=  "<li class='dashboard-item "+item.beneficiario+" muestraDestino' card='"+item.noCuenta+"' banco='"+item.banco+"' codBanco='"+item.codBanco+"' id_ext_per='"+item.id_ext_per+"' nombre='"+item.beneficiario+"' emailCliente='"+item.email+"' id_afiliacion='"+item.id_afiliacion+"' marca='"+item.marca+"' mascara='"+item.noCuentaConMascara+"'>";
						cadena+=		"<div class='dashboard-item-box'>"
						cadena+=			"<img src='"+base_cdn+"/img/products/default/"+imagen+".png' width='200' height='130' alt='' />"
						cadena+=			"<div class='dashboard-item-info'>"
						cadena+=				"<p class='dashboard-item-cardholder'>"+item.beneficiario+"</p>"
						cadena+=				"<ul class='dashboard-item-actions'>"
						cadena+=					"<li class='actions-item'>"
						cadena+=						"<a title='Modificar' id='modificar'><span aria-hidden='true' class='icon-edit'></span></a>"
						cadena+=					"</li>"
						cadena+=					"<li class='actions-item' id='eliminar'>"
						cadena+=						"<a title='Remover'><span aria-hidden='true' class='icon-remove'></span></a>"
						cadena+=					"</li>"
						cadena+=				"</ul>"
						cadena+=				"<p class='dashboard-item-cardnumber'>"+item.noCuentaConMascara+"</p>"
						cadena+=				"<p class='dashboard-item-category'>"+item.banco+"</p>"
						cadena+=			"</div>"
						cadena+=		"</div>"
						cadena+=	"</li>"

					$("#dashboard").append(cadena);

					});

				$('.muestraDestino').on('click',"#modificar",function(){

					var imagen, tarjeta, marca, mascara, empresa, cadena, nombre;

					// imagen=$(this).find('img').attr('src');
					// tarjeta=$(".muestraDestino").attr('card');
					// id_ext_per=$(".muestraDestino").attr('id_ext_per');
					// nombre=$(".muestraDestino").attr('nombre');
					// emailCliente=$(".muestraDestino").attr('emailCliente');
					// id_afiliacion=$(".muestraDestino").attr('id_afiliacion');
					// banco=$(".muestraDestino").attr('banco');
					// codBanco=$(".muestraDestino").attr('codBanco');
					tarjeta =$(this).parents(".dashboard-item").attr('card');
					id_ext_per_1=$(this).parents(".dashboard-item").attr('id_ext_per');
					tipo_doc=id_ext_per_1.substr(0,1);
					id_ext_per=id_ext_per_1.substr(1,9);
					nombre=$(this).parents(".dashboard-item").attr('nombre');
					emailCliente=$(this).parents(".dashboard-item").attr('emailCliente');
					id_afiliacion=$(this).parents(".dashboard-item").attr('id_afiliacion');
					banco=$(this).parents(".dashboard-item").attr('banco');
					codBanco=$(this).parents(".dashboard-item").attr('codBanco');

					$(".product-button").attr('disabled','disabled');
					$('#selCtaOrigen').attr("style","display:none");
					$("#content-holder").children().remove();

						var ctaDestino;
						ctaDestino = "<div id='progress'>";
						ctaDestino+= 	"<ul class='steps'>";
						ctaDestino+= 		"<li class='step-item current-step-item'><span aria-hidden='true' class='icon-edit'></span> Modificación de Afiliación</li>";
						ctaDestino+= 		"<li class='step-item'><span aria-hidden='true' class='icon-view'></span> Confirmación</li>";
						ctaDestino+= 		"<li class='step-item'><span aria-hidden='true' class='icon-thumbs-up'></span> Finalización</li>";
						ctaDestino+= 	"</ul>";
						ctaDestino+= "</div>";
						ctaDestino+= "<div id='content-holder'>";
						ctaDestino+= "<form id='datos'>";
						ctaDestino+= "<ul class='field-group'>";
						ctaDestino+= 				"<li class='field-group-item'>";
						ctaDestino+= 					"<label for='bank-name'>Banco</label>";
						ctaDestino+= 					"<select id='bank-name' name='bank-name' banco='"+banco+"''>";
						ctaDestino+= 						"<option selected value='"+codBanco+"'>"+banco+"</option>";
						ctaDestino+= 					"</select>";
						ctaDestino+= 				"</li>";
				        ctaDestino+=    "<li class='field-group-item'>";
				        ctaDestino+=       "<label for='card-number'>N° de Cuenta Destino</label>";
				        ctaDestino+=       "<input class='field-medium' id='card-number' name='card-number' maxlength='20' value='"+tarjeta+"'/>";
				        ctaDestino+=    "</li>";
				        ctaDestino+=   " <li class='field-group-item'>";
				        ctaDestino+=       "<label for='card-holder'>Beneficiario</label>";
				        ctaDestino+=       "<input class='field-large' id='card-holder' name='card-holder' maxlength='35' type='text' value='"+nombre+"' />";
				        ctaDestino+=    "</li>";
				        ctaDestino+= "</ul>";
				        ctaDestino+=  "<ul class='field-group'>";
				        ctaDestino+=    "<li class='field-group-item'>";
				        ctaDestino+=       "<label for='bank-account-holder-id'>Documento de Identidad</label>";
				        ctaDestino+=		"<select id='doc-name' name='doc-name'>"
                        ctaDestino+=				"<option selected value='"+tipo_doc+"'>"+tipo_doc+"</option>"
                        ctaDestino+=				"<option value='V'>V</option>"
                        ctaDestino+=				"<option value='E'>E</option>"
                        ctaDestino+=				"<option value='J'>J</option>"
                        ctaDestino+=		 	"<option value='G'>G</option>"
                       	ctaDestino+=	"</select>"
				        ctaDestino+=       "<input class='field-medium' id='bank-account-holder-id' name='bank-account-holder-id' maxlength='14' minlength='5' type='text' value="+id_ext_per+" />";
				        ctaDestino+=    "</li>";
				        ctaDestino+=    "<li class='field-group-item'>";
				        ctaDestino+=       "<label for='card-holder-email'>Correo Electrónico</label>";
				        ctaDestino+=       "<input class='field-large' id='card-holder-email' name='card-holder-email' maxlength='30'  type='text' value="+emailCliente+" />";
				        ctaDestino+=    "</li>";
				        ctaDestino+= "</ul>";
				        ctaDestino+= "</form>";
								ctaDestino+="<div id='msg' banco='"+codBanco+"''></div>";
				        ctaDestino+="<div class='form-actions'>";
				        ctaDestino+="<button id='cancelar1' type='reset'>Cancelar</button>";
				        ctaDestino+="<button id='cambiar'>Modificar</button>";
				      	ctaDestino+="</div>";
				      	ctaDestino+="</div>";


				        $("#content-holder").append(ctaDestino);

				        						getBancos();
				        $("#cancelar1").click(function(){

   			 					$(location).attr('href', base_url+'/adm/adm_bank');

   							});

				        $("#cambiar").click(function(){

							validar_campos();

							$("#datos").submit();

							setTimeout(function(){$("#msg").fadeOut();},5000);

							var form, notSms, notEmail;

							form=$("#datos");

						var cDestino=$("#card-number").val();
				 		cod_ban=cDestino.substr(0,4);
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
				        	var confirmacion;
				        	var cDestino=$("#card-number").val();
				        	var nombreDest=$("#card-holder").val();
				        	var id_per1=$("#bank-account-holder-id").val();
				        	var tipod=$('#doc-name option:selected').val();
				        	var id_per = tipod+id_per1;
				        	var emailClienteD=$("#card-holder-email").val();
				        	//var bancoD=$("#bank-name").val();
				        	var bancoValor=$("#msg").attr("banco");
				        	var bancoD=$("#bank-name").attr('banco');
				        	$('#selCtaOrigen').attr("style","display:none");

									mascara=$("#donor").find(".product-cardnumber").html();//otra prueba para tomar la mascara de la cuenta origen

				        	$("#content-holder").children().remove();

				        	confirmacion= "<div id='progress'>";
							confirmacion+= "<ul class='steps'>";
							confirmacion+= 	"<li class='step-item completed-step-item'><span aria-hidden='true' class='icon-edit'></span> Modificación de Afiliación</li>";
							confirmacion+= 	"<li class='step-item current-step-item'><span aria-hidden='true' class='icon-view'></span> Confirmación</li>";
							confirmacion+= 	"<li class='step-item'><span aria-hidden='true' class='icon-thumbs-up'></span> Finalización</li>";
							confirmacion+= "</ul>";
							confirmacion+= "</div>";
							confirmacion+= "<div id='content-holder'>";
							confirmacion+= "<h2>Confirmación</h2>";;
							confirmacion+= 	"<table class='receipt' cellpadding='0' cellspacing='0' width='100%'>"
							confirmacion+= 		"<tbody>";
							confirmacion+= 			"<tr>";
							confirmacion+= 				"<td class='data-label'><label>Cuenta de Origen</label></td>";
							confirmacion+= 				"<td class='data-reference'>"+nombreOrigen+"<br /><span class='highlight'>"+mascara+"</span><br /><span class='lighten'>"+producto+"</span></td>";
							confirmacion+= 			"</tr>";
							confirmacion+= 			"<tr>";
							confirmacion+= 				"<td class='data-label'><label>Cuenta Destino a Afiliar</label;></td>";
							confirmacion+= 				"<td class='data-reference'>"+nombreDest+"<span class='lighten'>( "+emailClienteD+" )</span><br /> "+id_per+" <br /><span class='highlight'>"+cDestino+"</span><br /><span class='lighten'>"+bancoD+"</span></td>";
							confirmacion+= 			"</tr>";
							confirmacion+= 		"</tbody>";
							confirmacion+= 	"</table>";
							confirmacion+= 	"<div class='form-actions'>";
							confirmacion+= 		"<button id='cancelar' type='reset'>Cancelar</button>";
							confirmacion+= 		"<button id='continuar'>Continuar</button>";
							confirmacion+= 	"</div>";
							confirmacion+=   "</div>";
							$("#content-holder").append(confirmacion);


							$("#continuar").click(function(){
								$.post(base_url +"/adm/modificar",{"id_afiliacion":id_afiliacion, "nroPlasticoOrigen":ctaOrigen,"nroCuentaDestino":cDestino, "id_ext_per":id_per," beneficiario":nombreDest, "tipoOperacion":"P2T", "email":emailClienteD,"banco":bancoValor},function(data) {
				        			if(data.rc==0){
				        				var exito;
				        				$("#progress").attr('style','display:none');
						        		$("#content-holder").children().remove();
										exito= "<div id='progress'>";
										exito+= "<ul class='steps'>";
										exito+= 	"<li class='step-item completed-step-item'><span aria-hidden='true' class='icon-edit'></span> Modificación de Afiliación</li>";
										exito+= 	"<li class='step-item completed-step-item'><span aria-hidden='true' class='icon-view'></span> Confirmación</li>";
										exito+= 	"<li class='step-item current-step-item'><span aria-hidden='true' class='icon-thumbs-up'></span> Finalización</li>";
										exito+= "</ul>";
										exito+= "</div>";
										exito+= "<div class='alert-success' id='message'>";
										exito+=	"<span aria-hidden='true' class='icon-ok-sign'></span> Afiliación modificada satisfactoriamente";
										exito+= "</div>";
										exito+= 	"<div class='form-actions'>";
										exito+= 		"<button id='exit'>Finalizar</button>";
										exito+= 	"</div>";
										$("#content-holder").append(exito);
				        			}

				        			else{
				        				var exito;
										$("#progress").attr('style','display:none');
						        		$("#content-holder").children().remove();
										exito= "<div class='alert-error' id='message'>";
										exito+=	"<span aria-hidden='true' class='icon-cancel-sign'></span> Afiliación no modificada";
										exito+= "</div>";
										exito+= 	"<div class='form-actions'>";
										exito+= 		"<button id='exit'>Finalizar</button>";
										exito+= 	"</div>";
										$("#content-holder").append(exito);
				        			}
				        			$("#exit").click(function(){

   			 							$(location).attr('href', base_url+'/adm/adm_bank');

   									});
								});
							});
						}
							$("#cancelar").click(function(){

   			 					$(location).attr('href', base_url+'/adm/adm_bank');

   							});

						});


				});


				$('.muestraDestino').on('click',"#eliminar",function(){

					tarjeta =$(this).parents(".dashboard-item").attr('card');
					id_ext_per=$(this).parents(".dashboard-item").attr('id_ext_per');
					nombre=$(this).parents(".dashboard-item").attr('nombre');
					emailCliente=$(this).parents(".dashboard-item").attr('emailCliente')
					banco=$(this).parents(".dashboard-item").attr('banco');
					codBanco=$(this).parents(".dashboard-item").attr('codBanco');

					mascara=$("#donor").find(".product-cardnumber").html();//otra prueba para tomar la mascara de la cuenta origen

					$('#selCtaOrigen').attr("style","display:none");
					var eliminar;
					$("#content-holder").children().remove();

					eliminar= "<div id='progress'>";
					eliminar+=		"<ul class='steps two-steps'>";
					eliminar+=			"<li class='step-item current-step-item'><span aria-hidden='true' class='icon-remove'></span> Eliminación de Afiliación</li>";
					eliminar+=			"<li class='step-item'><span aria-hidden='true' class='icon-thumbs-up'></span> Finalización</li>";
					eliminar+=		"</ul>";
					eliminar+=	"</div>";
					eliminar+=	"<div id='content-holder'>";
					eliminar+=		"<h2>Eliminación de Afiliación</h2>";
					eliminar+=		"<p>Por favor, verifique los datos de la afiliación que Ud. está a punto de remover.</p>";
					eliminar+=			"<table class='receipt' cellpadding='0' cellspacing='0' width='100%'>";
					eliminar+=				"<tbody>";
					eliminar+=					"<tr>";
					eliminar+=						"<td class='data-label'><label>Cuenta de Origen</label></td>"
					eliminar+=						"<td class='data-reference'>"+nombreOrigen+"<br /><span class='highlight'>"+mascara+"</span><br /><span class='lighten'>"+marcaCtaOrigen+"</span></td>";
					eliminar+=					"</tr>";
					eliminar+=					"<tr>";
					eliminar+=						"<td class='data-label'><label>Cuenta Destino Afiliada</label></td>";
					eliminar+=						"<td class='data-reference'>"+nombre+"<span class='lighten'>( "+emailCliente+" )</span><br />"+id_ext_per+"<br /><span class='highlight'>"+tarjeta+"</span><br /><span class='lighten'>"+banco+"</span></td>";
					eliminar+=					"</tr>";
					eliminar+=				"</tbody>";
					eliminar+=			"</table>";
					eliminar+=			"<div class='form-actions'>";
					eliminar+=				"<button id='cancel' type='reset'>Cancelar</button>";
					eliminar+=				"<button id='cont'>Continuar</button>";
					eliminar+=			"</div>";
					eliminar+=	"</div>";
					$("#content-holder").append(eliminar);

					$("#cont").click(function(){
						$.post(base_url +"/adm/eliminar",{"noTarjeta":ctaOrigen, "noCuentaDestino":tarjeta,"tipoOperacion":"P2T"},function(data) {
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
								exito+= 		"<button id='exit'>Finalizar</button>";
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
								exito+= 		"<button id='exit'>Finalizar</button>";
								exito+= 	"</div>";
								$("#content-holder").append(exito);
							}
							$("#exit").click(function(){

   			 					$(location).attr('href', base_url+'/adm/adm_bank');

   							});
						});

					});

					$("#cancel").click(function(){
   						$(location).attr('href', base_url+'/adm/adm_bank');

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

		$("#datos").validate({

			errorElement: "label",
			ignore: "",
			errorContainer: "#msg",
			errorClass: "field-error",
			validClass: "field-success",
			errorLabelContainer: "#msg",
			rules: {
				"card-number": {"required":true,"number": true},
				"card-holder": {"required":true, "pattern":letter},
				"doc-name": {"required":true},
				"bank-account-holder-id": {"number":true, "required":true, "maxlength": 14, "minlength":5, "numOnly":true},
				"card-holder-email": {"required":true, "email": true}
			},

			messages: {
				"card-number": "El n° de cuenta destino no puede estar vacío y debe contener solo números",
				"card-holder": {
					required: "El beneficiario no puede estar vacío",
					pattern: "El beneficiario no debe tener caracteres especiales"
				},
				"doc-name": "El Tipo de Documento no puede estar vacío",
				"bank-account-holder-id": {
					required: "El documento de identidad no puede estar vacío",
					number: "El documento de identidad debe ser numérico y no debe tener caracteres especiales",
					minlength: "El documento de identidad debe tener un mínimo de 5 caracteres",
					numOnly: "El documento de identidad debe ser numérico y no debe tener caracteres especiales"
				},
				"card-holder-email": "El correo electrónico no puede estar vacío y debe contener formato correcto. (xxxxx@ejemplo.com)."
			}
		}); // VALIDATE
	}

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


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
