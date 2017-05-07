
	<div id="content">
		<article>
			<header>
				<h1>Transferencias</h1>
			</header>
			<section>
				<div id="content-holder">
					<h2>Creación de Clave de Operaciones</h2>
					<p>Para realizar transacciones con sus cuentas desde <strong>Conexión Personas</strong> es necesario proporcione su clave de operaciones. Por favor, complete los campos a continuación para generar esta clave:</p>
					<form accept-charset="utf-8" id="form-validar" method="post">
						<fieldset class="fieldset-column-center">
							<div class="field-meter" id="password-strength-meter">
								<h4>Requerimientos de contraseña:</h4>
								<ul class="pwd-rules">
									<li id="letter" class="pwd-rules-item rule-invalid">• Debe tener al menos <strong>una letra</strong></li>
									<li id="capital" class="pwd-rules-item rule-invalid">• Debe tener al menos una <strong>letra mayúscula</strong></li>
									<li id="number" class="pwd-rules-item rule-invalid">• Debe tener <strong>mínimo 1 y máximo 3 números consecutivos</strong></li>
									<li id="length" class="pwd-rules-item rule-invalid">• Debe tener <strong>mínimo 8 y máximo 15 caracteres</strong></li>
									<li id="consecutivo" class="pwd-rules-item rule-invalid">• No puede tener más de  <strong>3 caracteres</strong> iguales consecutivos</li>
									<li id="especial" class="pwd-rules-item rule-invalid">• Tener al menos <strong>un caracter especial</strong><br />(ej: ! @ ? + - . , #)</li>
								</ul>
							</div>
							<label for="transpwd">Clave de Operaciones</label>
							<input class="field-medium" id="new-transpwd" maxlength="15" name="new-transpwd" type="password" />
							<label for="confirm-new-transpwd">Confirmar Clave Nueva</label>
							<input class="field-medium" id="confirm-new-transpwd" maxlength="15" name="confirm-new-transpwd" type="password" />
						</fieldset>
					</form>
						<div class="form-actions">
							<div id="msg"> </div>
							<a href="<? echo $this->config->item("base_url"); ?>/dashboard"> <button type="reset">Cancelar</button> </a>
							<button id="continuar">Continuar</button>
						</div>
				</div>
			</section>
		</article>
	</div>

<!-- CONFIRMAR CREAR -->

		<div id="confirmaCrear" style='display:none'>
			<article>
				<header>
					<h1>Crear Clave Operaciones</h1>
				</header>
				<section>
					<div id="content-holder">
						<h2>Confirmación</h2>
							<div class="alert-success" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Contraseña creada exitosamente
								<p>Su clave de operaciones ha sido creada <strong>con éxito.</strong></p>
							</div>
							<div class="form-actions">
								<button id="continuar">Continuar</button>
							</div>
					</div>
				</section>
			</article>
		</div>


<!-- CONFIRMAR ACTUALIZAR -->

		<div id="confirmaActualizar" style='display:none'>
			<article>
				<header>
					<h1>Actualizar Clave Operaciones</h1>
				</header>
				<section>
					<div id="content-holder">
						<h2>Confirmación</h2>
							<div class="alert-success" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Clave actualizada exitosamente
								<p>Su clave de operaciones ha sido actualizada <strong>con éxito</strong>.</p>
							</div>
							<div class="form-actions">
								<button id="confirmar">Continuar</button>
							</div>
					</div>
				</section>
			</article>
		</div>
<!-- error ACTUALIZAR -->

		<div id="sinExito" style='display:none'>
			<article>
				<header>
					<h1>Error creando Clave de Operaciones</h1>
				</header>
				<section>
					<div id="content-holder">
							<div class="alert-error" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Clave no actualizada
								<p>Su clave de operaciones no ha sido actualizada. Por favor verifique sus datos.</p>
							</div>
							<div class="form-actions">
								<button id="regresar">Regresar</button>
							</div>
					</div>
				</section>
			</article>
		</div>
<!-- ERROR 1 -->

		<div id="dialog-clave-inv" style='display:none'>
			<header>
				<h2>Campos obligatorios</h2>
			</header>
			<div class="dialog-small" id="dialog">
				<div class="alert-simple alert-warning" id="message">
					<span aria-hidden="true" class="icon-warning-sign"></span>
					<p>Todos los campos son <strong>obligatorios</strong>. Por favor <strong>verifique</strong> sus datos, e intente nuevamente. </p>
				</div>
				<div class="form-actions">
					<button id="invalido">Aceptar</button>
				</div>
			</div>
		</div>


<!-- ERROR 3 -->

		<div id="dialog-clave-inv2" style='display:none'>
			<header>
					<h2>Claves no coinciden</h2>
			</header>
			<div class="dialog-small" id="dialog">
				<div class="alert-simple alert-warning" id="message">
					<span aria-hidden="true" class="icon-warning-sign"></span>
					<p>Sus claves <strong>no coinciden</strong>. Por favor <strong>verifique</strong> sus datos, e intente nuevamente. </p>
				</div>
				<div class="form-actions">
					<button id="invalido2">Aceptar</button>
				</div>
			</div>
		</div>
