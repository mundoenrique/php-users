$(function() {
	operationType = 'P2P';

	$("#updateAmount").on('click', function() {

		jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });

    jQuery.validator.addMethod("tokenValid", function(value, element) {
        var regEx = /^[a-zA-Z0-9]+$/,
            token = element.value;

        if (regEx.test(token)) {
            return true;
        } else {
            return false;
        }
    });

		$("#form-amount").validate({
			errorElement: "label",
			ignore: "",
			errorContainer: "#msg-history",
			errorClass: "field-error",
			validClass: "field-success",
			errorLabelContainer: "#msg-history",
			rules: {
				"password": {
					"required": true,
				},
				"amount": {
					"required": true
				}
			},
			messages: {
				"password": {
					required: "La clave de acceso no puede estar vacia",
				},
				"amount": {
					required: "Debe seleccionar un monto base"
				}
			},
			//Al subir el formualrio con los datos completos
			submitHandler: function(form) {
			//data de envio
				var ajax_data = {
						'codigo': $("#amount").val(),
						'monto':  $('select[name="amount"] option:selected').attr('monto'),
						'clave': hex_md5($("#password").val()),
				};

				var data_seralize = $.param(ajax_data);


				//petición de setAmount
				var cpo_cook = decodeURIComponent(
					document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
				);

				var dataRequest = JSON.stringify ({
					data: data_seralize,
					model: "setAmount"
				});

				dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();


				$.ajax({
					url: base_url + '/transferencia/peGeneral',
					type: "post",
					data: {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},
					datatype: 'JSON',
					success: function(response) {
						data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
						switch (data.code) {
							case 0:
								msgService(data.title, data.msg, data.modalType, 1);
								break;

							case 2:
								$(location).attr('href', base_url + '/users/error_gral');
								break;

							default:
								msgService(data.title, data.msg, data.modalType, 1);
							break;
						}
					}
				});
				//fin de petición de montos
				return false;
			},
		});
	});
});
