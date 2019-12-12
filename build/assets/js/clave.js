var base_url, base_cdn;
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');

$(function(){
	$("#continuar_transfer").click(function(){
		var pass=$("#transpwd").val();
		if(confirmPassOperac(pass)){
			$('#content_bank').show();
		}
		else{
		$('#content-clave').show();
		}
	 });

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


});
