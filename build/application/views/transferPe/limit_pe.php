<nav id="tabs-menu">
	<ul class="menu">
		<li class="menu-item current-menu-item">
			<!-- <a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section"><span aria-hidden="true" class="icon-card"></span> <?php echo lang("MENU_P2P");?></a> -->
			<a href="<? echo $this->config->item("base_url"); ?>/transferencia" rel="section"><span aria-hidden="true" class="icon-card"></span> <?php echo lang("MENU_P2P");?></a>
		</li>
	</ul>
</nav>
<div id="content">
	<article>
		<header>
			<h1>Historial cuenta general</h1>
		</header>
		<section>
			<nav id="secondary-menu">
				<ul class="menu">
					<li class="menu-item add current-menu-item">
						<a href="<? echo $this->config->item("base_url"); ?>/limit/pe" rel="section">Configurar limites</a>
					</li>
					<li class="menu-item manage">
						<a href="<? echo $this->config->item("base_url"); ?>/transferencia/pe" rel="section">Transferir</a>
					</li>
					<li class="menu-item log">
						<a href="<? echo $this->config->item("base_url"); ?>/historial/pe" rel="section">Historial</a>
					</li>
				</ul>
			</nav>
			<h2>Montos personales para transferencias directas </h2>
			<h3>Seleccione el monto máximo para transferencias sin autorización (código de seguridad)</h3>
			<form id="form-amount" name="form-amount">
				<div id="transfer-date">
					<?php
						//consulta el monto actual
						$baseAmounts = unserialize($amounts);
						$defaultAmount = "";
						if($baseAmounts->code == 0)
						{
							foreach ($baseAmounts->amounts as $key => $options) {
							 if($options->default == 1){
								 $defaultAmount = $options->monto;
								 break;
							 }
							}
						}
					?>
					<fieldset class="form-inline">
						<div>
							<ul class='product-balance-group' style="margin: 10px 0">
								<li>Monto máximo actual <span class='product-balance' id='balance-available'> <?php echo lang("MONEDA").". ".$defaultAmount;?> </span></li>
								<input type="hidden" value="<?php echo $this->session->userdata("pais") ?>" id="codPais" name="codPais">
								<select class="field-medium skip" id="amount" name="amount">
									<?php
									if($baseAmounts->code == 0)
									{
										//construyen listado de montos
										foreach ($baseAmounts->amounts as $key => $options) {
											$selected = ($options->default == 1) ? 'selected':'';
											echo "<option value=".$options->codigo." monto='".$options->monto."' ".$selected.">".lang("MONEDA").". ".$options->monto." </option>";
										}
									}
									?>
								</select>
							</ul>
						</div>
						<div class="aling-right-form">
							<label>Clave de inicio</label>
							<input class='field-medium skip' id="password" name="password" maxlength="20" type='password' />
						</div>
					</fieldset>

					<div id='msg-history'></div>
				</div>
				<div class="form-actions">
					<a href="<? echo $this->config->item("base_url"); ?>/dashboard"><button class="reset-button-trx" type="button">Cancelar</button></a>
					<button id="updateAmount" type="submit">Aplicar</button>
				</div>
			</form>
	</article>

	<!--***************************************MODAL ERRORES*****************************************-->
	<div id="msg_system" style='display:none'>
	    <div id="dialog-confirm">
	        <div id="msg_info">
	            <span aria-hidden="true"></span>
	            <p></p>
	        </div>
	        <div id="form-action" class="form-actions">
	            <button id="close-info"></button>
	        </div>
	    </div>
	</div>
	<!--*************************************FIN MODAL ERRORES***************************************-->

	</section>
</div>
