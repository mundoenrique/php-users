<?
if(isset($pagina) ){
	//Obtener si el usuario completó los campos de afiliación plata beneficios
	$aplicaPerfil = $this->session->userdata('aplicaPerfil');
	$afiliado = $this->session->userdata('afiliado');
	$tyc = $this->session->userdata('tyc');
	$redirec = ($aplicaPerfil === 'S' && $afiliado == 0) || $tyc == 0;
	$current = @end(explode('/',base_url(uri_string())));
	if($redirec && $current !== 'perfil') {
		redirect(base_url('perfil'), 'location');
	}

	# FUNCION PARA EL NUEVO MENU
  echo construccion_menu($pagina);

}

?>
