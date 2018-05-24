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
					"tokenValid":true,
				},
				"amount": {
					"required": true
				}
			},
			messages: {
				"password": {
					required: "La clave de acceso no puede estar vacia",
					tokenValid: "El código de seguridad no puede tener caracteres especiales",
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
						'clave': $("#password").val(),
				};

				var data_seralize = $.param(ajax_data);


				//petición de setAmount
				$.ajax({
					url: base_url + '/transferencia/peGeneral',
					type: "post",
					data: {data : data_seralize, model : "setAmount"},
					datatype: 'JSON',
					success: function(data) {

						switch (data.code) {
							case 0:
								notiSystem(data.title, data.msg, 'success', 'out');
							break;

							default:
								notiSystem(data.title, data.msg, 'error', 'out');
							break;

						}
					}
				});
				//fin de petición de montos
				return false;
			}
		});
	});

	//REALIZAR TRANSACCION---------------------------------------------------------------------------------

	$("#continuar").on("click", function() {});

});
