var path;
path = window.location.href.split( '/' );
base_url = path[0]+ "//" +path[2] + "/" + path[3];

$(document).ready(function(){
	idleTime = 0;
	//Increment the idle time counter every second.
	var idleInterval = setInterval(timerIncrement, 120000);
	function timerIncrement()
	{
		idleTime++;
		if (idleTime > 2 && path !== base_url)
		{
			doPreload();
		}
	}
	//Zero the idle timer on mouse movement.
	$(this).mousemove(function(e){
		idleTime = 0;
	});
	function doPreload(){
		$("#diesession_modal").dialog({
			modal:"true",
			width:"440px",
			open: function(event, ui) {
				$(".ui-dialog-titlebar-close", ui.dialog).hide();
			},
			close: function(){
				$("#diesession_modal").dialog("close");
			}
		});
		$("#diesession_modal #aceptar_diesession").click(function(){
			$("#diesession_modal").dialog("close");
		});
		$.ajax({
			method: 'POST',
			url: base_url+'/users/closeSess'
		});
	}
});
