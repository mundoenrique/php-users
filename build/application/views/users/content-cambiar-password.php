
<?php
$cpo_name = $this->security->get_csrf_token_name();
$cpo_cook = $this->security->get_csrf_hash();
?>
<div id="content">
				<article>
					<header>
						<h1>Cambio de Contraseña</h1>
					</header>
					<section>
						<div id="content-holder">
							<?php if($temporal == 't'): ?>
								<p>Ud. ha solicitado el restablecimiento de su contraseña recientemente y accedido a <strong>Conexión Personas</strong> por medio de una contraseña provisional la cual, por su seguridad, debe modificar de forma inmediata.</p>
							<?php endif; ?>
							<?php if($temporal == 'v'): ?>
								<p>Su contraseña ha vencido</p>
							<?php endif; ?>
							<p>Por favor complete la información requerida a continuación para generar una nueva contraseña:</p>
							<form accept-charset="utf-8" method="post">
								<input type="hidden" name="<?php echo $cpo_name ?>" class="ignore" value="<?php echo $cpo_cook ?>">
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
									<label for="old-userpwd">Contraseña Actual</label>
									<input class="field-medium" maxlength="15" id="old-userpwd" name="old-userpwd" type="password" />
									<label for="userpwd">Nueva Contraseña</label>
									<input class="field-medium" maxlength="15" id="userpwd" name="userpwd" type="password" />
									<label for="confirm-userpwd">Confirmación</label>
									<input class="field-medium" maxlength="15" id="confirm-userpwd" name="confirm-userpwd" type="password" />
									<h5 id='vacio'></h5>
								</fieldset>
								</form>
								<div class="form-actions">
									<?php
										if(isset($temporal) && ($temporal == 'n')) {
										echo '<button class="volver" type="reset" class="novo-btn-primary">Cancelar</button>';
										}
									?>
									<div id="loading" class="icono-load" style="display: none; float:right; width:30px; margin-top:7px; margin-right:60px; margin-bottom:0px;">
												<span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 30px"></span>
									</div>
									<button id="continuar" class="novo-btn-primary" disabled>Continuar</button>

								</div>
						</div>
					</section>
				</article>
			</div>


<!-- CONFIRMACION -->

		<div id="confirmacion" style='display:none'>
			<article>
				<header>
					<h1>Actualizar contraseña</h1>
				</header>
				<section>
					<div id="content-holder">
						<h2>Confirmación</h2>
							<div class="alert-success" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Contraseña actualizada exitosamente
								<p>Su contraseña ha sido actualizada <strong>con éxito.</strong></p>
							</div>
							<div class="form-actions">
								<button id="aceptar" class="novo-btn-primary">Continuar</button>
							</div>
					</div>
				</section>
			</article>
		</div>

		<!-- error ACTUALIZAR -->

		<div id="sinExito" style='display:none'>
			<article>
				<header>
					<h2>Actualizar contraseña</h2>
				</header>
				<section>
					<div id="content-holder">
							<div class="alert-error" id="message">
								<span aria-hidden="true" class="icon-ok-sign"></span> Contraseña no actualizada
								<p id="msg_pass"></p>
							</div>
								<?php
									if(isset($temporal)&&$temporal!='t'){
										echo '<button class="volver" type="reset" class="novo-btn-primary">Aceptar</button>';
									}

									else{
									echo '<button id="regresar" type="reset" class="novo-btn-secondary">Regresar</button>';

									}

								?>
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
					<button id="invalido" class="novo-btn-primary">Aceptar</button>
				</div>
			</div>
		</div>

<!-- ERROR 2 -->

		<div id="dialog-clave-inv1" style='display:none'>
			<header>
				<h2>Cambio de contraseña</h2>
			</header>
			<div class="dialog-small" id="dialog">
				<div class="alert-simple alert-warning" id="message">
					<span aria-hidden="true" class="icon-warning-sign"></span>
					<p>Su contraseña <strong>coincide</strong> con la anterior. Por favor <strong>verifique</strong> sus datos, e intente nuevamente. </p>
				</div>
				<div class="form-actions">
					<button id="invalido1" class="novo-btn-primary">Aceptar</button>
				</div>
			</div>
		</div>

<!-- ERROR 3 -->

		<div id="dialog-clave-inv2" style='display:none'>
			<header>
					<h2>Contraseñas no coinciden</h2>
			</header>
			<div class="dialog-small" id="dialog">
				<div class="alert-simple alert-warning" id="message">
					<span aria-hidden="true" class="icon-warning-sign"></span>
					<p>Sus contraseñas <strong>no coinciden</strong>. Por favor <strong>verifique</strong> sus datos, e intente nuevamente. </p>
				</div>
				<div class="form-actions">
					<button id="invalido2" class="novo-btn-primary">Aceptar</button>
				</div>
			</div>
		</div>
