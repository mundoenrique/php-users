<div id="content" idUsuario="<? echo $this->session->userdata("userName") ?>" confirmacion="<? echo $this->session->userdata("transferir") ?>">
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
</div>

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
