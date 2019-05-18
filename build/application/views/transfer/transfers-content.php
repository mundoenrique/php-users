<?php
$country = $this->session->userdata('pais');
$cpo_name = $this->security->get_csrf_token_name();
$cpo_cook = $this->security->get_csrf_hash();
?>
<nav id="tabs-menu" style='display:none'>
	<ul class="menu">
		<li class="menu-item current-menu-item">
			<a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section"><span aria-hidden="true" class="icon-card"></span> <?php echo lang("MENU_P2P");?></a>
		</li>
		<li class="menu-item">
			<a href="<? echo $this->config->item("base_url"); ?>/transfer/index_bank" rel="section"><span aria-hidden="true" class="icon-bank"></span> Cuentas Bancarias</a>
		</li>
	</ul>
</nav>

<div id="content" confirmacion="<? echo $this->session->userdata("transferir") ?>">
	<div id="content-clave" style='display:none'>
		<article>
			<header>
				<h1>Transferencias</h1>
			</header>
			<section>
				<div id="content-holder">
					<h2>Autenticación Requerida</h2>
					<p>Para realizar transacciones con sus cuentas desde <strong>Conexión Personas</strong> es necesario proporcione su clave de operaciones. Esta clave le será solicitada solamente una vez durante su sesión actual.</p>
					<fieldset class="fieldset-column-center">
						<label for="transpwd">Clave de Operaciones</label>
						<input class="field-medium" id="transpwd" name="transpwd" type="password" />
					</fieldset>
					<p>En caso de haber olvidado su <strong>Clave de Operaciones</strong></strong>, comuníquese con el <strong>Centro de Contacto</strong>.</p>
					<div class="form-actions">
						<a href="<? echo $this->config->item("base_url"); ?>/dashboard"><button type="reset">Cancelar</button></a>
						<button id="continuar_transfer">Continuar</button>
					</div>
				</div>
			</section>
		</article>
	</div>
	<div id="content_plata" style='display:none'>
		<article>
			<header>
				<h1>Transferencias <?php echo lang("MENU_P2P");?></h1>
			</header>

			<section>
				<div>
					<nav id="secondary-menu">
						<ul class="menu">
							<li class="menu-item add">
								<a href="<? echo $this->config->item("base_url"); ?>/affiliation" rel="section">Afiliar</a>
							</li>
							<li class="menu-item handler">
								<a href="<? echo $this->config->item("base_url"); ?>/adm" rel="section">Administrar Afiliaciones</a>
							</li>
							<li class="menu-item current-menu-item manage">
								<a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section">Transferir</a>
							</li>
							<li class="menu-item log">
								<a href="<? echo $this->config->item("base_url"); ?>/historial" rel="section">Historial</a>
							</li>
						</ul>
					</nav>
					<div id="progress">
						<ul class="steps">
							<li class="step-item current-step-item"><span aria-hidden="true" class="icon-exchange"></span> Transferir</li>
							<li class="step-item"><span aria-hidden="true" class="icon-view"></span> Confirmación</li>
							<li class="step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
						</ul>
					</div>
					<div id="affiliate-account">
						<a class="button alternate-button small-button" href="<? echo $this->config->item("base_url"); ?>/affiliation">Afiliar Cuenta</a>
						<h2>Transferir</h2>
						<p>Espacio reservado para indicaciones sobre completado de datos necesarios para llevar a cabo la transferencia entre tarjetas por demanda del usuario.</p>
					</div>
					<div id="transfer-date">
						<fieldset>
							<label for="donor">Cuenta de Origen</label>
							<div class='group' id='donor' moneda="<?php echo lang('MONEDA') ?>">
								<div class='product-presentation'>
									<a class='dialog button product-button'><span aria-hidden='true' class='icon-find'></span></a>
									<input id='donor-cardnumber' name='donor-cardnumber' type='hidden' value='' />
								</div>
								<div class='product-info'>
									<p class='field-tip'>Seleccione una cuenta propia desde la cual desea transferir fondos.</p>
								</div>
								<div class='product-scheme'>
									<ul class='product-balance-group disabled-product-balance-group' style="margin: 10px 0">
										<li>Disponible <span class='product-balance' id='balance-available'> <?php echo lang("MONEDA");?> </span></li>
										<li>A debitar <span class='product-balance' id='balance-debit'> <?php echo lang("MONEDA");?> </span></li>
										<li style="width: 161px;">Fecha de Vencimiento<span class='product-balance'><select disabled style="margin-right: 5px;"><option value=''>Mes</option></select><select disabled><option value="">Año</option></select></span></li>
									</ul>
								</div>
							</div>
							<label for='beneficiary-1x'>Cuentas Destino <span class='field-instruction'>(máx. 3 simultáneas)</span><span id="wait" style="display: none; color: #368db6;"> <strong>Esperando cuentas destino...</strong></span></label>
							<div id="tdestino">
								<div class='group obscure-group' id='btn-destino'>
									<div class='product-presentation'>
										<a class='dialogDestino button product-button disabled-button' ><span aria-hidden='true' class='icon-find'></span></a>
										<input id='beneficiary-1x-cardnumber' name='beneficiary-1x-cardnumber' type='hidden' value='' />
									</div>
									<div class='product-info'>
										<p class='field-tip'>Seleccione una de sus cuentas afiliadas como beneficiaria de esta transferencia.</p>
									</div>
									<div class='product-scheme'>
										<fieldset class='form-inline'>
											<label for='beneficiary-1x-description'>Concepto</label>
											<input disabled class='field-large skip' id='beneficiary-1x-description' maxlength="20" name='beneficiary-1x-description' type='text' />
											<label for='beneficiary-1x-amount'>Importe</label>
											<div class='field-category'>
												<?php echo lang("MONEDA"); ?>
												<input disabled id='beneficiary-1x-coin' name='beneficiary-1x-coin' type='hidden' value='<?php echo lang("MONEDA");?>' />
											</div>
											<input disabled class='field-small monto skip' id='beneficiary-1x-amount' maxlength="15" name='beneficiary-1x-amount' type='text' />
										</fieldset>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
					<div id="next-step" class="form-actions">
						<a id="cancel" href="<? echo $this->config->item("base_url"); ?>/dashboard"><button type="reset">Cancelar</button></a>
						<button disabled class="confir" id="continuar">Confirmar</button>
					</div>
				</div>
			</section>
		</article>
	</div>
</div>

<?php
	//Obtener listado de tarjetas origen
	$datos = null;
	if(isset($data)) {
		if($this->session->userdata("aplicaTransferencia")=='N') {
			header("Location: transfer/error_transfer");
		}
		if(($this->session->userdata("aplicaTransferencia")=='S')&&($this->session->userdata("passwordOperaciones")=='')) {
			$pass = '/users/crearPasswordOperaciones';
			$ruta = $this->config->item("base_url").$pass;
			header("Location: $ruta");
		}
		$datos = unserialize($data);

		if($datos->rc==-150) {
			$error = '/transfer/error_transfer';
			$ruta = $this->config->item("base_url").$error;
			header("Location: $ruta");
		}

		if($datos->rc==0){
			$todos = 0;

			foreach ($datos->cuentaOrigen as $value) {
				$nombre_empresa = $value->nomEmp;
				$cuenta = count(explode(" ", $nombre_empresa));

				if($cuenta>1) {
					$findspace = ' ';
					$posicion = strpos($nombre_empresa , $findspace);
					$princ = 0;
					$nombre_empresa = substr($nombre_empresa, $princ, $posicion);
				}

				$todos = $todos + 1;
			}
		}
	}
?>
<!--***********************************MODAL CTAS DE ORIGEN**************************************-->
<div id='content-product' style='display:none'>
	<nav id="filters-stack">
		<ul id="filters" class="stack option-set" data-option-key="filter">
			<li class="stack-item current-stack-item">
				<a href="#all" rel="subsection" data-option-value="*"><span class="badge"><?php echo $todos; ?></span> <?php echo $todos > 1 ? 'Cuentas' : 'Cuenta'; ?></a>
			</li>
		</ul>
	</nav>
	<ul id='dashboard-donor'>
		<?php
			$datos = null;
			$datos = unserialize($data);
			$base_cdn = $this->config->item('base_url_cdn');

			foreach ($datos->cuentaOrigen as $value) {
				$cadena = strtolower($value->producto);
				$producto1 = quitar_tildes($cadena);
				$img1=strtolower(str_replace(' ','-',$producto1));
				$img=str_replace("/", "-", $img1);
				$marca= strtolower(str_replace(" ", "-", $value->marca));
				$empresa = strtolower($value->nomEmp);
				$pais=ucwords($this->session->userdata('pais'));
				$moneda=lang("MONEDA");
				$tarjetaHabiente=ucwords(mb_strtolower($value->tarjetaHabiente, 'UTF-8'));
				$nomProducto=ucwords(mb_strtolower($value->producto, 'UTF-8'));

				echo "<li class='dashboard-item $empresa' card='$value->nroTarjeta' pais='$pais' moneda='$moneda' nombre='$tarjetaHabiente' marca='$marca' mascara='$value->nroTarjetaMascara' empresa='$empresa' producto1='$nomProducto' producto='$img' prefix='$value->prefix'>
	         		<a rel='section'>
	         			<img src='".$base_cdn."img/products/".$pais."/$img.png' width='200' height='130' alt='' />
	         			<div class='dashboard-item-network $marca'></div>
	         			<div class='dashboard-item-info'>
	         				<p class='dashboard-item-cardholder'>$tarjetaHabiente</p>
	         				<p class='dashboard-item-balance'><?php echo $country !== 'Ve' ? $moneda --- : ''; ?></p>
	         				<p class='dashboard-item-cardnumber'>$value->nroTarjetaMascara</p>
	         				<p class='dashboard-item-category'>$nomProducto</p>
	         			</div>
	         		</a>
         		</li>";
			}
			function quitar_tildes($cadena) {
				$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
				$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
				$texto = str_replace($no_permitidas, $permitidas ,$cadena);
				return $texto;
			}
		?>
	</ul>
	<div class="form-actions">
		<button type="reset" id="cerrar">Cancelar</button>
	</div>
</div>
<!--*********************************FIN MODAL CTAS DE ORIGEN************************************-->
<!--**********************************MODAL CTAS DE DESTINO**************************************-->
<div id='content-destino' style='display:none'>
	<ul id="dashboard-beneficiary">

	</ul>
	<div class='form-actions'>
		<button  id='close' type='reset'>Cancelar</button>
	</div>
</div>
<!--*********************************FIN MODAL CTAS DE DESTINO***********************************-->
<!--*******************************TARJETA SIN CUNETAS AFILIADAS*********************************-->
<div id="without-account" style="display: none;">
	<div id="empty-state">
		<h2>Sin cuentas afiliadas</h2>
		<p>Para la cuenta origen seleccionada, usted no posee cuentas asociadas para llevar a cabo esta operación.</p>
		<div class="empty-state-actions">
			<a class="button" href="<? echo $this->config->item("base_url"); ?>/affiliation" rel="section">Afiliar Cuenta</a>
		</div>
		<span aria-hidden="true" class="icon-card"></span>
	</div>
</div>
<!--*****************************FIN TARJETA SIN CUNETAS AFILIADAS*******************************-->
<!--**********************************CONFIRMAR TRANSFERENCIA************************************-->
<div id="confirm-transfer" style="display: none">
	<div>
		<div id="titulo">
			<h2>Confirmación</h2>
			<p>Por favor, verifique los datos de las siguientes operaciones de transferencia que solicita:</p>
		</div>
		<form accept-charset="utf-8" method="post" id="formConfirmTransferencia">
			<input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
			<table class="receipt" cellpadding="0" cellspacing="0" width="100%">
				<tbody id="cargarConfirmacion">
				</tbody>
			</table>
		</form>
		<div id="transfer-success" style="display: none">
			<p><?php echo lang('trans_card_confirm'); ?></p>
		</div>
	</div>
</div>
<!--********************************FIN CONFIRMAR TRANSFERENCIA**********************************-->

<!--***************************************MODAL ERRORES*****************************************-->
<div id="info-system" class="dialog-small" style='display:none'>
	<div class="alert-simple alert-warning skip" id="content-info">
		<span aria-hidden="true" class="skip icon-warning-sign"></span>
	</div>
	<div id="content-input" class="skip"></div>
	<div id="button-action" class="form-actions skip">
		<button id="close-info" class="skip">Aceptar</button>
	</div>
</div>
<!--*************************************FIN MODAL ERRORES***************************************-->
