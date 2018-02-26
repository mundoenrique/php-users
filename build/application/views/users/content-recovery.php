<?php
$skin = $this->input->cookie($this->config->item('cookie_prefix') . 'skin');
if($skin == 'latodo'){
	$homeLink = $this->config->item('base_url') . '/latodo/home';
}else{
	$homeLink = $this->config->item('base_url');
}
?>
	<div id="content">
		<article>
			<header>
				<h1>Restablecer Contraseña</h1>
			</header>
			<section>
				<div id="progress">
					<ul class="steps two-steps">
						<li class="step-item current-step-item"><span aria-hidden="true" class="icon-edit"></span> Verificación de Datos</li>
						<li class="step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
					</ul>
				</div>
				<div id="content-holder">
					<h2>Verificación de Datos</h2>
					<p>Si ha olvidado su contraseña de acceso a <strong>Conexión Personas</strong>, por favor ingrese los siguientes datos para recuperar:</p>
					<form accept-charset="utf-8" id="form-validar">
						<fieldset class="fieldset-column-center">
							<label for="email">Correo Electrónico</label>
							<input class="field-large" id="email" maxlength="64" name="email" placeholder="usuario@ejemplo.com" type="text" />
							<label for="card-holder-id">Documento de Identidad</label>
							<input class="field-medium" maxlength="15" id="card-holder-id" name="card-holder-id" type="text" />
						</fieldset>
					</form>
						<div id="msg"></div>
						<div class="form-actions">
							<button type="reset" onclick="window.location.href='<?php echo $homeLink; ?>'">Cancelar</button>
							<button id="continuar">Continuar</button>
							<div id="loading" class="icono-load" style="display:none; float:right; width:30px; margin-top:5px;">
								<span aria-hidden="true" class="icon-refresh icon-spin" style="font-size: 30px"></span>
							</div>
				</div>
			</section>
		</article>
	</div>


<!-- CONFIRMACION -->


	<div id="confirmacion" style='display:none'>
		<article>
			<header>
				<h1>Restablecer Contraseña</h1>
			</header>
			<section>
				<div id="progress">
					<ul class="steps two-steps">
						<li class="step-item completed-step-item"><span aria-hidden="true" class="icon-edit"></span> Verificación de Datos</li>
						<li class="step-item current-step-item"><span aria-hidden="true" class="icon-thumbs-up"></span> Finalización</li>
					</ul>
				</div>
				<div id="content-holder">
					<h2>Finalización</h2>
					<form accept-charset="utf-8" method="post">
						<div class="alert-success" id="message">
							<span aria-hidden="true" class="icon-ok-sign"></span> Contraseña restablecida exitosamente
							<p>Se ha envíado un mensaje a su correo electrónico con una nueva contraseña temporal de acceso al sistema <strong>Conexión Personas</strong>, la cual es válida solamente por tiempo limitado.</p>
						</div>
					</form>
						<div class="form-actions">
							<a href="<?php echo $homeLink; ?>"><button>Continuar</button></a>
						</div>
				</div>
			</section>
		</article>
	</div>

	<!-- MODAL CORREO O CEDULA INVALIDO -->

		 <div id="dialog-login-error" style='display:none'>
		 	<header>
				<h2>Datos Erróneos</h2>
			</header>
			<div class="dialog-small" id="dialog">
				<div class="alert-simple alert-error" id="message">
					<span aria-hidden="true" class="icon-cancel-sign"></span>
					<p>Correo o Documento de identidad <strong>inválido</strong>. Por favor <strong>verifique</strong> sus datos, e intente nuevamente. </p>
				</div>
				<div class="form-actions">
					<button id="invalido">Aceptar</button>
				</div>
			</div>
		</div>