var base_url, base_cdn;
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');

	$(function(){
		var max = 15;
			var old =$('#new-transpwd').val();
			var newC =$('#confirm-new-transpwd').val();

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
				old =$('#new-transpwd').val();
				newC =$('#confirm-new-transpwd').val();

				valor1=true;
				valor2=true;
				valor3=true;

				if( old=="" || newC==""){
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
				if(newC != old){
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
				if((valor1==true) && (valor3==true)){
					$('#continuar').removeClass('disabled-button');

				passwordOperaciones=novo_cryptoPass($("#new-transpwd").val());

				var cpo_cook = decodeURIComponent(
					document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
					);

				$.post(base_url +"/users/passwordOperaciones",{"passwordOperaciones":passwordOperaciones, "cpo_name": cpo_cook},function(data){
					if(data.rc == -61){
            			$(location).attr('href', base_url+'/users/error_gral');
        			}
				if(data.rc==0) {

					$("#content").children().remove();
					$("#content").append($("#confirmaCrear").removeAttr('style')).html();

		 			$("#continuar").click(function(){

		 				$(location).attr('href', base_url+'/dashboard');

					});
				}
				if(data.rc==-202){

						$("#content").children().remove();
						$("#content").append($("#sinExito").removeAttr('style')).html();

			 			$("#regresar").click(function(){

			 				$(location).attr('href', base_url+'/users/passwordOperaciones');

						});

					}
					else{
						$(location).attr('href', base_url + '/users/error_gral');
    				}

			});	//POST



		}
			});



// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	function validar_campos(){

	jQuery.validator.setDefaults({
 		debug: true,
 		success: "valid"
 	});

		$("#form-validar").validate({

			errorElement: "label",
			ignore: "",
			errorContainer: "#msg",
			errorClass: "field-error",
			validClass: "field-success",
			errorLabelContainer: "#msg",
			rules: {

				"transpwd": {"required":true},
				"confirm-transpwd": {"required":true, "equalTo":"#transpwd"}
			},

			messages: {

				"transpwd": "El campo Clave de Operaciones NO puede estar vacío, y debe contener la estructura recomendada",
				"confirm-transpwd": "El campo Confirmar Clave de Operaciones NO puede estar vacío, y debe ser igual a la Clave de Operaciones"

			}
		}); // VALIDATE


	}

	});  //FIN DE LA FUNCION GENERAL
