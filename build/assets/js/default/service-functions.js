//function for service option
function viewSelect (id) {
    var disable = $('#lock-acount select, #lock-acount input, #continuar'),
        clean = 'block',
        into,
        leave,
        conceal,
        display,
        action,
        formData = $('#bloqueo-cuenta');

    if (id == 'key') {
        disable = $("#change-key input, #change-key select, #continuar");
        formData = $('#cambio-pin');
        clean = 'change';
    }
    if(id == 'recover') {
        disable = $("#rec-key input, #continuar");
        formData = $('#recover-key');
        clean = 'rec';
    }
    if (viewControl != id) {
        disable.prop('disabled', false);
        resetForms(formData);
        cleanComplete(clean);
        $("#sendToken").remove()
    }
    viewControl = id;


    switch (id) {
        case 'lock':
            $('#msg-block h2').text(bloqAction + 'cuenta');
            into = $('#lock');
            leave = $('#key, #replace, #recover');
            conceal = $('#change-key, #reason-rep, #rec-key');
            display = $('#lock-acount, #prevent-bloq');
            $('#mot-sol').prop('disabled', true);
            action = 'lockAccoun';
            $('#action').text(bloqAction);
            break;
        case 'key':
            $('#msg-change h2').text('Cambio de PIN');
            into = $('#key');
            leave = $('#lock, #replace, #recover');
            conceal = $('#lock-acount, #rec-key');
            display = $('#change-key');
            action = 'changePin';
            break;
        case 'replace':
            $('#msg-block h2').text('Solicitud de reposición');
            into = $('#replace');
            leave = $('#lock, #key, #recover');
            conceal = $('#change-key, #prevent-bloq, #rec-key');
            display = $('#lock-acount, #reason-rep');
            action = 'lockReplace';
            break;
        case 'recover':
            $('#msg-rec h2').text('Solicitud de reposición de PIN');
            into = $('#recover');
            leave = $('#lock, #key, #replace');
            conceal = $('#lock-acount, #change-key, #reason-rep');
            display = $('#rec-key, #rec-clave');
            action = 'recoverKey';
            break;
    }

    into
        .removeClass('service-item-unselect')
        .addClass('service-item-select');
    leave
        .removeClass('service-item-select')
        .addClass('service-item-unselect');


    conceal.hide();
    display.show(950);

    $('#continuar').attr('data-action', action);
}

function lock_change (formData, model, form, action) {
    var msgMain = (model == 'LockAccount') ? 'block' : 'change';
		var token = 1;
    var msgSec = (model == 'LockAccount') ? 'lock-acount' : 'change-key';
		var costo_repo;
    if(action == 'recoverKey') {
        msgMain = 'rec';
        msgSec = 'recoverKey';
    }

		var cpo_cook = decodeURIComponent(
			document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);
			var dataRequest = JSON.stringify({
				formData,
				model: model,
			});
			dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

    $.ajax({
        url: base_url + '/servicios/modelo',
        type: 'POST',
        data: {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},
        datatype: 'JSON',
        beforeSend: function (xrh, status) {
            cleanBefore (msgMain, msgSec);
        },
        success: function (response) {
					data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))
            cleanComplete (msgMain);
            switch (data.code) {
                case 0:
                    notiSystem(data.title, data.msg, 'success', 'out', form);
                    break;
                case 1:
                    notiService (data.msg, 'msg-lock-error', 'msg-lock-success', msgMain);
                    (msgSec == 'lock-acount') ?
                        $("#lock-acount input, #lock-acount select, #continuar").prop('disabled', false) :
                        $("#change-key input, #change-key select, #continuar").prop('disabled', false);
                    (action == 'lockAccoun') ? $('#mot-sol').prop('disabled', true) : '';
                    break;
                case 2:
                    notiService (data.msg, 'msg-lock-error', 'msg-lock-success', msgMain);
                    (msgSec == 'lock-acount') ?
                        $("#lock-acount input, #lock-acount select, #continuar").prop('disabled', true) :
                        $("#change-key input, #change-key select, #continuar").prop('disabled', true);
                    break;
                case 3:
                    notiSystem(data.title, data.msg, 'warning', 'out', form);
                    break;
                case 4:
										//Verifica si la transacción tiene costo
										costo_repo = (typeof data.cost_repos_plas !== 'undefined' && data.cost_repos_plas !== '') ? data.cost_repos_plas : '';
                    viewToken(data.msg, msgMain, costo_repo, token);
                    break;
                case 5:
                    notiService (data.msg, 'msg-lock-error', 'msg-lock-success', 'block');
                    $('#msg-block div')
                        .html('Presione <strong>Aquí</strong> para recibir un nuevo código de seguridad')
                        .on('click', function() {
                            getToken(msgMain);
                            $('#msg-block div').unbind("click");
                        });
                    break;
								case 6:
										token = 0;//Operacion no requiere muestra token
											//Verifica si llega el costo
										costo = (typeof data.cost_repos_plas !== 'undefined' && data.cost_repos_plas !== '') ? data.cost_repos_plas : '';
                    viewToken(data.msg, msgMain, costo, token);
                    break;
                default:
                    notiSystem(data.title, data.msg, 'error', 'close', form);
            }
        },
        error: function (xrh, status, obj) {
            console.log(xrh);
            console.log(status);
            console.log(obj);
        }
    });
}

function getToken (msgMain) {
	var token = 1; //Requiere token 1, no requiere 0
		$('#carry').remove();

		var cpo_cook = decodeURIComponent(
			document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);
		var dataRequest = JSON.stringify({
			model: 'GetToken'
		});
		dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

    $.ajax({
        url: base_url + '/servicios/modelo',
        type: 'POST',
        data: {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},
        datatype: 'json',
        beforeSend: function (xrh, status) {
            cleanBefore ('block');
        },
        success: function (response) {
					data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))
            cleanComplete ('block');
            switch (data.code) {
                case 4:
                    viewToken (data.msg, msgMain, '', token);
                    break;
                case 5:
                    notiService (data.msg, 'msg-lock-error', 'msg-lock-success', 'block');
                    $('#msg-block div')
                        .html('Presione <strong>Aquí</strong> para recibir un nuevo código de seguridad')
                        .on('click', function () {
                            getToken(msgMain);
                            $('#msg-block div').unbind("click");
                        });
                    break;
                case 2:
                    notiSystem(data.title, data.msg, 'warning', 'out');
                    break;
                default:
                    notiSystem(data.title, data.msg, 'error', 'close');
            }
        },
        error: function (xrh, status, obj) {
            console.log(xrh);
            console.log(status);
            console.log(obj);
        }
    });
}

function cleanBefore (msgMain, msgSec) {
    (msgSec == 'lock-acount') ?
        $("#lock-acount input, #lock-acount select, #continuar").prop('disabled', true) :
        $("#change-key input, #change-key select, #continuar").prop('disabled', true);

    $('#msg-'+ msgMain).removeClass('msg-lock-error msg-lock-success');
    $('#msg-'+ msgMain +' #result-'+ msgMain)
        .html('')
        .append('<span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 50px;"></span>');
    $('#msg-'+ msgMain +' h3').text('Estamos procesando tu solicitud');
    $('#msg-'+ msgMain).show();
}

function cleanComplete (msgMain) {
    $('#msg-'+ msgMain +' h3').text('');
    $('#msg-'+ msgMain +' #result-'+ msgMain).html('');
}

//función para enviar mensjes del servicio al usuario
function notiService (msg, NewClass, oldClass, msgMain) {
    resetForms();//reset de los formularios
    $('#msg-' + msgMain)
        .removeClass(oldClass)
        .addClass(NewClass);
    $('#msg-'+ msgMain +' > h3').html(msg);
}

//Función para enviar mensajes del sistema al usuario
function notiSystem (title, message, type, action, param) {
	var id = (param === 'lock' || param === 'key' || param === 'replace' || param === 'recover') ? param : null,
	form = (param != 'lock' && param != 'key' && param != 'replace' && param != 'recover') ? param : null;

    resetForms(form);//reset de los formularios
    var icon =  (type == 'warning') ? 'warning' :
            (type == 'error') ? 'cancel' : 'ok',
        msgSystem = $('#msg_system');

    msgSystem.dialog({
        title: title,
        modal: 'true',
        width: '440px',
        draggable: false,
        rezise: false,
        open: function(event, ui) {
            $('.ui-dialog-titlebar-close', ui.dialog).hide();
            if (action == 'carry') {

							$('#form-action').append('<button id="carry" class="novo-btn-primary">Si</button>');

								$('#close-info').addClass('novo-btn-secondary-modal');
								$('#carry').focus();
                $('#close-info')
                    .text('No')
                    .attr('type', 'reset');
            } else {
                $('#close-info')
                    .text('Cerrar')
                    .removeAttr('type');
            }
            $('#msg_info p').empty().append(message);
        }
    });
    $('#close-info').on('click', function(e){
        e.preventDefault();
        $('#msg_system').dialog('close');
        switch (action) {
            case 'out':
                $(location).attr('href',base_url+'/servicios');
                break;
            case 'close':
                $(location).attr('href',base_url+'/cerrar-sesion');
                break;
        }
        $('#carry').remove();
    });
    $('#carry').on('click', function (e) {
        e.preventDefault();
        $('#msg_system').dialog('close');
        viewSelect(id);
        $('#carry').remove();
    });
};

//costoReposicion: Vector si no es vacio muestra al usuario el valor de la operación
function viewToken (msg, msgMain, costoReposicion, token) {

		var sendToken = "";
    notiService (msg, 'msg-lock-success', 'msg-lock-error', msgMain);
    (msgMain == 'block') ?
        $("#lock-acount input, #lock-acount select, #continuar")
            .not('#mes-exp-bloq, #anio-exp-bloq, #mot-sol')
            .prop('disabled', false) :
        $("#change-key input, #change-key select, #continuar")
            .not('#mes-exp-cambio, #anio-exp-cambio, #pin-current, #new-pin, #confirm-pin')
            .prop('disabled', false);

		if(token === 1)//Verifica si tiene que mostrar el token
		{
	    sendToken += '<li id="sendToken" class="col-md-3-profile">';
	    sendToken+= '<label for="token">Código de seguridad</label>';
	    sendToken+= '<input class="field-medium" id="token" name="token" type="text">';
	    sendToken+= '</li>';
		}

		//Si tiene costo se define y muestra al usuario
		if(costoReposicion !== ''){
			$("#montoComisionTransaccion").val(costoReposicion);
			sendToken += '<table class="receipt" cellspacing="0" cellpadding="0"><tr><td class="data-metadata">Comisión/Pago (S/. ' + costoReposicion + ') <br><span class="money-amount">S/. ' + costoReposicion + '</span></td></tr></table>';
		}

    $('#'+ msgMain +'-ul').append(sendToken);
}

function validar_campos() {

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

    jQuery.validator.addMethod("pinNew1", function(value,element){
        if(element.value.length>0 && element.value == $("#new-pin").val())
            return true;
        else return false;
    }, "Debe ser igual al nuevo PIN");

    jQuery.validator.addMethod("pinNew2", function(value, element) {
        if(element.value.length>0 && element.value == $("#pin-current").val())
            return false;
        else return true;
    }, "El nuevo PIN no debe ser igual a su PIN anterior");

    $("#bloqueo-cuenta").validate({

        errorElement: "label",
        ignore: "",
        errorContainer: "#msg1",
        errorClass: "field-error",
        validClass: "field-success",
        errorLabelContainer: "#msg1",
        rules: {
            "token": {"required":true, "tokenValid": true},
            "mot-sol": {"required":true}
        },
        messages: {
            "token": {
                required:"Debe colocar su código de seguridad",
                tokenValid: "El código de seguridad no debe tener caracteres especiales"
            },
            "mot-sol": "Debe seleccionar el motivo de la reposición"
        }
    }); // VALIDATE

    $("#cambio-pin").validate({

        errorElement: "label",
        ignore: "",
        errorContainer: "#msg2",
        errorClass: "field-error",
        validClass: "field-success",
        errorLabelContainer: "#msg2",
        rules: {
            "token": {"required": true, "tokenValid": true},
            "pin-current": {"required":true, "number":true, "minlength": 4},
            "new-pin": {"number":true,  "pinNew2":true, "required":true, "minlength": 4},
            "confirm-pin": {"number":true, "pinNew1":true}
        },

        messages: {
            "token": {
                required:"Debe colocar su código de seguridad",
                tokenValid: "El código de seguridad no debe tener caracteres especiales"
            },
            "pin-current":{
                required:"Debe colocar su PIN actual",
								number:"Debe ser numérico",
								minlength: "El PIN debe tener 4 digitos"
            },
            "new-pin": {
                number:"Su nuevo PIN debe ser numérico",
                pinNew2:"El nuevo PIN no debe ser igual a su PIN anterior",
                required:"Debe colocar su nuevo PIN",
								minlength: "El nuevo PIN debe tener 4 digitos"
            },
            "confirm-pin": {
                number:"La confirmación de su nuevo PIN debe ser numérico",
                pinNew1:"Debe ser igual a su nuevo PIN"
            }
        }
    }); // VALIDATE

    $("#recover-key").validate({
        errorElement: "label",
        ignore: "",
        errorContainer: "",
        errorClass: "field-error",
        validClass: "field-success",
        errorLabelContainer: ""
    }); // VALIDATE
}

//RESETEAR LOS FORMULARIOS
function resetForms(formData){
    (formData)?formData[0].reset(): '';
    $('#msg1, #msg2').children().remove();
    $('#bloqueo-cuenta *, #cambio-pin *').children().removeClass('field-success field-error');
}
