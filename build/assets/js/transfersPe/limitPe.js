$(function() {
	operationType = 'P2P';

	$("#updateAmount").on('click', function() {

		$("#form-amount").validate({
			errorElement: "label",
			ignore: "",
			errorContainer: "#msg-history",
			errorClass: "field-error",
			validClass: "field-success",
			errorLabelContainer: "#msg-history",
			rules: {
				"password": {
					"required": true
				},
				"amount": {
					"required": true
				}
			},
			messages: {
				"password": {
					required: "La clave de acceso no puede estar vacia"
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
					'monto':  $('select[name="amount"] option:selected').attr('monto')
				};

				//petición de setAmount
				$.ajax({
					url: base_url + '/limit/setAmount',
					type: "post",
					data: ajax_data,
					dataType: 'json',
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
