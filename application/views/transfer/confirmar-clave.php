<div id="content">
		<article>
			<header>
				<h1>Transferencias</h1>
			</header>
			<section>
				<div id="content-holder">
					<h2>Autenticación Requerida</h2>
					<p>Para realizar transacciones con sus cuentas desde <strong>Conexión Personas</strong> es necesario proporcione su clave de operaciones. Esta clave le será solicitada solamente una vez durante su sesión actual.</p>
					<form accept-charset="utf-8" method="post">
						<fieldset class="fieldset-column-center">
							<label for="transpwd">Clave de Operaciones</label>
							<input class="field-medium" id="transpwd" name="transpwd" type="password" />
						</fieldset>
						<div class="form-actions">
							<a href="<? echo $this->config->item("base_url"); ?>/transfer/dashboard"><button type="reset">Cancelar</button></a>
							<button id="continuar_transfer">Continuar</button>
						</div>
					</form>
				</div>
			</section>
		</article>
</div>