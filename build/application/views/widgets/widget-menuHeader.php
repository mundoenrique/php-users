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
	$tyc = $this->session->userdata('tyc');
	$redirec = ($aplicaPerfil === 'S' && $afiliado == 0) || $tyc == 0;
	$current = @end(explode('/',base_url(uri_string())));
	if($redirec && $current !== 'perfil') {
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

$closeLink = $this->config->item('base_url') . '/users/closeSess';


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
			<?php
			//Verifica el pasi para asignar menu de transferencias
			switch ($pais) {
				case 'Pe':
						?>
							<a href="<?php echo $this->config->item('base_url'); ?>/transferencia/pe" rel="section">Transferencias</a>
						<?php
					break;

				default:
					?>
						<a href="<?php echo $this->config->item('base_url'); ?>/transferencia" rel="section">Transferencias <span aria-hidden="true" class="icon-chevron-down"></span></a>
						<ul class="submenu-transfer sub-menu">
							<li class="sub-menu-item transfers-p2p">
								<a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="subsection"><?php echo lang("MENU_P2P");?></a>
							</li>
							<li class="sub-menu-item transfers-bank">
								<a href="<? echo $this->config->item("base_url"); ?>/transfer/index_bank" rel="subsection">Cuentas Bancarias</a>
							</li>
						</ul>
					<?php
					break;
			}
			?>
		</li>
		<li class="<?php echo $clase_pago?> menu-item payments">
			<a href="<? echo $this->config->item("base_url"); ?>/transfer/index_tdc" rel="section">Pagos</a>
		</li>
		<li class="<?php echo $clase_report?> menu-item reports">
			<a href="<? echo $this->config->item("base_url"); ?>/report" rel="section">Reportes</a>
		</li>
		<?php if ($pais == 'Co' || $pais == 'Ve' || $pais == 'Pe'): ?>
			<li class="<?php echo $clase_service?> menu-item service">
				<a href="<? echo $this->config->item("base_url"); ?>/servicios" rel="section">Atención al cliente</a>
			</li>
			<?php endif; ?>
		<li class="<?php echo $clase_perfil?> menu-item account user">
			<a class="account" href="<? echo $this->config->item("base_url"); ?>/perfil" rel="section"><?php echo $fullname;?>
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
