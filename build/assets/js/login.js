var base_url, base_cdn, skin;
var base_url = $('body').attr('data-app-url');
var base_cdn = $('body').attr('data-app-cdn');
var skin = $('body').attr('data-app-skin');
var cpo_cook;
var dataRequest;

$(function() {
	var user, pass;
	var hasCookie = navigator.cookieEnabled;

	if (!hasCookie) {
		$('#form-login input, #form-login button').attr('disabled', true);
		$('<div><h5>La funcionalidad de cookies de su navegador se encuentra desactivada.</h5><h4>Por favor vuelva activarla.</h4></div>').dialog({
			title: "Conexion personas Online",
			modal: true,
			maxWidth: 700,
			maxHeight: 300,
			resizable: false,
			close: function () { $(this).dialog("destroy"); },
			buttons: {
				Aceptar: function () {
					$(this).dialog("destroy");
					location.reload();
				}
			}
		});
	}

	$('#username, #userpwd').on('focus', function() {
		$(this)
		.removeAttr('class')
		.attr('placeholder', '');
	});


	$("#login").click(function() {
		$('#username').removeAttr("class");
		$('#userpwd').removeAttr("class");
		$('#username').val($('#username').val().replace(/[ ]/g, ''));
		user = $('#username').val();
		user = user.toUpperCase();
		pass = $('#userpwd').val();

		if (user == '' || pass == '') {
			if (user == '') {
				$('#username')
				.addClass("field-error")
				.attr('placeholder', 'Campo obligatorio')
			}
			if (pass == '') {
				$('#userpwd')
				.addClass("field-error")
				.attr('placeholder', 'Campo obligatorio')

			}
			return
		}

		$('#form-login input, #form-login button').attr('disabled', true);
		var passValid = true;
		var userValid = true;
		if(skin == 'pichincha') {
			passValid = (/^[\w!@\*\-\?¡¿+\/.,#]+$/i.test(pass))
			userValid = (/^[\wñÑ*.-]+$/i.test(user))
		}
		if(userValid && passValid) {
			mostrarProcesando(skin);
			grecaptcha.ready(function() {
				grecaptcha.execute('6LdRI6QUAAAAAEp5lA831CK33fEazexMFq8ggA4-', {action: 'login'})
				.then(function(token) {
					validateCaptcha(token, user, pass)
				}, function (token) {
					if(!token) {
						ocultarProcesando();
						habilitar();
						$("#dialog-error").dialog({
							title: "Conexión Personas",
							modal: "true",
							width: "440px",
							open: function (event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
						});

						$("#error").click(function () {
							$("#dialog-error").dialog("close");
						});
					}
				});
			});

		} else {
			ocultarProcesando();
			$("#dialog-login").dialog({
				modal: "true",
				width: "440px",
				open: function (event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			});

			$("#invalido").click(function () {
				$("#dialog-login").dialog("close");
				habilitar();
			});
			return
		}

	});

	$("#slideshow").click(function(){
		$("#content-product").dialog({
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			},
			open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
		});
	})

});

function mostrarProcesando(skin) {
	var imagen = "";

	switch (skin) {
		case 'pichincha': imagen = "loading-pichincha.gif";
			break;
		case 'latodo': imagen = "loading-latodo.gif";
			break;
	}

	$("#login").attr('disabled', 'true');
	if (imagen == "") {
		$("#login").html('<div id="loading" class="icono-load" style="display:flex; width:20px; margin:0 auto;">'
			+ '<span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 20px"></span></div>');
	} else {
		$("#login").html('<img src="' + base_cdn + 'img/' + imagen + '">');
	}
	if (skin == "pichincha") {
		$("#login").css({
			'position': 'relative',
			'height': '35px',
			'width': '100%',
			'opacity': '1'
		});

		$("#login").children(0).css({
			'position': 'absolute',
			'top': '50%',
			'left': '50%',
			'transform': 'translate(-50%, -50%)',
			'height': '25px'
		});
	}
};

function ocultarProcesando() {
	$("#login").html('Ingresar');
	$("#login").prop("disabled", false);
}

function habilitar() {
	$("#username").removeAttr('disabled');
	$("#userpwd").removeAttr('disabled');
}

function validateCaptcha(token, user, pass) {
	cpo_cook = decodeURIComponent(
		document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
	);

	dataRequest = JSON.stringify({
		token: token,
		user: user
	})

	dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();
	$.post(base_url + "/users/validateRecaptcha", {
		request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)
	})
	.done(function (response) {
		data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))

		score = $('.widget').attr('data-score-capcha');

		if((data.success == true) && (parseFloat(data.score) >= parseFloat(score))) {
			login(user, pass)

		} else {
			ocultarProcesando();
			$("#dialog-validate").dialog({
				modal: "true",
				width: "440px",
				open: function (event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
			});

			$("#error-validate").click(function () {
				$("#dialog-validate").dialog("close");
				habilitar();
			});
		}
	})
}

function login(user, pass) {
	cpo_cook = decodeURIComponent(
		document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
	);
	dataRequest = JSON.stringify({
		user_name: user,
		user_pass: hex_md5(pass)
	})
	dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, { format: CryptoJSAesJson }).toString();
	$.post(base_url + "/users/login", {
		request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)
	})
		.done(function (response) {

			data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8))

			if (data == 1) {
				$("#dialog-login-ve").dialog({
					modal: "true",
					width: "440px",
					open: function (event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				});
			} else if (data.rc == 0) {

				if (data.passwordTemp == 1) {

					$(location).attr('href', base_url + '/users/cambiarPassword?t=t');

				} else if (data.passwordVencido == 1) {

					$(location).attr('href', base_url + '/users/cambiarPassword?t=v');

				} else {

					$(location).attr('href', base_url + '/dashboard');

				}

			} else if (data.rc == -1) {
				ocultarProcesando();
				$("#dialog-login").dialog({
					modal: "true",
					width: "440px",
					open: function (event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				});

				$("#invalido").click(function () {
					$("#dialog-login").dialog("close");
					habilitar();
				});


			} else if (data.rc == -5) {
				ocultarProcesando();
				$("#sesion-activa").dialog({
					modal: "true",
					width: "440px",
					open: function (event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				});

				$("#activa").click(function () {
					$("#sesion-activa").dialog("close");
					$(location).attr('href', base_url + '/users/closeSess');
					habilitar();
				});


			} else if (data.rc == -194) {
				ocultarProcesando();
				$("#dialog-overlay").dialog({
					title: "Password Caducado",
					modal: "true",
					width: "440px",
					open: function (event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				});

				$("#caducado").click(function () {
					$("#dialog-overlay").dialog("close");
					habilitar();
				});

			}
			else if (data.rc == -205) {
				ocultarProcesando();
				$("#dialog-voygo-error").dialog({
					//title:"VOYGO ERROR",
					modal: "true",
					width: "440px",
					open: function (event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				});

				$("#error-voygo").click(function () {
					$("#dialog-voygo-error").dialog("close");
				});

			}
			else if ((data.rc == -35) || (data.rc == -8)) {
				ocultarProcesando();
				$("#dialog-bloq").dialog({
					modal: "true",
					width: "440px",
					open: function (event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				});

				$("#aceptar").click(function () {
					$("#dialog-bloq").dialog("close");
					habilitar();
				});

			}
			else {
				ocultarProcesando();
				$("#dialog-error").dialog({
					title: "Conexión Personas",
					modal: "true",
					width: "440px",
					open: function (event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				});

				$("#error").click(function () {
					$("#dialog-error").dialog("close");
					habilitar();
				});
			}

			if(skin == 'pichincha') {
				$('#username')
				.val('')
				.attr('placeholder', 'Usuario');
			}
			$('#userpwd')
			.val('')
			.attr('placeholder', 'Contraseña');
			user = '';
			pass = '';

		});
}
