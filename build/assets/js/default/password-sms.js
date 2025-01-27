var base_url, base_cdn;
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');

	$(function(){
		  var max = 4;
      var telefono = getVarsUrl()["num%20"];
      var estatus = getVarsUrl()["disponeClaveSMS%20"];
      var pais = getVarsUrl()["acCodPais%20"];
      var id_ext_per = getVarsUrl()["id_ext_per%20"];

             cadena = "<form accept-charset='utf-8' method='post' id='form-validar'>" ;
             cadena+= "<fieldset class='fieldset-column-center'>";
             cadena+=     "<div class='field-meter' id='password-strength-meter'>";
             cadena+=       "<h4>Requerimientos de contraseña:</h4>";
             cadena+=       "<ul class='pwd-rules'>";
             cadena+=                   "<li id='consecutivo' class='pwd-rules-item rule-invalid'>• Debe tener <strong>4 números</strong></li>";
             cadena+=       "</ul>";
             cadena+=     "</div>";
             cadena+=     "<label>Número de teléfono</label>";
             cadena+=     "<input class='field-medium' maxlength='15' id='num_tlf' name='num_tlf' value="+telefono+" disabled/>";
             cadena+=     "<label for='userpwd'>Clave SMS</label>";
             cadena+=     "<input class='field-medium' maxlength='4' id='userpwd' name='userpwd' type='password' />";
             cadena+=     "<label for='confirm-userpwd'>Confirmación</label>";
             cadena+=     "<input class='field-medium' maxlength='4' id='confirm-userpwd' name='confirm-userpwd' type='password'/>";
             cadena+=   "</fieldset>";
             cadena+=   "</form>";

            confirmacion=  "<div class='form-actions'>";
            confirmacion+=    "<button id='eliminar' type='reset' class='novo-btn-secondary'>Eliminar</button>";
            confirmacion+=    "<button id='actualizar' class='novo-btn-primary'>Actualizar</button>";
            confirmacion+=  "</div>";


            confirmacion1=  "<div class='form-actions'>";
            confirmacion1+=    "<button id='volver' type='reset' class='novo-btn-secondary'>Volver</button>";
            confirmacion1+=    "<button id='afiliar' class='novo-btn-primary'>Afiliar</button>";
            confirmacion1+=  "</div>";


      $("#content-pass").append(cadena).html();

      if(estatus==1){
        $("#content-pass").append(confirmacion).html();
      }
      else if(estatus==0){
        $("#content-pass").append(confirmacion1).html();
      }

$("#volver").click(function(){
   $(location).attr('href', base_url+'/perfil');
});


$("#actualizar").click(function(){

    validar_campos();

    $("#form-validar").submit();
    setTimeout(function(){$("#msg").fadeOut();},5000);

    var form=$("#form-validar");


    if(form.valid() == true) {

      $('#consecutivo').removeClass('rule-invalid').addClass('rule-valid');

      var claveSMS = $('#userpwd').val();

      $("#actualizar").removeClass("disabled-button");

			var dataRequest = JSON.stringify ({
				id_ext_per:id_ext_per,
				claveSMS:novo_cryptoPass(claveSMS),
				nroMovil:telefono
			});

			dataRequest = novo_cryptoPass(dataRequest, true);

       $.post(base_url +"/users/passwordSmsActualizar",{request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},function(response){

				data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {
					format: CryptoJSAesJson
				}).toString(CryptoJS.enc.Utf8));

        if(data.rc==0) {

          $("#content-pass").children().remove();
          $("#content-pass").append($("#confirmaActualizar").removeAttr('style')).html();

          $("#confirmar").click(function(){

            $(location).attr('href', base_url+'/dashboard');

          });
        }
        if(data.rc==-217){

            $("#content-pass").children().remove();
            $("#content-pass").append($("#sinExito").removeAttr('style')).html();

            $("#regresar").click(function(){

              $(location).attr('href', base_url+'/perfil');

            });

        }
        if(data.rc==-215){

            $("#content-pass").children().remove();
            $("#content-pass").append($("#sinExito2").removeAttr('style')).html();

            $("#regresar2").click(function(){

              $(location).attr('href', base_url+'/perfil');

            });

          }


    }); //POST

    }
});

$("#eliminar").click(function(){
			var claveSMS = "";
			var cpo_cook = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
				);
      $.post(base_url +"/users/passwordSmsEliminar",{"id_ext_per":id_ext_per,"claveSMS":claveSMS,"nroMovil":telefono, "cpo_name": cpo_cook},function(data){

        if(data.rc==0) {

          $("#content-pass").children().remove();
          $("#content-pass").append($("#confirmaEliminar").removeAttr('style')).html();

          $("#confirmar-eliminar").click(function(){

            $(location).attr('href', base_url+'/dashboard');

          });
        }
        if(data.rc == -61){
              $(location).attr('href', base_url+'/users/error_gral');
          }
        if(data.rc==-214){

            $("#content-pass").children().remove();
            $("#content-pass").append($("#sinExito3").removeAttr('style')).html();

            $("#regresar3").click(function(){

              $(location).attr('href', base_url+'/perfil');

            });

        }
         if(data.rc==-218){

            $("#content-pass").children().remove();
            $("#content-pass").append($("#sinExito4").removeAttr('style')).html();

            $("#regresar4").click(function(){

              $(location).attr('href', base_url+'/perfil');

            });

        }
        if(data.rc==-215){

            $("#content-pass").children().remove();
            $("#content-pass").append($("#sinExito2").removeAttr('style')).html();

            $("#regresar2").click(function(){

              $(location).attr('href', base_url+'/perfil');

            });

          }


    }); //POST


});
$("#afiliar").click(function(){
      validar_campos();

    $("#form-validar").submit();
    setTimeout(function(){$("#msg").fadeOut();},5000);

    var form=$("#form-validar");


    if(form.valid() == true) {

      $('#consecutivo').removeClass('rule-invalid').addClass('rule-valid');

      var claveSMS =$('#userpwd').val();

      $("#actualizar").removeClass("disabled-button");

			var dataRequest = JSON.stringify ({
				id_ext_per:id_ext_per,
				claveSMS:novo_cryptoPass(claveSMS),
				nroMovil:telefono
			});

			dataRequest = novo_cryptoPass(dataRequest, true);

			$.post(base_url +"/users/passwordSmsNew",{request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},function(response){

				data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));

        if(data.rc==0) {

          $("#content-pass").children().remove();
          $("#content-pass").append($("#confirmaCrear").removeAttr('style')).html();

          $("#continuar").click(function(){

            $(location).attr('href', base_url+'/dashboard');

          });
        }
        if(data.rc == -61){
              $(location).attr('href', base_url+'/users/error_gral');
          }
        if(data.rc==-213){

            $("#content-pass").children().remove();
            $("#content-pass").append($("#sinExito5").removeAttr('style')).html();

            $("#regresar5").click(function(){

              $(location).attr('href', base_url+'/perfil');

            });

        }
         if(data.rc==-216){

            $("#content-pass").children().remove();
            $("#content-pass").append($("#sinExito6").removeAttr('style')).html();

            $("#regresar6").click(function(){

              $(location).attr('href', base_url+'/perfil');

            });

        }
        if(data.rc==-215){

            $("#content-pass").children().remove();
            $("#content-pass").append($("#sinExito2").removeAttr('style')).html();

            $("#regresar2").click(function(){

              $(location).attr('href', base_url+'/perfil');

            });

          }
        if(data.rc==-20){

            $("#content-pass").children().remove();
            $("#content-pass").append($("#sinExito7").removeAttr('style')).html();

            $("#regresar7").click(function(){

              $(location).attr('href', base_url+'/perfil');

            });

          }


    }); //POST

    }
});


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
        "userpwd": {"required":true, "number": true},
        "confirm-userpwd":{"required":true,"number":true,"minlength":4, "maxlength": 4, "equalTo":"#userpwd"},
      },

      messages: {
        "userpwd": "El campo Clave SMS no puede estar vacío y debe contener 4 números",
        "confirm-userpwd": "El campo Confirmación no puede estar vacío, debe contener 4 números y coincidir con el campo Clave SMS",
      }
    }); // VALIDATE

  }



function getVarsUrl(){
    var url= location.search.replace("?", "");
    var arrUrl = url.split("&");
    var urlObj={};
    for(var i=0; i<arrUrl.length; i++){
        var x= arrUrl[i].split("=%20");
        urlObj[x[0]]=x[1]
    }
    return urlObj;
}

	});  //FIN DE LA FUNCION GENERAL
