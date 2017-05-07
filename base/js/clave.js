var path, base_cdn;
path =window.location.href.split( '/' ); 
base_cdn = path[0]+ "//" +path[2].replace('online','cdn')+'/'+path[3];
base_url = path[0]+ "//" +path[2] + "/" + path[3];

$(function(){
	$("#continuar_transfer").click(function(){
		var pass=$("#transpwd").val();
		//alert("entro al click");
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