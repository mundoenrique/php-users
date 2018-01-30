<?
$clase_tranfer= '';
$clase_dash = '';
$clase_pago = '';
$clase_report = '';
$clase_perfil = '';
$clase_service = '';
$clase_soporte = '';

if(isset($pagina) ){
	//Obtener si el usuario completó los campos de afiliación plata beneficios
	$aplicaPerfil = $this->session->userdata('aplicaPerfil');
	$afiliado = $this->session->userdata('afiliado');
	$cantCorreos = $this->session->userdata('cantCorreos');
	$current = @end(explode('/', base_url(uri_string())));
	if ((($aplicaPerfil === 'S' && $afiliado == 0) || $cantCorreos > 0) && $current !== 'perfil') {
		redirect(base_url('perfil'), 'location');
	}
	switch ($pagina) {
		case 'transfer':
			$clase_tranfer= 'current-menu-item';
			$clase_dash = '';
			$clase_pago = '';
			$clase_report = '';
			$clase_perfil = '';
			$clase_service = '';
			//$clase_soporte = '';
			break;

		case 'dashboard':
			$clase_dash = 'current-menu-item';
			$clase_tranfer= '';
			$clase_pago = '';
			$clase_report = '';
			$clase_perfil = '';
			$clase_service = '';
			//$clase_soporte = '';
			break;

		case 'pago':
			$clase_pago = 'current-menu-item';
			$clase_report = '';
			$clase_tranfer= '';
			$clase_dash = '';
			$clase_perfil = '';
			$clase_service = '';
			//$clase_soporte = '';
			break;

		case 'reportes':
			$clase_report = 'current-menu-item';
			$clase_pago = '';
			$clase_tranfer= '';
			$clase_dash = '';
			$clase_perfil = '';
			$clase_service = '';
			break;

		case 'service':
			$clase_service = 'current-menu-item';
			$clase_pago = '';
			$clase_tranfer= '';
			$clase_dash = '';
			$clase_perfil = '';
			$clase_report = '';
			break;

		case 'perfil':
			$clase_perfil = 'current-menu-item';
			$clase_pago = '';
			$clase_tranfer= '';
			$clase_dash = '';
			$clase_report = '';
			$clase_service = '';
			break;
	}

}

$skin = $this->input->cookie($this->config->item('cookie_prefix') . 'skin');
if($skin == 'latodo'){
	$closeLink = $this->config->item('base_url') . '/users/closeSess_pe';
}else{
	$closeLink = $this->config->item('base_url') . '/users/closeSess';
}


$fullname = ucwords($this->session->userdata('nombreCompleto'));
if (strlen($fullname) >= 15) {
	$fullname = substr($fullname, 0, 12) . '...';
}


//OBTIENE EL PAIS DEL USER
$pais = $this->session->userdata('pais');

?>

<nav id="main-menu">
	<ul class="menu">
		<li class="<?php echo $clase_dash?> menu-item products">
			<a href="<? echo $this->config->item("base_url"); ?>/dashboard" rel="section">Vista Consolidada</a>
		</li>
		<li class="<?php echo $clase_tranfer?> menu-item transfers">
			<a href="<?php echo $this->config->item('base_url'); ?>/transferencia" rel="section">Transferencias <span aria-hidden="true" class="icon-chevron-down"></span></a>
			<ul class="submenu-transfer sub-menu">
				<li class="sub-menu-item transfers-p2p">
					<a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="subsection"><?php echo lang("MENU_P2P");?></a>
				</li>
				<li class="sub-menu-item transfers-bank">
					<a href="<? echo $this->config->item("base_url"); ?>/transfer/index_bank" rel="subsection">Cuentas Bancarias</a>
				</li>
			</ul>
		</li>
		<li class="<?php echo $clase_pago?> menu-item payments">
			<a href="<? echo $this->config->item("base_url"); ?>/transfer/index_tdc" rel="section">Pagos</a>
		</li>
		<li class="<?php echo $clase_report?> menu-item reports">
			<a href="<? echo $this->config->item("base_url"); ?>/report" rel="section">Reportes</a>
		</li>
		<?php if ($pais == 'Co' || $pais == 'Ve'): ?>
			<li class="<?php echo $clase_service?> menu-item service">
				<a href="<? echo $this->config->item("base_url"); ?>/servicios" rel="section">Atención al cliente</a>
			</li>
			<?php endif; ?>
		<li class="<?php echo $clase_perfil?> menu-item account user">
			<a href="<? echo $this->config->item("base_url"); ?>/perfil" rel="section"><?php echo $fullname;?>
			<span aria-hidden="true" class="icon-chevron-down"></span></a>
			<ul class="submenu-user sub-menu">
				<li class="sub-menu-item account-profile">
					<a href="<? echo $this->config->item("base_url"); ?>/perfil" rel="subsection">Perfil</a>
				</li>
				<li class="sub-menu-item account-signout">
					<a href="<? echo $closeLink; ?>" rel="subsection" id="cerrarSesion">Cerrar Sesión</a>
				</li>
			</ul>
		</li>
	</ul>
</nav>
<nav id="compact-menu">
	<ul class="menu">
		<li class="menu-item account-signout">
			<a href="<? echo $closeLink; ?>" rel="section" title="Cerrar Sesión" id="cerrarSesion"><span aria-hidden="true" class="icon-off"></span></a>
		</li>
	</ul>
</nav>
