var base_url, base_cdn;
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');

	$(function(){
	$('input[type=text], input[type=password], input[type=textarea]').attr('autocomplete','off');

	$("#continuar").click(function(){

    $("#loading").show();
    $("button").attr("disabled",true);

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

			var cpo_cook = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
				);

				var dataRequest = JSON.stringify ({
					id_ext_per:id_ext_per,
					email:email
					});

					dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

					$.post(base_url+"/users/resetpassword", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},function(response){

						data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))

				if(data.rc==0) {

					$("#content").children().remove();
					$("#content").append($("#confirmacion").removeAttr('style')).html();

				}else if(data.rc == -61){
          $(location).attr('href', base_url+'/users/error_gral');

        }else if(data.rc==-186){

					$("#dialog-login-error").dialog({
						title:"Datos Erróneos",
						modal:"true",
						width:"400px",
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
					});

					$("#invalido").click(function(){
						$("#dialog-login-error").dialog("close");
					});
				}else{
					location.assign("/personas");
    		}

        $("#loading").hide();
        $("button").attr("disabled",false);

			});	//POST

		}else{

        $("#loading").hide();
        $("button").attr("disabled",false);
    }     //FORM VALID

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
				"card-holder-id": {"required":true,"number":true},
			},

			messages: {

				"email": "El correo electrónico no puede estar vacío y debe contener formato correcto. (xxxxx@ejemplo.com)",
				"card-holder-id": "Debe introducir su número de identidad"
			}
		}); // VALIDATE


	}

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
