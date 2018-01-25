<div id="content" data-temporary="<?php echo $temporal; ?>">
	<article>
		<header>
			<h1>Cambio de Contraseña</h1>
		</header>
		<section>
			<div id="content-holder">
				<?php if($temporal == 't'): ?>
					<p>Recientemente has solicitado el restablecimiento de tu contraseña y accedido a <strong>Conexión Personas</strong> por medio de una contraseña provisional la cual, por tu seguridad, debes modificar de forma inmediata.</p>
				<?php endif; ?>
				<?php if($temporal == 'v'): ?>
					<p>Tu contraseña ha expirado</p>
				<?php endif; ?>
				<p>Por favor completa la información requerida a continuación para generar una nueva contraseña:</p>
				<form accept-charset="utf-8" method="post">
					<fieldset class="fieldset-column-center">
						<div class="field-meter" id="password-strength-meter">
							<h4>Requerimientos de contraseña:</h4>
							<ul class="pwd-rules">
								<li id="actual" class="pwd-rules-item rule-invalid">• Debe indicar la contraseña <b><?php echo $temporal === 't' ? 'Temporal' : 'Actual'; ?></b></li>
								<li id="diferente" class="pwd-rules-item rule-invalid">• La <b>Nueva	Contraseña</b> debe ser diferente a la <b><?php echo $temporal === 't' ? 'Temporal' : 'Actual'; ?></b></li>
								<li id="letter" class="pwd-rules-item rule-invalid">• Debe tener al menos <strong>una letra</strong></li>
								<li id="capital" class="pwd-rules-item rule-invalid">• Debe tener al menos una <strong>letra mayúscula</strong></li>
								<li id="number" class="pwd-rules-item rule-invalid">• Debe tener <strong>mínimo 1 y máximo 3 números consecutivos</strong></li>
								<li id="length" class="pwd-rules-item rule-invalid">• Debe tener <strong>mínimo 8 y máximo 15 caracteres</strong></li>
								<li id="consecutivo" class="pwd-rules-item rule-invalid">• No puede tener más de  <strong>3 caracteres</strong> iguales consecutivos</li>
								<li id="especial" class="pwd-rules-item rule-invalid">• Tener al menos <strong>un caracter especial</strong> (ej: ! @ ? + - . , #)</li>
								<li id="igual" class="pwd-rules-item rule-invalid">• La <b>confirmación</b> debe ser igual a la <b>Nueva contraseña</b></li>
							</ul>
						</div>
						<div id="pwd-in">
							<label for="old-userpwd">Contraseña <?php echo $temporal === 't' ? 'Temporal' : 'Actual'; ?></label>
							<input class="field-medium" maxlength="15" id="old-userpwd" name="old-userpwd" type="password" />
							<label for="userpwd">Nueva Contraseña</label>
							<input class="field-medium" maxlength="15" id="userpwd" name="userpwd" type="password" />
							<label for="confirm-userpwd">Confirmación</label>
							<input class="field-medium" maxlength="15" id="confirm-userpwd" name="confirm-userpwd" type="password" />
						</div>
					</fieldset>
				</form>
				<div class="form-actions">
					<?php if($temporal === 'n'): ?>
					<a href="<?php echo base_url('perfil') ?>">
						<button class="volver" type="reset">Cancelar</button>
					</a>
					<?php endif; ?>
					<div id="loading" class="icono-load" style="display: none; float:right; width:30px; margin-top:7px; margin-right:60px; margin-bottom:0px;">
						<span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 30px"></span>
					</div>
					<button id="continuar" disabled>Continuar</button>
				</div>
			</div>
		</section>
	</article>
</div>

<!--*******************************Modal respuestas del servicio*********************************-->
<div id="response-pwd" class="dialog-small" style='display:none'>
	<header>
    <h2 id="title-pwd"></h2>
  </header>
	<div class="alert-simple" id="alert-pwd">
		<span aria-hidden="true" class="icon-warning-sign"> </span>
		<div id="content-pwd"></div>
	</div>
	<div id="button-action" class="form-actions">
		<button id="close-pwd">Aceptar</button>
	</div>
</div>
<!--*****************************Fin Modal respuestas del servicio*******************************-->
