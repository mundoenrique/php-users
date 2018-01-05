var path, base_cdn, base_url, pais, digVer = '', aplicaPerfil = 0;
var fecha = new Date();
path = window.location.href.split('/');
base_url = path[0] + '//' + path[2];
base_cdn = base_url + '/assets';

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

	$( "#birth-date" ).datepicker({
		onSelect: function(selected){
			$( "#birth-date" ).datepicker('option','maxDate',fecha)
		}

	});

	// MODAL TERMINOS Y CONDICIONES
	$("#condiciones").on("click", "a", function() {

		if ($("#accept-terms").is("disabled") === false) {
			if ($("#iso").val() == "Co") {
				$("#dialog-rg-Co").dialog({
					modal:"true",
					width:"940px",
					open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				});
			} else if ($("#iso").val() == "Pe" || $("#iso").val() == "Usd") {
				$("#dialog-rg-Pe").dialog({
					modal:"true",
					width:"940px",
					open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				});
			} else if ($("#iso").val() == "Ve") {
				$("#dialog-rg-Ve").dialog({
					modal:"true",
					width:"940px",
					open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				});
			}
		}

	});
	getPaises();
	$("button#aceptar").on("click", function(){

		var $pais = $(this).parent().parent().attr("id");
		$("#" + $pais).dialog("close");

	});

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	// FUNCION PARA ACTIVAR CHECKBOX DE CONDICIONES DE ACUERDO A SELECCIÓN DE PAIS

	$('#iso').on('change', function(evt) {
		pais = $('option:selected', this);
		acceptance = $("#accept-terms");
		acceptance.removeAttr('checked');

		if (this.selectedIndex > 0) {
			acceptance.prop('disabled', false);
			$('#condiciones').removeClass('label-disabled');
		} else {
			acceptance.prop('disabled', true);
		}
	});

	$('.iso2').on('change', function(evt) {
		var valor=$('.iso2').val();
		$('.ocultar').hide();
		if (valor=='Co') {
			$('#dialog-rg-Co2').show();
		}else if(valor=='Pe' || valor=='Usd'){
			$('#dialog-rg-Pe2').show();
		}else if(valor=='Ve'){
			$('#dialog-rg-Ve2').show();
		}else if(valor=='Ve'){
			$('.ocultar').hide();
		}

	});
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

// FUNCION PARA VALIDAR LOS DATOS DEL REGISTRO DE USUARIO
	anioMayorEdad	= 0;
	diaActual		= 0;
	mesActual		= 0;
	anioActual		= 0;
	//country			= 0;
	$("#validar").click(function(){
		$("#loading").show();
		$("button").attr("disabled",true);
		validar_campos();

		$("#form-validar").submit();
		setTimeout(function(){$("#msg").fadeOut();},5000);

		var form	= $("#form-validar");

		if(form.valid() == true) {
			var pais, cuenta, cedula, id_ext_per, pin, d, fecha, userName,claveWeb, anio;

			pais		= $('#iso option:selected').val();
			cuenta		= $("#content-holder").find("#card-number").val();
			id_ext_per	= $("#content-holder").find("#card-holder-id").val();
			pin			= $("#content-holder").find("#card-holder-pin").val();
			fecha		= $.datepicker.formatDate('ddmmy', new Date());
			id_ext_per	= $("#content-holder").find("#card-holder-id").val();
			id_ext_per1	= $("#content-holder").find("#card-holder-id").val();
			userName	= id_ext_per + '' + fecha;
			pin 		= pin.toUpperCase();
			claveWeb	= hex_md5(pin);
			if(pais == 'Ve'){
				pin_enc	= hex_md5(pin+cuenta);
			}
			else{
				cuentaP	= cuenta.substring(10,16);
				pin_enc	= hex_md5(pin+cuentaP);
			}

            country			= pais;
            noTarjerta		= cuenta;
			anio			= new Date();
			anioActual		= anio.getFullYear();
			mesActual		= anio.getMonth() + 1;
			diaActual		= anio.getDate();
			anioMayorEdad	= parseInt(anioActual - 18);

			cuenta		= Base64.encode(cuenta);
			id_ext_per	= Base64.encode(id_ext_per);

			$.post(base_url +"/registro/validar",{"userName":userName, "pais":pais ,"cuenta":cuenta,"id_ext_per":id_ext_per,"pin":pin_enc,"claveWeb":claveWeb},function(data){
				$("#loading").hide();
				$("button").attr("disabled",false);
				pais	= data.pais;

				if(data.rc == 0) {
					aplicaPerfil = data.user.aplicaPerfil;
					digVer = data.afiliacion.dig_verificador_aux;
					if(pais == 'Pe') {

						if (data.user.aplicaPerfil == 'N') {
							$('.dig-verificador').remove();
							$('#contract').remove();
							$('.lugar-nacimiento').remove();
							$('.verificacion-one').remove();
							$('.segments-laborales').remove();
							$('.separador-3').remove();
							$('.remove-plata-sueldo').remove();
							$('.area-telefonos').removeClass('four-segments');
							$('.area-telefonos').addClass('two-segments');

							$('.nacimiento-mitad').removeClass('inline-list four-segments field-plata');
							$('.radio-sexo').removeClass('field-group four-segments');

							$('.fecha-nacimiento li').removeClass('field-group-item');
							$('.radio-sexo li').removeClass('select-group-item');

							$('.fecha-nacimiento').addClass('ul-mitad');
							$('.nacimiento-mitad').addClass('ul-mitad');
							$('.radio-sexo').addClass('ul-mitad');

							$('#content-registro').css('display', 'block');

						}
						else if (data.user.aplicaPerfil == 'S') {
							$('.verificacion-one').remove();
							$('#content-registro').css('display', 'block');

							$.post(base_url + "/registro/listadoDepartamento", {"pais": pais, "subRegion": 1}, function (data) {
								$("#departamento").empty().append("<option value=''>Cargando...</option>");
								if(data.rc == 0) {
                                    $("#departamento").empty().append("<option value=''>Seleccione</option>");
									$.each(data.listaSubRegiones, function (pos, item) {
										var lista;
										lista = "<option value="+item.codregion+"> "+item.region+" </option>";
										$("#departamento").append(lista);
									});
								}else{

									$("#dialog-cargar-regiones").show(800);
									$("#invalido3").click(function () {
										$("#dialog-cargar-regiones").hide("slow");
									});
								}
							});
							$("#departamento").change(function () {
								$("#provincia").empty().append("<option value=''>Cargando...</option>");
								$("#distrito").empty().append("<option value=''>-</option>");
								if( this.value != "" )
								{
									getProvincias(this.value, pais);
								} else {
									$("#provincia").empty().append("<option value=''>-</option>");
								}
							});

							getProfesiones();
						}
					}else{
						$('.dig-verificador').remove();
						$('#contract').remove();
						$('.lugar-nacimiento').remove();
						$('.verificacion-one').remove();
						$('.segments-laborales').remove();
						$('.separador-3').remove();
						$('.remove-plata-sueldo').remove();
						$('.area-telefonos').removeClass('four-segments');
						$('.area-telefonos').addClass('two-segments');

						$('.nacimiento-mitad').removeClass('inline-list four-segments field-plata');
						$('.radio-sexo').removeClass('field-group four-segments');

						$('.fecha-nacimiento li').removeClass('field-group-item');
						$('.radio-sexo li').removeClass('select-group-item');

						$('.fecha-nacimiento').addClass('ul-mitad');
						$('.nacimiento-mitad').addClass('ul-mitad');
						$('.radio-sexo').addClass('ul-mitad');

						$('#content-registro').css('display', 'block');
					}
					for(var antiguedad = 0; antiguedad < 51; antiguedad++){
						$('.antiguedad-laboral').append('<option>'+antiguedad+'</option>');
					}

					if((pais == 'Ve')||(pais == 'Co')){
						$("#first-name").attr("disabled",false);
						$("#first-nam").attr("disabled",false);
						$("#first-ext-name").attr("disabled",false);
						$("#last-name").attr("disabled",false);
						$("#last-ext-name").attr("disabled",false);
						$("#telefonoFijo").attr("disabled",false);
						$("#birth-date").attr("disabled",false);
					}

					$("#content").children().remove();
					$("#content").append($("#content-registro").removeAttr('style')).html();
					pais 				= data.pais;
					tipo_doc			= data.user.tipo_id_ext_per;
					nro_doc				= data.user.id_ext_per;
					primer_nombre		= data.user.primerNombre;
					segundo_nombre		= data.user.segundoNombre;
					primer_apellido		= data.user.primerApellido;
					segundo_apellido	= data.user.segundoApellido;
					sexo				= data.afiliacion.sexo;
					fecha_nacimiento	= data.user.fechaNacimiento;
					$('#dia').blur(fechaNacimiento);
					$('#mes').change(fechaNacimiento);
					$('#ano').blur(fechaNacimiento);

					if(data.user.aplicaPerfil == 'S'){
						lugar_nacimiento	= data.afiliacion.lugar_nacimiento;
						estado_civil		= data.afiliacion.edocivil;
						nacionalidad		= data.afiliacion.nacionalidad;
						if(pais == 'Pe'){
							$("#paisResidencia").val("Perú");
						}
						var ruc = data.afiliacion.ruc_cto_laboral;
						$('#ruc').val(ruc);
					}
					$('#paisResidenciaHidden').val(pais);


					$("#listaIdentificadores").val(tipo_doc);
					$("#holder-id").val(nro_doc);
					$("#first-name").val(primer_nombre);
					$("#first-ext-name").val(segundo_nombre);
					$("#last-name").val(primer_apellido);
					$("#last-ext-name").val(segundo_apellido);

					if(sexo == 'M'){
						$("#gender-male").prop("checked", true);
					}else if(sexo == 'F'){
						$("#gender-female").prop("checked", true);
					}

					var dia		= fecha_nacimiento.substring(0,2);
					var mes		= fecha_nacimiento.substring(3,5);
					var ano		= fecha_nacimiento.substring(6,10);
					$("#dia").val(dia);
					$("#mes").val(mes);
					$("#ano").val(ano);
					if(dia!='' && mes!='' && ano!=''){
						$('#fecha-de-nacimiento').val(dia+'/'+mes+'/'+ano);
					}

				} else if(data.rc == -183) {
					$("#dialogo-documento").dialog({
						title	: "Error",
						modal	: "true",
						width	: "440px",
						open	: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#ok2").click(function(){
						$("#dialogo-documento").dialog("close");
					});

				} else if(data.rc == -184) {
					$("#dialogo-pin").dialog({
						title	: "Validar cuenta",
						modal	: "true",
						width	: "440px",
						open	: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#inva3").click(function(){
						$("#dialogo-pin").dialog("close");
					});

				} else {

					$("#dialogo_error").dialog({
						title	:"Error",
						modal	:"true",
						width	:"440px",
						open	: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#ok").click(function(){
						$("#dialogo_error").dialog("close");
					});

				} // ELSE

			});	// POST VALIDAR

		}else {
			$("#loading").hide();
			$("button").attr("disabled",false);
		} // IF FORM VALID

	});	// FUNCION VALIDAR

// ---------------------------------------------------------------------------------------------------------------------
	//Funcion que valida si el usuario es mayor de edad.

	function fechaNacimiento() {
		var dia		= $('#dia').val();
		var mes		= $('#mes option:selected').val();
		var anio	= $('#ano').val();

		if(dia != '' && mes != '' && anio != '') {
			if (anio < anioMayorEdad) {
				$('#fecha-de-nacimiento').val(dia + '/' + mes + '/' + anio);
				$('#dia').removeClass('field-error').addClass('field-success');
				$('#mes').removeClass('field-error').addClass('field-success');
				$('#ano').removeClass('field-error').addClass('field-success');
				return true;

			} else {
				if (anio == anioMayorEdad) {
					if (mes < mesActual) {
						$('#fecha-de-nacimiento').val(dia + '/' + mes + '/' + anio);
						$('#dia').removeClass('field-error').addClass('field-success');
						$('#mes').removeClass('field-error').addClass('field-success');
						$('#ano').removeClass('field-error').addClass('field-success');
						return true;

					} else {
						if (mes == mesActual) {
							if (dia <= diaActual) {
								$('#fecha-de-nacimiento').val(dia + '/' + mes + '/' + anio);
								$('#dia').removeClass('field-error').addClass('field-success');
								$('#mes').removeClass('field-error').addClass('field-success');
								$('#ano').removeClass('field-error').addClass('field-success');
								return true;

							} else {
								return false;
							}
							$('#dia').removeClass('field-error').addClass('field-success');
							$('#mes').removeClass('field-error').addClass('field-success');
							$('#ano').removeClass('field-error').addClass('field-success');
							return true;
						}
						else {
							return false;
						}
						$('#dia').removeClass('field-error').addClass('field-success');
						$('#mes').removeClass('field-error').addClass('field-success');
						$('#ano').removeClass('field-error').addClass('field-success');
						return true;
					}
				} else {
					return false;
				}
				$('#dia').removeClass('field-error').addClass('field-success');
				$('#mes').removeClass('field-error').addClass('field-success');
				$('#ano').removeClass('field-error').addClass('field-success');
				return true;
			}
			return true;
		}else if(dia != '' || mes != '' || anio != '') {
			$('#dia').removeClass('field-error').addClass('field-success');
			$('#mes').removeClass('field-error').addClass('field-success');
			$('#ano').removeClass('field-error').addClass('field-success');
			return true;
		}
		//
	}



// ----------------------------------------------------------------------------------------------------------------------------------------------------------------//
	// Funcion que obtiene las Provincias

	function getProvincias(subRegion, pais) {
		$.post(base_url + "/registro/listadoDepartamento", {"pais": pais, "subRegion": subRegion}, function (data) {
			if(data.rc == 0) {
				$("#provincia").empty().append("<option value=''>Seleccione</option>");
				$.each(data.listaSubRegiones, function (pos, item) {
					var lista;
					lista = "<option value="+item.codregion+"> "+item.region+" </option>";
					$("#provincia").append(lista);
				});
			}
		});
		$("#provincia").change(function () {
			$("#distrito").empty().append("<option value=''>Cargando...</option>");
			if( this.value != "" )
			{
				getDistritos(this.value, pais);
			} else {
				$("#distrito").empty().append("<option value=''>-</option>");
			}
		});
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------//
	// Funcion que obtiene los Distristos

	function getDistritos(subRegion, pais) {
		$.post(base_url + "/registro/listadoDepartamento", {"pais": pais, "subRegion": subRegion}, function (data) {
			if(data.rc == 0) {
				$("#distrito").empty().append("<option value=''>Seleccione</option>");
				$.each(data.listaSubRegiones, function (pos, item) {
					var lista;
					lista = "<option value="+item.codregion+"> "+item.region+" </option>";
					$("#distrito").append(lista);
				});
			}
		});
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------//
// FUNCION PARA MOSTRAR EL WIDGET DEL CALENDARIO

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

	$("#birth-date").datepicker();

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	$('#userpwd').keyup(function() {

		// set password variable
		var pswd = $(this).val();
		//validate the length
		if ( pswd.length < 8 || pswd.length > 15 ) {
			$('#length').removeClass('rule-valid').addClass('rule-invalid');
			longitud=false;
		} else {
			$('#length').removeClass('rule-invalid').addClass('rule-valid');
			longitud=true;
		}

		//validate letter
		if ( pswd.match(/[A-z]/) ) {
			$('#letter').removeClass('rule-invalid').addClass('rule-valid');
			mt=true;
		} else {
			$('#letter').removeClass('rule-valid').addClass('rule-invalid');
			mt=false;
		}

		//validate capital letter
		if ( pswd.match(/[A-Z]/) ) {
			$('#capital').removeClass('rule-invalid').addClass('rule-valid');
			cap=true;
		} else {
			$('#capital').removeClass('rule-valid').addClass('rule-invalid');
			cap=false;
		}

		//validate number

		if (!pswd.match(/((\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#\$%])*\d(\w|[!@#$%])*(\d)*)/) && pswd.match(/\d{1}/) ) {
			$('#number').removeClass('rule-invalid').addClass('rule-valid');
			car=true;
		} else {
			$('#number').removeClass('rule-valid').addClass('rule-invalid');
			car=false;
		}

		if (! pswd.match(/(.)\1{2,}/) ) {
			$('#consecutivo').removeClass('rule-invalid').addClass('rule-valid');
			cons=true;
		} else {
			$('#consecutivo').removeClass('rule-valid').addClass('rule-invalid');
			cons=false;
		}

		if ( pswd.match(/([!@\*\-\?¡¿+\/.,_#])/ )) {
			$('#especial').removeClass('rule-invalid').addClass('rule-valid');
			esp=true;
		} else {
			$('#especial').removeClass('rule-valid').addClass('rule-invalid');
			esp=false;
		}
		if((longitud==true)&& (mt==true) && (cap==true) && (car==true) &&  (cons==true) && (esp==true)){
			$('#registrar').removeAttr("disabled");
		}else{
			$('#registrar').attr("disabled", true);
		}

	}).focus(function() {

		$("#new").showBalloon({position: "right", contents: $('#psw_info')});
		$('#psw_info').show();

	}).blur(function() {

		$("#new").hideBalloon({position: "right", contents: $('#psw_info')});
		$('#psw_info').hide();
	});

//	--------------------------------------------------------------------------------------------------------------------
	// Funcion que obtiene lista de profesiones

	function getProfesiones(){
		$("#ocupacion-laboral").empty().append("<option value=''>Cargando...</option>");
		$.post(base_url +"/registro/ListadoProfesiones",{"pais" : country}, function(data){
			if(data.rc == 0) {
				$("#ocupacion-laboral").empty().append("<option value=''>Seleccione</option>");
				$.each(data.listaProfesiones, function (pos, item) {
					var lista;
					lista = "<option value="+item.idProfesion+"> "+item.tipoProfesion+" </option>";
					$("#ocupacion-laboral").append(lista);
				});
			}
		});
	}

// ---------------------------------------------------------------------------------------------------------------------
	//Funcion que valida si existe el usuario en DB

    $("#username").blur(function(){
        usuario     = $("#username").val();								//38 N
        username    = usuario.toUpperCase();							//	 N
		if(usuario.match(/[\s]/gi)){
			$("#loading").hide();
		}else{
			$("#loading").show();
			$.post(base_url + "/registro/verificar",{"usuario":username},function(data){

				if(data.rc == 0) {
					$("#loading").hide();
					$("#registrar").removeAttr('disabled');
					$("#username").removeClass('field-error').addClass('field-success');
				} else {

					$("#loading").hide();
					$("#username").removeClass('field-success').addClass('field-error');
					$("#registrar").attr('disabled', true);

					$("#dialogo_disponible").dialog({
						title	:"Usuario no disponible",
						modal	:"true",
						width	:"440px",
						open	: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});
					$("#disp").click(function(){
						$("#dialogo_disponible").dialog("close");
					});
				}	//ELSE
			});
		}
    });

	//Modal protección de datos personales
	$('#proteccion').on('click', function(){
		$(this).off('click');
		$('#datos_personales').dialog({
			title: 'PROTECCIÓN DE DATOS PERSONALES',
			modal: true,
			width:'940px',
			draggable: false,
			rezise: false,
			open: function(event, ui) {
				$(".ui-dialog-titlebar-close", ui.dialog).hide();
			}
		});
		$("#close-datos").click(function(){
			$("#datos_personales").dialog("close");
		});
	});

	//Modal protección de datos personales
	$('#contrato').on('click', function(){
		$(this).off('click');
		$('#contrato_cuenta').dialog({
			title: 'CONTRATO DE CUENTA DINERO ELECTRÓNICO PLATA BENEFICIOS',
			dialogClass: "contratos",
			modal: true,
			width:'940px',
			draggable: false,
			rezise: false,
			open: function(event, ui) {
				$(".ui-dialog-titlebar-close", ui.dialog).hide();
			}
		});
		$(".contratos").css("top","50px");
		$("#close-contrato").click(function(){
			$("#contrato_cuenta").dialog("close");
		});
		$('html, body').animate({
			scrollTop: $('body').offset().top
		}, 0);
	});
 //----------------------------------------------------------------------------------------------------------------------
	// Funcion que Registra el usuario

	$("#registrar").click(function(){

		$("#registrar").css("display","none");

		validar_campos();

		$("#form-usuario").submit();

		setTimeout(function(){$("#msg").fadeOut();},5000);

		var form, notSms, notEmail, typeIdentifier, nroDocument, verifyDigit, firstName, firstExtName, lastName, lastExtName, placeBirth, birthDate, sexo, civilStatus, nationality,
            typeAddress, postalCode, countryResidence, departament, province, district, address, email, confirmEmail, phone, movilPhone, anotherPhone, anotherPhoneNum,
            ruc, centroLaboral, situacionLaboral, antiguedadLaboral, ocupacionLaboral, cargoLaboral, ingreso, desemPublico, cargoPublico, institucion, uif, usuario,
            username, password, confirmPassword, tipoId, proteccion, contrato;

		form=$("#form-usuario");

		if(form.valid() == true) {
			$("#load_reg").show();

			typeIdentifier		= $('#listaIdentificadores').val();					//1 N
			nroDocument			= $('#holder-id').val();							//2 N
			verifyDigit			= $('#dig-ver').val();
			firstName			= $('#first-name').val();							//3 N
			firstExtName		= $('#first-ext-name').val();						//4 N
			lastName			= $('#last-name').val();							//5 N
			lastExtName			= $('#last-ext-name').val();						//6 N
			placeBirth			= $('#lugar-nacimiento').val();						//7 N
			//day				= $('#dia').val();									//8
			//month				= $('#mes').val();									//9
			//year				= $('#ano').val();									//10
			birthDate			= $("#fecha-de-nacimiento").val();					//Campo fecha de nacimiento tipo Hidden - N
			sexo				= $("input[name='genero']:checked").val();			//11 N
			civilStatus			= $('#edocivil').val();								//12
			nationality			= $('#nacionalidad').val();							//13
			typeAddress			= $('#tipoDireccion').val();						//14
			postalCode			= $('#codigoPostal').val();							//15
			countryResidence	= country //$('#paisResidenciaHidden').val();		//16
			departament			= $('#departamento').val();							//17
			province			= $('#provincia').val();							//18
			district			= $('#distrito').val();								//19
			address				= $('#text-address').val();							//20
			email				= $('#email').val();								//21 N
			confirmEmail		= $('#confirm-email').val();						//22 N
			phone				= $('#telefonoFijo').val();							//23 N
			movilPhone			= $('#telefonoMovil').val();						//24 N
            anotherPhone        = $('#otroTelefonoSelect option:selected').val();   //25 N
			anotherPhoneNum 	= $('#otroTelefonoNum').val();						//26 N
            ruc					= $('#ruc').val();									//27
			centroLaboral		= $('#centro-laboral').val();						//28
			situacionLaboral	= $('#text-situacion').val();						//29
			antiguedadLaboral	= $('#antiguedadLaboral').val();					//30
			ocupacionLaboral	= $('#ocupacion-laboral option:selected').val();	//31
			cargoLaboral		= $('#cargo-laboral').val();						//32
			ingreso				= $('#ingreso').val();								//33
			desemPublico		= $("input[name='desem_publico']:checked").val();	//34
			cargoPublico		= $('#cargo-publico').val();						//35
			institucion			= $('#institucion').val();							//36
			uif					= $("input[name='uif']:checked").val();				//37
			usuario				= $("#username").val();								//38 N
			username			= usuario.toUpperCase();							//	 N
			password			= $("#userpwd").val();								//39 N
			confirmPassword		= $("#confirm-userpwd").val();						//40 N
			proteccion			= ($("#proteccion").is(':checked')) ? 1 : 0;
			contrato			= ($("#contrato").is(':checked')) ? 1 : 0;


            if(countryResidence == 'Ve'){
                tipoId = 3;
            }
            if(countryResidence == 'Co'){
                tipoId = 4;
            }
            if((countryResidence == 'Pe')||(countryResidence == 'Usd')){
                tipoId = 1;
            }

			empresa		= "tebca";
			empresaU	= "TEBCA";
			empresa2	= "servitebca";
			empresa2U	= "SERVITEBCA";

			//validate letter, capital letter, caracteres especiales
			if (password.match(/[A-z]/) && password.match(/[A-Z]/) && password.match(/([!@\*\-\?¡¿+\/.,_#])/) && !password.match(/(.)\1{2,}/) && !password.match(empresa) && !password.match(empresaU) && !password.match(empresa2) && !password.match(empresa2U)) {
				if(anotherPhone==null || anotherPhone==false){
					anotherPhone = "";
				}
				if (anotherPhone==null || anotherPhone==false){
					anotherPhone= "";
				}

				if(aplicaPerfil == 'S'){

					$.post(base_url + "/registro/registrar",
						{"aplicaPerfil":aplicaPerfil, "primerNombre":firstName, "segundoNombre":firstExtName, "primerApellido":lastName, "segundoApellido":lastExtName, "telefono":phone, "id_ext_per":nroDocument, "fechaNacimiento":birthDate, "tipo_id_ext_per":tipoId, "lugar_nacimiento":placeBirth, "sexo":sexo, "edocivil":civilStatus, "nacionalidad":nationality, "tipo_direccion":typeAddress, "cod_postal":postalCode, "pais":countryResidence, "departamento":departament, "provincia":province, "distrito":district, "direccion":address, "correo":email, "telefono2":movilPhone, "otro_telefono":anotherPhone, "telefono3":anotherPhoneNum, "ruc_cto_laboral":ruc, "centrolab":centroLaboral, "situacionLaboral":situacionLaboral, "antiguedad_laboral":antiguedadLaboral, "profesion":ocupacionLaboral, "cargo":cargoLaboral, "ingreso_promedio_mensual":ingreso, "cargo_publico_last2":desemPublico, "cargo_publico":cargoPublico, "institucion_publica":institucion, "uif":uif, "userName":username, "password":password, "notarjeta":noTarjerta, "verifyDigit": verifyDigit, "proteccion": proteccion, "contrato": contrato},
						function(data) {
							$("#load_reg").hide();
							if(data.rc == 0) {
								var cadena=	'<span aria-hidden="true" class="icon-ok-sign"></span> Usuario registrado exitosamente';
								cadena+=	'<p>El usuario "'+username+'" se ha registrado de forma correcta en el <strong>Sistema Conexión Personas Online.</strong></p>';

								$("#content").children().remove();
								$("#content").append($("#exito").removeAttr('style')).html();
								$("#message").append(cadena);
							}
							if((data.rc == -61)||(data.rc == -5)||(data.rc == -3)){
								$(location).attr('href', base_url+'/users/error_gral');
							}
							if(data.rc == -181){

								$("#registrar").fadeIn();

								$("#dialogo_correo").dialog({
									title	:"Correo Registrado",
									modal	:"true",
									width	:"440px",
									open	: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }

								});
								$("#inva").click(function(){
									$("#dialogo_correo").dialog("close");
								});
							}
							if(data.rc == -206){

								$("#registrar").fadeIn();

								$("#dialogo_correo_2").dialog({
									title	:"Correo Registrado",
									modal	:"true",
									width	:"440px",
									open	: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }

								});
								$("#inva2").click(function(){
									$(location).attr('href', base_url);
								});
							}
							if(data.rc == -230){

								$("#registrar").fadeIn();

								$("#dialogo-fallo").dialog({
									title	:"Fallo en Registro",
									modal	:"true",
									width	:"440px",
									open	: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }

								});
								$("#inva4").click(function(){
									$(location).attr('href', base_url);
								});
							}
							if(data.rc == -271 || data.rc == -335){
								var cadena=	'<span aria-hidden="true" class="icon-ok-sign"></span>Usuario registrado';
								cadena+=	'<p>El usuario "'+username+'" se ha registrado, pero algunos datos no fueron cargados en su totalidad.</br> Por favor completarlos en la sección de <strong>Perfíl.</strong></p>';

								$("#content").children().remove();
								$("#content").append($("#exito2").removeAttr('style')).html();
								$("#message2").append(cadena);
							}

							//RC ERRORES ACTIVACION TARJETA PLATA SUELDO
							if(data.rc == -317 || data.rc == -314 || data.rc == -313 || data.rc == -311 || data.rc == -21){
								var cadena=	'<span aria-hidden="true" class="icon-ok-sign"></span>Usuario registrado';
								cadena+=	'<p>El usuario "'+username+'" se ha registrado satisfactoriamente, pero su tarjeta esta bloqueada comuníquese con el <strong>Centro de Contacto</strong></p>';

								$("#content").children().remove();
								$("#content").append($("#exito2").removeAttr('style')).html();
								$("#message2").append(cadena);
							}
							//RC FIN ERRORES ACTIVACION TARJETA PLATA SUELDO


							if(data.rc == -284) {
							 msgService('Teléfono móvil existente', 'El teléfono móvil ya se encuentra registrado.');
							}

						});	//POST

				}else if(aplicaPerfil == 'N') {
					$.post(base_url + "/registro/registrar",
						{"aplicaPerfil":aplicaPerfil, "primerNombre":firstName, "segundoNombre":firstExtName, "primerApellido":lastName, "segundoApellido":lastExtName, "telefono":phone, "id_ext_per":nroDocument, "fechaNacimiento":birthDate, "tipo_id_ext_per":tipoId, "lugar_nacimiento":placeBirth, "sexo":sexo, "correo":email, "telefono2":movilPhone, "otro_telefono":anotherPhone, "telefono3":anotherPhoneNum, "userName":username, "password":password, "pais":countryResidence},
						function(data) {
							$("#load_reg").hide();
							if(data.rc == 0) {

								var cadena=		'<span aria-hidden="true" class="icon-ok-sign"></span> Usuario registrado exitosamente';
								cadena+=	'<p>El usuario "'+username+'" se ha registrado de forma correcta en el <strong>Sistema Conexión Personas Online.</strong></p>';

								$("#content").children().remove();
								$("#content").append($("#exito").removeAttr('style')).html();
								$("#message").append(cadena);

							}
							if((data.rc == -61)||(data.rc == -5)||(data.rc == -3)) {
								$(location).attr('href', base_url+'/users/error_gral');
							}
							if(data.rc == -181){

								$("#registrar").fadeIn();

								$("#dialogo_correo").dialog({
									title	:"Correo Registrado",
									modal	:"true",
									width	:"440px",
									open	: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }

								});
								$("#inva").click(function(){
									$("#dialogo_correo").dialog("close");
								});
							}
							if(data.rc == -206){

								$("#registrar").fadeIn();

								$("#dialogo_correo_2").dialog({
									title	:"Correo Registrado",
									modal	:"true",
									width	:"440px",
									open	: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }

								});
								$("#inva2").click(function(){
									$(location).attr('href', base_url);
								});
							}
							if(data.rc == -230){

								$("#registrar").fadeIn();

								$("#dialogo-fallo").dialog({
									title	:"Fallo en Registro",
									modal	:"true",
									width	:"440px",
									open	: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }

								});
								$("#inva4").click(function(){
									$(location).attr('href', base_url);
								});
							}
							if(data.rc == -271){
								var cadena=	'<span aria-hidden="true" class="icon-ok-sign"></span>Usuario registrado';
								cadena+=	'<p>El usuario "'+username+'" se ha registrado, pero algunos datos no fueron cargados en su totalidad.</br> Por favor completarlos en la sección de <strong>Perfíl.</strong></p>';

								$("#content").children().remove();
								$("#content").append($("#exito2").removeAttr('style')).html();
								$("#message2").append(cadena);
							}
							//RC ERRORES ACTIVACION TARJETA PLATA SUELDO
							if(data.rc == -317 || data.rc == -314 || data.rc == -313 || data.rc == -311 || data.rc == -21){
								console.log('cualquier locura');
								console.log(data.rc);
								var cadena=	'<span aria-hidden="true" class="icon-ok-sign"></span>Usuario registrado';
								cadena+=	'<p>El usuario "'+username+'" se ha registrado satisfactoriamente, pero su tarjeta esta bloqueada comuníquese con el <strong>Centro de Contacto</strong></p>';

								$("#content").children().remove();
								$("#content").append($("#exito2").removeAttr('style')).html();
								$("#message2").append(cadena);
							}
							//RC FIN ERRORES ACTIVACION TARJETA PLATA SUELDO
							if(data.rc == -284) {

								msgService('Teléfono móvil existente', 'El teléfono móvil ya se encuentra registrado.');

							}
						});	//POST
				}

			} else { ///////////////////////////////////

				$("#registrar").fadeIn();

				$("#dialogo_oculto").dialog({
					title	:"Contraseña Errónea",
					modal	:"true",
					width	:"440px",
					open	: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				});

			}	//ELSE
		}//FORM VALID
		else{
			$("#registrar").fadeIn();
		} //FORM INVALID
	});

//ESPACIO DE FUNCIONES

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
	// Funcion para obtener lista de paises

	function getPaises() {
		$.post(base_url +"/registro/listado",function(data){
			$.each(data.listaPaises,function(pos,item){
				var lista;
				lista	= "<option value="+item.cod_pais+"> "+item.nombre_pais+" </option>";
				$("#iso").append(lista);
			});
		});
	} //GET PAISES

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Funcion para validar el campo otro telefono
    $("#otroTelefonoNum").attr('disabled','disabled');
    $("#otroTelefonoSelect").on("change", function() {

        if($('#otroTelefonoSelect option:selected').val() != "") {
            $("#otroTelefonoNum").removeAttr("disabled");
        }else {
            $("#otroTelefonoNum").attr('disabled','disabled');
            $("#otroTelefonoNum").val("");
        }
    });

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Funcion para validar el campo cargo publico e institucion
    $("#cargo-publico").attr('disabled','disabled');
    $("#institucion").attr('disabled','disabled');
    $("input[name=desem_publico]").on("click", function() {

        if($("#cargo-publico-si").is(':checked')){
            $("#cargo-publico").removeAttr("disabled");
            $("#institucion").removeAttr("disabled");
        }else if($("#cargo-publico-no").is(':checked')){
            $("#cargo-publico").attr('disabled','disabled');
            $("#institucion").attr('disabled','disabled');
            $("#cargo-publico").val("");
            $("#institucion").val("");
        }
    });

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

//****************Funcion para validar fecha***************

	function fecha_Invalida() {
		var dia		= $('#dia').val();
		var mes		= $('#mes option:selected').val();

		if((dia==31 && mes==02) || (dia==30 && mes==02) || (dia==29 && mes==02) || (dia==31 && mes==04) || (dia==31 && mes==06) || (dia==31 && mes==09) || (dia==31 && mes==11)){
			$('#dia').removeClass('field-success').addClass('field-error');
			$('#mes').removeClass('field-success').addClass('field-error');
			return false;
		}
		else{
			$('#dia').removeClass('field-error').addClass('field-success');
			$('#mes').removeClass('field-error').addClass('field-success');
			return true;
		}
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
	// Funcion que valida los campos para que solo obtengan letras

	function expresionRegular(value,element){
		//var id =  element.id;
		if(value.match(/[^a-z ñáéíóú \s]/gi)){
			return false;
		}else{
			return true;
		}
	}

	function expresionRegular2(value,element){
		//var id =  element.id;
		if(value.match(/[^a-z ñáéíóú 0-9 \s]/gi)){
			return false;
		}else{
			return true;
		}
	}

// ---------------------------------------------------------------------------------------------------------------------
	function validar_campos(){

		jQuery.validator.setDefaults({
			debug	: true,
			success	: "valid"
		});

		jQuery.validator.addMethod("numberEqual1", function(value,element){
			if(element.value.length>0 && (element.value == $("#telefonoFijo").val() || element.value == $("#telefonoMovil").val()))
				return false;
			else return true;

		}, "Teléfono Otro está repetido");

		jQuery.validator.addMethod("numberEqual2", function(value, element) {
			if(element.value.length>0 && (element.value == $("#telefonoMovil").val() || element.value == $("#otroTelefonoNum").val()))
				return false;
			else return true;

		}, "Teléfono Fijo está repetido");

        jQuery.validator.addMethod("numberEqual3", function(value, element) {
            if(element.value.length>0 && (element.value == $("#telefonoFijo").val() || element.value == $("#otroTelefonoNum").val()))
                return false;
            else return true;

        }, "Teléfono Movil está repetido");

		jQuery.validator.addMethod("username", function(value,element,regex){
			return regex.test(value);
		}, "Usuario invalido. ");

		// Metodo que valida si el usuario es mayor de edad
		jQuery.validator.addMethod("mayorEdadAnio", function(value,element){
			var fecha_nacimiento = fechaNacimiento();
			if(fecha_nacimiento == true){
				return true;
			}else if(fecha_nacimiento == false) {
				return false;
			}
		}, "Usted no es mayor de edad ");

		// Metodo que valida si la fecha es invalida
		jQuery.validator.addMethod("fecha_invalida", function(value,element){
			var fechaInvalida = fecha_Invalida();
			if(fechaInvalida == true){
				return true;
			}else if(fechaInvalida == false) {
				return false;
			}
		}, "Fecha invalida. ");

		//Expresion regular para permitir solo letras y espacio expresionRegular2
		jQuery.validator.addMethod("expresionRegular", function(value,element){
			var valida_expresion = expresionRegular(value,element);
			if(valida_expresion == true){
				return true;
			}else if(valida_expresion == false) {
				return false;
			}
		}, "Usted. ");

		jQuery.validator.addMethod("expresionRegular2", function(value,element){
			var valida_expresion2 = expresionRegular2(value,element);
			if(valida_expresion2 == true){
				return true;
			}else if(valida_expresion2 == false) {
				return false;
			}
		}, "Usted. ");

		jQuery.validator.addMethod("mail",function(value,element,regex){
				return regex.test(value);
			},
			"Correo invalido. "
		);

		jQuery.validator.addMethod("digValido",function(value, element, regex){
				return value == digVer ? true : false;
			}
		);

		$("#form-validar").validate({

			errorElement		: "label",
			ignore				: "",
			errorContainer		: "#msg",
			errorClass			: "field-error",
			validClass			: "field-success",
			errorLabelContainer	: "#msg",
			rules				: {

				"card-holder-pin": {"required":true},
				"card-number": {"required":true,"number":true, "minlength":16, "maxlength": 16},
				"card-holder-id": {"required":true,"number":true},
				"iso": {"required":true},
				"accept-terms": {"required":true}
			},

			messages: {

				"card-holder-pin": "Debe introducir la clave secreta o clave web de su tarjeta",
				"card-number": "Debe introducir un número de tarjeta",
				"card-holder-id": "Debe introducir el número de su documento de identidad",
				"iso": "Debe seleccionar su país",
				"accept-terms": "Debe aceptar las Condiciones de Uso"
			}
		}); // VALIDATE

		$("#form-usuario").validate({

			errorElement		: "label",
			ignore				: "",
			errorContainer		: "#msg",
			errorClass			: "field-error",
			validClass			: "field-success",
			errorLabelContainer	: "#msg2",
			rules				: {

				"tipo_identificacion" : {"required":true},																	//1
				"numero_identificacion" : {"required":true, "number":true},													//2
				"dig-ver" : {"required":true, "digits":true, "maxlength":1, "digValido": true},
				"primer_nombre" : {"required":true, "expresionRegular":true},												//3
				"segundo_nombre" : {"required":false, "expresionRegular":true},												//4
				"primer_apellido" : {"required":true, "expresionRegular":true},												//5
				"segundo_apellido": {"required":false, "expresionRegular":true},											//6
				"lugar_nacimiento" : {"required":false, "expresionRegular":true},											//7
				"dia" : {"required" : true, "number":true, range : [1,31]},													//8
				"mes" : {"required" : true, "number":true, range : [1,12], "fecha_invalida": true},							//9
				"ano" : {"required" : true, "number":true, min: 1900, "mayorEdadAnio" : true/*range : [1920,mesActual-18]*/},//10
				"genero" : {"required" : false},																			//11
				"edo_civil" : {"required" : false},																			//12
				"nacionalidad" : {"required" : true, "expresionRegular":true},												//13
				"tipo_direccion" : {"required" : true},																	//14
				"codigo_postal" : {"required" : false, digits: true},														//15
				"pais_Residencia" : {"required" : true},																	//16
				"departamento" : {"required" : true},																		//17
				"provincia" : {"required" : true},																			//18
				"distrito" : {"required" : true},																			//19
				"direccion" : {"required" : true},																			//20
				"correo" : {"required":true, "mail": /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/},																	//21
				"confirm-correo": {"required":true, "mail": /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/, "equalTo":"#email"},//22
				"telefono_fijo": {"number":true, "numberEqual2": true, "minlength": 7, "maxlength": 11},					//23
				"telefono_movil": {"required":true, "number":true, "numberEqual3": true, "minlength": 7, "maxlength": 11},	//24
				"otro_tipo_telefono" : {"required":false},																	//25
				"otro_telefono_num" : {"number":true, "numberEqual1": true, "minlength": 7, "maxlength": 11},				//26
				"ruc_laboral" : {"required":true},																			//27
				"centro_laboral" : {"required":true},																		//28
				"situacion_laboral" : {"required":false},																	//30
				"ocupacion_laboral" : {"required":true},																	//31
				"cargo_laboral" : {"expresionRegular":true},																//32
				"ingreso" : {"required":false, "number":true},							    								//33
				"desem_publico" : {"required":true},																		//34
				"cargo_publico" : {"required":true, "expresionRegular":true},												//35
				"institucion" : {"required":true, "expresionRegular2":true},												//36
				"uif" : {"required":true},																					//37
				"username":{"required":true, "nowhitespace":true, "username": /^[a-z0-9_-]{6,16}$/i},						//38
				"userpwd": {"required":true, "minlength":8, "maxlength": 15},												//39
				"confirm_userpwd": {"required":true, "minlength":8, "maxlength": 15, "equalTo":"#userpwd"},					//40
				"contrato": {"required": true}
			},

			messages: {

				"tipo_identificacion" : "Debe Seleccionar su Tipo de Identificación.",															//1
				"numero_identificacion" : "El campo Número de identificación NO puede estar vacío y debe contener solo números.",				//2
				"dig-ver": "Dígito verificador inválido.",
				"primer_nombre" : "El campo Primer Nombre NO puede estar vacío y debe contener solo letras.",									//3
				"segundo_nombre" : "El campo Segundo Nombre debe contener solo letras.",														//4
				"primer_apellido" : "El campo Apellido Paterno NO puede estar vacío y debe contener solo letras.",								//5
				"segundo_apellido" : "El campo Apellido Materno debe contener solo letras.",													//6
				"lugar_nacimiento" : "El campo Lugar de Nacimiento debe contener solo letras.",													//7
				"dia" : {																														//8
					"required"	: "El campo Día NO puede estar vacío y debe contener solo números.",
					"number"	: "El campo Día NO puede estar vacío y debe contener solo números.",
					"range":"El Día debe estar comprendido entre 1 y 31."
				},
				"mes" : {																														//9
					"required"	: "El campo Mes NO puede estar vacío y debe contener solo números.",
					"number"	: "El campo Mes NO puede estar vacío y debe contener solo números.",
					"fecha_invalida" : "Usted introdujo una fecha inválida.",
				},
				"ano" : {																														//10
					"required"	: "El campo Año NO puede estar vacío y debe contener solo números.",
					"number"	: "El campo Año NO puede estar vacío y debe contener solo números.",
					"min" : "Por favor ingrese un Año de nacimiento válido."
				},
				"nacionalidad" : "El campo Nacionalidad NO puede estar vacío.",
				"tipo_direccion" : "El campo Tipo Dirección NO puede estar vacío",																//14																									//14
				"codigo_postal" : "El campo Código Postal debe contener solo números.",															//15
				"pais_Residencia" : "El campo País de Residencia NO puede estar vacío y debe contener solo letras.",							//16
				"departamento" : "El campo Departamento NO puede estar vacío.",																	//17
				"provincia" : "El campo Provincia NO puede estar vacío.",																		//18
				"distrito" : "El campo Distrito NO puede estar vacío.",																			//19
				"direccion" : "El campo Dirección NO puede estar vacío.",																		//20
				"correo" : "El correo electrónico NO puede estar vacío y debe contener formato correcto. (usuario@ejemplo.com).",				//21
				"confirm-correo" : "El campo confirmar correo electrónico debe coincidir con su correo electrónico.",							//22
				"telefono_fijo" : {																												//23
					"number"		: "El campo Teléfono Fijo debe contener solo números.",
					"numberEqual2"	: "Teléfono Fijo está repetido.",
					"minlength"		: "El campo Teléfono Fijo debe contener como mínimo 7 caracteres numéricos.",
					"maxlength" 	: "El campo Teléfono Fijo debe contener máximo 11 caracteres numéricos."
				},
				"telefono_movil" : {																											//24
					"required"		: "El campo Teléfono Móvil NO puede estar vacío y debe contener solo números.",
                    "number"		: "El campo Teléfono Móvil NO puede estar vacío y debe contener solo números.",
                    "numberEqual3"	: "Teléfono Móvil está repetido.",
					"minlength"		: "El campo Teléfono Móvil debe contener como mínimo 7 caracteres numéricos.",
					"maxlength"		: "El campo Teléfono Móvil debe contener máximo 11 caracteres numéricos."
                },																//25
				"otro_telefono_num"	: {                                                                                                         //26
                    "number"		: "El campo Otro Teléfono debe contener solo números.",
                    "numberEqual1"	: "El campo Otro Teléfono está repetido.",
					"minlength"		: "El campo Otro Teléfono debe contener como minímo 7 caracteres númericos.",
					"maxlength"		: "El campo Otro Teléfono  debe contener máximo 11 caracteres númericos."
                },
				"ruc_laboral" : "El campo Teléfono Móvil NO puede estar vacío.",																//27
				"centro_laboral" : "El campo Centro Laboral NO puede estar vacío.",
				"ocupacion_laboral" : "El campo Ocupación Laboral NO puede estar vacío y debe contener solo letras.",							//31
				"cargo_laboral" : "El campo Cargo Laboral debe contener solo letras.",															//32
				"ingreso" : "El campo Ingreso promedio mensual debe contener solo números.",																												//33
				"desem_publico" : "El campo ¿Desempeñó cargo público en últimos 2 años? NO puede estar vacío.",									//34
				"cargo_publico" : "El campo Cargo Público NO puede estar vacío y debe contener solo letras.",									//35
				"institucion" : "El campo Institución NO puede estar vacío.",																	//36
				"uif" : "El campo ¿Es sujeto obligado a informar UIF-Perú, conforme al artículo 3° de la Ley N° 29038? NO puede estar vacío.",	//37
				"username" : {																													//38
					"required" : "El campo Usuario NO puede estar vacío.",
					"username" : "El campo Usuario no tiene un formato valido. Permitido alfanumérico y underscore (barra_piso).",
					"nowhitespace" : "El campo Usuario no permite espacios en blanco."
				},
				"userpwd" : "El campo contraseña NO puede estar vacío.",																			//39
				"confirm_userpwd" : "El campo confirmar contraseña debe coincidir con su contraseña.",											//40
				"contrato": "Debe aceptar el contrato de cuenta dinero electrónico."
			}
		}); // VALIDATE
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

//  MODAL TERMINOS Y CONDICIONES
$(".label-inline").on("click", "a", function() {

    $("#dialog-tc").dialog({
      dialogClass: "cond-serv",
      modal:"true",
      width:"940px",
      draggable:false,
      open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
    });
    $(".cond-serv").css("top","50px");
    $("#ok").click(function(){
      $("#dialog-tc").dialog("close");
    });

    });

	/*BASE 64*/

	var Base64 = {
		// private property
		_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

		// public method for encoding
		encode : function (input) {
			var output = "";
			var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
			var i = 0;

			input = Base64._utf8_encode(input);

			while (i < input.length) {
				chr1 = input.charCodeAt(i++);
				chr2 = input.charCodeAt(i++);
				chr3 = input.charCodeAt(i++);

				enc1 = chr1 >> 2;
				enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
				enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
				enc4 = chr3 & 63;

				if (isNaN(chr2)) {
					enc3 = enc4 = 64;
				} else if (isNaN(chr3)) {
					enc4 = 64;
				}

				output = output +
					this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
					this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
			}

			return output;
		},

		// private method for UTF-8 encoding
		_utf8_encode : function (string) {
			string = string.replace(/\r\n/g,"\n");
			var utftext = "";

			for (var n = 0; n < string.length; n++) {
				var c = string.charCodeAt(n);

				if (c < 128) {
					utftext += String.fromCharCode(c);
				}
				else if((c > 127) && (c < 2048)) {
					utftext += String.fromCharCode((c >> 6) | 192);
					utftext += String.fromCharCode((c & 63) | 128);
				}
				else {
					utftext += String.fromCharCode((c >> 12) | 224);
					utftext += String.fromCharCode(((c >> 6) & 63) | 128);
					utftext += String.fromCharCode((c & 63) | 128);
				}
			}

			return utftext;
		},
	}
});  //FIN DE LA FUNCION GENERAL

function msgService (title, msg) {
	$("#registrar").fadeIn();
	$("#dialogo-movil").dialog({
		title	:title,
		modal	:"true",
		width	:"440px",
		open	: function(event, ui) {
			$(".ui-dialog-titlebar-close", ui.dialog).hide();
			$('#msgService').text(msg);
		}

	});
	$("#inva5").click(function(){
		$("#dialogo-movil").dialog("close");
	});
}
