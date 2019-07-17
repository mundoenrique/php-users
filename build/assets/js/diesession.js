var path = window.location.href.split('/');
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');

$(document).ready(function(){
	$('input[type=text], input[type=password], input[type=textarea]').attr('autocomplete','off');
	idleTime = 0;
	//Increment the idle time counter every second.
	var idleInterval = setInterval(timerIncrement, 180000);
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
		var cpo_cook = decodeURIComponent(
			document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
		);
		$.ajax({
			method: 'POST',
			url: base_url+'/users/closeSess',
			data: {cpo_name: cpo_cook}
		});
	}
});
