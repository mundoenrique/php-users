var path = window.location.href.split( '/' ),
    base_cdn,
    base_url,
    viewControl = '',
    bloqAction,
    moneda,
    pais;

base_cdn = path[0]+ "//" +path[2].replace('online','cdn')+'/'+path[3];
base_url = path[0]+ "//" +path[2] + "/" + path[3];

$(function(){

    // MENU WIDGET TRANSFERENCIAS
    $('.transfers').hover(function(){
        $('.submenu-transfer').attr("style","display:block")
    },function(){
      $('.submenu-transfer').attr("style","display:none")
    });

    // MENU WIDGET USUARIO
    $('.user').hover(function(){
        $('.submenu-user').attr("style","display:block")
    },function(){
        $('.submenu-user').attr("style","display:none")
    });

    $(".label-inline").on("click", "a", function() {

    $("#dialog-tc").dialog({
      dialogClass: "cond-serv",
      modal:"true",
      width:"940px",
      draggable:false,
      open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
    });
    $(".cond-serv").css("top","50px");
    $("#ok").click(function(){
      $("#dialog-tc").dialog("close");
    });

    });


// -------------------------------------------------------------------------------------------------------------------------------------------------------------------
// CARGA MODAL CTA ORIGEN
    $(".dialog").click(function() {

        $("#content-product").dialog({
            title:"Selección de Cuentas",
            modal:"true",
            width:"940px",
            open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
        });
        $("#cerrar").click(function(){
            $("#content-product").dialog("close");
        });

        var $container = $('#dashboard-donor');        // INICIA CONFIGURACION DEL FILTRO TEBCA - SERVITEBCA

        $container.isotope({
            itemSelector : '.dashboard-item',
            animationEngine :'jQuery',
            animationOptions: {
                duration: 800,
                easing: 'easeOutBack',
                queue: true
            }
        });

        var $optionSets = $('#filters-stack .option-set'),
            $optionLinks = $optionSets.find('a');

        $optionLinks.click(function(){
            var $this = $(this);
            // don't proceed if already selected
            if ( $this.hasClass('selected') ) {
                return false;
            }
            var $optionSet = $this.parents('.option-set');
            $optionSet.find('.selected').removeClass('selected');
            $this.addClass('selected');

            // make option object dynamically, i.e. { filter: '.my-filter-class' }
            var options = {},
                key = $optionSet.attr('data-option-key'),
                value = $this.attr('data-option-value');
            // parse 'false' as false boolean
            value = value === 'false' ? false : value;
            options[ key ] = value;
            if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
                // changes in layout modes need extra logic
                changeLayoutMode( $this, options )
            } else {
                // otherwise, apply new options
                $container.isotope( options );
            }

            return false;
        });          // FINALIZA CONFIGURACION DE FILTROS
    });		 // FIN DE CARGA MODAL CTAS ORIGEN
// -------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FUNCION PARA OBTENER DATOS DE TARJETA CUENTA ORIGEN
    $(".dashboard-item").click(function() {

        var imagen = $(this).find('img').attr('src'),
            tarjeta = $(this).attr('card'),
            marca = $(this).attr('marca').toLowerCase(),
            mascara = $(this).attr('mascara'),
            producto = $(this).attr('producto1'),
            empresa = $(this).attr('empresa'),
            nombre = $(this).attr('nombre'),
            moneda = $(this).attr("moneda"),
            prefix = $(this).attr("prefix"),
            bloqueo = $(this).attr("bloqueo"),
            condition = $(this).attr("condition"),
            fe = $(this).attr("fe"),
            bloqHtml =  true,
            icon,
            options = '<p class="field-tip" style="margin-left: 10px;">Indique la operación que desea realizar</p>',
            cadena;
        pais  = $(this).attr("pais");
        options = (pais == 'Ve') ? 'Para reponer su PIN presione sobre Reposición de PIN' : options;
        var intoReplace = (condition == 0 && pais != 'Ve') ? '<li id="replace" class="service-item-unselect"><span class="icon-spinner services-item"></span>Solicitud <br>de reposición</span></li>' : '';


        options+= '<ul class="product-balance-group services-content">';
        switch  (bloqueo) {
            case 'N':
                if(pais == 'Ve'){
                    break;
                }
                bloqAction = 'Bloquear ';
                icon = 'lock';
                options+= '<li id="lock" class="service-item-unselect"><span class="icon-' + icon +' services-item"></span>Bloquear <br>cuenta</li>';
                options+= '<li id="key" class="service-item-unselect"><span class="icon-key services-item"></span>Cambio <br>de PIN</span></li>';
                break;
            case 'PB':
                if(pais == 'Ve'){
                    break;
                }
                bloqAction = 'Desbloquear ';
                icon = 'unlock';
                options+= '<li id="lock" class="service-item-unselect"><span class="icon-' + icon +' services-item"></span>Desbloquear <br>cuenta</li>';
                break;
            default:
                bloqHtml = false;


        }
        if(pais == 'Ve') {
            options+= '<li id="recover" class="service-item-unselect"><span class="icon-key services-item"></span>Reposición <br>de PIN</span></li>';
        }
        options+= intoReplace;
        options+= '</ul>';

        if (bloqHtml == true) {
            $("#donor").children().remove();

            cadena= '<div class="product-presentation" producto="'+producto+'">';
            cadena+=	'<img src="'+imagen+'" width="200" height="130" alt="" />';
            cadena+=	'<div class="product-network '+marca+'"></div>';
            cadena+=	    '<input id="donor-cardnumber-origen" name="donor-cardnumber" type="hidden" prefix="'+prefix+'" cardOrigen="'+tarjeta+'" stat-bloq="'+bloqueo+'" fe="'+fe+'"/>';
            cadena+= '</div>';
            cadena+= '<div class="product-info">';
            cadena+=    '<p class="product-cardholder" id="nombreCtaOrigen">'+nombre+'</p>';
            cadena+=	'<p class="product-cardnumber">'+mascara+'</p>';
            cadena+=	'<p class="product-metadata">'+producto+'</p>';
            cadena+=	'<nav class="product-stack">';
            cadena+=	    '<ul class="stack">';
            cadena+=	        '<li class="stack-item">';
            cadena+=		        '<a dialog button product-button rel="section" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit"></span></a>';
            cadena+=		    '</li>';
            cadena+=	    '</ul>';
            cadena+=	'</nav>';
            cadena+= '</div>';
            cadena+= '<div class="product-scheme">';
            cadena+=    options;
            cadena+= '</div>';

            // MOSTRAR DATOS DE LA CUENTA EN LA VISTA PRINCIPAL
            $("#donor").append(cadena);
        } else {
            notiSystem('Servicios', 'No es posible realizar esta acción, la tarjeta se encuentra bloqueada permanentemente', 'warning').delay(10);
        }

        $("#content-product").dialog("close");

        //FUNCION PARA MODIFICAR LA CUENTA
        $('.stack-item').click(function() {
            viewControl = '';
            $('#lock-acount').hide();
            $('#change-key').hide();
            $('#rec-key').hide();
            $('#tdestino').children().remove();
            $("#tdestino").append($("#removerDestino").html());
            $("#continuar").prop("disabled",true);
            $("#content-product").dialog({
                title:"Modificación de Cuentas",
                modal:"true",
                width:"940px",
                open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
            });
        });

    });

    // --------------------------------------------------------------------------------------------------------------------------------------------------------------
    $('#donor').on('click', '#lock, #key, #replace, #recover', function(e) {
        var thisId = e.target.id,
            parentId = e.target.parentNode.id,
            id;

        id = (thisId) ? thisId : parentId;

        switch (id) {
            case 'lock':
                (viewControl != id && viewControl != '') ? notiSystem(bloqAction + 'cuenta', '¿Realmente desea realizar esta acción?', 'warning', 'carry', id): viewSelect(id);
                break;
            case 'key':
                (viewControl != id && viewControl != '') ? notiSystem('Cambio de PIN', '¿Realmente desea realizar esta acción?', 'warning', 'carry', id): viewSelect(id);
                break;
            case 'replace':
                (viewControl != id && viewControl != '') ? notiSystem('Reposición de tarjeta', '¿Realmente desea realizar esta acción?', 'warning', 'carry', id): viewSelect(id);
                break;
            case 'recover':
                (viewControl != id && viewControl != '') ? notiSystem('Recuperar cuenta', '¿Realmente desea realizar esta acción?', 'warning', 'carry', id): viewSelect(id);
                break;
        }

    });

    // ------------------------------------------------------- BOTON CONTINUAR -------------------------------------------------------------------------------------
    $('#continuar').on('click', function() {
        var action = $('#continuar').attr('data-action'),
            fe = $('#donor-cardnumber-origen').attr('fe'),
            cardAction = $('#donor-cardnumber-origen').attr('cardorigen'),
            bloqueo,
            prefix = $('#donor-cardnumber-origen').attr('prefix'),
            form,
            formData,
            pinCurrent,
            pinNew,
            reasonRep,
            model;
        if (action != 'changePin') {

            bloqueo = $('#donor-cardnumber-origen').attr('stat-bloq');
            form = $("#bloqueo-cuenta");

            $('#fecha-exp-bloq').val(fe);
            $('#card-bloq').val(cardAction);
            $('#status').val(bloqueo);
            $('#prefix-bloq').val(prefix);
        }

        switch (action) {
            case 'lockAccoun':
                $('#lock-type').val('temporary');
                $('#prevent-bloq').hide();
                model = 'LockAccount';
                break;
            case 'changePin':
                pinCurrent = $('#pin-current').val();
                pinNew = $('#new-pin').val();

                $('#fecha-exp-cambio').val(fe);
                $('#card-cambio').val(cardAction);
                $('#pin-current-now').val(pinCurrent);
                $('#new-pin-now').val(pinNew);
                $('#prefix-cambio').val(prefix);
                form = $("#cambio-pin");
                model = 'changePin';
                break;
            case 'lockReplace':
                $('#lock-type').val('final');
                reasonRep = $('#mot-sol').val();

                $('#mot-sol-now').val(reasonRep);
                model = 'LockAccount';
                break;
            case 'recoverKey':
                $('#rec-clave').hide();
                $('#fecha-exp-rec').val(fe);
                $('#card-rec').val(cardAction);
                $('#prefix-rec').val(prefix);
                form = $('#recover-key');
                model = 'recoverKey';
                break;
        }
        validar_campos();
        form.submit();
        if (form.valid() == true) {
            formData = form.serialize();
            lock_change (formData, model, form, action);
        }
    });
});  //FIN DE LA FUNCION GENERAL
