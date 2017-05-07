var path, base_cdn, moneda;
path =window.location.href.split( '/' );
base_cdn = path[0]+ "//" +path[2].replace('online','cdn')+'/'+path[3];
base_url = path[0]+ "//" +path[2] + "/" + path[3];

  $(function(){

    if ($('#dialog-temporal').length) {
      mensaje_temporal();
    }

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
    var $container = $('#dashboard');
    $container.isotope({
      itemSelector : '.dashboard-item',
      animationEngine :'jQuery',
      animationOptions: {
        duration: 800,
        easing: 'easeOutBack',
        queue: true
      }

    });

    // FUNCION PARA CONTAR LAS TARJETAS DEL CLIENTE
    contar_tarjetas();

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

  var d, fecha, hora, cantidad;

  d=new Date();
  fecha=d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear();
  hora=(d.getHours())+':'+d.getMinutes()+':'+d.getSeconds();

  $(".tiempo").html(fecha +" "+ hora);

  cantidad=contar_tarjetas();
  if(isNaN(cantidad)){
    $("#cantidad").html("<strong> -- Cuenta(s) </strong>");
  }
  else{
    $("#cantidad").html("<strong>" +cantidad+ " Cuenta(s) </strong>");
  }

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
    });

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

  $('.dashboard-item').click(function(){
    $('#numt').val($(this).attr('card'));
    $('#marca').val($(this).attr('marca'));
    $('#empresa').val($(this).attr('empresa'));
    $('#producto').val($(this).attr('producto'));
    $('#numt_mascara').val($(this).attr('numt_mascara'));
    $("#tarjeta").submit();
  });

  // FUNCION LLAMAR SALDO
  $.each($(".dashboard-item"),function(pos,item){
    $.post(base_url+"/dashboard/saldo",{"tarjeta":$(item).attr("card")},function(data){
      var moneda=$(".dashboard-item").attr("moneda");
      var id=$(".dashboard-item").attr("doc");
      var saldo=data.disponible;
      if (typeof saldo != 'string'){
        saldo="---";
      }

      $(item).find(".dashboard-item-balance").html(moneda+saldo);
    });
  });

  $('li.stack-item a').click(function(){
    $('#filters').find('.current-stack-item').removeClass('current-stack-item');
    $(this).parents('li').addClass('current-stack-item');
  });

  $("#dialog").click(function(){
    $("#content-product").dialog({
      width: "600px",
      modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      },
      open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
    });

  });

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

  function contar_tarjetas(){

    var contar;
    $.each($('.dashboard-item').children(), function(pos,item) {
      contar = pos;
    });
    return contar+1;
  } //FIN FUNCION CONTAR TARJETAS

    var pass = getVarsUrl()["ps%20"];

    if(pass==1){
      $(location).attr('href','users/cambiarPassword?t=n');
    }


function getVarsUrl(){
    var url= location.search.replace("?", "");
    var arrUrl = url.split("&");
    var urlObj={};
    for(var i=0; i<arrUrl.length; i++){
        var x= arrUrl[i].split("=%20");
        urlObj[x[0]]=x[1]
    }
    //console.log(urlObj);
    return urlObj;
}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

// MODAL TERMINOS Y CONDICIONES
    $(".label-inline").on("click", "a", function() {

    $("#dialog-tc").dialog({
      modal:"true",
      width:"940px",
      open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
    });

    $("#ok").click(function(){
      $("#dialog-tc").dialog("close");
    });

    });

  }); // FIN

function mensaje_temporal(){
  $('#dialog-temporal').dialog({
    modal: 'true',
    width: '550px',
    close: function(){$(this).dialog('destroy');},
    open: function(event, ui) {
      $('.ui-dialog-titlebar', ui.dialog).hide();
      $('.ui-dialog-titlebar-close', ui.dialog).hide();
    }
  });

  $('#close-button').click(function() {
    $('#dialog-temporal').dialog('close');
  });
}
