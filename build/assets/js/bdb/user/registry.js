'use strict';
document.addEventListener('DOMContentLoaded', function(){
	//vars
	var fase1 = document.getElementById("preRegistry");
	var fase2 = document.getElementById("postRegistry");

	//core
	document.getElementById('btnValidar').addEventListener('click',function(e){
		e.preventDefault();

		var form = $('#formVerifyAccount');
		validateForms(form, {handleMsg: false});
		if(form.valid()) {

			var document_id = document.getElementById('documentID').value;

			var data = {
				userName: document_id + '' + formatDate_ddmmy(new Date),
				id_ext_per: document_id,
				telephone_number: document.getElementById('telephoneNumber').value
			}

			callNovoCore('POST', 'User', 'registryValidation', data, function(response) {
				//TODO procesar response
				if (response.code == 0) {
					console.log(response.data);
					var  datosUsuario, primerNombre, segundoNombre, primerApellido, segundoApellido, telefono, id_ext_per,fechaNacimiento, tipo_id_ext_per, id_ext_emp, aplicaPerfil, isDriver;

					datosUsuario = response.data.dataUser.user
					primerNombre = datosUsuario.primerNombre;
					segundoNombre = datosUsuario.segundoNombre;
					primerApellido = datosUsuario.primerApellido;
					segundoApellido = datosUsuario.segundoApellido;
					telefono = datosUsuario.telefono;
					id_ext_per = datosUsuario.id_ext_per;
					fechaNacimiento = datosUsuario.fechaNacimiento;
					tipo_id_ext_per = datosUsuario.tipo_id_ext_per;
					id_ext_emp = datosUsuario.id_ext_emp;
					aplicaPerfil = datosUsuario.aplicaPerfil;
					isDriver = datosUsuario.isDriver;

					document.getElementById('idType').value = tipo_id_ext_per;
					document.getElementById('idNumber').value = id_ext_per;
					document.getElementById('firstName').value = primerNombre;
					document.getElementById('middleName').value = segundoNombre;
					document.getElementById('lastName').value = primerApellido;
					document.getElementById('secondSurname').value = segundoNombre;




					fase1.classList.toggle("none");
					fase2.classList.toggle("none");
				}
			});

		}else{
			console.log('form no valido');
		}
	});

	//functions
	function formatDate_ddmmy(dateToFormat)
	{
		var month = dateToFormat.getMonth();
		var day = dateToFormat.getDate().toString();
		var year = dateToFormat.getFullYear();

		year = year.toString().substr(-2);
		month = (month + 1).toString();

		if (month.length === 1)
		{
				month = '0' + month;
		}

		if (day.length === 1)
		{
				day = '0' + day;
		}
		return month + day + year;
	}

});



