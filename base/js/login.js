var path, base_cdn;
path =window.location.href.split( '/' );
base_cdn = path[0]+ "//" +path[2].replace('online','cdn')+'/'+path[3];
base_url = path[0]+ "//" +path[2] + "/" + path[3];

$(function() {

	var user, pass;

	$('#slideUnlock').sliderbutton({
		text: "Desliza para ingresar",
		activate: function()
		{
			$('#username').removeAttr("class");
			$('#userpwd').removeAttr("class");
			// Reemplazo agregado por incidencia FP #37165
			$('#username').val($('#username').val().replace(/[ ]/g, ''));
			user = $('#username').val();
			user = user.toUpperCase();
			pass = $('#userpwd').val();

			$("#userpwd").val('');

			login(user, pass);
		}
	});

	$('.ui-slider-handle.ui-state-default.ui-corner-all').append('<a class="unlock-knob" title="Desliza para ingresar"><span aria-hidden="true" class="icon-arrow-right"></span></a>');

	$("#login").click(function(){
		$('#username').removeAttr("class");
		$('#userpwd').removeAttr("class");
		// Reemplazo agregado por incidencia FP #37165
		$('#username').val($('#username').val().replace(/[ ]/g, ''));
		user = $('#username').val();
		user = user.toUpperCase();
		pass = $('#userpwd').val();

		$("#userpwd").val('');

		login(user, pass);
	});

	function login(user,pass){

		document.cookie = 'cookie';
		cookie = document.cookie;

		if(user!='' && pass!='' && cookie!=''){

			$('#username').attr('disabled','true');
			$('#userpwd').attr('disabled','true');

			$(".ju-sliderbutton-text").html("Verificando...");

			$(".ju-sliderbutton .ju-sliderbutton-slider .ui-slider-handle").hide();

			$consulta = $.post(base_url+"/users/login", { 'user_name': user, 'user_pass': hex_md5(pass) } );

			$consulta.done(function(data){
				
				if (data == 1) {
					$("#dialog-login-ve").dialog({
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});					
				} else if(data.rc==0) {

					if(data.passwordTemp==1) {

						$(location).attr('href', base_url+'/users/cambiarPassword?t=t');

					} else if(data.passwordVencido==1) {

						$(location).attr('href', base_url+'/users/cambiarPassword?t=v');

					} else {

						$(location).attr('href', base_url+'/dashboard');

					}

				} else if(data.rc==-1) {

					$("#dialog-login").dialog({
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#invalido").click(function(){
						$("#dialog-login").dialog("close");
						habilitar();
					});


				}else if(data.rc==-194) {

					$("#dialog-overlay").dialog({
						title:"Password Caducado",
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#caducado").click(function(){
						$("#dialog-overlay").dialog("close");
						habilitar();
					});

				}
				else if(data.rc==-205){

					$("#dialog-voygo-error").dialog({
						//title:"VOYGO ERROR",
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#error-voygo").click(function(){
						$("#dialog-voygo-error").dialog("close");
					});

				}
				else if((data.rc==-35)||(data.rc==-8)) {

					$("#dialog-bloq").dialog({
						//title:"Usuario Bloqueado",
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#aceptar").click(function(){
						$("#dialog-bloq").dialog("close");
						habilitar();
					});

				}
				else {

					$("#dialog-error").dialog({
						title:"Error en el sistema",
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#error").click(function(){
						$("#dialog-error").dialog("close");
						habilitar();
					});

					//habilitar();

					//$(location).attr('href', base_url);

		 			// $.balloon.defaults.classname = "field-error";
		 			// $.balloon.defaults.css = null;
		 			// $("#username").showBalloon({position: "left", contents: data.msg});
	 				// setTimeout(function() {
				    // $("#username").hideBalloon();
				    // habilitar();
				    // 	}, 3000);

	}

		 	});	//IF CONSULTA DONE

}else if(cookie==''){
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
}else if(user=='' || pass==''){

	if(user==''){
		$('#username').addClass("field-error");
	}
	if(pass==''){
		$('#userpwd').addClass("field-error");
	}
}

}

function habilitar(){
	$("#username").removeAttr('disabled');
	$("#userpwd").removeAttr('disabled');
	$(".ju-sliderbutton-text").html("Desliza para ingresar");
	$(".ju-sliderbutton .ju-sliderbutton-slider .ui-slider-handle").show();
}

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



});
