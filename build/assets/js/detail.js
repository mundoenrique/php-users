var reporte;

$(function(){
  var nombreMes = new Array ('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

 if ($('#filter-month').val() == "0") {
    $("#period").text("reciente");
  }

//PERIOD SPAN TITLE
$('#buscar').on('click',function(){

  if ($('#filter-month').val() == "0") {
    $("#period").text("Reciente");
  }else if ($('#filter-month').val() == "1") {
    $("#period").text("de Enero"  + " " + $("#filter-year").val());
  }else if ($('#filter-month').val() == "2") {
    $("#period").text("de Febrero" + " " + $("#filter-year").val());
  }else if ($('#filter-month').val() == "3") {
    $("#period").text("de Marzo"  + " " + $("#filter-year").val());
  }else if ($('#filter-month').val() == "4") {
    $("#period").text("de Abril"  + " " + $("#filter-year").val());
  }else if ($('#filter-month').val() == "5") {
    $("#period").text("de Mayo"  + " " + $("#filter-year").val());
  }else if ($('#filter-month').val() == "6") {
    $("#period").text("de Junio"  + " " + $("#filter-year").val());
  }else if ($('#filter-month').val() == "7") {
    $("#period").text("de Julio"  + " " + $("#filter-year").val());
  }else if ($('#filter-month').val() == "8") {
    $("#period").text("de Agosto"  + " " + $("#filter-year").val());
  }else if ($('#filter-month').val() == "9") {
    $("#period").text("de Septiembre"  + " " + $("#filter-year").val());
  }else if ($('#filter-month').val() == "10") {
    $("#period").text("de Octubre"  + " " + $("#filter-year").val());
  }else if ($('#filter-month').val() == "11") {
    $("#period").text("de Noviembre"  + " " + $("#filter-year").val());
  }else if ($('#filter-month').val() == "12") {
    $("#period").text("de Diciembre"  + " " + $("#filter-year").val());
  }
  //$("#period").text($(this).val())
});


  // MENU WIDGET TRANSFERENCIA
  $('.transfers').hover(function(){
    $('.submenu-transfer').attr('style', 'display: block');
  }, function(){
    $('.submenu-transfer').attr('style', 'display: none');
  });

  // MENU WIDGET USUARIO
  $('.user').hover(function(){
    $('.submenu-user').attr('style', 'display: block');
  }, function(){
    $('.submenu-user').attr('style', 'display: none');
  });

  // ----------------------------------------------------------------------------------------------------------------------------------------------------------------
	var cpo_cook = decodeURIComponent(
		document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
	);

	var dataRequest = JSON.stringify ({
		tarjeta:$("#card").attr("card")
	});

	dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

	$.post(base_url+"/detalles/load", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},function(response){

		data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))

    $('#loading').hide();
    carga_lista(data);
  });
	var cpo_cook = decodeURIComponent(
		document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
	);

	var dataRequest = JSON.stringify ({
		tarjeta:$("#card").attr("card")
		})

	dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

	$.post(base_url+"/dashboard/saldo", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},function(response){

		data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))

    var moneda=$(".product-info-full").attr("moneda");
    var saldoAct=data.actual;
    var saldoBloq=data.bloqueo;
    var saldoDisp=data.disponible;
    if (typeof saldoAct!='string'){
      saldoAct="---";
    }
    if (typeof saldoBloq!='string'){
      saldoBloq="---";
    }
    if (typeof saldoDisp!='string'){
      saldoDisp="---";
    }

    $("#actual").html(moneda+saldoAct);
    $("#bloqueado").html(moneda+saldoBloq);
    $("#disponible").html(moneda+saldoDisp);

  });

  $("#download").click(function(event){
    event.preventDefault();
    if(reporte == false){
      $("#list-detail").children().remove();
      cadena='<div id="empty-state" style="position: static;">';
      cadena+=                '<h2>No se encontraron movimientos</h2>';
      cadena+=                 '<p>Vuelva a realizar la búsqueda con un filtro distinto para obtener resultados.</p>';
      cadena+=                '<span aria-hidden="true" class="icon-cancel-sign" style="position: relative;right: -260px;"></span>';
      cadena+=             '</div>';
      $("#list-detail").append(cadena);
    }
    else{
      $("#tarjeta").val($("#card").attr("card"));

      if($("#filter-month").val()==0){
        $("#mes").val('');
        $("#anio").val('');
      }
      else{
        $("#mes").val(("0"+$("#filter-month").val()).slice(-2));
        $("#anio").val($("#filter-year").val());
      }
      document.getElementById("idOperation").value='5';
      $("#form").submit();
    }
  });

  $("#downloadxls").click(function(event){
    event.preventDefault();
    if(reporte == false){
      $("#list-detail").children().remove();
      cadena='<div id="empty-state" style="position: static;">';
      cadena+=                '<h2>No se encontraron movimientos</h2>';
      cadena+=                 '<p>Vuelva a realizar la búsqueda con un filtro distinto para obtener resultados.</p>';
      cadena+=                '<span aria-hidden="true" class="icon-cancel-sign" style="position: relative;right: -260px;"></span>';
      cadena+=             '</div>';
      $("#list-detail").append(cadena);
    }
    else{
      $("#tarjeta").val($("#card").attr("card"));
      if($("#filter-month").val()==0){
        $("#mes").val('');
        $("#anio").val('');
      }
      else{
        $("#mes").val(("0"+$("#filter-month").val()).slice(-2));
        $("#anio").val($("#filter-year").val());
      }
      document.getElementById("idOperation").value="46";
     $("#form").submit();
    }
  });

  $('#mes').hover(function(){
    $('.sub-stack').attr("style","display:block")
  },function(){
    $('.sub-stack').attr("style","display:none")
  });

  $.each(nombreMes, function(pos, item){
    $(".sub-stack").append('<li class="sub-stack-item"><a href="#" rel="subsection" num="'+parseInt(pos+1)+'">'+item+'</a></li>');
  });

  $('#content').on('click',"#filter-month",function(){
    mes = $("#filter-month").val();
    if(mes==0){
      $("#filter-year").prop("disabled",true);
      $("#filter-year")[0].selectedIndex = 0;
    }
    else{
      $("#filter-year").prop('disabled',false);
      if($("#filter-year").selectedIndex == 0){
        $("#filter-year")[0].selectedIndex = 1;
      }
    }
  });

  $('#content').on('click',"#buscar",function(){
    $('#list-detail').children("li").remove();
    $('#estadisticas').children().remove();
    $('#loading').show();
    mes = $("#filter-month").val();
		anio = $("#filter-year").val();
		var cpo_cook = decodeURIComponent(
			document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
		);
    if(mes==0){

			var dataRequest = JSON.stringify ({
				tarjeta:$("#card").attr("card")
			});

			dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

			$.post(base_url+"/detalles/load", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)},function(response){

				data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))

        $('#loading').hide();
        carga_lista(data);
      });
    }
    else{

			var dataRequest = JSON.stringify ({
				tarjeta:$("#card").attr("card"),
				mes:mes,
				anio:anio,
			})

			dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {format: CryptoJSAesJson}).toString();

			$.post(base_url+"/detail/CallWsMovimientos", {request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook)}, function(response){
				data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8))

        $('#loading').hide();
        carga_lista(data);
      });
    }

  });

  // ----------------------------------------------------------------------------------------------------------------------------------------------------------------

  function carga_lista(data){
    var clase, cadena;
    if(data.rc == -61){
      $(location).attr('href', base_url+'/users/error_gral');
    }
    if(data.rc != 0){
      $("#list-detail").children().remove();
      cadena='<div id="empty-state" style="position: static;">';
      cadena+=                '<h2>No se encontraron movimientos</h2>';
      cadena+=                 '<p>Vuelva a realizar la búsqueda con un filtro distinto para obtener resultados.</p>';
      cadena+=                '<span aria-hidden="true" class="icon-cancel-sign" style="position: relative;right: -260px;"></span>';
      cadena+=             '</div>';
      $("#list-detail").append(cadena);
      reporte = false;
    }
    else{
      reporte = true;
      $("#list-detail").children().remove();
      $.each(data.movimientos,function(pos,item){

        if(item.signo=='+'){

          clase= 'feed-income';

        } else {

          clase='feed-expense';
        }
        var date = item.fecha.split('/');
        var dia = date[0];
        var mes;
        var annio = date[2];
        var moneda=$(".product-info-full").attr("moneda");

        switch (date[1]){
          case "01":
            mes="Ene";
            break;
          case "02":
            mes="Feb";
            break;
          case "03":
            mes="Mar";
            break;
          case "04":
            mes="Abr";
            break;
          case "05":
            mes="May";
            break;
          case "06":
            mes="Jun";
            break;
          case "07":
            mes="Jul";
            break;
          case "08":
            mes="Ago";
            break;
          case "09":
            mes="Sep";
            break;
          case "10":
            mes="Oct";
            break;
          case "11":
            mes="Nov";
            break;
          case "12":
            mes="Dic";
            break;
        }

        var seccion;

        seccion='<li class="feed-item '+clase+'">';
        seccion+=   '<div class="feed-date">'+dia+'<span class="feed-date-month">'+mes+'</span><span class="feed-date-year">'+annio+'</span></div>';
        if (item.signo == "-") {
        seccion+= item.concepto+'<span class="money-amount"> '+'- '+moneda+' '+item.monto+'</span>';
        }else{
        seccion+= item.concepto+'<span class="money-amount"> '+moneda+' '+item.monto+'</span>';
        }
        seccion+= '<ul class="feed-metadata">'
        seccion+= '<li class="feed-metadata-item"><span aria-hidden="true" class="icon-file-text"></span> '+item.referencia+'</li>'
        seccion+= '</ul></li>';

        $('#list-detail').append(seccion);


      });

      $("#estadisticas").kendoChart({

        legend: {
          position: "top",
          visible: false
        },
        seriesDefaults: {
          labels: {
            template: "#= category # - #= kendo.format('{0:P}', percentage)#",
            position: "outsideEnd",
            visible: false,
            background: "transparent",
          }
        },
        seriesColors: ["#E74C3C", "#2ECC71"],
        series: [{
          type: "donut",
          overlay: {
            gradient: "none"
          },
          data: [{
            category: "Cargos",
            value: parseFloat(parseFloat(data.totalCargos).toFixed(1))
          }, {
            category: "Abonos",
            value: parseFloat(parseFloat(data.totalAbonos).toFixed(1))
          }]
        }],
        tooltip: {
          visible: true,
          template: "#= category # - #= kendo.format('{0:P}', percentage) #"
        }
      });

    }
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

}); //FIN
