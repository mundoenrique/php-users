var base_url, base_cdn;
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');

$(function(){

			var max = 15;
			var old =$('#transpwd').val();
			var newC =$('#new-transpwd').val();
			var cNewC = $('confirm-new-transpwd').val();

		$('#new-transpwd').keyup(function() {
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
		        	$('#continuar').removeClass('disabled-button');
		        }else{
		        	$('#continuar').addClass('disabled-button');
		        }

		    }).focus(function() {

		        $("#new").showBalloon({position: "right", contents: $('#psw_info')});
		        $('#psw_info').show();

		    }).blur(function() {

		        $("#new").hideBalloon({position: "right", contents: $('#psw_info')});
		        $('#psw_info').hide();
		});

		    $("#continuar").click(function(){
				old =$('#transpwd').val();
				newC =$('#new-transpwd').val();
				cNewC = $('#confirm-new-transpwd').val();
				valor1=true;
				valor2=true;
				valor3=true;
				// if((longitud==true)&& (mt==true) && (cap==true) && (car==true) &&  (cons==true) && (esp==true)){
		  //       	$('#continuar').removeClass('disabled-button');
		  //       }
				if( old=="" || newC=="" || cNewC=="" ){
					//$(this).find($('#vacio')).text('Todos los campos son obligatorios');
					//$('#continuar').addClass('disabled-button');
					//alert("Todos los campos son obligatorios");
					valor1=false;
					$("#dialog-clave-inv").dialog({
						//title:"Campos obligatorios",
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#invalido").click(function(){
						$("#dialog-clave-inv").dialog("close");
					});
				}
				if(newC == old){
					//$(this).find($('#vacio')).text('Su contraseña no puede ser igual a la anterior');
					//alert("Su contraseña no puede ser igual a la anterior");
					valor2=false;
					$("#dialog-clave-inv1").dialog({
						//title:"Error en campos",
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#invalido1").click(function(){
						$("#dialog-clave-inv1").dialog("close");
					});
				}
				if(newC != cNewC){
					//$(this).find($('#vacio')).text('Su contraseña no puede ser igual a la anterior');
					//alert("Su contraseñas no coinciden");
					valor3=false;
					$("#dialog-clave-inv2").dialog({
						//title:"Contraseñas no coinciden",
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#invalido2").click(function(){
						$("#dialog-clave-inv2").dialog("close");
					});
				}
				if((valor1==true) && (valor2==true) && (valor3==true)){
					$('#continuar').removeClass('disabled-button');

					var cpo_cook = decodeURIComponent(
						document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
					);

					var dataRequest = JSON.stringify ({
						passwordOperacionesOld:old,
						passwordOperaciones:newC
					});

					dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

					$.post(base_url +"/users/passwordOperacionesActualizar",{request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},function(response){

						data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));

					if(data.rc==0) {

						$("#content").children().remove();
						$("#content").append($("#confirmaActualizar").removeAttr('style')).html();

			 			$("#confirmar").click(function(){

			 				$(location).attr('href', base_url+'/perfil');

						});

					}
					if(data.rc==-202){

						$("#content").children().remove();
						$("#content").append($("#sinExito").removeAttr('style')).html();

			 			$("#regresar").click(function(){

			 				$(location).attr('href', base_url+'/users/actualizarPasswordOperaciones');

						});

					}
					if(data.rc == -61){
						$(location).attr('href', base_url+'/users/error_gral');
					}

					if(data.rc== -22) {
					$("#dialog-clave-inv3").dialog({
						//title:"Error en campos",
						modal:"true",
						width:"440px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#invalido3").click(function(){
						$("#transpwd").val("");
						$("#dialog-clave-inv3").dialog("close");

					});

					};

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
