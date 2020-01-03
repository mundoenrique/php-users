var base_url, base_cdn;
base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');

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
});
