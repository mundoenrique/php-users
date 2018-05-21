//Función para enviar mensajes del sistema al usuario
function notiSystem (title, message, type, action) {

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
                $('#form-action').append('<button id="carry">Si</button>');
                $('#carry').focus();
                $('#close-info')
                    .text('No')
                    .attr('type', 'reset');
            } else {
                $('#close-info')
                    .text('Cerrar')
                    .removeAttr('type');
            }
            $('#msg_info')
                .removeAttr('class')
                .addClass('alert-simple alert-' + type);
            $('#msg_info span')
                .removeAttr('class')
                .addClass('icon-' + icon + '-sign');
            $('#msg_info p').empty().append(message);
        }
    });
    $('#close-info').on('click', function(e){
        e.preventDefault();
        $('#msg_system').dialog('close');
        switch (action) {
            case 'out':
                $(location).attr('href',base_url+'/limit/pe');
                break;
            case 'close':
                $(location).attr('href',base_url+'/limit/pe');
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
