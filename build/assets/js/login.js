var base_url, base_cdn, skin;
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');
skin = $('body').attr('data-app-skin');

$(function() {

	var user, pass;

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
	  function mostrarProcesando(skin){
			var imagen="";

			switch(skin){
				case 'pichincha': imagen = "loading-pichincha.gif";
				break;
				case 'latodo': imagen = "loading-latodo.gif" ;
				break;
			}

				$("#login").attr('disabled', 'true');
				if (imagen == "") {
					$("#login").html('<div id="loading" class="icono-load" style="display:flex; width:20px; margin:0 auto;">'
					+'<span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 20px"></span></div>');
				} else {
					$("#login").html('<img src="'+base_cdn+'img/'+imagen+'">');
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

	function login(user,pass){
		var hasCookie = navigator.cookieEnabled;

		if(user!='' && pass!='' && hasCookie){

			$('#username').attr('disabled','true');
			$('#userpwd').attr('disabled','true');

			$(".ju-sliderbutton-text").html("Verificando...");

			$(".ju-sliderbutton .ju-sliderbutton-slider .ui-slider-handle").hide();
			mostrarProcesando(skin);
			var cpo_cook = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);

			$consulta = $.post(base_url+"/users/login", { 'user_name': user, 'user_pass': hex_md5(pass), cpo_name: cpo_cook } );

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
					ocultarProcesando();
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
					ocultarProcesando();
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
					ocultarProcesando();
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
					ocultarProcesando();
					$("#dialog-bloq").dialog({
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
					ocultarProcesando();
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
				}

		 	});	//IF CONSULTA DONE

}else if(!hasCookie){
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
