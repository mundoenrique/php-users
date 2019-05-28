var base_url, base_cdn, skin;
var fecha=new Date();
var controlValid = 0;
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');
skin = $('body').attr('data-app-skin');
var aplicaperfil = $('#content').attr('aplicaperfil'),
		afiliado = $('#content').attr('afiliado'),
		tyc = $('#content').attr('tyc');

$(function(){

	if(tyc == '0') {
		systemDialog('Términos y Condiciones', 'Debes aceptar los términos y condiciones.', 'tyc');
	}
	if(aplicaperfil == 'S' && afiliado == '0') {
		$('#widget-account').focus();
		systemDialog('Activa tu tarjeta plata beneficio', 'Completa el formulario.');
	}

	var tlfLength = '11';
	var codLength = '10';
	if (skin == 'pichincha'){
		$('#codepostal').attr('maxlength','6');
		$('#telefono_hab').attr('maxlength','9');
		tlfLength = '9';
		codLength = '6'
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


	checkeds();
	getProfesiones();

	setTimeout(function(){$("#msg").fadeOut();},5000);
	$('#loading-first').remove();
	$('#content-holder').css('display','block');

	/*Ocultar o mostrar campos segun la condición aplica perfil N o S*/
	function removeFieldperfil(){
		if($('#content').attr('aplicaperfil')=='N' || $('#pais-residencia-value').val() !='Pe'){
			$('#contract').remove();
			$('.dig-verificador').remove();
			$('.remove-perfil-plata-sueldo').remove();
			$('.row-fecha-nacimiento').css({'width':'31%', 'float':'left'});
			$('.col-profile-fecha-nac .nac-input').css('width','17%');
			$('.row-profesion').css({'width':'100%', 'float':'left'});
			$('.row-profesion select').css('width','27%');
			$('.row-modifica').removeClass('row-profile');
			$('.row-modifica').addClass('col-divide-profile');
			$('.row-modifica >li').removeClass('col-md-3-profile');
			$('.row-modifica').css('float','left');
			$('.expand-row').css('width','31%');
		}else if($('#content').attr('aplicaperfil')=='S' || $('#pais-residencia-value').val()=='Pe'){
			$('.row-profesion').remove();
		}
	}
	removeFieldperfil();
	/*Fin condicion aplica perfil*/

	/*Funciones radio buttons checked no checked*/
	var cargo_publico=$('#cargo-publico');

	function cargoPublico(){
		if(cargo_publico.val()==0){
			$('#cargo-publico-no').attr('checked','checked');
		}
		else if(cargo_publico.val()==1){
			$('#cargo-publico-si').attr('checked','checked');
		}
	}
	$('#cargo-publico-si').on('click',function(){
		$('#cargo-publico-no').removeAttr('checked','checked');
	});
	$('#cargo-publico-no').on('click',function(){
		$('#cargo-publico-si').removeAttr('checked','checked');
	});
	cargoPublico();

	///////////////////////////////////////////////////////////////////////

	var sujeto_uif=$('#uif');

	function sujetoObligadouif(){
		if(sujeto_uif.val()==0){
			$('#sujeto-obligado-no').attr('checked','checked');
		}
		else if(sujeto_uif.val()==1){
			$('#sujeto-obligado-si').attr('checked','checked');
		}
	}

	$('#sujeto-obligado-si').on('click',function(){
		$('#sujeto-obligado-no').removeAttr('checked','checked');
	});
	$('#sujeto-obligado-no').on('click',function(){
		$('#sujeto-obligado-si').removeAttr('checked','checked');
	});
	sujetoObligadouif();
	/*Fin funciones radio*/

	/*Function antiguedad laboral*/
	function selectAntiguedad(){

		var anio_antiguedad=$('#antiguedad').val();

		for(var antiguedad = 0; antiguedad < 51; antiguedad++){
			$('#antiguedad_laboral').append('<option value='+antiguedad+'>'+antiguedad+'</option>');
			if(anio_antiguedad==antiguedad){
				$('#antiguedad_laboral > option[value="'+anio_antiguedad+'"]').attr('selected', 'selected');
			}
		}
	}
	selectAntiguedad();
	/*Fin antiguedad laboral*/

	/*Funcion situacion laboral*/
	function situacionLaboral(){
		var situacionlaboral=$('#situacion-laboral-value').val();
		$('#situacion_laboral > option[value="'+situacionlaboral+'"]').attr('selected', 'selected');
	}
	situacionLaboral();
	/*Fin funcion situacion laboral*/

	/*funcion tipo de telefono*/
	function tipoTelefono(){
		var otrotelefonoTipo=$('#otro_telefono_tipo_value').val();
		$('#otro_telefono_tipo > option[value="'+otrotelefonoTipo+'"]').attr('selected', 'selected');
	}
	tipoTelefono();
	/*fin funcion tipo de telefono*/

	/*funcion tipo de direccion*/
	function tipoDireccion_fun(){
		var tipoDireccionval=$('#acTipo').val();
		$('#tipo_direccion > option[value="'+tipoDireccionval+'"]').prop('selected', 'selected');
	}
	tipoDireccion_fun();
	/*fin funcion tipo de direccion*/

	/*funcion estado civil*/
	function estadoCivil(){
		var estadoCivilvar=$('#edo-civil-value').val();
		$('#edocivil > option[value="'+estadoCivilvar+'"]').attr('selected', 'selected');
	}
	estadoCivil();
	/*fin funcion estado civil*/

	/*Funcion rellenar fecha de nacimiento en 3 campos*/
	function rellenarFecha(){
		var fecha_nacimiento=$('#fecha-nacimiento-valor').val();
		var dia =fecha_nacimiento.substring(0,2);
		var mes = fecha_nacimiento.substring(3,5);
		var anio  =fecha_nacimiento.substring(6,10);

		$('#dia-nacimiento').val(dia);
		$('#mes-nacimiento > option[value="'+mes+'"]').attr('selected', 'selected');
		$('#anio-nacimiento').val(anio);
	}


	rellenarFecha();
	$('#dia-nacimiento').blur(fechaNacimiento, fechaNacimientoInvalid);
	$('#mes-nacimiento').change(fechaNacimiento, fechaNacimientoInvalid);
	$('#anio-nacimiento').blur(fechaNacimiento, fechaNacimientoInvalid);

	$('#dia-nacimiento').blur(fechaNacimientoInvalid);
	$('#mes-nacimiento').change(fechaNacimientoInvalid);

	anio			= new Date();
	anioActual		= anio.getFullYear();
	mesActual		= anio.getMonth() + 1;
	diaActual		= anio.getDate();
	anioMayorEdad	= parseInt(anioActual - 18);

	function fechaNacimiento() {
		var dia		= $('#dia-nacimiento').val();
		var mes		= $('#mes-nacimiento option:selected').val();
		var anio	= $('#anio-nacimiento').val();

		if(dia != '' && mes != '' && anio != '') {
			if (anio < anioMayorEdad) {
				$('#fecha-nacimiento-valor').val(dia + '/' + mes + '/' + anio);
				//console.log("Fecha de nacimiento con evento: " + $('#fecha-nacimiento-valor').val() + " Prueba");
				$('#dia').removeClass('field-error').addClass('field-success');
				$('#mes').removeClass('field-error').addClass('field-success');
				$('#ano').removeClass('field-error').addClass('field-success');
				return true;

			} else {
				if (anio == anioMayorEdad) {
					if (mes < mesActual) {
						$('#fecha-nacimiento-valor').val(dia + '/' + mes + '/' + anio);
						//console.log("Fecha de nacimiento con evento: " + $('fecha-nacimiento-valor').val() + " Prueba");
						$('#dia').removeClass('field-error').addClass('field-success');
						$('#mes').removeClass('field-error').addClass('field-success');
						$('#ano').removeClass('field-error').addClass('field-success');
						return true;

					} else {
						if (mes == mesActual) {
							if (dia <= diaActual) {
								$('#fecha-nacimiento-valor').val(dia + '/' + mes + '/' + anio);
								//console.log("Fecha de nacimiento con evento: " + $('#fecha-nacimiento-valor').val() + " Prueba");
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

	}


	function fechaNacimientoInvalid() {
		dia		= $('#dia-nacimiento').val();
		mes		= $('#mes-nacimiento option:selected').val();

		if(dia==31 && mes==02 || dia==30 && mes==02 || dia==31 && mes==4 || dia==31 && mes==6 || dia==31 && mes==9 || dia==31 && mes==11){
			$('#dia-nacimiento').removeClass('field-success').addClass('field-error');
			$('#mes-nacimiento').removeClass('field-success').addClass('field-error');
			return false;
		}
		else{
			$('#dia-nacimiento').removeClass('field-error').addClass('field-success');
			$('#mes-nacimiento').removeClass('field-error').addClass('field-success');
			return true;
		}
	}
	/*Fin rellenar fecha de nacimiento*/

	/*Validacion nombres y apellidos*/
	function validaNombre1(){
		primer_nombre=$('#primer-nombre').val();

		if(primer_nombre.match(/[^a-z ñáéíóú \s]/gi)){
			$('#primer-nombre').removeClass('field-success').addClass('field-error');
			return false;
		}
		else{
			$('#primer-nombre').removeClass('field-error').addClass('field-success');
			return true;
		}
	}

	function validaNombre2(){
		segundo_nombre=$('#segundo-nombre').val();
		if(segundo_nombre.match(/[^a-z ñáéíóú \s]/gi)){
			$('#segundo-nombre').removeClass('field-success').addClass('field-error');
			return false;
		}
		else{
			$('#segundo-nombre').removeClass('field-error').addClass('field-success');
			return true;
		}
	}
	//$('#segundo-nombre').blur(validaNombre2);

	function validaApellido1(){
		primer_apellido=$('#primer-apellido').val();
		if(primer_apellido.match(/[^a-z ñáéíóú \s]/gi)){
			$('#primer-apellido').removeClass('field-success').addClass('field-error');
			return false;
		}
		else{
			$('#primer-apellido').removeClass('field-error').addClass('field-success');
			return true;
		}
	}

	function validaApellido2(){
		segundo_apellido=$('#segundo-apellido').val();
		if(segundo_apellido.match(/[^a-z ñáéíóú \s]/gi)){
			$('#segundo-apellido').removeClass('field-success').addClass('field-error');
			return false;
		}
		else{
			$('#segundo-apellido').removeClass('field-error').addClass('field-success');
			return true;
		}
	}

	function validaCargo(){
		cargo=$('#cargo').val();
		if(cargo.match(/[^a-z ñáéíóú \s]/gi)){
			$('#cargo').removeClass('field-success').addClass('field-error');
			return false;
		}
		else{
			$('#cargo').removeClass('field-error').addClass('field-success');
			return true;
		}
	}

	function validaLugarnacimiento(){
		lugarnac=$('#lugar-nacimiento').val();
		if(lugarnac.match(/[^a-z ñáéíóú \s]/gi)){
			$('#lugar-nacimiento').removeClass('field-success').addClass('field-error');
			return false;
		}
		else{
			$('#lugar-nacimiento').removeClass('field-error').addClass('field-success');
			return true;
		}
	}

	function validaCentrolaboral(){
		centro_laboral=$('#centro_laboral').val();
		if(centro_laboral.match(/[^a-z ñáéíóú \s]/gi)){
			$('#centro_laboral').removeClass('field-success').addClass('field-error');
			return false;
		}
		else{
			$('#centro_laboral').removeClass('field-error').addClass('field-success');
			return true;
		}
	}

	/*Fin validacion nombres y apellidos*/
	/********* Enviar formulario ******/
	function enviarForm() {
		controlValid = 1;
		validar_campos();
		formUpdate.submit();

		if(formUpdate.valid() == true){
			$('#actualizar').css('display', 'none');
			$("#load_reg").show();
			actualizarDatos();
		}
	}

	/*Funcion pais de residencia*/

	var codPaisresidencia=$('#pais-residencia-value').val().split("-")[0];

	function paisdeResidencia(){
		switch (codPaisresidencia) {
			case 'Co':
				$('#pais-de-residencia').val('Colombia');
				$('#state').text('Departamento');
				$('#city').text('Municipio');
				break;
			case 'Pe':
				$('#pais-de-residencia').val('Perú');
				$('#state').text('Departamento');
				$('#city').text('Provincia');
				break;
			case 'Usd':
				$('#pais-de-residencia').val('Perú');
				$('#state').text('Departamento');
				$('#city').text('Provincia');
				break;
			case 'Ve':
				$('#pais-de-residencia').val('Venezuela');
				$('#state').text('Estado');
				$('#city').text('Ciudad');
				break;
				case 'Ec':
				$('#pais-de-residencia').val('Ecuador');
				$('#state').text('Departamento');
				$('#city').text('Municipio');
				break;
			default:

		}
	}
	paisdeResidencia();
	/*Fin funcion pais de residencia*/

	/*funcion desempeño cargo publico*/
	function comprobarRcargo(){
		if($('#cargo-publico-no').is(':checked')){
			$('.cargo_publico').removeAttr('id name').attr('disabled','disabled').val('');
			$('.institucion_publica').removeAttr('id name').attr('disabled','disabled').val('');
		}
	}
	comprobarRcargo();
	$('#cargo-publico-no').on('click',function(){
		$('.cargo_publico').removeAttr('id name').attr('disabled','disabled').val('');
		$('.institucion_publica').removeAttr('id name').attr('disabled','disabled').val('');
	});
	$('#cargo-publico-si').on('click',function(){
		$('.cargo_publico').attr({id:'cargo_publico', name:'cargo_publico'}).removeAttr('disabled','disabled');
		$('.institucion_publica').attr({id:'institucion_publica', name:'institucion_publica'}).removeAttr('disabled','disabled');
	});
	/*Fin funcion desempeño cargo publico*/

	/*Habilitar campo otro telefono*/
	function habiliOtronum(){
		if($('#otro_telefono_tipo').val()==''){
			$('#otro_telefono_num').attr('disabled','disabled').val('');
		}
		else if($('#otro_telefono_tipo').val()!=''){
			$('#otro_telefono_num').removeAttr('disabled','disabled');
		}
	}
	habiliOtronum();
	$('#otro_telefono_tipo').on('change',function(){
		habiliOtronum();
	});
	/*Fin habilitar campo*/

	/*Funciones para la region*/
	function CargarRegionesPerfil(){
		var aplicaPerfil=$('#aplicaPerfil').val();
		if(aplicaPerfil=='S'){

			var cpo_cook = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
				);

				var dataRequest = JSON.stringify ({
					pais: codPaisresidencia,
					subRegion: 1
				});

				dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

				$.post(base_url+"/perfil/listadoDepartamento", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)}, function (response) {

				data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
				//console.log(data);
				$("#departamento").empty().append("<option value=''>Cargando...</option>");
				if(data.rc == 0) {

					$("#departamento").empty().append("<option value=''>Seleccione</option>");
					$.each(data.listaSubRegiones, function (pos, item) {
						var lista;
						lista = "<option value="+item.codregion+"> "+item.region+" </option>";
						$("#departamento").append(lista);
					});

					var departamento_data=$('#departamento_data').val();
					$('#departamento > option[value="'+departamento_data+'"]').attr('selected','selected');
					getProvinciasGeo(departamento_data, codPaisresidencia);
				}else{

					$("#dialog-cargar-regiones").show(800);
					$("#invalido3").click(function () {
						$("#dialog-cargar-regiones").hide("slow");
					});
				}
			});
		}
		else if(aplicaPerfil=='N'){

			var cpo_cook = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
				);

				var dataRequest = JSON.stringify ({
					codPais: codPaisresidencia,
					subRegion: 1
				});

				dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();


			$.post(base_url + "/perfil/listaEstado", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)}, function (response) {
				//console.log(data);

				data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))

				$("#departamento").empty().append("<option value=''>Cargando...</option>");
				if(data.rc == 0) {

					$("#departamento").empty().append("<option value=''>Seleccione</option>");
					$.each(data.listaEstados, function (pos, item) {
						var lista;
						lista = "<option value="+item.codEstado+"> "+item.estados+" </option>";
						$("#departamento").append(lista);
					});

					var departamento_data=$('#departamento_data').val();
					$('#departamento > option[value="'+departamento_data+'"]').attr('selected','selected');
					getProvinciasGeo(departamento_data, codPaisresidencia);
				}else{

					$("#dialog-cargar-regiones").show(800);
					$("#invalido3").click(function () {
						$("#dialog-cargar-regiones").hide("slow");
					});
				}
			});
		}
	}
	CargarRegionesPerfil();

	/*geolocalizacion perfil inicial*/
	function getProvinciasGeo(subRegion, codPaisresidencia) {
		var aplicaPerfil=$('#aplicaPerfil').val();
		if(aplicaPerfil=='S'){
			//console.log("Valor==> " + subRegion);
			var cpo_cook = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
				);

				var dataRequest = JSON.stringify ({
					pais: codPaisresidencia,
					subRegion: subRegion
				});

				dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

			$.post(base_url+"/perfil/listadoDepartamento", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)}, function (response) {
				data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
				//console.log(data);
				if(data.rc == 0) {
					$("#provincia").empty().append("<option value=''>Seleccione</option>");
					$.each(data.listaSubRegiones, function (pos, item) {
						var lista;
						lista = "<option value="+item.codregion+"> "+item.region+" </option>";
						$("#provincia").append(lista);

					});
					var provincia_data=$('#provincia_data').val();
					$('#provincia > option[value="'+provincia_data+'"]').attr('selected','selected');
					getDistritosGeo(provincia_data, codPaisresidencia);
				}
			});
		}
		else if(aplicaPerfil=='N'){
			//console.log("Valor==> " + subRegion);
			var cpo_cook = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
				);

				var dataRequest = JSON.stringify ({
					codPais: codPaisresidencia,
					codEstado: subRegion
				});

				dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

			$.post(base_url + "/perfil/listaCiudad", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)}, function (response) {
				//console.log(data);
				data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))
				if(data.rc == 0) {
					$("#provincia").empty().append("<option value=''>Seleccione</option>");
					$.each(data.listaCiudad, function (pos, item) {
						var lista;
						lista = "<option value="+item.codCiudad+"> "+item.ciudad+" </option>";
						$("#provincia").append(lista);

					});
					var provincia_data=$('#provincia_data').val();
					$('#provincia > option[value="'+provincia_data+'"]').attr('selected','selected');

				}
			});
		}
	}
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------//

	function getDistritosGeo(subRegion, codPaisresidencia) {
		//  console.log("Valor==> " + subRegion);
		var cpo_cook = decodeURIComponent(
			document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);

			var dataRequest = JSON.stringify ({
				pais: codPaisresidencia,
				subRegion: subRegion
			});

			dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();


		$.post(base_url + "/perfil/listadoDepartamento", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)}, function (response) {
			// console.log(data);

			data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))

			if(data.rc == 0) {
				$("#distrito").empty().append("<option value=''>Seleccione</option>");
				$.each(data.listaSubRegiones, function (pos, item) {
					var lista;
					lista = "<option value="+item.codregion+"> "+item.region+" </option>";
					$("#distrito").append(lista);
				});
				var distrito_data=$('#distrito_data').val();
				$('#distrito > option[value="'+distrito_data+'"]').attr('selected','selected');
			}
			else{
				$("#distrito").empty().append("<option value=''>-</option>");
			}
		});
	}
	/*end geolocalizacion*/

	$("#departamento").change(function () {
		$("#provincia").empty().append("<option value=''>Cargando...</option>");
		$("#distrito").empty().append("<option value=''>-</option>");
		if( this.value != "" )
		{
			getProvincias(this.value, codPaisresidencia);
		} else {
			$("#provincia").empty().append("<option value=''>-</option>");
		}
	});


	function getProvincias(subRegion, codPaisresidencia) {
		var aplicaPerfil=$('#aplicaPerfil').val();
		if(aplicaPerfil=='S'){
			//console.log("Valor==> " + subRegion);
			var cpo_cook = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
				);

				var dataRequest = JSON.stringify ({
					pais: codPaisresidencia,
					subRegion: subRegion
				});

				dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

			$.post(base_url + "/perfil/listadoDepartamento", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)}, function (response) {
				//console.log(data);
				data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))

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
					getDistritos(this.value, codPaisresidencia);
				} else {
					$("#distrito").empty().append("<option value=''>-</option>");
				}
			});
		}else if(aplicaPerfil=='N'){

			var cpo_cook = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
				);

				var dataRequest = JSON.stringify ({
					codPais: codPaisresidencia,
					codEstado: subRegion
				});

				dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();


			$.post(base_url + "/perfil/listaCiudad", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)}, function (response) {
				//console.log(data);
				data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))

				if(data.rc == 0) {
					$("#provincia").empty().append("<option value=''>Seleccione</option>");
					$.each(data.listaCiudad, function (pos, item) {
						var lista;
						lista = "<option value="+item.codCiudad+"> "+item.ciudad+" </option>";
						$("#provincia").append(lista);

					});
				}
			});
		}
	}
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------//

	function getDistritos(subRegion, codPaisresidencia) {
		//console.log("Valor==> " + subRegion);
		var cpo_cook = decodeURIComponent(
			document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);

			var dataRequest = JSON.stringify ({
				pais: codPaisresidencia,
				subRegion: subRegion
			});

			dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

		$.post(base_url+"/perfil/listadoDepartamento", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)}, function (response) {

			data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
			//console.log(data);
			if(data.rc == 0) {
				$("#distrito").empty().append("<option value=''>Seleccione</option>");
				$.each(data.listaSubRegiones, function (pos, item) {
					var lista;
					lista = "<option value="+item.codregion+"> "+item.region+" </option>";
					$("#distrito").append(lista);
				});
			}
			else{
				$("#distrito").empty().append("<option value=''>-</option>");
			}
		});
	}

	/*Fin funciones para la region*/

	/*------------------------FUNCIONES-----------------------------*/


	function getProfesiones() {

		profesion = $("#content").attr("profesion");
		tipo_profesion = $("#content").attr("tipo_profesion");
		if(profesion!="" && tipo_profesion!=""){
			lista_p='<option selected value="'+tipo_profesion+'">'+profesion+'</option>';

		}
		else if(profesion=="" || tipo_profesion==""){
			lista_p='<option selected value="">Seleccione</option>';
		}

		var cpo_cook = decodeURIComponent(
			document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);


		$.post(base_url +"/perfil/profesiones", {cpo_name: cpo_cook, plot: btoa(cpo_cook)}, function(response){

			data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))

			$.each(data.listaProfesiones,function(pos,item){

				if((item.idProfesion!=tipo_profesion)&&(item.tipoProfesion!=profesion)){
					lista_p+= '<option value="'+item.idProfesion+'"> '+item.tipoProfesion+' </option>';
				}

			});
			$("#listaProfesion").append(lista_p);
		});

	}

	$('#listaProfesion').on('change', function(){
		$('#tipo_profesion_value').val($('#listaProfesion').val());
	});

	$('.profesion-labora').on('change', function(){
		$('.tipo_profesion_value').val($('.profesion-labora').val());
	});

	$('#tipo_direccion').on('change', function(){
		$('#tipo_direccion_value').val($('#tipo_direccion').val());
	});

	$('#otro_telefono_tipo').on('change', function(){
		$('#otro_telefono_tipo_value').val($('#otro_telefono_tipo').val());
	});

	$('#edocivil').on('change', function(){
		$('#edo-civil-value').val($('#edocivil').val());
	});

	function checkeds(){

		genero = $("#content").attr("sexo");
		inf_cel= $("#notificacions-sms").attr("value");
		inf_mail= $("#notificacions-email").attr("value");
		aProteccion= $('#proteccion').attr("value");
		aContrato= $('#contrato').attr("value");

		if(genero=="M"){
			$('#gender_m').attr('checked',true);
		}
		if(genero=="F"){
			$('#gender_f').attr('checked',true);
		}
		if(inf_mail==1){
			$('#notificacions-email').attr('checked',true);
		}
		if(inf_cel==1){
			$('#notificacions-sms').attr('checked',true);
		}
		if(aProteccion==1){
			$('#proteccion').attr('checked',true);
			$('body').off('click', '#proteccion');

		}
		if(aContrato==1){
			$('#contrato').attr('checked',true);
			$('body').off('click', '#contrato');
		}
	}


	/*Funcion actualizar datos del usuario*/
	function actualizarDatos(){

		var cpo_cook = decodeURIComponent(
			document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);

			var valuegender = "";
			$("input[type='radio'][name='gender']").each(function(){
			  if($(this).is(":checked"))
				valuegender = $(this).val();
			});

			var valueCargop = "";
			$("input[type='radio'][name='cargo_public']").each(function(){
				if($(this).is(":checked"))
				  valueCargop = $(this).val();
			});

			var valueSujeto = "";
			$("input[type='radio'][name='sujeto-obligado']").each(function(){
				if($(this).is(":checked"))
				  valueSujeto = $(this).val();
			});

			if(otro_telefono_num==""){
				otro_telefono_tipo="";
				otro_telefono_num="";
			}
			else
			{
				otro_telefono_tipo=$("#otro_telefono_tipo").val();
				otro_telefono_num=$("#otro_telefono_num").val();
			}

			if($("#notificacions-sms").is(':checked')) {

				$("#notificacions-sms").val("1");
				notSms="1";

			}
			else {

				notSms=$("#notificacions-sms").val("0");
				notSms="0";//48

			}

			if($("#notificacions-email").is(':checked')) {

				$("#notificacions-email").val("1");
				notEmail="1";

			} else {

				notEmail=$("#notificacions-email").val("0");
				notEmail="0";//49
			}

			if($("#proteccion").is(':checked')) {

				$("#proteccion").val("1");
				proteccion="1";

			} else {

				$("#proteccion").val("0");
				proteccion="0";
			}

			if($("#contrato").is(':checked')) {

				$("#contrato").val("1");
				contrato="1";

			} else {

				$("#contrato").val("0");
				contrato="0";
			}


		var dataRequest = JSON.stringify ({
		userName:$("#content").attr("userName"), ///1
		tipo_identificacion:$('#tipo_identificacion').val(), ///2
		verifyDigit:$('#dig-ver').val(),
		primerNombre:$("#primer-nombre").val(),//3
		segundoNombre:$("#segundo-nombre").val(),//4
		primerApellido:$("#primer-apellido").val(),//5
		segundoApellido:$("#segundo-apellido").val(),//6
		lugarNacimiento:$("#lugar-nacimiento").val(),//7
		fechaNacimiento:$("#fecha-nacimiento-valor").val(),//8
		sexo:valuegender,//9
		edocivil:$("#edo-civil-value").val(),//10
		nacionalidad:$("#nacionalidad-valor").val(),//11
		profesion:$("#listaProfesion").val(),//12
		tipo_profesion:$('#tipo_profesion_value').val(),//13
		tipo_direccion:$("#tipo_direccion_value").val(),//14
		codigoPostal:$("#codepostal").val(),//15
		paisResidencia:$("#pais-residencia-value").val(),//16
		departamento_residencia:$("#departamento").val(),//17
		provincia_residencia:$("#provincia").val(),//18
		distrito_residencia:$("#distrito").val(),//19
		direccion:$("#direccion").val(),//20
		telefono_hab:$("#telefono_hab").val(),//21
		telefono:$("#telefono").val(),//22
		otro_telefono_tipo:otro_telefono_tipo,//23
		otro_telefono_num:otro_telefono_num,//24
		email:$("#email").val(),//25
		ruc_cto_labora:$("#ruc_cto_labora").val(),//26
		centro_laboral:$("#centro_laboral").val(),//27
		situacion_laboral:$("#situacion_laboral").val(),//28
		antiguedad_laboral_value:$("#antiguedad_laboral").val(),//29
		profesion_labora:$(".profesion-labora").val(),//30
		cargo:$("#cargo").val(),//31
		ingreso_promedio:$("#ingreso_promedio").val(),//32
		cargo_publico_sino:valueCargop,//33
		cargo_publico:$("#cargo_publico").val(),//34
		institucion_publica:$("#institucion_publica").val(),//35
		sujeto_obligado:valueSujeto,//36
		dtfechorcrea_usu:$("#dtfechorcrea_usu").val(),//37
		id_ext_per:$('#id_ext_per').val(),//38
		tipo_id_ext_per:$('#tipo_id_ext_per').val(),//39
		aplicaPerfil:$('#aplicaPerfil').val(),//40
		notarjeta:$('#notarjeta').val(),//41
		acCodCiudad:$('#provincia').val(),//42
		acCodEstado:$('#departamento').val(),//43
		acCodPais:$('#acCodPais').val(),//44
		acTipo:$('#tipo_direccion_value').val(),//45
		acZonaPostal:$('#codepostal').val(),//46
		disponeClaveSMS:$('#disponeClaveSMS').val(),//47
		tyc : $('#tyc').is(':checked') ? "1" : "0",
		notSms:notSms,
		notEmail:notEmail,
		proteccion:proteccion,
		contrato:contrato
		});

		dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

		$.post(base_url+"/perfil/actualizar",{ request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook) }, function(response) {

			data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));

				$("#load_reg").hide();
				switch (data.rc) {
					case 0:
						$('#content-formulario-perfil').remove();
						$('#exito').css('display','block');
						break;
					case -200:
					systemDialog('Alerta', data.msg, 'dash');

						break;
					case -271:
						$('.overlay-modal').show();
						$('#dialogo-actualizacion-incompleta').show();
						break;
					case -335:
						$('#dig-ver').focus();
						systemDialog('Perfil', 'Dígito verificador inválido');
						break;
					case -317:
					case -314:
					case -313:
					case -311:
					case -21:
						systemDialog('Activación Plata beneficios', 'El perfil se actualizó satisfactoriamente, pero no fue posible activar su tarjeta, comuníquese con el <strong>Centro de Contacto</strong>', 'dash');
						break;
					default:
						$(location).attr('href', base_url+'/users/error_gral');
				}
			});
	}

	/**************funcion ocultar modales*****************/
	$('#invalido1').on('click',function(){
		$('#dialogo-fallo-actualizacion').hide();
		$('.overlay-modal').hide();
	});
	$('#invalido2').on('click',function(){
		$('#dialogo-actualizacion-incompleta').hide();
		location.reload(true);
	});
	/**************fin ocultar modales****************/

	// MODAL TERMINOS Y CONDICIONES
	$(".label-inline").on("click", "a", tycModal);
	$('#tyc').on('click', function(){
		tycModal();
		$('#tyc').off('click');
	});
	if($('#tyc').is(':checked')) {
		$('#tyc')
			.off('click')
			.prop('disabled', true);
	}

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
	if(aProteccion==1){
		$('#proteccion')
			.off('click')
			.prop('disabled', true);
	}

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
	if(aContrato==1){
		$('#contrato')
			.off('click')
			.prop('disabled', true);
	}
	/******envio de formualario*****/
	var formUpdate=$('#form-perfil');
	validar_campos();

	$("#actualizar").on('click', function(e) {
		e.preventDefault();
		pais=$('#content').attr('accodpais');
		email=$('#email').val();
		userName=$('#content').attr('username');
		verificarMail=$('#verificar-email').val();

		if (email != verificarMail && !email.match(/[\s]/gi)) {
			$("#loading").show();

			var cpo_cook = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
				);

			$.post(base_url + '/perfil/verificarEmail', {
				"pais": pais,
				"email": email,
				"username": userName,
				"cpo_name": cpo_cook
			}, function (data) {
				$('#msg-correo').hide();
				response_email = JSON.parse(data);

				//console.log(response_email);
				if(response_email.rc == -238) {
					$("#loading").hide();
					$('#msg-correo').css('display', 'none');
					$('#email').removeClass('field-error').addClass('field-success');
					$('#actualizar').removeAttr('disabled');
					enviarForm();
				} else if (response_email.rc == 0) {
					$("#loading").hide();
					$('#email').removeClass('field-success').addClass('field-error');

					$("#dialogo_disponible").dialog({
						title: "Correo no disponible",
						modal: "true",
						width: "440px",
						open: function (event, ui) {
							$(".ui-dialog-titlebar-close", ui.dialog).hide();
						}
					});
					$("#disp").click(function () {
						$("#dialogo_disponible").dialog("close");
					});
				} else {
					$("#loading").hide();
					$('#msg-correo').css('display', 'none');
					$('#email').removeClass('field-error').addClass('field-success');
					$('#actualizar').removeAttr('disabled');
					enviarForm();
				}
			});
		} else if (email == verificarMail) {
			$('#msg-correo').css('display', 'none');
			$('#email').removeClass('field-error').addClass('field-success');
			$('#actualizar').removeAttr('disabled');
			enviarForm();
		}
	});
	/*********fin envio de formulario*******/

	$("#perfil-cancelar").click(function(){
		window.location.href = base_url + '/dashboard';
	});

	/**************validacion de formularios************************/
	function validar_campos(){


		jQuery.validator.setDefaults({
			debug	: true,
			success	: "valid"
		});

		jQuery.validator.addMethod("numberEqual1", function(value,element){
			if(element.value.length>0 && (element.value == $("#telefono_hab").val() || element.value == $("#telefono").val()))
				return false;
			else return true;

		}, "Teléfono Otro está repetido");

		jQuery.validator.addMethod("numberEqual2", function(value, element) {
			if(element.value.length>0 && (element.value == $("#telefono").val() || element.value == $("#otro_telefono_num").val()))
				return false;
			else return true;

		}, "Teléfono Fijo está repetido");

		jQuery.validator.addMethod("numberEqual3", function(value, element) {
			if(element.value.length>0 && (element.value == $("#telefono_hab").val() || element.value == $("#otro_telefono_num").val()))
				return false;
			else return true;

		}, "Teléfono Móvil está repetido");

		jQuery.validator.addMethod("username", function(value,element,regex){
			return regex.test(value);
		}, "Usuario invalido. ");

		jQuery.validator.addMethod("mayorEdadAnio", function(value,element){
			if(controlValid == 0) {
				var fecha_nacimiento = fechaNacimiento();
				if(fecha_nacimiento == true){
					return true;
				}else if(fecha_nacimiento == false) {
					return false;
				}
			} else {
				return true;
			}

		}, "Usted no es mayor de edad. ");

		jQuery.validator.addMethod("validarFecha", function(value,element){
			var fechadenacimeintovalida = fechaNacimientoInvalid();
			if(fechadenacimeintovalida == true){
				return true;
			}else if(fechadenacimeintovalida == false){
				return false;
			}
		}, "Fecha invalida");

		jQuery.validator.addMethod("validaNombre1", function(value,element){
			var validaNombre1J = validaNombre1();
			if(validaNombre1J == true){
				return true;
			}else if(validaNombre1J == false){
				return false;
			}
		}, "El campo Primer nombre no admite caracteres especiales.");

		jQuery.validator.addMethod("validaNombre2", function(value,element){
			var validaNombre2J = validaNombre2();
			if(validaNombre2J == true){
				return true;
			}else if(validaNombre2J == false){
				return false;
			}
		}, "El campo Segundo nombre no admite caracteres especiales.");

		jQuery.validator.addMethod("validaApellido1", function(value,element){
			var validaApellido1J = validaApellido1();
			if(validaApellido1J == true){
				return true;
			}else if(validaApellido1J == false){
				return false;
			}
		}, "El campo Primer apellido no admite caracteres especiales.");

		jQuery.validator.addMethod("validaApellido2", function(value,element){
			var validaApellido2J = validaApellido2();
			if(validaApellido2J == true){
				return true;
			}else if(validaApellido2J == false){
				return false;
			}
		}, "El campo Segundo apellido no admite caracteres especiales.");

		jQuery.validator.addMethod("validaCargo", function(value,element){
			var validaCargoJ = validaCargo();
			if(validaCargoJ == true){
				return true;
			}else if(validaCargoJ == false){
				return false;
			}
		}, "El campo Cargo no admite caracteres especiales.");

		jQuery.validator.addMethod("validaLugarnac", function(value,element){
			var validarLugnac = validaLugarnacimiento();
			if(validarLugnac == true){
				return true;
			}else if(validarLugnac == false){
				return false;
			}
		}, "El campo Lugar de Nacimiento no admite caracteres especiales.");

		jQuery.validator.addMethod("validaCentro", function(value,element){
			var Funcentrolaboral = validaCentrolaboral();
			if(Funcentrolaboral == true){
				return true;
			}else if(Funcentrolaboral == false){
				return false;
			}
		}, "El campo Centro Laboral no admite caracteres especiales.");

		jQuery.validator.addMethod("mail",function(value,element,regex){
				return regex.test(value);
			},
			"Correo invalido. "
		);

		$("#form-perfil").validate({

			errorElement		: "label",
			ignore				: "",
			errorContainer		: "#msg",
			errorClass			: "field-error",
			validClass			: "field-success",
			errorLabelContainer	: "#msg",
			rules				: {

				"dig-ver" : {"required":true, "digits":true, "maxlength":1},										//2
				"primer_nombre" : {"required":true, "validaNombre1":true},													//3
				"segundo_nombre" : {"required":false, "validaNombre2":true},													//4
				"primer_apellido" : {"required":true, "validaApellido1":true},													//5
				"segundo_apellido":{"required":false, "validaApellido2":true},													//6
				"lugar_nac" : {"required":false, "validaLugarnac":true},												//7
				"dia-nacimiento" : {"required" : true, "number":true, range : [1,31]},							//8
				"mes-nacimiento" : {"required" : true, "number":true, range : [1,12], "validarFecha": true},							//9
				"anio-nacimiento" : {"required" : true, "number":true, min: 1900, "mayorEdadAnio" : true},			//10
				"genero" : {"required" : false},																			//11
				"edo_civil" : {"required" : false},																			//12
				"nacionalidad" : {"required" : true, "lettersonly": true},																		//13
				"tipo_direccion" : {"required" : true},																	//14
				"codepostal" : {"required" : false, digits: true,"maxlength": codLength},														//15
				"pais_Residencia" : {"required" : true},																	//16
				"departamento_residencia" : {"required" : true},																		//17
				"provincia_residencia" : {"required" : true},																			//18
				"distrito_residencia" : {"required" : true},																			//19
				"direccion" : {"required" : true},																			//20
				"email" : {"required":true, "mail": /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/},																	//21
				"telefono_hab": {"number":true, "numberEqual2": true, "maxlength": 11, "minlength": tlfLength},									//23
				"telefono": {"required":true, "number":true, "numberEqual3": true, "maxlength": 11, "minlength":7},					//24
				"otro_telefono_tipo" : {"required":false},																	//25
				"otro_telefono_num" : {"number":true, "numberEqual1": true, "maxlength": 11, "minlength":7},								//26
				"ruc_laboral" : {"required":true},																			//27
				"centro_laboral" : {"required":true, "validaCentro":true},																		//28
				"situacion_laboral" : {"required":false},																	//29
				"profesion_labora" : {"required":true},
				"profesion" : {"required":true},																	//31
				"cargo" : {"validaCargo":true},																		//32
				"ingreso_promedio" : {"required":false, "number":true},							    								//33
				"desem_publico" : {"required":true},																		//34
				"cargo_publico" : {"required":true},																		//35
				"institucion_publica" : {"required":true},																			//36
				"uif" : {"required":true},																					//37
				"contrato": {"required": true},
				"tyc": {"required": true}
			},

			messages: {
				"dig-ver": "Dígito verificador inválido.",
				"primer_nombre" : "El campo Primer Nombre NO puede estar vacío y debe contener solo letras.",									//3
				"segundo_nombre" : "El campo Segundo Nombre debe contener solo letras.",														//4
				"primer_apellido" : "El campo Apellido Paterno NO puede estar vacío y debe contener solo letras.",								//5
				"segundo_apellido" : "El campo Apellido Materno debe contener solo letras.",													//6
				"lugar_nac" : "El campo Lugar de Nacimiento debe contener solo letras.",													//7

				"dia-nacimiento" : {																														//8
					"required"	: "El campo Día NO puede estar vacío y debe contener solo números.",
					"number"	: "El campo Día NO puede estar vacío y debe contener solo números.",
					"mayorEdadAnio"	: "Usted no es mayor de edad.",
					"range":"El Día debe estar comprendido entre 1 y 31."
				},
				"mes-nacimiento" : {																														//9
					"required"	: "El campo Mes NO puede estar vacío y debe contener solo números.",
					"number"	: "El campo Mes NO puede estar vacío y debe contener solo números.",
					"mayorEdadAnio"	: "Usted no es mayor de edad.",
					"validarFecha" : "Fecha invalida.",
				},
				"anio-nacimiento" : {																														//10
					"required"	: "El campo Año NO puede estar vacío y debe contener solo números.",
					"number"	: "El campo Año NO puede estar vacío y debe contener solo números.",
					"mayorEdadAnio"	: "Usted no es mayor de edad.",
					"min" : "Por favor ingrese un Año de nacimiento válido."
				},
				"nacionalidad" : {
					"lettersonly"	: "El campo Nacionalidad NO puede contener números.",
					"required"		: "El campo Nacionalidad NO puede estar vacío."
				},																													//13
				"tipo_direccion" : "El campo Tipo Dirección NO puede estar vacío.",																//14
				"codepostal" : {
					"digits":"El campo Código Postal debe contener solo números.",
					"maxlength" : "El campo Código postal debe contener máximo "+ codLength +" caracteres númericos."
				},																																																						//15
				"pais_Residencia" : "El campo País de Residencia NO puede estar vacío y debe contener solo letras.",							//16
				"departamento_residencia" : "El campo Departamento NO puede estar vacío.",																	//17
				"provincia_residencia" : "El campo Provincia NO puede estar vacío.",																		//18
				"distrito_residencia" : "El campo Distrito NO puede estar vacío.",																			//19
				"direccion" : "El campo Dirección NO puede estar vacío.",																		//20
				"email" : "El correo electrónico NO puede estar vacío y debe contener formato correcto. (usuario@ejemplo.com).",
				"telefono_hab" : {																												//23
					"number"		: "El campo Teléfono Fijo debe contener solo números.",
					"numberEqual2"	: "Teléfono Fijo está repetido.",
					"minlength": "El campo Teléfono Fijo debe contener mínimo 7 caracteres numéricos.",
					"maxlength" : "El campo Teléfono Fijo debe contener máximo "+ tlfLength +" caracteres númericos."
				},
				"telefono" : {																											//24
					"required"		: "El campo Teléfono Móvil NO puede estar vacío y debe contener solo números.",
					"number"		: "El campo Teléfono Móvil NO puede estar vacío y debe contener solo números.",
					"numberEqual3"	: "Teléfono Móvil está repetido.",
					"minlength"		: "El campo Teléfono Móvil debe contener minimo 7 caracteres númericos.",
					"maxlength"		: "El campo Teléfono Móvil debe contener máximo 11 caracteres numéricos."
				},

				"otro_telefono_num"	: {                                                                                                         //26
					"number"		: "El campo Otro Teléfono debe contener solo números.",
					"numberEqual1"	: "El campo Otro Teléfono está repetido.",
					"minlength"		: "El campo Otro Teléfono  debe contener mínimo 7 caracteres numéricos.",
					"maxlength"		: "El campo Otro Teléfono  debe contener máximo 11 caracteres numéricos."
				},
				"ruc_laboral" : "El campo Teléfono Móvil NO puede estar vacío.",																//27
				"centro_laboral" : "El campo Centro Laboral NO puede estar vacío y NO puede contener caracteres especiales.",																//28

				"profesion_labora" : "El campo Ocupación Laboral NO puede estar vacío y debe contener solo letras.",
				"profesion" : "Debe seleccionar una profesión.",							//31
				"cargo" : "El campo Cargo no admite caracteres especiales.",															//32
				"ingreso_promedio" : "El campo Ingreso promedio mensual debe contener solo números.",																												//33
				"desem_publico" : "El campo ¿Desempeñó cargo público en últimos 2 años? NO puede estar vacío",									//34
				"cargo_publico" : "El campo Cargo Público NO puede estar vacío y debe contener solo letras.",									//35
				"institucion_publica" : "El campo Institución pública NO puede estar vacío.",																	//36
				"uif" : "El campo ¿Es sujeto obligado a informar UIF-Perú, conforme al artículo 3° de la Ley N° 29038? NO puede estar vacío.",	//37
				"contrato": "Debe aceptar el contrato de cuenta dinero electrónico.",
				"tyc": "Debe aceptar los términos y condiciones."
			}
		}); // VALIDATE
	}
	/*********Fin validacion de formularios********/

}); //FIN FUNCION GENERAL

function systemDialog(title, msg, action) {
	$("#completar-afiliacion").dialog({
		title: title,
		modal: "true",
		width: "440px",
		open: function (event, ui) {
			$(".ui-dialog-titlebar-close", ui.dialog).hide();
			$('#msgAfil').html(msg);
		}
	});
	$("#acept").click(function () {
		$('#actualizar').fadeIn();
		$("#completar-afiliacion").dialog("close");
		switch(action) {
			case 'dash':
				$(location).attr('href', base_url+'/dashboard');
				break;
			case 'tyc':
				$('#tyc').focus();
				break;

		}
	});
}

function tycModal() {
	$("#dialog-tc").dialog({
		dialogClass: "cond-serv",
		modal:"true",
		width:"940px",
		draggable:false,
		open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
	});
	$('html, body').animate({
		scrollTop: $('body').offset().top
	}, 0);
	$(".cond-serv").css("top","50px");
	$("#ok").click(function(){
		$("#dialog-tc").dialog("close");
	});
}
