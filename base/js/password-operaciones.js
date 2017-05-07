var path, base_cdn;
path =window.location.href.split( '/' ); 
base_cdn = path[0]+ "//" +path[2].replace('online','cdn')+'/'+path[3];
base_url = path[0]+ "//" +path[2] + "/" + path[3];

	$(function(){
		var max = 15;
			var old =$('#new-transpwd').val();
			var newC =$('#confirm-new-transpwd').val();
			//var cNewC = $('confirm-new-transpwd').val();
			
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
				// if((longitud==true)&& (mt==true) && (cap==true) && (car==true) &&  (cons==true) && (esp==true)){
		  //       	$('#continuar').removeClass('disabled-button');
		  //       }
				if( old=="" || newC==""){			
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
				if(newC != old){
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
				if((valor1==true) && (valor3==true)){
					$('#continuar').removeClass('disabled-button');
					
				passwordOperaciones=$("#new-transpwd").val();

				$.post(base_url +"/users/passwordOperaciones",{"passwordOperaciones":passwordOperaciones},function(data){  
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
    					header("Location: users/error");
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

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
// MODAL TERMINOS Y CONDICIONES
    $(".label-inline").on("click", "a", function() {               

    $("#dialog-tc").dialog({
      /**/
      modal:"true",
      width:"940px",
      open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
    });

    $("#ok").click(function(){ 
      $("#dialog-tc").dialog("close");
    });

    });


	});  //FIN DE LA FUNCION GENERAL 