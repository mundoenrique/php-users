var path, base_cdn;
path =window.location.href.split( '/' ); 
base_cdn = path[0]+ "//" +path[2].replace('online','cdn')+'/'+path[3];
base_url = path[0]+ "//" +path[2] + "/" + path[3];

	$(function(){


	$("#continuar").click(function(){ 
    $("#continuar").attr('disabled',true );
    $("#loading").show();

		validar_campos();
		
		$("#form-validar").submit();
		setTimeout(function(){$("#msg").fadeOut();},5000);

		var form=$("#form-validar");

		if(form.valid() == true) { 

			var email, id_ext_per;
			
			id_ext_per=$("#card-holder-id").val();
			email=$("#email").val();

			id_ext_per = Base64.encode(id_ext_per);
			email = Base64.encode(email);

			$.post(base_url +"/users/obtenerlogin_call",{"id_ext_per":id_ext_per, "email":email},function(data){  
        if(data.rc == -61){
              $(location).attr('href', base_url+'/users/error_gral');
          }
				if(data.rc==0) {
					$("#content").children().remove();
					$("#content").append($("#confirmacion").removeAttr('style')).html();
          $("#continuar").attr('disabled',false );
          $("#loading").hide();
				}
				else if(data.rc==-187){
					$("#dialog-login-error").dialog({
						title:"Datos Erróneos",
						modal:"true",
						width:"400px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					}); 

					$("#invalido").click(function(){
						$("#dialog-login-error").dialog("close"); 
					});
            $("#continuar").attr('disabled',false );
            $("#loading").hide();
				}
				else{
					location.assign("/personas");
    			}

			});	//POST

		} else {
      $("#continuar").attr('disabled',false );
      $("#loading").hide();
    }	//FORM VALID

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
				
				"email": {"required":true, "email": true},
				"card-holder-id": {"required":true,"number":true},    //{"required":true,"number":true}
			},

			messages: {
				
				"email": "El correo electrónico NO puede estar vacío y debe contener formato correcto. (xxxxx@ejemplo.com)",
				"card-holder-id": "Debe introducir su número de identidad"
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

/*BASE 64*/
 
var Base64 = { 
  // private property
  _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
 
  // public method for encoding
  encode : function (input) {
    var output = "";
    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
    var i = 0;
 
    input = Base64._utf8_encode(input);
 
    while (i < input.length) {
      chr1 = input.charCodeAt(i++);
      chr2 = input.charCodeAt(i++);
      chr3 = input.charCodeAt(i++);
 
      enc1 = chr1 >> 2;
      enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
      enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
      enc4 = chr3 & 63;
 
      if (isNaN(chr2)) {
        enc3 = enc4 = 64;
      } else if (isNaN(chr3)) {
        enc4 = 64;
      }
 
      output = output +
      this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
      this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
    }
 
    return output;
  },
 


  // private method for UTF-8 encoding
  _utf8_encode : function (string) {
    string = string.replace(/\r\n/g,"\n");
    var utftext = "";
 
    for (var n = 0; n < string.length; n++) {
      var c = string.charCodeAt(n);
 
      if (c < 128) {
        utftext += String.fromCharCode(c);
      }
      else if((c > 127) && (c < 2048)) {
        utftext += String.fromCharCode((c >> 6) | 192);
        utftext += String.fromCharCode((c & 63) | 128);
      }
      else {
        utftext += String.fromCharCode((c >> 12) | 224);
        utftext += String.fromCharCode(((c >> 6) & 63) | 128);
        utftext += String.fromCharCode((c & 63) | 128);
      }
    }
 
    return utftext;
  },

}

});  //FIN DE LA FUNCION GENERAL 