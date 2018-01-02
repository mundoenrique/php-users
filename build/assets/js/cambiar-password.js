var path, base_cdn, base_url;
path = window.location.href.split('/');
base_url = path[0] + '//' + path[2];
base_cdn = base_url + '/assets';

	$(function(){
			var max = 15;
			var old =$('#old-userpwd').val();
			var newC =$('#userpwd').val();
			var cNewC = $('#confirm-userpwd').val();
			var $dialogo = $(this);
			$("#continuar").attr('disabled','disabled');
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
		        	$('#continuar').removeAttr("disabled");
		        }else{
					$('#continuar').attr("disabled",true);
		        }

		    }).focus(function() {

		        $("#new").showBalloon({position: "right", contents: $('#psw_info')});
		        $('#psw_info').show();

		    }).blur(function() {

		        $("#new").hideBalloon({position: "right", contents: $('#psw_info')});
		        $('#psw_info').hide();
		    });


			$("#cancelar").click(function(){
				$(location).attr('href', base_url+'/perfil');
			});
			$(".volver").click(function(){
				$(location).attr('href', base_url+'/perfil');
			});
			$("#continuar").click(function(){
				$("#continuar").hide();
				$("#loading").show();
				old =$('#old-userpwd').val();
				newC =$('#userpwd').val();
				cNewC = $('#confirm-userpwd').val();
				valor1=true;
				valor2=true;
				valor3=true;
				if( old=="" || newC=="" || cNewC=="" ){
					$("#continuar").show();
					$("#loading").hide();
					valor1=false;
					$("#dialog-clave-inv").dialog({
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#invalido").click(function(){
						$("#dialog-clave-inv").dialog("close");
					});
				}
				if(newC == old){
					$("#continuar").show();
					$("#loading").hide();
					valor2=false;
					$("#dialog-clave-inv1").dialog({
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#invalido1").click(function(){
						$("#dialog-clave-inv1").dialog("close");
					});

				}
				if(newC != cNewC){
					$("#continuar").show();
					$("#loading").hide();
					valor3=false;
					$("#dialog-clave-inv2").dialog({
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#invalido2").click(function(){
						$("#dialog-clave-inv2").dialog("close");
					});
				}
				if((valor1==true) && (valor2==true) && (valor3==true)){
					$("#continuar").hide();
					$("#loading").show();
					$.post(base_url +"/users/actualizarPassword",{"passwordOld":old, "passwordNew":newC},function(data){
							if(data.rc == -61){
								$(location).attr('href', base_url+'/users/error_gral');

							}
							if(data.rc==0) {

								$("#content").children().remove();
								$("#content").append($("#confirmacion").removeAttr('style')).html();

					 			$("#aceptar").click(function(){

					 				$(location).attr('href', base_url+'/dashboard');

								});
							}
							if(data.rc==-192) {

								$("#content").children().remove();
								$('#msg_pass').text('Contraseña actual incorrecta. Por favor verifique sus datos.')
								$("#content").append($("#sinExito").removeAttr('style')).html();

			 					$("#regresar").click(function(){

			 					$(location).attr('href', base_url+'/users/cambiarPassword?t=t');

								});

							}
							if(data.rc==-199) {

								$("#content").children().remove();
								$('#msg_pass').text('Su contraseña no ha sido actualizada. Por favor verifique sus datos.')
								$("#content").append($("#sinExito").removeAttr('style')).html();

			 					$("#regresar").click(function(){

			 					$(location).attr('href', base_url+'/users/cambiarPassword?t=t');

								});

							}

						});	//POST
				}
			});

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
