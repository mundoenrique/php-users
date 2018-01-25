var base_url, base_cdn, recoverUser, recoverPwd, user, pass;
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');
recoverUser = $('#slideshow').data('recover-user');
recoverPwd = $('#slideshow').data('recover-pwd');

$(function() {

	$('#slideUnlock').sliderbutton({
		text: "Desliza para ingresar",
		activate: function()
		{
			$('#username').removeAttr("class");
			$('#userpwd').removeAttr("class");
			$('#username').val($('#username').val().replace(/[ ]/g, ''));
			user = $('#username').val();
			user = user.toUpperCase();
			pass = $('#userpwd').val();
			$("#userpwd").val('');

			verifyData(user, pass);
		}
	});

	$('.ui-slider-handle.ui-state-default.ui-corner-all').append('<a class="unlock-knob" title="Desliza para ingresar"><span aria-hidden="true" class="icon-arrow-right"></span></a>');

	$("#login").on('click', function() {
		$('#username').removeAttr("class");
		$('#userpwd').removeAttr("class");
		$('#username').val($('#username').val().replace(/[ ]/g, ''));
		user = $('#username').val();
		user = user.toUpperCase();
		pass = $('#userpwd').val();
		$("#userpwd").val('');

		verifyData(user, pass);
	});
});

function verifyData(user, pass)
{
	var hasCookie = navigator.cookieEnabled;
	if(user !== '' && pass !== '' && hasCookie) {
		$('#username').attr('disabled', true);
		$('#userpwd').attr('disabled', true);
		$('#login').attr('disabled', true);
		$(".ju-sliderbutton-text").html("Verificando...");
		$(".ju-sliderbutton .ju-sliderbutton-slider .ui-slider-handle").hide();

		login(user, pass);

	} else if(!hasCookie){
		$('<div><h5>La funcionalidad de cookies de su navegador se encuentra desactivada.</h5><h4>Por favor vuelva activarla.</h4></div>').dialog({
			title: "Conexion personas Online",
			modal: true,
			maxWidth: 700,
			maxHeight: 300,
			resizable: false,
			close: function(){$(this).dialog("destroy");},
			buttons: {
				Aceptar: function(){
					$(this).dialog("destroy");
				}
			}
		});
	} else if(user=='' || pass=='') {

		if(user==''){
			$('#username').addClass("field-error");
		}
		if(pass==''){
			$('#userpwd').addClass("field-error");
		}
	}
}

function login(user, pass)
{
	$.post(base_url + "/users/login", {user_name: user, user_pass: hex_md5(pass)})
	.done(function(response) {
		switch(response.code) {
			case 0:
				$(".ju-sliderbutton-text").html("Ingresando...");
				$(location).attr('href', base_url + '/dashboard');
				break;
			case -185:
				$(location).attr('href', base_url + '/users/cambiarPassword?t=v');
				break;
			case -381:
				$(location).attr('href', base_url + '/users/cambiarPassword?t=t');
				break;
			case 1:
				$("#dialog-login-ve").dialog({
					modal:"true",
					width:"440px",
					open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
				});
				break;
			case -1:
			case -8:
			case -35:
			case -194:
			default:
				systemResponse(response.title, response.msg);
		}
		if(response.code !== 0) {
			enableSlider();
		}
	});
}

function enableSlider()
{
	$("#username").removeAttr('disabled');
	$("#userpwd").removeAttr('disabled');
	$("#login").removeAttr('disabled');
	$(".ju-sliderbutton-text").html("Desliza para ingresar");
	$(".ju-sliderbutton .ju-sliderbutton-slider .ui-slider-handle").show();
}

function systemResponse(title, msg)
{
	$('#system-response').dialog({
		title: title,
		modal: true,
		width: '440px',
		draggable: false,
		resizable: false,
		focus: false,
		open: function(event, ui) {
			$(".ui-dialog-titlebar-close", ui.dialog).hide();
			$('#title-info').text(title);
			$('#content-info').empty().append('<p>' + msg + '</p>');
		}
	});
	$('#close-info').on('click', function() {
		$('#system-response').dialog('close');
	});
}
