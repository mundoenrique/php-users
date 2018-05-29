<?php $country = $this->session->userdata('pais'); ?>
<nav id="tabs-menu" style='display:none'>
	<ul class="menu">
		<li class="menu-item current-menu-item">
			<a href="<? echo $this->config->item("base_url"); ?>/transferencia/cg" rel="section"><span aria-hidden="true" class="icon-card"></span> <?php echo lang("MENU_P2P");?></a>
		</li>
	</ul>
</nav>

<div id="content">

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
									<a href="<? echo $this->config->item("base_url"); ?>/limit/pe" rel="section">Configurar limites</a>
								</li>
								<li class="menu-item current-menu-item manage">
									<a href="<? echo $this->config->item("base_url"); ?>/transferencia/pe" rel="section">Transferir</a>
								</li>
								<li class="menu-item log">
									<a href="<? echo $this->config->item("base_url"); ?>/transferencia/HistorialPe" rel="section">Historial</a>
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
						<div id="transfer-date">
							<fieldset id="formulario">
								<label for="donor">Cuenta de Origen</label>
								<div class='group group-short' id='donor' moneda="<?php echo lang('MONEDA') ?>">
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
										</ul>
									</div>
								</div>
								<label for='beneficiary-1x'>Destino<span class='field-instruction'></span></label>
								<div id="tdestino">
									<input type="hidden" id="typeCurrency" value="<?php echo lang("MONEDA");?>">
									<div class='group' id='btn-destino'>
										<div class='product-info product-scheme'>
											<fieldset>
												<label for="">Seleccione dato de transferencia</label>
												<div class="form-phone">
													<input type="hidden" id="ctaOrigen" name="ctaOrigen" value="">
													<label class="label-inline">
				                            <input disabled class="label-inline skip" id="tipoRef2" name="tipoRef" value="2" type="radio" checked="checked">Teléfono</label>
													<label class="label-inline">
				                            <input disabled class="label-inline skip" id="tipoRef" name="tipoRef" value="1" type="radio" > Tarjeta </label>

												</div>
												<form id="form-search" method="post" name="form-search">
													<div id='cardRef' style="display:none">
														<fieldset class='form-inline'>
															<label for='beneficiary-1x-description'>Tarjeta</label>
															<input disabled class='field-medium ignore' id='ctaDestinoNot' maxlength="16" minlength="16" name='ctaDestinoNot' type='text' />
														</fieldset>
													</div>
													<div id='phoneRef'>
														<fieldset class='form-inline '>
															<label for='beneficiary-1x-description'>Teléfono</label>
															<input class='field-medium monto' name='telefonoDestino' id='telefonoDestino' type='text' value="" required minlength="9" maxlength="9" disabled />
															<button id="search-cards" disabled class="mensual search-cards" type="submit"><span aria-hidden="true" class="icon-find"></span></button>
														</fieldset>
													</div>
												</form>
											</fieldset>
										</div>
										<div class='product-scheme'>
											<form id="form-trx" method="post" name="form-trx">
												<fieldset class='form-inline '>
													<div id="data-transfer">
														<div id='cardSelect'>
																<label for='beneficiary-1x-description'>Tarjetas</label>
																<select class="field-large" id="ctaDestino" name="ctaDestino" disabled>
																</select>
														</div>
														<div id="cardText" style="display:none">
															<label for='beneficiary-1x-description'>Tarjeta</label>
															<input disabled class='field-medium ignore' id='ctaDestinoText' maxlength="16" minlength="16" name='ctaDestinoText' type='text' />
														</div>
														<label for='beneficiary-1x-description'>Concepto</label>
														<input disabled class='field-large skip' id='descripcion' maxlength="50" name='descripcion' type='text' />
														<label for='beneficiary-1x-amount'>Monto</label>
														<div class='field-category'>
															<?php echo lang("MONEDA"); ?>
															<input disabled id='montoLabel' name='montoLabel' type='hidden' value='<?php echo lang("MONEDA");?>' />
														</div>
														<input disabled class='field-small monto skip' id='monto' maxlength="5" name='monto' type='text' />
													</div>
												</fieldset>
											</form>
										</div>
									</div>
								</div>
							</fieldset>
							<div id='msg-history'></div>
						</div>


						<div id="confirmTrxValues" style="display:none">
								<div id="titulo">
									<h2>Confirmación</h2>
									<p>Por favor, verifique los datos de las siguientes operaciones de transferencia que solicita:</p>
								</div>

									<input type="hidden" id="ctaOrigen" name="ctaOrigen" value="">
									<input type="hidden" id="ctaDestino" name="ctaDestino" value="">
									<input type="hidden" id="monto" name="monto" value="">
									<input type="hidden" id="descripcion" name="descripcion" value="">

									<table class="receipt" width="100%" cellspacing="0" cellpadding="0">
										<tbody id="cargarConfirmacion">
											<tr>
												<td class="data-label"><label >Cuenta Origen</label></td>
												<td class="data-reference"><span class="highlight" id="conCtaOrigen"></span></td>
												<td class="data-metadata data-resultado">
													<strong>Concepto: </strong><span id="conDescripcion"></span>
													<br><strong>Monto: </strong><span class="money-amount" ><?php echo lang("MONEDA"); ?></span><span id="conMonto"></span>
												</td>
											</tr>
											<tr>
												<td class="data-label"><label>Cuentas Destino</label></td>
												<td class="data-reference"> <span class="highlight" id="conCtaDestino"></span></td>
												<td class="data-metadata">Total <br><span class="money-amount"><?php echo lang("MONEDA"); ?></span><span id="conMonto2"></span></td>
											</tr>
										</tbody>
									</table>
						</div>

						<div id="confirmacion" style="display:none">

									<label for="donor"><h1>Finalización<h1></label>
										<div id="dialog-confirm dialog-confirm-transfer">
											<div id="" class="alert-simple alert-success">
													<span aria-hidden="true" class="icon-ok-sign"></span>
														<p class="dialog-confirm-transfer">Transferencia procesada exitosamente</p>
														<p class="dialog-confirm-mail">Se ha enviado un comprobante de la operación a su correo electrónico</p>
											</div>
										</div>
										<h3>Los datos ingresados para la operación fueron los siguientes:</h3>
										<div class="">
											<table class="receipt" width="100%" cellspacing="0" cellpadding="0">
												<tbody id="cargarConfirmacion">
													<tr>
														<td class="data-label"><label >Cuenta Origen</label></td>
														<td class="data-reference"><span class="data-reference" id="nombreOrigen">Nombre</span><br><span class="highlight" id="conCtaOrigen">cuenta de origen</span><br></td>
														<td class="data-metadata data-resultado">
															<strong>Concepto: </strong><span id="conDescripcion"></span>
															<br><strong>Monto: </strong><span class="money-amount" ><?php echo lang("MONEDA"); ?></span><span id="conMonto"></span>
														</td>
													</tr>
													<tr>
														<td class="data-label"><label>Cuentas Destino</label></td>
														<td class="data-reference"><span class="data-reference" id="conCtaOr">Nombre cuenta de destino</span><br><span class="highlight" id="conCtaDestino">cuenta de destnino</span></td>
														<td class="data-metadata">Total<br><span class="money-amount"><?php echo lang("MONEDA"); ?></span><span id="conMonto2"></span></td>
													</tr>
												</tbody>
											</table>
										</div>

							</div>
						</div>

						<div id="pinDiv" class="" style="display: none">
							<fieldset>
							<form id="form-pin" name="form-pin" method="post">
								<input type="hidden" id="ctaOrigen" name="ctaOrigen" value="">
								<input type="hidden" id="ctaDestino" name="ctaDestino" value="">
								<input type="hidden" id="monto" name="monto" value="">
								<input type="hidden" id="descripcion" name="descripcion" value="">

								<div id="msg-change" class="msg-prevent">
										<h2>Confirmación</h2>
										<h3>Por favor ingresa el código de seguridad que recibiste por SMS o correo electronico</h3>
										<div id="result-change"></div>
								</div>
								<div>
											<div class="col-md-6-transfer"><span>Código de seguridad</span> &nbsp;&nbsp;&nbsp; <input class="field-medium" id="pin" name="pin" maxlength="8" type="password" required></div>
							</form>
							<fieldset>
							<div id='msg-history2'></div></div>
						</div>

						<div id="buttonTrx" class="form-actions">
							<a id="cancel" href="<? echo $this->config->item("base_url"); ?>/dashboard"><button class="reset-button-trx" type="button">Cancelar</button></a>
							<button disabled class="confir" id="continuar" type="submit" action='form-confirm'>Continuar</button>
						</div>
						<div id="finalTrx" class="form-actions" style="display:none">
							<p class="msgr">¿Desea realizar otra transferencia?</p>
							<a id="cancel" href="<? echo $this->config->item("base_url"); ?>/dashboard"><button class="reset-button-trx" type="button">No</button></a>
							<a id="cancel" href="<? echo $this->config->item("base_url"); ?>/transferencia/pe"><button class="button" type="button">Si</button></a>
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
				//$marca = strtolower($marca);
				$empresa = strtolower($value->nomEmp);
				$pais=ucwords($this->session->userdata('pais'));
				$moneda=lang("MONEDA");


				echo "<li class='dashboard-item $empresa' card='$value->nroTarjeta' pais='$pais' moneda='$moneda' nombre='$value->tarjetaHabiente' marca='$marca' mascara='$value->nroTarjetaMascara' empresa='$empresa' producto1='$value->producto' producto='$img' prefix='$value->prefix'>
	         		<a rel='section'>
	         			<img src='".$base_cdn."img/products/".$pais."/$img.png' width='200' height='130' alt='' />
	         			<div class='dashboard-item-network $marca'></div>
	         			<div class='dashboard-item-info'>
	         				<p class='dashboard-item-cardholder'>$value->tarjetaHabiente</p>
	         				<p class='dashboard-item-balance'><?php echo $country !== 'Ve' ? $moneda --- : ''; ?></p>
	         				<p class='dashboard-item-cardnumber'>$value->nroTarjetaMascara</p>
	         				<p class='dashboard-item-category'>$value->producto</p>
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
