<?php
	$skin = $this->input->cookie($this->config->item('cookie_prefix') . 'skin');
	if ($skin == 'latodo') {
		$recoverUserLink = $this->config->item('base_url') . '/users/obtenerLogin_pe';
		$recoverPwdLink = $this->config->item('base_url') . '/users/recoveryPassword_pe';
		$signupLink = $this->config->item('base_url') . '/registro/index_pe';
	} else if($skin == 'pichincha'){
		$recoverUserLink = $this->config->item('base_url') . '/users/obtenerLogin_pi';
		$recoverPwdLink = $this->config->item('base_url') . '/users/recoveryPassword_pi';
		$signupLink = $this->config->item('base_url') . '/registro/index_pi';
	}else {
		$recoverUserLink = $this->config->item('base_url') . '/users/obtenerLogin';
		$recoverPwdLink = $this->config->item('base_url') . '/users/recoveryPassword';
		$signupLink = $this->config->item('base_url') . '/registro';
	}
?>
<div class="widget" id="widget-signin">
	<div class="widget-header">
		<h2 class="screen-reader">Ingreso</h2>
	</div>
	<div class="widget-section">
		<form accept-charset="utf-8" method="post">
			<fieldset>
				<div class="field-prepend">
					<span aria-hidden="true" class="icon-user"></span>
					<input id="username" maxlength="15" name="username" placeholder="Usuario" type="text" />
				</div>
				<div class="field-prepend">
					<span aria-hidden="true" class="icon-key"></span>
					<input id="userpwd" maxlength="15" name="userpwd" placeholder="Contraseña" type="password" />
				</div>
			</fieldset>
			<div id = "slideUnlock" class="unlock"></div>
		</form>
		<button id="login">Ingresar</button>
			<p class="align-center">¿Olvidaste tu<br><a href="<? echo $recoverUserLink; ?>" rel="section">usuario</a> o <a href="<? echo $recoverPwdLink; ?>" rel="section">contraseña</a>?</p>
	</div>
	<div class="widget-footer">
		<p>Si es la primera vez que entras al nuevo sistema, debes <a href="<? echo $signupLink; ?>" rel="section">registrarte</a> para crear tu usuario de acceso.</p>
	</div>
</div>
<div class="widget" id="widget-support">
	<div class="widget-header">
		<h2>¿Necesitas ayuda?</h2>
	</div>
	<div class="widget-section">
						<p>Comunícate con nuestro Centro de Contacto 24 horas en:</p>
						<form accept-charset="utf-8" action="support.html" method="post">
							<select onchange="val()" id="iso" name="iso">
								<option selected value="sel">Seleccione país</option>
								<option value="colombia" value="co">Colombia</option>
								<option value="peru" value="pe">Perú</option>
								<option class="venezuela" value="ve">Venezuela</option>
							</select>
						</form>
						<script type="text/javascript">
							function val(){
								d = document.getElementById("iso").value;
								if(d =="sel"){
									document.getElementById('support-info-co').style.display = 'none';
									document.getElementById('support-info-ve').style.display = 'none';
									document.getElementById('support-info-pe').style.display = 'none';
							    }
								if(d =="colombia"){
									document.getElementById('support-info-pe').style.display = 'none';
									document.getElementById('support-info-ve').style.display = 'none';
									document.getElementById('support-info-co').style.display = 'block';
							    }
							    if(d =="peru"){
							    	document.getElementById('support-info-co').style.display = 'none';
									document.getElementById('support-info-ve').style.display = 'none';
									document.getElementById('support-info-pe').style.display = 'block';
							    }
							    if(d =="ve"){
							    	document.getElementById('support-info-co').style.display = 'none';
									document.getElementById('support-info-pe').style.display = 'none';
									document.getElementById('support-info-ve').style.display= 'block';
							    }
							}
						</script>

						<div class="dynamic-content" id="support-info">
							<div id="support-info-co" style="display: none;">
								<p><strong>Teléfono: </strong>0180001175282</p>
							</div>
							<div id="support-info-pe" style="display: none;">
								<p><strong>Provis Alimentación</strong> 6198930</p>
								<p><strong>Plata Servitebca</strong> 6198931</p>
								<p><strong>Tarjeta LATODO</strong> 6193500</p>
							</div>
							<div id="support-info-ve" style="display: none;">
								<p><strong>0500-BONUS-00</strong> (0500-26687-00)</p>
								<p><strong>0501-PLATA-00</strong> (0501-75282-00)</p>
								<p><strong>0501-SAMBIL-1</strong> (0501-726245-1)</p>
							</div>
						</div>
					</div>
</div>
