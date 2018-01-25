var base_url, base_cdn, temporary, uri, oldPwd, pwd, confirmPwd;
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');
temporary = $('#content').data('temporary');
uri = temporary === 'n' ? '/dashboard' : '';

$(function() {
	var max = 15,
			valid = 0;

	//Valida que se indique la contraseña actual
	$('#old-userpwd').on('keyup', function() {
		oldPwd = $(this).val();
		pwd = $('#userpwd').val();

		if(oldPwd != '' && oldPwd.length >= 4) {
			$('#actual').removeClass('rule-invalid').addClass('rule-valid');
		} else {
			$('#actual').removeClass('rule-valid').addClass('rule-invalid');
		}
		//Valida que la contraseña sea diferente de la actual
		if(oldPwd !== '' && pwd !== '' && oldPwd !== pwd) {
			$('#diferente').removeClass('rule-invalid').addClass('rule-valid');
		} else {
			$('#diferente').removeClass('rule-valid').addClass('rule-invalid');
		}
	});

	//Valida estructura de la Nuva contraseña
	$('#userpwd').on('keyup', function() {
		pwd = $(this).val();
		oldPwd = $('#old-userpwd').val(),
		confirmPwd = $('#confirm-userpwd').val();


		//Valida que la contraseña sea diferente de la actual
		if(oldPwd !== '' && pwd !== '' && oldPwd !== pwd) {
			$('#diferente').removeClass('rule-invalid').addClass('rule-valid');
		} else {
			$('#diferente').removeClass('rule-valid').addClass('rule-invalid');
		}

		//Valida longitud
		if(pwd.length < 8 || pwd.length > 15) {
			$('#length').removeClass('rule-valid').addClass('rule-invalid');
		} else {
			$('#length').removeClass('rule-invalid').addClass('rule-valid');
		}

		//Valida minúscula
		if(pwd.match(/[a-z]/)) {
			$('#letter').removeClass('rule-invalid').addClass('rule-valid');
		} else {
			$('#letter').removeClass('rule-valid').addClass('rule-invalid');
		}

		//Valida mayúscula
		if(pwd.match(/[A-Z]/)) {
			$('#capital').removeClass('rule-invalid').addClass('rule-valid');
		} else {
			$('#capital').removeClass('rule-valid').addClass('rule-invalid');
		}

		//Valida números
		if(!pwd.match(/((\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#\$%])*\d(\w|[!@#$%])*(\d)*)/) && pwd.match(/\d{1}/) ) {
			$('#number').removeClass('rule-invalid').addClass('rule-valid');
		} else {
			$('#number').removeClass('rule-valid').addClass('rule-invalid');
		}

		//Valida números consecutivos
		if(!pwd.match(/(.)\1{2,}/) && pwd !== '') {
			$('#consecutivo').removeClass('rule-invalid').addClass('rule-valid');
		} else {
			$('#consecutivo').removeClass('rule-valid').addClass('rule-invalid');
		}

		///Valida caracter especial
		if(pwd.match(/([!@\*\-\?¡¿+\/.,_#])/)) {
			$('#especial').removeClass('rule-invalid').addClass('rule-valid');
		} else {
			$('#especial').removeClass('rule-valid').addClass('rule-invalid');
		}

		//Valida que la confirmación sea igual a la nueva contraseña
		if(confirmPwd !== '' && confirmPwd === pwd) {
			$('#igual').removeClass('rule-invalid').addClass('rule-valid');
		} else {
			$('#igual').removeClass('rule-valid').addClass('rule-invalid');
		}
	});

	//Valida que la confirmación sea igual a la nueva contraseña
	$('#confirm-userpwd').on('keyup', function() {
		confirmPwd = $(this).val();
		pwd = $('#userpwd').val();

		//Valida que la confirmación sea igual a la nueva contraseña
		if(confirmPwd !== '' && confirmPwd === pwd) {
			$('#igual').removeClass('rule-invalid').addClass('rule-valid');
		} else {
			$('#igual').removeClass('rule-valid').addClass('rule-invalid');
		}
	});

	//Verifica que se cunplan los requerimientos de la contraseña
	$('#pwd-in').on('keyup', function(){
		valid = $('.rule-valid').length;
		valid === 9 ? $('#continuar').removeAttr("disabled") : $('#continuar').attr("disabled", true);
	});

	$('#continuar').on('click', function() {
		oldPwd = hex_md5($('#old-userpwd').val());
		pwd = hex_md5($('#userpwd').val());
		$('#continuar').hide();
		$('#loading').show();

		updatePasword(oldPwd, pwd);
	});
});

//Actualizar contraseña
function updatePasword(oldPwd, pwd)
{
	$.post(base_url + "/users/actualizarPassword",
	{passwordOld: oldPwd, passwordNew: pwd, temporary: temporary})
	.done(function(response) {
		pwdResponse(response.title, response.msg, response.alert, response.action);
		$('#loading').hide();
		if(response.code !== 0) {
			$('#continuar').show();
		}
	});
}

//Modal respuestas del servicio
function pwdResponse(title, msg, alert, action)
{
	$('#response-pwd').dialog({
		title: title,
		modal: true,
		width: '440px',
		draggable: false,
		resizable: false,
		focus: false,
		open: function(event, ui) {
			$(".ui-dialog-titlebar-close", ui.dialog).hide();
			$('#title-pwd').text(title);
			$('#alert-pwd').addClass(alert);
			$('#content-pwd').empty().append('<p> ' + msg + '</p>');
		}
	});
	$('#close-pwd').on('click', function() {
		$('#response-pwd').dialog('close');
		$('#alert-pwd').removeClass(alert);
		action ? $(location).attr('href', base_url + uri) : '';
	});
}
